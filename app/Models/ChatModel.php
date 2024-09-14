<?php

// File: app/Models/ChatModel.php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    protected $allowedFields = ['from_id', 'to_id', 'message', 'opened', 'created_at'];


    // This function replaces your raw PHP helper function
    public function getChats($id_1, $id_2)
    {
        $builder = $this->db->table($this->table);

        $builder->where('(from_id = :id_1: AND to_id = :id_2:) OR (to_id = :id_1: AND from_id = :id_2:)', [
            'id_1' => $id_1,
            'id_2' => $id_2
        ]);

        $builder->orderBy('chat_id', 'ASC');

        $query = $builder->get();

        return ($query->getNumRows() > 0) ? $query->getResultArray() : [];
    }

    public function getLastChat($id_1, $id_2)
    {
        // Query to fetch the last chat between two users
        $builder = $this->db->table($this->table);
        $builder->where('(from_id = :id_1: AND to_id = :id_2:) OR (to_id = :id_1: AND from_id = :id_2:)', [
            'id_1' => $id_1,
            'id_2' => $id_2
        ]);
        $builder->orderBy('chat_id', 'DESC');
        $builder->limit(1);

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $chat = $query->getRowArray();
            return htmlspecialchars($chat['message'], ENT_QUOTES);
        } else {
            return '';
        }
    }





    // Update the 'opened' status for chats
    public function updateOpenedChats($id_1, $chats)
    {
        foreach ($chats as $chat) {
            if ($chat['opened'] == 0) {
                $builder = $this->db->table($this->table);

                // Update the 'opened' field for chats from the user
                $builder->set('opened', 1)
                        ->where('from_id', $id_1)
                        ->where('chat_id', $chat['chat_id']);

                $builder->update();
            }
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




    // Method to get chats and update the 'opened' status
    public function getChatsAndMarkOpened($id_1, $id_2)
    {
        // Fetch chats where the current user is the recipient
        $this->where('from_id', $id_1);
        $this->where('to_id', $id_2);
        $this->orderBy('chat_id', 'ASC');
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

