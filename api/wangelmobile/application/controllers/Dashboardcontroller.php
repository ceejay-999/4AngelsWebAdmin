<?php defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: pwauth');
    class Dashboardcontroller extends CI_Controller{
        protected $Filemanager;
        protected $DashboardDb;
        protected $Notify;
        
        public function __construct(){
            parent::__construct();
            $this->load->model('dbcontext/Dashboarddbcontext');
            $this->DashboardDb = $this->Dashboarddbcontext;
            $this->load->model('PWFileManager');
            $this->Filemanager = $this->PWFileManager;
            $this->load->model('Token');
            $this->load->model('dbcontext/Notificationdbcontext');
            $this->Notify = $this->Notificationdbcontext;
        }

        public function index(){
            echo '404';
        }

        public function DashboardTotalReport(){
            try{
                $token = $this->input->get_request_header('pwauth');

                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                $result = $this->DashboardDb->get_Reports();
                echo json_encode($this->response(true,'Success',$result));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }

        public function DashboardTodaySched(){
            try{
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('facilityid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                //Getting all schedules for today
                $green = array();
                $gray = array();
                $red = array();
                $yellow = array();
                $complete = array();
                $result = $this->DashboardDb->get_TodaySchedule($this->input->post('facilityid'));

                date_default_timezone_set('America/New_York');
                $current_time = time();
                //the result will suppose to return schedule data for today
                //Checking if upcomming,started but late, started but no clockin, started and clockin on time or completed
                foreach($result as $key){
                    //time not yet started
                    if($current_time <= strtotime($key->schedule_detail_start_time) && $current_time < strtotime($key->schedule_detail_end_time)){
                        //possible clock in early so need to check
                        if($key->clock_event_isclockin == 1 && $key->clock_event_isclockout != 1){
                            if(strtotime($key->clock_event_intime) <= strtotime($key->schedule_detail_start_time)){
                                $green[] = (array)$key;
                            }else{
                                $yellow[] = (array)$key;
                            }
                        }else if($key->clock_event_isclockin != 1 && $key->clock_event_isclockout != 1){
                            $gray[] = (array)$key;
                        }else if($key->clock_event_isclockin == 1 && $key->clock_event_isclockout == 1){
                            $complete[] = (array)$key;
                            /**
                             * if the schedule is complete, Need to check if the Employee has no problem on his or her clock in or clock out
                             * 
                             */

                             

                            
                            
                            
                            //check if the schedule is completed. if does then it will caculate the total hour and wage
                            //second condition is to check if it is already recorded on timesheet
                            // 0 if not yet recorded. 1 if recorded to check also if not repeating saved record
                            // if($key->schedule_assign_isComplete == 0 && $key->schedule_assign_isRecordTimesheet == 0){
                            //     $this->DashboardDb->calculate_CompletedSched($key); // Ready to record this schedule to the timesheet
                            // }
                        }else{
                            $red[] = (array)$key;
                            if($key->schedule_assign_tracker == 0){
                                $this->Notify->MakeNotifyForMissingClockinToManagers($key->userid,$key->schedule_assigns_id,1);//notify when missing
                            }
                        }
                    }
                    //time started
                    else if($current_time > strtotime($key->schedule_detail_start_time) && $current_time <= strtotime($key->schedule_detail_end_time)){
                        //possible check
                        if($key->clock_event_isclockin == 1 && $key->clock_event_isclockout != 1){
                            if(strtotime($key->clock_event_intime) <= strtotime($key->schedule_detail_start_time)){
                                $green[] = (array)$key;
                            }else{
                                $yellow[] = (array)$key;
                                if($key->schedule_assign_tracker == 0){
                                    $this->Notify->MakeNotifyForMissingClockinToManagers($key->userid,$key->schedule_assigns_id,2);//notify when late
                                }
                            }
                        }else if($key->clock_event_isclockin == 1 && $key->clock_event_isclockout == 1){
                            $complete[] = (array)$key;
                           //check if the schedule is completed. if does then it will caculate the total hour and wage
                            //second condition is to check if it is already recorded on timesheet
                            // 0 if not yet recorded. 1 if recorded
                            // if($key->schedule_assign_isComplete == 0 && $key->schedule_assign_isRecordTimesheet == 0){
                            //     $this->DashboardDb->calculate_CompletedSched($key); // Ready to record this schedule to the timesheet
                            // }
                        }else{
                            $red[] = (array)$key;
                            if($key->schedule_assign_tracker == 0){
                                $this->Notify->MakeNotifyForMissingClockinToManagers($key->user_id,$key->schedule_assigns_id,1);//notify when missing
                            }
                        }
                    }
                    //time done
                    else{
                        $complete[] = (array)$key;
                        //check if the schedule is completed. if does then it will caculate the total hour and wage
                        //second condition is to check if it is already recorded on timesheet
                        // 0 if not yet recorded. 1 if recorded
                        // if($key->schedule_assign_isComplete == 0 && $key->schedule_assign_isRecordTimesheet == 0){
                        //     $this->DashboardDb->calculate_CompletedSched($key); // Ready to record this schedule to the timesheet
                        // }
                    }
                }
                // 'green' started and clockin on time
                // 'yellow' started but late
                // 'red' started but no clockin
                // 'gray' upcomming today schedules or not yet started
                // 'complete' Meaning the day is done and completed

                $data = [
                    'green' => (array)$green,
                    'yellow' => (array)$yellow,
                    'red' => (array)$red,
                    'gray' => (array)$gray,
                    'complete' => (array)$complete,
                ];

                echo json_encode($this->response(true,'Success',$data));

            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function RecordScheduleToTimesheet(){
            
        }
        public function GetClockevent(){
            try{
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('clockid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                $result = $this->DashboardDb->get_Clockevent($this->input->post('clockid'));
                echo json_encode($this->response(true,'Success',$result));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function UpdateClockinevent(){
            try{
                $data = [];
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('clockid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                if(strtotime($this->input->post('clockin')) === false){
                    throw new InvalidArgumentException('Invalid Date!');
                }
                $data["clock_event_intime"] = $this->input->post('clockin');
                $data["clock_event_isclockin"] = 1;
                $this->DashboardDb->update_Clockevent($this->input->post('clockid'),$data);
                echo json_encode($this->response(true,'Success'));
            }catch(Exception $ex){
                echo json_encode($this->response(false,$ex->getMessage(),null));
            }
        }
        public function UpdateClockoutevent(){
            try{
                $data = [];
                $token = $this->input->get_request_header('pwauth');
                //validate token
                if(!$this->Token->validate($token)){
                    die(json_encode(array(
                        "success" => false,
                        "msg" => "Invalid Token!"
                    )));
                }
                if(empty($this->input->post('clockid'))){
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
                if(strtotime($this->input->post('clockout')) === false){
                    throw new InvalidArgumentException('Invalid Date!');
                }
                
                $data["clock_event_outtime"] = $this->input->post('clockout');
                $data["clock_event_isclockout"] = 1;
                $this->DashboardDb->update_Clockevent($this->input->post('clockid'),$data);
                echo json_encode($this->response(true,'Success'));
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
