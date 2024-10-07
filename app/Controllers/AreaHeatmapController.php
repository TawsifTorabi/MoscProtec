<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HeatzoneLocationModel;

class AreaHeatmapController extends BaseController
{
    //////////////////////////////////////////////Heatmap Dashboard/////////////////////////////////////////////////
    public function index()
    {
        $data['title'] = 'Mosquito HeatZones - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\AreaHeatMap\HeatMap_Header.php', $data);
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

    //////////////////////////////////////////////Heatmap Dashboard/////////////////////////////////////////////////
    public function report()
    {
        $data['title'] = 'Report HeatZones - MoscProtec';

        // Check if the user is logged in
        if ($this->isAuthenticated()) {
            echo view('includes\user\AreaHeatMap\HeatMap_Header.php', $data);
            echo view('includes\user\AreaHeatMap\HeatMap_Head_Assets.php');
            echo view('includes\user\Navigation\Navigation.php');
            echo view('includes\user\Navigation\NavigationSecond.php');

            echo view('includes\user\AreaHeatMap\HeatMap_Report_Layout.php');

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



    public function reportLocation()
    {

        // Check if the user is logged in
        // if (!$this->isAuthenticated()) {
        //     // Initialize data array for error
        //     $data['title'] = 'Report HeatZones API - MoscProtec';
        //     $data_error = [
        //         'title' => $data['title'],  // Use the same title from $data
        //         'message' => 'You are not authenticated to view this page.'
        //     ];
        //     return view('errors\html\not_authorized.php', $data_error);
        //     exit();
        // }


        $validation = \Config\Services::validation();
        $validation->setRules([
            'description'       => 'required',
            'longitude'    => 'required',
            'latitude'    => 'required',
            'images.*'   => 'uploaded[images]|is_image[images]|max_size[images,2048]|ext_in[images,jpg,jpeg,png]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors(),
            ]);
        }

        // Get form inputs
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $description = $this->request->getPost('description');

        // Handle image upload
        $uploadedFiles = $this->request->getFiles();
        $imagePaths = [];
        if ($uploadedFiles && isset($uploadedFiles['images'])) {
            foreach ($uploadedFiles['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $tempName = $file->getTempName();
                    $extension = $file->getClientExtension();
                    $newFileName = uniqid('report_', true) . '.' . $extension;
                    $filePath = WRITEPATH . 'uploads/reports/' . $newFileName;

                    if ($this->resizeImage($tempName, $filePath, 800, 800, 40)) {
                        $imagePaths[] = $newFileName;
                    } else {
                        log_message('error', 'Failed to resize image: ' . $file->getName());
                    }
                } else {
                    log_message('error', 'Invalid file upload: ' . $file->getErrorString());
                }
            }
        } else {
            log_message('error', 'No files uploaded.');
        }

        // Prepare heatzone data
        $heatzoneData = [
            'latitude'          => $latitude,
            'longitude'         => $longitude,
            'description'       => $description,
            'images'            => implode(',', $imagePaths),
            'time-added'        => time(),
            'user_id'           => session()->get('user_id')
        ];


        //Necessary class instances
        $HeatzoneLocationModel = new \App\Models\HeatzoneLocationModel();

        // Insert order data
        if ($HeatzoneLocationModel->insert($heatzoneData)) {
            log_message('info', 'Heatzone inserted successfully: ' . json_encode($heatzoneData)); // Log inserted data
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Heatzone Report submitted successfully',
                'image_count' => count($imagePaths),
                'images' => $imagePaths
            ]);
        } else {
            log_message('error', 'Failed to insert report: ' . json_encode($heatzoneData)); // Log any failure
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to submit heatzone report',
            ]);
        }
    }



    private function resizeImage($sourceImagePath, $destinationPath, $maxWidth, $maxHeight, $quality)
    {
        // Get image info
        list($width, $height, $imageType) = getimagesize($sourceImagePath);

        // Calculate aspect ratio
        $aspectRatio = $width / $height;

        // Determine new dimensions and round them
        if ($width > $height) {
            $newWidth = $maxWidth;
            $newHeight = round($maxWidth / $aspectRatio);
        } else {
            $newHeight = $maxHeight;
            $newWidth = round($maxHeight * $aspectRatio);
        }

        // Create a new image resource with the new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Create image from source based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourceImagePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourceImagePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourceImagePath);
                break;
            default:
                return false; // Unsupported image type
        }

        // Preserve transparency for PNG and GIF images
        if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
            imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        // Copy and resize the image
        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Compress and save the image based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                // Compress JPEG to reduce size (quality can range from 0-100)
                imagejpeg($newImage, $destinationPath, $quality); // Adjust the $quality for compression (75 is good balance)
                break;
            case IMAGETYPE_PNG:
                // Compress PNG with compression level (0 for no compression, 9 for max compression)
                $compressionLevel = round(9 * ($quality / 100)); // Convert quality percentage to PNG compression level
                imagepng($newImage, $destinationPath, $compressionLevel);
                break;
            case IMAGETYPE_GIF:
                // GIF doesn't support compression, so just save it
                imagegif($newImage, $destinationPath);
                break;
        }

        // Free up memory
        imagedestroy($newImage);
        imagedestroy($sourceImage);

        // Check if the file exists and was successfully written to the destination
        if (!file_exists($destinationPath)) {
            return false; // Return false if the file was not successfully saved
        }

        return true; // Return true if everything went well
    }

    // Helper method to serve an image
    private function serveImage($filePath)
    {
        if (!is_file($filePath)) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'File not found']);
        }

        return $this->response
            ->setContentType(mime_content_type($filePath))
            ->setBody(file_get_contents($filePath));
    }
}
