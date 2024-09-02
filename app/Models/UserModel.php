<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'username', 'password', 'dob', 'blood_group', 'gender', 'usertype', 'pp', 'lastseen'];
}

