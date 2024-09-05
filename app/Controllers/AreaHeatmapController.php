<?php

namespace App\Controllers;
use App\Models\UserModel;

class AreaHeatmapController extends BaseController
{
        
        
    //////////////////////////////////////////////Dashboard/////////////////////////////////////////////////
    public function index(){
        $data['title'] = 'Home Page';
        echo view('includes\user\AreaHeatMap\HeatMapMain.php', $data);
        echo view('includes\user\AreaHeatMap\HeatMap_Head_Assets.php');
    }

        
}

