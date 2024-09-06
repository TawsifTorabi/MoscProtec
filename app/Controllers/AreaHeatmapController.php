<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\HeatzoneLocationModel;

class AreaHeatmapController extends BaseController
{
        
        
    //////////////////////////////////////////////Dashboard/////////////////////////////////////////////////
    public function index(){
        $data['title'] = 'Mosquito HeatZones';
        echo view('includes\user\AreaHeatMap\HeatMap_Header.php', $data);
        echo view('includes\user\AreaHeatMap\HeatMap_Head_Assets.php');
        echo view('includes\user\Navigation\Navigation.php');
        echo view('includes\user\AreaHeatMap\HeatMap_Main_Layout.php');
        echo view('includes\user\AreaHeatMap\HeatMap_Footer.php');

    }

    //////////////////////////////////////////////Dashboard/////////////////////////////////////////////////
    public function demo(){
        $data['title'] = 'Mosquito HeatZones';
        echo view('includes/user/AreaHeatMap/heatmap.php', $data);

    }

    //Get Heatzone Locations
    public function getLocations()
    {
        $locationModel = new HeatzoneLocationModel();
        $locations = $locationModel->getAllLocations();
        
        // Return data as JSON
        return $this->response->setJSON($locations);
    }

        
}

