<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: PWAuth');

    class Rolecontroller extends CI_Controller{
        protected $RoleModel;
        protected $RoleDbContext;
        
        public function __construct(){
            parent::__construct();
            $this->load->model('app-models/Rolemodel');
            $this->RoleModel = $this->Rolemodel;
            $this->load->model('dbcontext/Roledbcontext');
            $this->RoleDbContext = $this->Roledbcontext;
            $this->load->model('Token');
        }

        public function index(){
            echo '404';
        }

        //For admin function to display all roles
        public function DisplayAllRoles(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                
                $data = $this->RoleDbContext->view_Role();
                echo json_encode($this->response(true,'Success',$data));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //For admin function to display specific roles
        public function DisplayARole(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                $data = $this->RoleDbContext->view_Arole($this->input->post('roleid'));
                echo json_encode($this->response(true,'Success',$data));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //For admin Creating Roles
        public function CreateRoles(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                $this->RoleModel->setRoleName($this->input->post('rolename'));
                $this->RoleModel->setRoleColor($this->input->post('rolecolor'));

                $data = [
                    'role_name' => $this->RoleModel->getRoleName(),
                    'role_color' => $this->RoleModel->getRoleColor(),
                ];
                $response = $this->RoleDbContext->create_Role($data);
                
                echo json_encode($this->response(true,'Success',$response));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //For admin Updating Roles
        public function UpdateRoles(){
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
                if(empty($this->input->post('roleid'))){
                    throw new InvalidArgumentException('Role Id is required!');
                }
                if(!empty($this->input->post('rolename'))){
                    $data['role_name'] = $this->input->post('rolename');
                }
                if(!empty($this->input->post('rolecolor'))){
                    $data['role_color'] = $this->input->post('rolecolor');
                }
                $roleId = $this->input->post('roleid');
                $response = $this->RoleDbContext->update_Role($roleId,$data);

                echo json_encode($this->response(true,'Success',$response));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //For admin Deleting Roles
        public function DeleteRoles(){
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
                if(empty($this->input->post('roleid'))){
                    throw new InvalidArgumentException('Role Id is required!');
                }
                $roleId = $this->input->post('roleid');
                $response = $this->RoleDbContext->delete_Role($roleId);

                echo json_encode($this->response(true,'Successfully deleted roles',$response));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //For admin to search Specific roles
        public function SearchRoles(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('keyword'))){
                    $result = $this->RoleDbContext->view_Role();
                    if($result > 0){
                        echo json_encode($this->response(true,'Success',$result));
                    }else{
                        echo json_encode($this->response(true,'No data found',$result));
                    }
                }else{
                    $keyword = $this->input->post('keyword');
                    $result = $this->RoleDbContext->search_Role($keyword);
                    if($result > 0){
                        echo json_encode($this->response(true,'Success',$result));
                    }else{
                        echo json_encode($this->response(true,'No data found',$result));
                    }
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        //Role profession
        public function InsertProfession(){
           try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                $this->RoleModel->setProfuserid($this->input->post('userid'));
                $this->RoleModel->setProfroleid($this->input->post('roleid'));
                $this->RoleModel->setProffacilityid($this->input->post('facilityid'));
                $this->RoleModel->setProfwage($this->input->post('wage'));

                $data = [
                    'prof_user_id' => $this->RoleModel->getProfuserid(),
                    'prof_role_id' => $this->RoleModel->getProfroleid(),
                    'prof_facility_id' => $this->RoleModel->getProffacilityid(),
                    'prof_wage' => $this->RoleModel->getProfwage(),
                ];
                $result = $this->RoleDbContext->insert_profession($data);
                echo json_encode($this->response(true,'Success',$result));
           }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
           }
            
        }
        public function EditProfession(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('profid'))){
                    throw new InvalidArgumentException('Something went wrong!');
                }
                $this->RoleModel->setProfuserid($this->input->post('userid'));
                $this->RoleModel->setProfroleid($this->input->post('roleid'));
                $this->RoleModel->setProfwage($this->input->post('wage'));

                $data = [
                    'prof_id' => $this->input->post('profid'),
                    'prof_user_id' => $this->RoleModel->getProfuserid(),
                    'prof_role_id' => $this->RoleModel->getProfroleid(),
                    'prof_wage' => $this->RoleModel->getProfwage(),
                ];

                $result = $this->RoleDbContext->edit_profession($data);
                echo json_encode($this->response(true,'Success',$result));
           }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
           }
        }
        public function ViewProfession(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(!empty($this->input->post('profid'))){
                    $query = $this->RoleDbContext->view_profession($this->input->post('profid'));
                    echo json_encode($this->response(true,'Success',$query));
                }else{
                    throw new InvalidArgumentException('Something went wrong!');
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