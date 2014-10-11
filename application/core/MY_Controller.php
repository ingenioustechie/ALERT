<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * 
 * Base_controller request handler class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Base_controller
 */
class MY_Controller extends CI_Controller {

    protected $view_data = array();
    protected $parse_main_data = array();
    protected $arrProUser = array();
    protected $data = '';
    protected $useragent = '';
    

    protected $mixedUsernameIdFromUrl = NULL;
    public    $scripts = array();
    public    $meta = '';
    public    $version = '';
    public    $params = '';

    function __construct() {

        parent::__construct();

        $this->scripts = array('js' => array(), 'css' => array());
        array_push($this->scripts['css'], "css/style.css","css/home_body.css","css/home_menu.css","css/pure-min.css");
        //array_push($this->scripts['css'], "css/bootstrap.css","css/style.css");
        array_push($this->scripts['js'],"js/common.js");
        
        $this->view_data['main_view']       = '';
        $this->parse_main_data['site_url']  = site_url();
        $this->parse_main_data['base_url']  = base_url();        
        $this->view_data['meta_data']       = 'meta_data';

        $this->parse_main_data['image_url'] = base_url() . 'assets/images/';

        $this->get_flash_data();
        
        $this->version = '0.0.1';

        $this->setRightsidebar();
        
        $this->parse_main_data['main_menu'] = '';
        if(isset($this->session->userdata['user']) and isset($this->session->userdata['user']['key'])){
            $this->params['key'] = $this->session->userdata['user']['key'];   
        }

        $this->params['request_from'] = 'web';
        // $this->params['key'] = '06459e2bfa9dc500f88e6bddcae14fa6f0331f7a';
    }

    protected function display_view() {

// echo "<pre>"; print_r($this->parse_main_data);echo "</pre>"; die();


        if (isset($this->view_data['leftbar'])){
            $this->template->parse_view('leftbar', $this->view_data['leftbar'], $this->parse_main_data);
        }

        if (isset($this->view_data['rightbar'])&& $this->view_data['rightbar'] != ''){
            $this->template->parse_view('rightbar', $this->view_data['rightbar'], $this->parse_main_data);
        }            
        
        // set user session

        if (isset($this->view_data['title']) && $this->view_data['title'] != ''){
            $this->template->parse_view('content', $this->view_data['title'], $this->parse_title_data);
        }


        // Write to $header        
        
        if (isset($this->view_data['header'])  && $this->view_data['header'] != ''){
            $this->template->parse_view('header', $this->view_data['header'], $this->parse_main_data);
        }

        if (isset($this->view_data['footer'])  && $this->view_data['footer'] != ''){
            $this->template->parse_view('footer', $this->view_data['footer'], $this->parse_main_data);
        }

        // Write to $content

        if (isset($this->view_data['main_view']) && $this->view_data['main_view'] != '')
            $this->template->parse_view('content', $this->view_data['main_view'], $this->parse_main_data);

        $this->template->parse_view('meta_data', $this->view_data['meta_data'], $this->parse_main_data);


        
        // Render the template
        $this->render_scripts(); // add all js and css to page
        $this->template->render();
    }

    /**
     * Validate users session 
     * 
     * @return boolean true or false
     */
    public function validate_session() {
        $user_data = $this->session->userdata('user');
        if (isset($user_data['id']) && $user_data['id'] > 0) {
            return $user_data['id'];
        } else {
            return 0;
        }
    }

    /**
     * Get flash Data from session and assign in a view.
     *
     */
    protected function get_flash_data() {
        $flash_data = $this->session->flashdata('flash_data');
        $this->parse_main_data['flash_type'] = $flash_data['type'];
        $this->parse_main_data['flash_msg'] = $flash_data['message'];
        $this->parse_left_data['flash_type'] = $flash_data['type'];
        $this->parse_left_data['flash_msg'] = $flash_data['message'];
    }

    function render_scripts() {

        if (empty($this->scripts)) {
            return false;
        }

        if (!empty($this->scripts['css'])) {
            $this->scripts['css'] = array_unique($this->scripts['css']);
            foreach ($this->scripts['css'] as $key => $value) {
                if($value != ''){
                    if (ENVIRONMENT == 'production') 
                        $this->template->add_css("assets/" . $value."?v={$this->version}");
                    else
                        $this->template->add_css("assets/" . $value."?v={$this->version}");
                }
            }
        }
        if (!empty($this->scripts['js'])) {
            $this->scripts['js'] = array_unique($this->scripts['js']);
            foreach ($this->scripts['js'] as $key => $value) {
                if (ENVIRONMENT == 'production') 
                    $this->template->add_js("assets/" . $value."?v={$this->version}", 'import', true);
                else
                    $this->template->add_js("assets/" . $value."?v={$this->version}", 'import', true);  
            }
        }
        $this->template->add_js('site_url="' . site_url() . '";', 'embed');
        $this->template->add_js('image_url="' . $this->parse_main_data['image_url'] . '";', 'embed');
    }

    /**
     * To display data when doing ajax query
     * @param type $data
     * @param type $status
     * @return type
     */
    public function display_ajax($data, $status){

        echo json_encode(($status)?
            array('status'=>'success','data'=>$data):
            array('status'=>'fail','data'=>$data)
            );
        exit;
    }

    function getAjaxView($view){
        // echo "<pre>"; print_r($this->parse_main_data);echo "</pre>"; die();
        return $this->parser->parse("{$this->useragent}/$view",$this->parse_main_data,true);

    }

    function checkDevice(){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            $this->useragent = "sd";
        else
            $this->useragent = "ld";

        $this->parse_main_data['useragent'] = $this->useragent;
        return $this->useragent;
    }

    function display() {        

        if(!isset($this->view_data['header']))
            $this->view_data['header'] = "common/header";
        
        if(!isset($this->view_data['footer']))
            $this->view_data['footer'] = "common/footer";        
        
        if(!isset($this->view_data['rightbar']))
            $this->view_data['rightbar'] = "common/rightbar";        

        $this->view_data['main_view'] = $this->view_data['main_view'];
        $this->display_view();
    }


    function redirectUnlogged(){
        if(empty($this->user->arrUserinfo)){
            redirect('');
        }
    }


    public function setRightsidebar(){}

    

    public function getPagination($url,$total_rows,$limit,$query = ''){
          
        $config['base_url'] = base_url().$url;
        $config['suffix'] = '?'.$query;
        $config['uri_segment'] = 2;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit; 

        $config['full_tag_open'] = '<div class=" paging_bootstrap"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['prev_link'] = '← Previous';

        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = 'Next →';



        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['last_link'] = 'Last';


        $this->pagination->initialize($config); 

        return $this->pagination->create_links();
    }
}
