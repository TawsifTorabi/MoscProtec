<?php

namespace App\Models;

use CodeIgniter\Model;

class HeatzoneLocationModel extends Model
{
    protected $table = 'heatzone_locations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'latitude', 
        'longitude', 
        'images', 
        'description', 
        'time-added', 
        'user_id'];

    // Method to fetch all locations
    public function getAllLocations()
    {
        return $this->findAll();
    }

    /**
     * Insert a new order into the product_order table
     * 
     * @param array $data
     * @return int|bool The insert ID on success, or false on failure
     */
    public function insertLocation($data)
    {
        if ($this->insert($data)) {
            return $this->insertID(); // Return the order_id of the inserted row
        }

        return false;
    }
}
