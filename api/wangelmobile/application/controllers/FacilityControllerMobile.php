<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
    class FacilityControllerMobile extends CI_Controller{
        protected $AuthModel;
        protected $ProfileModel;
        protected $UsermanagerModel;
        protected $UserDbContext;
        protected $Filemanager;
        
        public function __construct(){
            parent::__construct();
            $this->load->model('app-models/Authmodel');
            $this->AuthModel = $this->Authmodel;
            $this->load->model('app-models/Profilemodel');
            $this->ProfileModel = $this->Profilemodel;
            $this->load->model('app-models/Usermanagermodel');
            $this->UsermanagerModel = $this->Usermanagermodel;
            $this->load->model('dbcontext/Userdbcontext');
            $this->UserDbContext = $this->Userdbcontext;
            $this->load->model('PWFileManager');
            $this->Filemanager = $this->PWFileManager;
            $this->load->model('Token');
        }

        public function index(){
            echo '404';
        }

        public function ReadFacility(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                if(true){
                    $query = $this->UserDbContext->MReadFacility();

                    echo json_encode($this->response(true,'Success', $query));
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        //getting the response of each function and return to axios
        private function response($success,$msg=null,$result=null){
            $response = array('success'=>$success);
            if(isset($msg)) $response['msg'] = $msg;
            if(isset($result)) $response['result'] = $result;
            return $response;
        }
        
    }
