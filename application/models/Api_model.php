<?php

class Api_model extends CI_Model
{
    function registerUser($data)
    {
        // print_r($data);
        $this->db->insert('users',$data);
    }

    function checkLogin($data)
    {
        $this->db->where($data);
        $query = $this->db->get('users');
        print_r($query->num_rows());
        if($query->num_rows()==1)
        {
//            print_r("Reached Success\n\n" . $query->num_rows() . " " . $query->row());
//            print_r($query->row());
            return $query->row();
        }
        else
        {
            print_r("Reached Failed");
            return false;
        }
    }

    function getProfile($userId)
    {
        $this->db->select('name,email');
        $this->db->where(['id'=>$userId]);
        $query = $this->db->get('users');
        return $query->row();
    }

}