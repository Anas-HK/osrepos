<?php

class AuthController extends RestApi_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('api_auth');
        $this->load->model('api_model');
    }

    function register()
    {
        $username = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('password','Password','required');


        if($this->form_validation->run())
        {
            $data  = array(
                'name'=>$username,
                'email'=>$email,
                'password'=>sha1($password),
            );
            if (!$this->api_model->registerUser($data)) {
                log_message('error', 'Failed to insert user data into database');
            }
//            $this->api_model->registerUser($data);
            $responseData = array(
                'status'=>true,
                'message' => 'Successfully Registered',
                'data'=> $data
            );
            return $this->response($responseData,200);
        }
        else
        {
            $responseData = array(
                'status'=>false,
                'message' => 'fill all the required fields',
                'data'=> []
            );
            return $this->response($responseData);
        }
    }

    function login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');


        $this->form_validation->set_rules('email','Email','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run())
        {
            $data = array('email'=>$email,'password'=> sha1($password));
            $loginStatus = $this->api_model->checkLogin($data);
//            print_r($loginStatus);

            if($loginStatus != false)
            {
                $userId = print_r($loginStatus->id);
                echo $userId;
                $bearerToken = $this->api_auth->generateToken($userId);
                print_r($bearerToken);
                $responseData = array(
                    'status'=> true,
                    'message' => 'Successfully Logged In',
                    'token'=> $bearerToken,
                );
//                print_r($userId);
                return $this->response($responseData,200);
            }
            else
            {
                $responseData = array(
                    'status'=>false,
                    'message' => 'Invalid Crendentials',
                    'data'=> $data,
                );
                return $this->response($responseData);
            }
        }
        else
        {
            $responseData = array(
                'status'=>false,
                'message' => 'Email Id and password is required',
                'data'=> []
            );
            return $this->response($responseData);
        }
    }

}