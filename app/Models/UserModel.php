<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'username', 'password', 'dob', 'blood_group', 'gender', 'usertype', 'pp', 'lastseen'];

    // Method to get user by username
    public function getUserByUsername($username)
    {
        // Use the query builder to find the user
        $user = $this->where('username', $username)->first();

        if ($user) {
            return $user;
        } else {
            return []; // Return an empty array if the user doesn't exist
        }
    }

    
}

