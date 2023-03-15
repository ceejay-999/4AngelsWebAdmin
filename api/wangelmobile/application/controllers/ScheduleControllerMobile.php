<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
class ScheduleControllerMobile extends CI_Controller{
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

        public function MScheduleAssignHandler(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                if(!empty($this->input->post('userid')))
                {
                    $result = $this->UserDbContext->MScheduleAssign($this->input->post('userid'));
                    echo json_encode($this->response(true,'Success',$result));
                }else{
                    throw new InvalidArgumentException('No Data!');
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
