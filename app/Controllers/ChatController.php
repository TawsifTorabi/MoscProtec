<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ChatModel;
use App\Models\ConversationModel;
use CodeIgniter\Controller;


class ChatController extends BaseController
{


    //Chat Homepage
    public function chatIndex()
    {
        $data['title'] = 'Messenger - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Chat\Chat_Header.php', $data);
            echo view('includes\user\Chat\Chat_Head_Assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\Chat\Chat_Interface.php');
            echo view('includes\user\Navigation\Footer.php');
        } else {
            // Initialize data array for error
            $data_error = [
                'title' => $data['title'],  // Use the same title from $data
                'message' => 'You are not authenticated to view this page.'
            ];
            echo view('errors\html\not_authorized.php', $data_error);
        }
    }




    //Get Chat Messages from Thread
    public function getChatMessages($id_1, $id_2)
    {
        $chatModel = new ChatModel();

        // Get chats between two users
        $chats = $chatModel->getChats($id_1, $id_2);

        // Pass the chats to the view or return JSON response, etc.
        //return view('chat_view', ['chats' => $chats]);
        return $this->response->setJSON(['chats' => $chats]);
    }



    //Get Last Chats
    public function getLastChat($id_1, $id_2)
    {
        $chatModel = new ChatModel();

        // Fetch the last chat between two users
        $lastChat = $chatModel->getLastChat($id_1, $id_2);

        // Return the last chat (you can return a view or JSON response)
        return $this->response->setJSON([
            'lastChat' => $lastChat
        ]);
    }



    public function getChats()
    {
        // Check if the user is logged in
        if (session()->has('user_id') && $this->request->getVar('id_2')) {

            // Retrieve the user ID from the session and POST data
            $id_1 = session()->get('user_id');
            $id_2 = $this->request->getVar('id_2');

            // Load the ChatModel
            $chatModel = new ChatModel();

            // Fetch chats and mark them as opened
            $chats = $chatModel->getChatsAndMarkOpened($id_1, $id_2);

            // Format the response
            $response = [];
            foreach ($chats as $chat) {
                $response[] = [
                    'message' => htmlspecialchars($chat['message'], ENT_QUOTES),
                    'sender' => $chat['from_id'],
                    'created_at' => date("h:i A, jS F, Y", $chat['created_at'])
                ];
            }

            // Return JSON response
            return $this->response->setJSON($response);
        } else {
            return $this->response->setJSON(['error' => 'Unauthorized access or missing parameters'], 403);
        }
    }






    //Send Message
    public function sendMessage()
    {
        if (session()->has('user_id')) {
            // Check if the POST request contains the required fields
            if ($this->request->getVar('message') && $this->request->getVar('to_id')) {

                // Retrieve the data from the request
                $from_id = session()->get('user_id');
                $to_id = $this->request->getVar('to_id');
                $message = $this->request->getVar('message');

                // Load the ChatModel
                $chatModel = new ChatModel();
                $ConversationModel = new ConversationModel();

                // Insert the message into the chats table
                $chatModel->insertChat($from_id, $to_id, $message);

                // Check if this is the first conversation between the users
                $conversationExists = $ConversationModel->checkConversation($from_id, $to_id);

                if (!$conversationExists) {
                    // Insert into conversations if no conversation exists
                    $ConversationModel->insertConversation($from_id, $to_id);
                }

                // Format the response
                $response = [
                    'status' => 'success',
                    'message' => $message,
                    'time' => date('h:i:s a', time()),
                ];

                // Return JSON response
                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON(['error' => 'Missing parameters'], 400);
            }
        } else {
            return $this->response->setJSON(['error' => 'Unauthorized access'], 403);
        }
    }





    //Search for Users to Chat
    public function search()
    {
        // Check if the user is logged in
        if (session()->has('username')) {
            // Check if the search key is submitted
            $key = $this->request->getVar('key');
            if ($key) {
                // Load the database library
                $db = \Config\Database::connect();

                // Create search keyword
                $key = "%" . $key . "%";

                // Prepare SQL query
                $sql = "SELECT * FROM `user` WHERE `username` LIKE ? OR `name` LIKE ?";
                $query = $db->query($sql, [$key, $key]);

                // Fetch results
                $users = $query->getResultArray();

                // Prepare response
                $response = [];
                if (!empty($users)) {
                    foreach ($users as $user) {
                        // Exclude the current user
                        if ($user['id'] == session()->get('userid')) continue;

                        $response[] = [
                            'username' => $user['username'],
                            'name' => $user['name'],
                            'profile_picture' => site_url('/global/photos/profile/') . $user['username'],
                            'chat_url' => site_url('chat.php?user=' . $user['username'])
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'The user "' . htmlspecialchars($key) . '" is not
                     found.'
                    ];
                }

                // Return JSON response
                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON(['error' => 'Search key not provided'], 400);
            }
        } else {
            return $this->response->setJSON(['error' => 'Unauthorized'], 403);
        }
    }





    //Load Conversations
    public function Conversation()
    {
        // Check if the user is logged in
        if (session()->has('username')) {

            // Load models
            $userModel = new UserModel();
            $conversationModel = new ConversationModel();

            // Fetch user data
            $user = $userModel->getUserByUsername(session()->get('username'));

            // Fetch user conversations
            $conversations = $conversationModel->getConversations($user['id']);

            // Prepare the response
            $data = [];

            if (!empty($conversations)) {
                foreach ($conversations as $conversation) {
                    $lastChatData = $this->lastChat(session()->get('user_id'), $conversation['id']);
                    $unreadCount = $this->countUnreadMessages(session()->get('user_id'), $conversation['id']);

                    $data[] = [
                        'name' => $conversation['name'],
                        'username' => $conversation['username'],
                        'userid' => $conversation['id'],
                        'profile_picture' => site_url('/global/photos/profile/') . $conversation['username'],
                        'last_message' => $lastChatData['message'],
                        'last_message_time' => $lastChatData['created_at'],
                        'last_message_time_raw' => $lastChatData['raw_created_at'],
                        'opened' => $lastChatData['opened'],
                        'unread_count' => $unreadCount,  // Add the unread message count here
                        'last_seen' => $this->lastSeen($conversation['lastseen']),
                        'is_online' => $this->lastSeen($conversation['lastseen']) === 'Active'
                    ];
                }
            } else {
                $data = ['message' => 'No messages yet, start the conversations'];
            }

            // Return JSON response
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['error' => 'Unauthorized'], 403);
        }
    }



    private function lastChat($id_1, $id_2)
    {
        $chatModel = new \App\Models\ChatModel();
        $builder = $chatModel->builder();

        // Ensure we only pull messages between the two users (id_1 and id_2)
        $builder->groupStart()
            ->groupStart()
            ->where('from_id', $id_1)
            ->where('to_id', $id_2)
            ->groupEnd()
            ->orGroupStart()
            ->where('from_id', $id_2)
            ->where('to_id', $id_1)
            ->groupEnd()
            ->groupEnd()
            ->orderBy('chat_id', 'DESC') // Get the most recent message
            ->limit(1); // Limit to one result

        // Fetch the result
        $lastChat = $builder->get()->getRowArray();

        // If a message exists, return message content, created_at, and opened status
        return $lastChat ? [
            'message' => htmlspecialchars($lastChat['message'], ENT_QUOTES),
            'created_at' => $this->lastSeen($lastChat['created_at']),
            'raw_created_at' => $lastChat['created_at'],
            'opened' => $lastChat['opened']
        ] : [
            'message' => '',
            'created_at' => '',
            'raw_created_at' => '',
            'opened' => 0
        ];
    }




    private function countUnreadMessages($id_1, $id_2)
    {
        $chatModel = new \App\Models\ChatModel();
        $builder = $chatModel->builder();

        // Fetch all unread messages in the conversation where the current user is the recipient
        $builder->where('to_id', $id_1) // The recipient is the current user
            ->where('from_id', $id_2) // The sender is the other user
            ->where('opened', 0); // Only messages that are not opened

        // Return the count of unread messages
        return $builder->countAllResults();
    }




    //Last Seen Helper
    private function lastSeen($date_time)
    {
        $timestamp = $date_time;
        $strTime = ["second", "minute", "hour", "day", "month", "year"];
        $length = ["60", "60", "24", "30", "12", "10"];

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = $currentTime - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff < 10 && $strTime[$i] === "second" ? 'Active' : $diff . " " . $strTime[$i] . "(s) ago ";
        }
    }



    //Session Validator
    private function checkSessionValidity()
    {
        $session = session();
        return $session->get('user_id') !== null;
    }
}
