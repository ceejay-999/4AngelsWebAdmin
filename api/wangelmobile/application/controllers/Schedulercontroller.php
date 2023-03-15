<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: pwauth');

class Schedulercontroller extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Token');
        $this->load->model('dbcontext/Schedulerdbcontext');
        $this->load->model('app-models/SchedulerFilterModel');
        $this->load->model('app-models/SchedulerModel');
        $this->load->model('app-models/SchedulerPermissionModel');
        $this->ctx = $this->Schedulerdbcontext;
        $this->filter = $this->SchedulerFilterModel;
        $this->schedule = $this->SchedulerModel;
    }

    public function index(){
        echo '404';
    }

    public function fetch(){
        try{
            $this->filter->setDate($this->input->get('date'));
            $this->filter->setDateEnd($this->input->get('dateend'));
            $this->filter->setFacility($this->input->get('facility'));
            $this->filter->setRole($this->input->get('role'));
            $this->filter->setType($this->input->get('type'));
            $this->filter->setID($this->input->get('id'));
            
            $res = $this->ctx->fetch($this->filter->getWhereQuery());
            
            if($res === false){
                echo json_encode(array(
                    'success' => false,
                    'result' => 'Fetching failed'
                ));
            }else{
                echo json_encode(array(
                    'success' => true,
                    'result' => $res
                ));
            }
        }catch(Exception $e){
            echo json_encode(array(
                'success' =>false,
                'msg' => $e->getMessage()
            ));
        }
    }

    public function fetchWithAssigned(){
        try{    
            $this->filter->setDate($this->input->get('date'));
            $this->filter->setDateEnd($this->input->get('dateend'));
            $this->filter->setFacility($this->input->get('facility'));
            $this->filter->setRole($this->input->get('role'));
            $this->filter->setType($this->input->get('type'));
            $this->filter->setID($this->input->get('id'));
            
            $res = $this->ctx->fetchWithAssigned($this->filter->getWhereQuery());

            if($res === false){
                echo json_encode(array(
                    'success' => false,
                    'result' => 'Fetching failed'
                ));
            }else{
                echo json_encode(array(
                    'success' => true,
                    'result' => $res
                ));
            }

            
        }catch(Exception $e){
            echo json_encode(array(
                'success' =>false,
                'msg' => $e->getMessage()
            ));
        }
        // 
    }

    public function createBatch(){
        try{
            $content = json_decode($this->input->post('content'));
            $this->ctx->createBatch($content);
        }catch(Exception $err){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }
 
    public function create(){
        try{
            $this->schedule->clear();
            $this->schedule->setID($this->input->post('id'));
            $this->schedule->setType($this->input->post('type'));
            $this->schedule->setWage($this->input->post('wage'));
            $this->schedule->setFacility($this->input->post('facility'));
            $this->schedule->setRole($this->input->post('role'));
            $this->schedule->setStartTime($this->input->post('start_time'));
            $this->schedule->setEndTime($this->input->post('end_time'));
            $this->schedule->setDate($this->input->post('date'));
            $this->schedule->setCreatedBy($this->input->post('created_by'));

            $assoc = $this->schedule->toAssocArray();
            $this->ctx->create($assoc['schedules'],$assoc['schedule_details']);
        }catch(Exception $err){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }

    public function assignBatch(){
        try{
            $content = json_decode($this->input->post('content'));
            foreach($content as $k=>$v){
                foreach($content[$k] as $i=>$j){
                    echo $k.' '.json_encode($j);
                }
            }
            
        }catch(Exception $err){

        }
    }

    public function deAssignBatch(){
        try{
            $content = json_decode($this->input->post('content'));

            
        }catch(Exception $err){

        }
    }

    public function updateBatch(){
        try{
            $content = json_decode($this->input->post('content'));
            foreach($content as $k=>$v){
                $this->schedule->clear();
                $this->schedule->setID($v->id);
                $this->schedule->setType($v->type);
                $this->schedule->setWage($v->wage);
                $this->schedule->setFacility($v->facility);
                $this->schedule->setRole($v->role);
                $this->schedule->setStartTime($v->start_time);
                $this->schedule->setEndTime($v->end_time);
                $this->schedule->setDate($v->date);
                $this->schedule->setCreatedBy($v->created_by);
                $assoc = $this->schedule->toAssocArray();

                $this->ctx->create($assoc['schedules'],$assoc['schedule_details'],$v->id);
            }
        }catch(Exception $err){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }
 
    public function update(){
        try{
            $this->schedule->clear();
            $this->schedule->setID($this->input->post('id'));
            $this->schedule->setType($this->input->post('type'));
            $this->schedule->setWage($this->input->post('wage'));
            $this->schedule->setFacility($this->input->post('facility'));
            $this->schedule->setRole($this->input->post('role'));
            $this->schedule->setStartTime($this->input->post('start_time'));
            $this->schedule->setEndTime($this->input->post('end_time'));
            $this->schedule->setDate($this->input->post('date'));
            $this->schedule->setCreatedBy($this->input->post('created_by'));

            $assoc = $this->schedule->toAssocArray();

            $this->ctx->create($assoc['schedules'],$assoc['schedule_details'],$v->id);

        }catch(Exception $err){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }

    public function delete(){
        try{
            $this->schedule->clear();
            $this->schedule->setID($this->input->post('id'));

            $this->ctx->delete($this->input->post('id'));
            
        }catch(Exception $e){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }

    public function init(){
        try{

            $pwauth = $this->input->get_request_header('pwauth', true);
            if(!$pwauth)
                throw new InvalidArgumentException('Token required!');

            $token_info = $this->Token->get_info($pwauth);
            if(!$token_info)
                throw new InvalidArgumentException('Token is malformed!');

            $this->SchedulerPermissionModel->setUser($token_info['user_id']);
            $res = $this->SchedulerPermissionModel->fetch();    
            echo json_encode(array(
                'success' => true,
                'result' => $res
            ));
        }catch(Exception $err){
            echo json_encode(array(
                'success' => false,
                'msg' => $err->getMessage()
            ));
        }
    }
}
