<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct($config = "rest")
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();
    }

    public function login()
    {
        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Load the Employee model
            $this->load->model('Employee');

            // Check if employee exists and password matches
            if ($this->Employee->login($username, $password)) {
                // Employee exists and password matches, generate token
                $token_data['userName'] = $username;
                $token_data['userRole'] = "Admin";
                $tokenData = $this->authorization_token->generateToken($token_data);

                // Return success response with token
                return $this->sendJson(array("token" => $tokenData, "status" => true, "response" => "Login Success!"));
            } else {
                // Employee does not exist or password does not match, return failure response
                return $this->sendJson(array("token" => null, "status" => false, "response" => "Login Failed!"));
            }
        } else {
            // Return error response for non-POST requests
            return $this->sendJson(array("message" => "POST Method", "status" => false));
        }
    }


    private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}