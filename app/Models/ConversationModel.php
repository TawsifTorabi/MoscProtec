<?php

namespace App\Models;

use CodeIgniter\Model;

class ConversationModel extends Model
{
    protected $table = 'conversations';
    protected $primaryKey = 'conversation_id';
    protected $allowedFields = ['user_1', 'user_2'];


    // Check if a conversation exists between two users
    public function checkConversation($from_id, $to_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('
            (user_1 = ' . $this->db->escape($from_id) . ' AND user_2 = ' . $this->db->escape($to_id) . ') 
            OR 
            (user_1 = ' . $this->db->escape($to_id) . ' AND user_2 = ' . $this->db->escape($from_id) . ')
        ');
        return $builder->get()->getRowArray();
    }




    // Insert new conversation
    public function insertConversation($from_id, $to_id)
    {
        return $this->db->table($this->table)->insert([
            'user_1' => $from_id,
            'user_2' => $to_id,
        ]);
    }



    public function getConversations($user_id)
    {
        // Query to fetch conversations
        $builder = $this->db->table($this->table);
        $builder->where('user_1', $user_id)
            ->orWhere('user_2', $user_id)
            ->orderBy('conversation_id', 'DESC');

        $conversations = $builder->get()->getResultArray();

        if (!empty($conversations)) {
            $user_data = [];

            // Loop through each conversation to fetch user data
            foreach ($conversations as $conversation) {
                $other_user_id = ($conversation['user_1'] == $user_id) ? $conversation['user_2'] : $conversation['user_1'];

                // Fetch user details from the 'users' table, including 'id'
                $userBuilder = $this->db->table('user');
                $userBuilder->select('id, name, username, pp, lastseen');
                $user = $userBuilder->where('id', $other_user_id)->get()->getRowArray();

                // Push the user data into the array
                if ($user) {
                    array_push($user_data, $user);
                }
            }
            return $user_data;
        } else {
            return [];
        }
    }
}
