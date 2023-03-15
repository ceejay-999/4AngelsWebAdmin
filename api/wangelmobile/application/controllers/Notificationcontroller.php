<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
    class Notificationcontroller extends CI_Controller{
        protected $Filemanager;
        protected $Notify;
        
        public function __construct(){
            parent::__construct();
            $this->load->model('PWFileManager');
            $this->Filemanager = $this->PWFileManager;
            $this->load->model('Token');
            $this->load->model('dbcontext/Notificationdbcontext');
            $this->Notify = $this->Notificationdbcontext;
        }

        public function index(){
            echo '404';
        }

        public function ShowMyNotif(){
            try{
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('userid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }

                $result = $this->Notify->ViewNotification($this->input->post('userid'));
                echo json_encode($this->response(true,'Success',$result));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        public function ReadNotif(){
            try{
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('notifid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }

                $this->Notify->isReadNotification($this->input->post('notifid'));
                echo json_encode($this->response(true,'Success',null));
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
