<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HeatzoneLocationModel;

class AreaHeatmapController extends BaseController
{
    //////////////////////////////////////////////Dashboard/////////////////////////////////////////////////
    public function index()
    {
        $data['title'] = 'Mosquito HeatZones - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\AreaHeatMap\HeatMap_Header.php');
            echo view('includes\user\AreaHeatMap\HeatMap_Head_Assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\AreaHeatMap\HeatMap_Main_Layout.php');
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

    //////////////////////////////////////////////Demo/////////////////////////////////////////////////
    public function demo()
    {
        $data['title'] = 'Mosquito HeatZones';
        echo view('includes/user/AreaHeatMap/heatmap.php', $data);
    }

    // Get Heatzone Locations
    public function getLocations()
    {
        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            $locationModel = new HeatzoneLocationModel();
            $locations = $locationModel->getAllLocations();

            // Return data as JSON
            return $this->response->setJSON($locations);
        }
    }
}
