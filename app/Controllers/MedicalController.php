<?php

namespace App\Controllers;

use App\Models\UserModel;


class MedicalController extends BaseController
{
    //////////////////////////////////////////////Medical Dashboard/////////////////////////////////////////////////
    public function index()
    {
        $data['title'] = 'Medical Dashboard - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Medical\medical_header.php', $data);
            echo view('includes\user\Medical\medical_head_assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\medical\medical_dashboard_body.php');
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

    //////////////////////////////////////////////History Dashboard/////////////////////////////////////////////////
    public function history()
    {
        $data['title'] = 'Medical History - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Medical\medical_header.php', $data);
            echo view('includes\user\Medical\medical_head_assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\medical\medical_history_body.php');
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


    //////////////////////////////////////////////History Dashboard/////////////////////////////////////////////////
    public function counselling()
    {
        $data['title'] = 'Medical Counselling - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Medical\medical_header.php', $data);
            echo view('includes\user\Medical\medical_head_assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\medical\medical_counselling_body.php');
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

    //////////////////////////////////////////////History Dashboard/////////////////////////////////////////////////
    public function bloodHistory()
    {
        $data['title'] = 'Blood Donation History - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Medical\medical_header.php', $data);
            echo view('includes\user\Medical\medical_head_assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\medical\medical_blood_history_body.php');
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


    //////////////////////////////////////////////History Dashboard/////////////////////////////////////////////////
    public function donorList()
    {
        $data['title'] = 'Blood Donation History - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\Medical\medical_header.php', $data);
            echo view('includes\user\Medical\medical_head_assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');
            echo view('includes\user\medical\medical_blood_donors_body.php');
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
}
