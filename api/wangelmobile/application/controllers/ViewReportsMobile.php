<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
class ViewReportsMobile extends CI_Controller{
        protected $Filemanager;
        
        public function __construct(){
            parent::__construct();
            $this->load->model('PWFileManager');
            $this->Filemanager = $this->PWFileManager;
            $this->load->model('Token');
            $this->load->model('dbcontext/Userdbcontext');
            $this->UserDbContext = $this->Userdbcontext;
        }

        public function index(){
            echo '404';
        }

        //getting the response of each function and return to axios
        private function response($success,$msg=null,$result=null){
            $response = array('success'=>$success);
            if(isset($msg)) $response['msg'] = $msg;
            if(isset($result)) $response['result'] = $result;
            return $response;
        }
        
    }
