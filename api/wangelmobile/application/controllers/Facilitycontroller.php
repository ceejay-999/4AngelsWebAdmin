<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: PWAuth');

    class Facilitycontroller extends CI_Controller{
        protected $FacilityModel;
        protected $FacilityDbContext;
        protected $UserDbContext;
        protected $Filemanager;

        public function __construct(){
            parent::__construct();
            $this->load->model('app-models/Facilitymodel');
            $this->FacilityModel = $this->Facilitymodel;
            $this->load->model('dbcontext/Facilitydbcontext');
            $this->FacilityDbContext = $this->Facilitydbcontext;
            $this->load->model('dbcontext/Userdbcontext');
            $this->UserDbContext = $this->Userdbcontext;
            $this->load->model('PWFileManager');
            $this->Filemanager = $this->PWFileManager;
        }

        public function index(){
            echo '404';
        }

        public function CreateFacility(){
            try{
                $this->FacilityModel->setFacilityname($this->input->post('facilityname'));
                $this->FacilityModel->setFacilityLocation($this->input->post('facilitylocation'),$this->input->post('facilitylong'),$this->input->post('facilitylat'));
                $this->FacilityModel->setFacilitylong($this->input->post('facilitylong'));
                $this->FacilityModel->setFacilitylat($this->input->post('facilitylat'));
                if(empty($this->input->post('userid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                $this->FacilityModel->setUserid($this->input->post('userid'));

                $data = [
                    'facility_name' => $this->FacilityModel->getFacilityname(),
                    'facility_location' => $this->FacilityModel->getFacilityLocation(),
                    'facility_long' => $this->FacilityModel->getFacilitylong(),
                    'facility_lat' => $this->FacilityModel->getFacilitylat()
                ];
                
                $facilityId = $this->FacilityDbContext->create_facility($data);
                if(isset($facilityId)){
                    if(isset($_FILES['file'])){
                        $result = $this->Filemanager->upload(null,null,$_FILES['file']);
                        if($result['success']){
                            $data = [
                                'facility_photo' => $result['file_name']
                            ];
                            $this->FacilityDbContext->update_Facility($facilityId,$data);
                            $query = $this->FacilityDbContext->view_AllFacility();
                            echo json_encode($this->response(true,'Successfully Created!',$query));
                        }else{
                            throw new InvalidArgumentException('Something went wrong! Try again later.');
                        }
                    }else{
                        $query = $this->FacilityDbContext->view_AllFacility();
                        echo json_encode($this->response(true,'Successfully Created!',$query));
                    }
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function SearchFacility(){
            try{
                $check = $this->UserDbContext->check_pass($this->input->post('userid'));
                if(empty($this->input->post('search'))){
                    if($check->user_access_level_id == 1){
                        $query = $this->FacilityDbContext->view_AllFacility();
                        if($query > 0){
                            echo json_encode($this->response(true,'Success',$query));
                        }else{
                            echo json_encode($this->response(false,'No Data'));
                        }
                    }else if($check->user_access_level_id == 2){
                        $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
                        if($query > 0){
                            echo json_encode($this->response(true,'Success',$query));
                        }else{
                            echo json_encode($this->response(false,'No Data'));
                        }
                    }else if($check->user_access_level_id == 3){
                        $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
                        if($query > 0){
                            echo json_encode($this->response(true,'Success',$query));
                        }else{
                            echo json_encode($this->response(false,'No Data'));
                        }
                    }else
                    {
                        throw new InvalidArgumentException('Something went wrong! Try again later.');
                    }
                }else{
                    $data = [
                        'searchkey' => $this->input->post('search'),
                        'userid' => $this->input->post('userid'),
                        'useraccess' => $check->user_access_level_id
                    ];
        
                    $query = $this->FacilityDbContext->search_Facility($data);
        
                    if(isset($query)){
                        echo json_encode($this->response(true,'Success',$query));
                    }else{
                        echo json_encode($this->response(false,'No Data'));
                    }
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }

        }
        public function EditFacility(){

        }
        public function ViewAllFacility(){
            try{
                //checking if userid is empty
                if(empty($this->input->post('userid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                //checking if viewing all facility is an admin or not
                $result = $this->UserDbContext->check_pass($this->input->post('userid'));
                if($result->user_access_level_id == 1){ // Admin Permission
                    $query = $this->FacilityDbContext->view_AllFacility();
                    if($query > 0){
                        echo json_encode($this->response(true,'Success',$query));
                    }else{
                        echo json_encode($this->response(false,'No Data'));
                    }
                }else if($result->user_access_level_id == 2){ //Supervisor PErmission
                    $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
                    if($query > 0){
                        echo json_encode($this->response(true,'Success',$query));
                    }else{
                        echo json_encode($this->response(false,'No Data'));
                    }
                }else if($result->user_access_level_id == 3){ //Manager Permission
                    $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
                    if($query > 0){
                        echo json_encode($this->response(true,'Success',$query));
                    }else{
                        echo json_encode($this->response(false,'No Data'));
                    }
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function ViewSpecificFacility(){
            try{
                if(!empty($this->input->post("facilityid"))){
                    $query = $this->FacilityDbContext->view_SpecificFacilitiy($this->input->post("facilityid"));
                    if($query > 0){
                        echo json_encode($this->response(true,'Success',$query));
                    }else{
                        echo json_encode($this->response(false,'No Data'));
                    }
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function CreatePermition(){
            try{
                if(empty($this->input->post('facilityid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                if(empty($this->input->post('userid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
    
                $query = $this->FacilityDbContext->createpermition($this->input->post('facilityid'),$this->input->post('userid'));
                echo json_encode($this->response(true,'Success',$query));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function facilities(){
            $query = $this->FacilityDbContext->view_AllFacility();
            if($query > 0){
                echo json_encode($this->response(true,'Success',$query));
            }else{
                echo json_encode($this->response(false,'No Data'));
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