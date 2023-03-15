<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
    class Usercontroller extends CI_Controller{
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

        public function Authuser(){
            try{
                $this->AuthModel->setEmail($this->input->post('email'));
                $this->AuthModel->setPassword($this->input->post('password'));

                $data = $this->UserDbContext->AuthenticateUser($this->AuthModel->getEmail(),$this->AuthModel->getPassword());
                if(count($data) > 0){
                    $data['token'] = $token = $this->Token->generate($data[0]->user_id);
                    echo json_encode($this->response(true,'Login Successfully!',$data));
                }else{
                    throw new InvalidArgumentException('Something went wrong!');
                }

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        public function Editprofile(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $data = [];
                $userid = "";
                if(empty($this->input->post('userid'))){
                    throw new InvalidArgumentException('Id is required!');
                }
                $userid = $this->input->post('userid');
                if(!empty($this->input->post('firstname'))){
                    $this->ProfileModel->setFirstname($this->input->post('firstname'));
                    $data['user_firstname'] = $this->ProfileModel->getFirstname();
                }
                if(!empty($this->input->post('lastname'))){
                    $this->ProfileModel->setLastname($this->input->post('lastname'));
                    $data['user_lastname'] = $this->ProfileModel->getLastname();
                }
                if(!empty($this->input->post('email'))){
                    $this->ProfileModel->setEmail($this->input->post('email'));
                    $data['user_email'] = $this->ProfileModel->getEmail();
                }
                if(!empty($this->input->post('birthday'))){
                    $this->ProfileModel->setBirthday($this->input->post('birthday'));
                    $data['user_birthday'] = $this->ProfileModel->getBirthday();
                }
                if(!empty($this->input->post('phone')))
                {
                    $this->ProfileModel->setPhone($this->input->post('phone'));
                    $data['user_phone'] = $this->ProfileModel->getPhone();
                }
                if(!empty($this->input->post('oldpass'))){
                    $query = $this->Userdbcontext->check_pass($this->input->post('userid'));
                    if(password_verify($this->input->post('oldpass'),$query->user_password)){
                        if(!empty($this->input->post('newpass'))){
                            if(!empty($this->input->post('confirmpass'))){
                                if(strcmp($this->input->post('confirmpass'),$this->input->post('newpass')) == 0){
                                    $this->ProfileModel->setNewpass(password_hash($this->input->post('newpass'), PASSWORD_BCRYPT));
                                    $data['user_password'] = $this->ProfileModel->getNewpass();
                                }else{
                                    throw new InvalidArgumentException('New password and confirm password doesn`t match');
                                }
                            }else{
                                throw new InvalidArgumentException('Confirm password is required!');
                            }
                        }
                    }
                }
                $result = $this->UserDbContext->update_user($userid,$data);

                if(!empty($result)){
                    echo json_encode($this->response(true,'Update Successfully',$result));
                }else{
                    echo json_encode($this->response(false,'Something went wrong! Try again later.',$result));
                }

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function uploadfile(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $get = $this->input->get();
                $post = $this->input->post();
                if(isset($this->session->post_data)) $post = $this->session->post_data;

                $profilepicture = $this->Filemanager->upload($get,$post,$_FILES['file']);
                if($profilepicture['success'])
                {
                    $data = [
                        'user_photo' => $profilepicture['file_name']
                    ];
                    $this->ProfileModel->setUserid($this->input->post('userid'));
                    $this->ProfileModel->setPhoto = $profilepicture['file_name'];
                    $this->UserDbContext->update_user($this->ProfileModel->getUserid(), $data);
                }else{
                    $data = [
                        'user_photo' => $profilepicture['file_name'],
                    ];
                    $this->ProfileModel->setUserid($this->input->post('userid'));
                    $this->ProfileModel->setPhoto = $profilepicture['file_name'];
                    $this->UserDbContext->update_user($this->ProfileModel->getUserid(), $data);
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function ViewAllUsermanagers(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $user_access = $this->input->post('useraccess');
                $query = $this->UserDbContext->view_allusersmanagers($user_access);
                echo json_encode($this->response(true,"Success",$query));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function ViewSearchUsermanagers(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $user_access = $this->input->post('useraccess');
                $searchkey = $this->input->post('searchkey');
                $query = $this->UserDbContext->view_searchusermanager($user_access, $searchkey);
                if($query > 0){
                    echo json_encode($this->response(true,"Success",$query));
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function AddUsermangers(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $this->UsermanagerModel->setEmail($this->input->post('email'));
                $this->UsermanagerModel->setStatus($this->input->post('status'));
                $this->UsermanagerModel->setNewpass($this->input->post('password'),$this->input->post('confirmpassword'));
                $this->UsermanagerModel->setDatehired($this->input->post('datehired'));
                $this->UsermanagerModel->setFirstname($this->input->post('firstname'));
                $this->UsermanagerModel->setLastname($this->input->post('lastname'));
    
                $data = [
                    'user_email' => $this->UsermanagerModel->getEmail(),
                    'user_access_level_id' => $this->UsermanagerModel->getStatus(),
                    'user_status' => 1,
                    'user_datehired' => $this->UsermanagerModel->getDatehired(),
                    'user_firstname' => $this->UsermanagerModel->getFirstname(),
                    'user_lastname' => $this->UsermanagerModel->getLastname(), 
                    'user_password' => $this->UsermanagerModel->getNewpass(),
                ];
    
                $userid = $this->UserDbContext->create_usermanagers($data);
    
                if(isset($userid)){
                    if(isset($_FILES['file'])){
                        $result = $this->Filemanager->upload(null,null,$_FILES['file']);
                        if($result['success']){
                            $data = [
                                'user_photo' => $result['file_name']
                            ];
                            $this->UserDbContext->update_usermanagers($userid,$data);
                            echo json_encode($this->response(true,"Success",$userid));
                        }else{
                            throw new InvalidArgumentException('Something went wrong! Try again later.');
                        }
                    }else{
                        echo json_encode($this->response(true,"Success",$userid));
                    }
    
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
    
                
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }

        }
        // public function EditUsermanagers(){

        // }

        public function ViewIndividualUsermanager(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                if(!empty($this->input->post('userid'))){
                    $query = $this->UserDbContext->SpecificUsermanager($this->input->post('userid'));

                    echo json_encode($this->response(true,'Success', $query));
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        //Employee
        public function ReadEmployee(){
            // $token = $this->input->get_request_header('pwauth');

            //     //validate token
            //     if(!$this->Token->validate($token)){
            //         die(json_encode(array(
            //             "success" => false,
            //             "msg" => "Invalid Token!"
            //         )));
            //     }

            $query = $this->UserDbContext->read_employee();
            echo json_encode($this->response(true,'Success',$query));
        }
        public function ReadwithTermiEmployee(){
            // $token = $this->input->get_request_header('pwauth');

            //     //validate token
            //     if(!$this->Token->validate($token)){
            //         die(json_encode(array(
            //             "success" => false,
            //             "msg" => "Invalid Token!"
            //         )));
            //     }

            $query = $this->UserDbContext->readwithtermi_employee();
            echo json_encode($this->response(true,'Success',$query));
        }
        public function ReadSpecificEmployee(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                if(!empty($this->input->post('userid'))){
                    $query = $this->UserDbContext->read_specificemployee($this->input->post('userid'));

                    echo json_encode($this->response(true,'Success', $query));
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function CreateEmployee(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $this->UsermanagerModel->setFirstname($this->input->post('employee_firstname'));
                $this->UsermanagerModel->setLastname($this->input->post('employee_lastname'));
                $this->UsermanagerModel->setDatehired($this->input->post('employee_hiredate'));
                $this->UsermanagerModel->setBirthday($this->input->post('employee_birthday'));
                $this->UsermanagerModel->setPhone($this->input->post('employee_phonenumber'));
                $this->UsermanagerModel->setEmail($this->input->post('employee_emailaddress'));
                $this->UsermanagerModel->setNewpass($this->input->post('employee_password'),$this->input->post('employee_password'));

                $data = [
                    'user_email' => $this->UsermanagerModel->getEmail(),
                    'user_access_level_id' => 0,
                    'user_status' => 1,
                    'user_phone' => $this->UsermanagerModel->getPhone(),
                    'user_birthday' => $this->UsermanagerModel->getBirthday(),
                    'user_datehired' => $this->UsermanagerModel->getDatehired(),
                    'user_firstname' => $this->UsermanagerModel->getFirstname(),
                    'user_lastname' => $this->UsermanagerModel->getLastname(), 
                    'user_password' => $this->UsermanagerModel->getNewpass(),
                ];
    
                $userid = $this->UserDbContext->create_usermanagers($data);
    
                if(isset($userid)){
                    if(isset($_FILES['file'])){
                        $result = $this->Filemanager->upload(null,null,$_FILES['file']);
                        if($result['success']){
                            $data = [
                                'user_photo' => $result['file_name']
                            ];
                            $this->UserDbContext->update_usermanagers($userid,$data);
                            echo json_encode($this->response(true,"Success",$userid));
                        }else{
                            throw new InvalidArgumentException('Something went wrong! Try again later.');
                        }
                    }else{
                        echo json_encode($this->response(true,"Success",$userid));
                    }
    
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function printEmployee(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }

                $query = $this->UserDbContext->print_employee();
                echo json_encode($this->response(true,'Success',$query));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function TermiEmployee(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                
                $query = $this->UserDbContext->terminate_employee($this->input->post('userid'),$this->input->post('value'),$this->input->post('comment'));
                echo json_encode($this->response(true,'Success',$query));
            }catch(Exceptionn $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }

        }


        //MOBILE FUNCTIONALITIES HERE
        public function MAuthuser(){
            try{
                $this->AuthModel->setEmail($this->input->post('email'));
                $this->AuthModel->setPassword($this->input->post('password'));

                $data = $this->UserDbContext->MAuthenticateUser($this->AuthModel->getEmail(),$this->AuthModel->getPassword());
                if(count($data) > 0){
                    $data['token'] = $this->Token->generate($data[0]->user_id);
                    echo json_encode($this->response(true,'Login Successfully!',$data));
                }else{
                    throw new InvalidArgumentException('Something went wrong!');
                }

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        //Update Mobile profile Employee
        public function MEditProfile(){
            try{
                if(!empty($this->input->post('email')) && !empty($this->input->post('userid')))
                {
                    $data = [
                        'user_id' => $this->input->post('userid'),
                        'user_email' => $this->input->post('email'),
                    ];
                    $result = $this->UserDbContext->MEditEmployee($this->input->post('userid'), $data);
                    echo json_encode($this->response(true,'Updated Successfully',$data));
                }else{
                    throw new InvalidArgumentException('Email is required');
                }
                

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        public function MSetProfileImage(){
            try{
                
                if(!empty($_FILES['file']))
                {
                    $userphoto = $this->Filemanager->upload(null,null,$_FILES['file'])['file_name'];
                    $data = [
                        'user_photo' => $userphoto
                    ];
                    $result = $this->UserDbContext->MSetEmployeeImage($this->input->post('userid'), $data);
                    echo json_encode($this->response(true,'Updated Successfully',$data));
                }else{
                    throw new InvalidArgumentException('Email is required');
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
