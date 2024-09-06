<?php

namespace App\Models;

use CodeIgniter\Model;

class HeatzoneLocationModel extends Model
{
    protected $table = 'heatzone_locations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['latitude', 'longitude', 'time-added', 'user_id'];

    // Method to fetch all locations
    public function getAllLocations()
    {
        return $this->findAll();
    }
}