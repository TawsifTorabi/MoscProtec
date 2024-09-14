<?php

// File: app/Models/ChatModel.php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    protected $allowedFields = ['from_id', 'to_id', 'message', 'opened', 'created_at'];


    //Returns Thread
    public function getChats($id_1, $id_2)
    {
        // Query to fetch chats between two users
        $builder = $this->db->table($this->table);
    
        // Use groupStart and orGroupStart for complex conditions
        $builder->groupStart()
            ->groupStart()
                ->where('from_id', $id_1)
                ->where('to_id', $id_2)
            ->groupEnd()
            ->orGroupStart()
                ->where('from_id', $id_2)
                ->where('to_id', $id_1)
            ->groupEnd()
        ->groupEnd();
    
        $builder->orderBy('chat_id', 'ASC');
    
        // Execute the query
        $query = $builder->get();
    
        // Return the result as an array or an empty array if no results are found
        return $query->getResultArray();
    }
    




    public function getLastChat($id_1, $id_2)
    {
        // Query to fetch the last chat between two users
        $builder = $this->db->table($this->table);

        // Use groupStart() and groupEnd() for complex conditions
        $builder->groupStart()
            ->where('from_id', $id_1)
            ->where('to_id', $id_2)
            ->groupEnd()
            ->orGroupStart()
            ->where('from_id', $id_2)
            ->where('to_id', $id_1)
            ->groupEnd();

        // Order by chat_id descending to get the latest message first
        $builder->orderBy('chat_id', 'DESC');
        $builder->limit(1); // Only return the last message

        // Execute the query
        $query = $builder->get();

        // Check if a message exists
        if ($query->getNumRows() > 0) {
            // Fetch the last chat message
            $chat = $query->getRowArray();

            // Return the message after escaping special characters
            return htmlspecialchars($chat['message'], ENT_QUOTES);
        } else {
            return ''; // Return an empty string if no message is found
        }
    }




    // Insert new message into the chat table
    public function insertChat($from_id, $to_id, $message)
    {
        $data = [
            'from_id'    => $from_id,
            'to_id'      => $to_id,
            'message'    => $message,
            'created_at' => time(),
        ];

        return $this->insert($data);
    }


    //Returns Chat From  Thread and Marks them as Read
    public function getChatsAndMarkOpened($id_1, $id_2)
    {
        // Fetch chats where either user can be the sender or recipient
        $this->groupStart()
            ->where('from_id', $id_1)
            ->where('to_id', $id_2)
            ->groupEnd()
            ->orGroupStart()
            ->where('from_id', $id_2)
            ->where('to_id', $id_1)
            ->groupEnd();

        // Order by chat ID in ascending order
        $this->orderBy('chat_id', 'ASC');

        // Fetch the chats
        $chats = $this->findAll();

        // Mark unread chats as opened
        foreach ($chats as &$chat) {
            if ($chat['opened'] == 0) {
                // Update 'opened' status
                $this->update($chat['chat_id'], ['opened' => 1]);
            }
        }

        return $chats;
    }
}
