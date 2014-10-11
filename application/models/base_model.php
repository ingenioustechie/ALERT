<?php

/**
 * <b>BaseModel</b> class.
 * Most of the classes in the application are derived from this class
 * Provides basic functionality to create, retrieve, update and delete
 * items from the database. Included are also some utility methods for
 * easy usage of the objects
 *
 */
class Base_Model extends CI_Model {

    protected $table_fields = array();
    protected $join_array = array();
    protected $table_name = '';
    protected $columns = '*';
    protected $single_column = '';
    protected $where = '';
    protected $query = '';
    private $row = '';
    private $query_result = '';
    protected $result = array();
    protected $num_rows = '';
    public $rules = '';
    public $fields = array();
    protected $sort_fields;
    protected $backwards = false;
    protected $numeric = false;

    /**
     * Enter description here...
     *
     */
    function __construct() {

        parent::__construct();
        // $this->load->library('pagination');
    }

    /**
     * function which will perform Query Execution
     *
     * @return array
     */
    function get_data() {
        $this->result = array();
        $this->get_query();
        $this->query_result = $this->db->query($this->query);
        $this->result = $this->query_result->result_array();
        $this->num_rows = $this->query_result->num_rows();
        $this->initialize_properties();
        return $this->result;
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    function get_single_result() {
        $this->get_query();
        $this->query_result = $this->db->query($this->query);
        $this->row = $this->query_result->row_array();
        $this->num_rows = $this->query_result->num_rows();
        $this->initialize_properties();
        return $this->row;
    }

    function get_single_column() {
        $this->get_query();
        $this->query_result = $this->db->query($this->query);
        $this->row = $this->query_result->result_array();
        $this->initialize_properties();
        return $this->row;
    }

    /**
     * Get values for single column in table 
     * Author : Nanda Khorate
     * @return array
     */
    function get_single_values($column='') {
        $this->get_query();
        $this->query_result = $this->db->query($this->query);
        $fields = $this->query_result->list_fields();
        $this->row = $this->query_result->result_array();
        $this->initialize_properties();
        foreach ($this->row as $row) {
            if (trim($column) != '') {
                $index = $row[$column];
                $data[$index] = $row[$fields[1]];
            } else {
                $data[] = $row[$fields[0]];
            }
        }
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        if (!empty($data)) {
            return $data;
        } else {
            return "";
        }
    }

    function get_single_values_custom() {
        $this->query_result = $this->db->query($this->query);
        $fields = $this->query_result->list_fields();
        $this->row = $this->query_result->result_array();
        $this->initialize_properties();
        foreach ($this->row as $row) {
            $data[] = $row[$fields[0]];
        }
        if (!empty($data)) {
            return $data;
        } else {
            return "";
        }
    }

    /**
     * Enter description here...
     *
     */
    function initialize_properties() {
        $this->query_result->free_result();
        $this->table_name = '';
        $this->columns = '*';
        $this->query = '';
        $this->query_result = '';
       // $this->db->_reset_select(); not working in latest codeingter
       // $this->db->_reset_write();
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    function get_num_rows() {
        return $this->db->count_all_results($this->table_name);
    }

    /**
     * Enter description here...
     *
     */
    function create_join_query() {
        $this->db->select($this->columns, FALSE);
        $this->db->from($this->table_name);

        foreach ($this->join_array as $key => $value) {
            $this->db->join($value['table'], $value['condition'], $value['type']);
        }
    }

    /**
     * Enter description here...
     *
     */
    function get_query() {
        $this->query = $this->db->get_compiled_select();
        //echo "<br/>".$this->query=$this->db->_compile_select();
    }

    /**
     * Saves data to the database
     * @return bolean
     */
    public function save_query() {

        $this->parse_form_data();
        if (isset($this->table_fields['modifiedOn'])) {
            $this->table_fields['modifiedOn'] = date('Y-m-d h:i:s');
        }

        if ($this->where != '') {
            if (isset($this->table_fields['createdOn'])) {
                unset($this->table_fields['createdOn']);
            }
            $this->query = $this->db->update_string($this->table_name, $this->table_fields, $this->where);  //exit;

            @array_walk($this->table_fields, array($this, 'trim_all_values'));
            ($this->db->update_string($this->table_name, $this->table_fields, $this->where));
            $this->query = $this->db->update_string($this->table_name, $this->table_fields, $this->where);
        } else {
            if (isset($this->table_fields['createdOn'])) {
                $this->table_fields['createdOn'] = date('Y-m-d h:i:s');
            }
            $this->query = $this->db->insert_string($this->table_name, $this->table_fields);
        }
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function save() {
        $this->save_query();
        //echo $this->query;exit;
        $this->db->query($this->query);
        if ($this->db->affected_rows() > 0) {

            if ($this->db->insert_id() > 0) {

                return $this->db->insert_id();
            } else {

                return $this->db->insert_id();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Enter description here...
     *
     */
    protected function delete() {
        $this->db->where($this->where, null, false);
        $this->db->delete($this->table_name);
    }

    /**
     * Enter description here...
     *
     * @return unknown
     */
    public function get_table_fields() {
        $this->table_fields = array();
        if (strlen($this->table_name) == 0) {
            return $this->db->list_fields($this->input->post('table'));
        }
        return $this->db->list_fields($this->table_name);
    }

    /**
     * For getting Post data as per table fields for Insertion or updation
     * Author : Nanda Khorate
     *
     */
    public function parse_form_data() {
        $this->result = $this->get_table_fields();

        foreach ($this->result as $row) {

            if ($this->input->post($row, true) != '') {
                $this->table_fields[$row] = $this->input->post($row, true);
            }
        }

        if (array_search('createdOn', $this->result)) {
            $this->table_fields['createdOn'] = "";
        }

        if (array_search('modifiedOn', $this->result)) {
            $this->table_fields['modifiedOn'] = "";
        }
    }

    /**
     * For server side form validations
     * Author : Nanda Khorate
     * @param unknown_type $form_rule
     * @return unknown
     */
    public function validate_form($form_rule) {

        $this->rules = array();
        $rules = $this->form_validation->_config_rules[$form_rule];
        foreach ($this->fields as $field) {
            if (array_key_exists($field, $rules)) {

                array_push($this->rules, $rules[$field]);
            } else {

                $rule = array(
                    'field' => $field,
                    'label' => ucwords($field),
                    'rules' => 'required'
                );
                array_push($this->rules, $rule);
            }
        }
        $this->form_validation->set_rules($this->rules);
        return $this->form_validation->run($this->rules);
    }

    /**
     * For setting Regisration session.
     * Author : Nanda Khorate
     * @param unknown_type $session_name
     * @param unknown_type $key
     * @param unknown_type $value
     */
    public function set_session_data($session_name, $key, $value) {
        $session_data = $this->session->userdata($session_name);
        if (!empty($session_data)) {
            $session_data = $this->session->userdata($session_name);
        }
        $session_data[$key] = $value;
        $this->session->set_userdata($session_name, $session_data);
    }

    /**
     * For Unsetting Multidimensional Session
     * Author : Alpesh Jain.
     * @param $session_name
     * @param $key
     * @param $value
     * @return unknown_type
     */
    public function unset_session_data($session_name, $key) {
        $session_data = $this->session->userdata($session_name);
        if (!empty($session_data)) {
            unset($session_data[$key]);
            $this->session->set_userdata($session_name, $session_data);
        }
    }

    /**
     * Get Enum values for specified fields
     * Author : Mukesh yadav
     * @param string $table
     * @param string $field
     * @return array
     */
    public function get_enum_values($table, $field) {
        $this->query = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
        $this->query_result = $this->db->query($this->query);
        $this->result = $this->query_result->row_array();
        $enum_value = $this->result['Type'];
        $enum_value = str_replace('enum(', '', $enum_value);
        $enum_value = str_replace(')', '', $enum_value);
        $enum_value = str_replace("'", "", $enum_value);
        return explode(",", $enum_value);
    }

    /**
     * Customize and create pagination
     * Author : Yogesh Nikam
     * @param string $pagination_link
     * @param int $total_rows
     * @return string
     */
    function set_pagination($pagination_link, $total_rows, $rows_per_page = ROWS_PER_PAGE, $curr_page='') {
        //set configuration parameters for pagination
        if ($rows_per_page <= 0) {
            $rows_per_page = 6;
        }
        $current_page = ceil($curr_page / $rows_per_page + 1);
        $total_page = ceil($total_rows / $rows_per_page);
        //exit;

        $config['base_url'] = $pagination_link;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $rows_per_page;
        $config['full_tag_open'] = "<div class='pagenavi '><span class='page_of'> Page $current_page of $total_page</span>";
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = ' &laquo; First';
        $config['first_tag_open'] = '';
        $config['first_tag_close'] = '';
        $config['last_link'] = '&raquo; Last';
        $config['uri_segment'] = $this->uri->total_segments();
        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';
        $config['next_link'] = "&raquo;";
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['prev_link'] = "&laquo;";
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $config['js_function'] = 'jsfunction';
        if ($curr_page != '')
            $config['cur_page'] = $curr_page;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function trim_all_values($value, $key) {
        $value = trim($value);
        $this->table_fields[$key] = $value;
    }

    /**
     * This function is used to sort the data. to sort numeric value use 
     *  $this->numeric = true;
     *  $this->multi_sort($data,'weight','id');
     *  this will sort the array in first by weight then id.
     *  
     * @param array to sort, index name of array 
     * @author Mukesh
     * @return Sorted Array
     */
    function multi_sort() {
        $args = func_get_args();
        $array = $args[0];
        if (!$array)
            return array();
        $this->sort_fields = array_slice($args, 1);
        if (!$this->sort_fields)
            return $array();

        if ($this->numeric) {
            usort($array, array($this, 'numericCompare'));
        } else {
            usort($array, array($this, 'stringCompare'));
        }
        return $array;
    }

    function numericCompare($a, $b) {
        foreach ($this->sort_fields as $sort_field) {
            if ($a[$sort_field] == $b[$sort_field]) {
                continue;
            }
            return ($a[$sort_field] > $b[$sort_field]) ? ($this->backwards ? 1 : -1) : ($this->backwards ? -1 : 1);
        }
        return 0;
    }

    function stringCompare($a, $b) {
        foreach ($this->sort_fields as $sort_field) {
            $cmp_result = strcasecmp($a[$sort_field], $b[$sort_field]);
            if ($cmp_result == 0)
                continue;
            return ($this->backwards ? -$cmp_result : $cmp_result);
        }
        return 0;
    }

    /**
     * similar to php get_file_contents() using CURL
     * @param $URL
     * @return content or FALSE
     */
    function curl_get_file_contents($URL) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents)
            return $contents;
        else
            return FALSE;
    }

    /**
     * This function takes out common array from two supplied multidimensional array,  
     * @param $array1
     * @param $array2
     * @param $compareString
     * @return associative array
     */
    function array_common($array1, $array2, $compareString) {
        if (!is_array($array1) || !is_array($array2)) {
            return false;
        }
        $arrResult = array();
        foreach ($array1 as $arrInsideArray1) {
            foreach ($array2 as $arrInsideArray2) {
                $found = false;
                if ($arrInsideArray1[$compareString] == $arrInsideArray2[$compareString]) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                array_push($arrResult, $arrInsideArray1);
            }
        }
        return $arrResult;
    }

    function email($email = array()) {
        $this->email->clear();
        $this->email->set_mailtype('html');
        $to_list = array($email['to']);
        $this->email->to($to_list);
        $this->email->from($email['from'], $email['from_name']);
        $this->email->subject($email['subject']);
        $this->email->message($email['message']);
        $this->email->set_alt_message('You need HTML support, sorry.');
        if (!$this->email->send()) {
            return false;
        } else {
            return true;
        }
    }

}

/**
 * 	This code is copyrighted by INNsight Hospitality Group for the sole intent and purpose for use by INNsight.com and its affiliates.
 *
 * 	Copyright (C) 2010 INNsight Hospitality Group, LLC and INNsight Interactive Pvt. Ltd.
 *
 */
