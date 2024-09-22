<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

//SteadFast Courier API Controller

class CourierController extends BaseController
{
    use ResponseTrait;

    private $apiUrl = 'https://portal.packzy.com/api/v1';



    //API Authentication Headers
    private function getHeaders()
    {
        return [
            'Api-Key' => 'your_api_key',
            'Secret-Key' => 'your_secret_key',
            'Content-Type' => 'application/json',
        ];
    }



    //Create Single Order
    public function create_order($data = null)
    {
        // If data isn't provided, assume it's an external request and get POST data
        if (!$data) {
            $data = $this->request->getPost();
        }

        // Validate input parameters
        $validation = \Config\Services::validation();
        $validation->setRules([
            'invoice' => 'required|alpha_numeric_punct',
            'recipient_name' => 'required|max_length[100]',
            'recipient_phone' => 'required|exact_length[11]|numeric',
            'recipient_address' => 'required|max_length[250]',
            'cod_amount' => 'required|numeric|greater_than_equal_to[0]',
            'note' => 'permit_empty|string'
        ]);

        if (!$validation->run($data)) {
            // Validation failed
            return $this->fail($validation->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        // API endpoint path
        $url = $this->apiUrl . '/create_order';

        // Send a POST request to the courier API
        $client = \Config\Services::curlrequest();
        $response = $client->post($url, [
            'headers' => $this->getHeaders(),
            'json' => $data
        ]);

        // Check for success response
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody(), true);
            return $this->respond($result, ResponseInterface::HTTP_OK);
        } else {
            return $this->fail('API request failed.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }



    //Create Bulk Order
    public function bulkCreate_order($data = null)
    {

        // If data isn't provided, assume it's an external request and get POST data
        if (!$data) {
            // Get the JSON data (array of orders)
            $data = $this->request->getJSON(true);
        }

        // Check if data is provided and it's an array
        if (!$data || !is_array($data)) {
            return $this->fail('Invalid input. Expected a JSON array.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Check the number of orders (maximum 500)
        if (count($data) > 500) {
            return $this->fail('Too many orders. Maximum 500 allowed.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Initialize validation service
        $validation = \Config\Services::validation();

        // Loop through the orders and validate each one
        foreach ($data as $order) {
            $validation->setRules([
                'invoice' => 'required|alpha_numeric_punct',
                'recipient_name' => 'required|max_length[100]',
                'recipient_phone' => 'required|exact_length[11]|numeric',
                'recipient_address' => 'required|max_length[250]',
                'cod_amount' => 'required|numeric|greater_than_equal_to[0]',
                'note' => 'permit_empty|string'
            ]);

            if (!$validation->run($order)) {
                return $this->fail($validation->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }
        }

        // API endpoint path for bulk orders
        $url = $this->apiUrl . '/create_order/bulk-order';

        // Send a POST request to the courier API for bulk orders
        $client = \Config\Services::curlrequest();
        $response = $client->post($url, [
            'headers' => $this->getHeaders(),
            'json' => $data
        ]);

        // Handle the API response
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody(), true);

            // Filter out orders with 'error' status
            $failedOrders = array_filter($result, function ($order) {
                return $order['status'] === 'error';
            });

            // If there are failed orders, respond with details
            if (!empty($failedOrders)) {
                return $this->respond([
                    'message' => 'Some orders failed.',
                    'failed_orders' => $failedOrders,
                ], ResponseInterface::HTTP_OK);
            }

            return $this->respond($result, ResponseInterface::HTTP_OK);
        } else {
            return $this->fail('API request failed.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }



    // Check delivery status by consignment ID
    public function status_by_cid($id)
    {
        // Validate consignment ID
        if (!is_numeric($id)) {
            return $this->fail('Invalid Consignment ID. It must be numeric.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        // API endpoint for consignment ID status
        $url = $this->apiUrl . '/status_by_cid/' . $id;

        // Send a GET request to the courier API
        $client = \Config\Services::curlrequest();
        $response = $client->get($url, [
            'headers' => $this->getHeaders()
        ]);

        return $this->handleStatusResponse($response);
    }



    // Check delivery status by invoice ID
    public function status_by_invoice($invoice)
    {
        // Validate invoice ID
        if (empty($invoice)) {
            return $this->fail('Invoice ID is required.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        // API endpoint for invoice ID status
        $url = $this->apiUrl . '/status_by_invoice/' . $invoice;

        // Send a GET request to the courier API
        $client = \Config\Services::curlrequest();
        $response = $client->get($url, [
            'headers' => $this->getHeaders()
        ]);

        return $this->handleStatusResponse($response);
    }



    // Check delivery status by tracking code
    public function status_by_trackingcode($trackingCode)
    {
        // Validate tracking code
        if (empty($trackingCode)) {
            return $this->fail('Tracking code is required.', ResponseInterface::HTTP_BAD_REQUEST);
        }

        // API endpoint for tracking code status
        $url = $this->apiUrl . '/status_by_trackingcode/' . $trackingCode;

        // Send a GET request to the courier API
        $client = \Config\Services::curlrequest();
        $response = $client->get($url, [
            'headers' => $this->getHeaders()
        ]);

        return $this->handleStatusResponse($response);
    }



    // Handle the status response and return it
    private function handleStatusResponse($response)
    {
        // Check for success response
        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody(), true);

            // Validate the API response format
            if (isset($result['delivery_status'])) {
                return $this->respond([
                    'status' => $response->getStatusCode(),
                    'delivery_status' => $result['delivery_status']
                ], ResponseInterface::HTTP_OK);
            }

            return $this->fail('Unexpected API response format.', ResponseInterface::HTTP_BAD_REQUEST);
        } else {
            return $this->fail('API request failed.', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
    
}
