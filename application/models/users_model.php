<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends Base_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'users';
    }

    function saveRegistrer() {
        
        $this->parse_form_data();
        return $this->save();
    }

     /**
     * get user byemail
     */
    function getUserByEmail($emailId) {
        $this->db->where('email', $emailId);
        $query = $this->db->get('users');
        return $query->row();
    }
}