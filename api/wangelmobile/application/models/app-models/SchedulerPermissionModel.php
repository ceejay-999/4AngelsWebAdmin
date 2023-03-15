<?php


class SchedulerPermissionModel extends CI_Model{
    private $user;

    public function __construct(){
        parent::__construct();
        $this->load->model('dbcontext/Userdbcontext');
        $this->UserDbContext = $this->Userdbcontext;
        $this->load->model('dbcontext/Facilitydbcontext');
        $this->FacilityDbContext = $this->Facilitydbcontext;
        $this->load->model('dbcontext/Roledbcontext');
        $this->RoleDbContext = $this->Roledbcontext;
    }

    // private function response($success,$msg=null,$result=null){
    //     $response = array('success'=>$success);
    //     if(isset($msg)) $response['msg'] = $msg;
    //     if(isset($result)) $response['result'] = $result;
    //     return $response;
    // }

    public function setUser($val){
        if(empty($val)) throw new InvalidArgumentException('ID is null!');
        $this->user = $this->UserDbContext->check_pass($val);
    }

    private function facilities(){
        try{
            if($this->user->user_access_level_id == 1)// Admin Permission
                $query = $this->FacilityDbContext->view_AllFacility();
            else if($this->user->user_access_level_id == 2) //Supervisor PErmission
                $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
            else if($this->user->user_access_level_id == 3) //Manager Permission
                $query = $this->FacilityDbContext->view_PermissionFacility($this->input->post('userid'));
            else
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            return $query;
        }catch(Exception $ex){
            echo json_encode($this->response(false,$ex->getMessage(),null));
        }
    }

    private function roles(){
        try{
            $data = $this->RoleDbContext->view_Role();
            return $data;
        }catch(Exception $ex){
            echo json_encode($this->response(false,$ex->getMessage(),null));
        }
    }

    private function employees(){
        try{
            $facilities = $this->facilities();
            $users = array();
            foreach($facilities as $k=>$v){
                $user = $this->db
                ->select('prof_facility_id,prof_role_id,users.user_id,users.user_firstname,users.user_lastname')
                ->join('users','role_professions.prof_user_id = users.user_id')
                ->where('prof_facility_id', $v->facility_id)
                ->get('role_professions')->result();
                if(count($user) == 0) continue;
                $user = $user[0];
                if(!isset($users[$user->user_id])){
                    $users[$user->user_id] = array(
                        'info' => $user,
                        'facilities' => array(),
                        'roles' => array()
                    );
                }
                $users[$user->user_id]['facilities'][] = $user->prof_facility_id;
                $users[$user->user_id]['roles'][] = $user->prof_role_id;
            }

            $data = $this->UserDbContext->read_employee();
            return $users;
        }catch(Exception $ex){
            echo json_encode($this->response(false,$ex->getMessage(),null));
        }
    }

    public function fetch(){
        
        return array(
            'facilities' => $this->facilities(),
            'roles' => $this->roles(),
            'employees' => $this->employees()
        );
    }

    

    
}