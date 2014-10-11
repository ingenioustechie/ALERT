<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Workshops_model extends Base_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = 'workshops';
    }

    function saveRegistrer() {
        
        $this->parse_form_data();
        return $this->save();
    }
}