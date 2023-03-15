<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboarddbcontext extends CI_Model{
        protected $db;

        public function __construct() {
            parent::__construct();
            $this->db = $this->load->database('default',true);
        }

        public function get_Reports(){
            $supervisor = $this->db
                          ->where('user_access_level_id', 2)
                          ->count_all_results('users');
            $manager = $this->db
                        ->where('user_access_level_id', 3)
                        ->count_all_results('users');
            $facilities = $this->db
                          ->count_all_results('facilities');

            $data = [
                'supervisor' => $supervisor,
                'manager' => $manager,
                'facilities' => $facilities,
            ];
            
            return $data;
        }
        public function get_TodaySchedule($facilities){
            if(empty($facilities)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $date = date('Y-m-d', time());
            $query = $this->db
                     ->select('schedule_assigns.*, schedule_details.*,schedule_clock_event.*,users.*')
                     ->from ('schedule_assigns')
                     ->join('schedules', 'schedules.schedule_id = schedule_assigns.schedule_assigns_schedules_id')
                     ->join('schedule_details', 'schedule_details.schedule_detail_schedule_id = schedules.schedule_id')
                     ->join('users','users.user_id = schedule_assigns.schedule_assigns_user_id')
                     ->join('schedule_clock_event', 'schedule_clock_event.clock_event_schedule_assigns_id = schedule_assigns.schedule_assigns_id')
                     ->where(array('schedule_details.schedule_detail_date' => $date))
                     ->where(array('schedule_details.schedule_detail_facilit_id' => $facilities))
                     ->get();

            return $query->result();
        }

        public function get_Clockevent($clockid){
            if(empty($clockid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db->get_where('schedule_clock_event', array('clock_event_id'=> $clockid));

            return $query->result();
        }
        public function update_Clockevent($clockid,$data){
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($clockid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db->where('clock_event_id', $clockid)
                            ->update('schedule_clock_event', $data);

            return $query;
        }
        // public function calculate_CompletedSched($data){
        //     if(isset($data)){
        //         //First thing is to update is Complete and isrecord column para ma think nga recorded na siya sa timesheet
        //         $upassign = [
        //             'schedule_assign_isComplete' => 1,
        //             'schedule_assign_isRecordTimesheet' => 1 
        //         ];
        //         $this->db->where('schedule_assigns_id', $data->schedule_assigns_id)
        //                  ->update('schedule_assign', $upassign);
        //         // //Next is calculate the clock_event_totalhour and clock_event_totalwage for the employee nga nakaassign sa kani nga sched
        //         // $totalwage = 
                
        //     }else{
        //         throw new InvalidArgumentException('Something went wrong!');
        //     }
        // }
        // public function calculatetotalhours($date,$timestart,$timeend,$clockin,$clockout){
        //     $scheduleDate = '$date';
        //     $scheduleTimeStart = '07:30';
        //     $scheduleTimeEnd = '15:30';
        //     $clockTimeStart = '12:00';
        //     $clockTimeEnd = '12:30';

        //     $schedStart = new DateTime($scheduleDate.' '.$scheduleTimeStart);
        //     $schedEnd = new DateTime($scheduleDate.' '.$scheduleTimeEnd);
        //     $clockStart = new DateTime($scheduleDate.' '.$clockTimeStart);
        //     $clockEnd = new DateTime($scheduleDate.' '.$clockTimeEnd);
        //     $scheduleTomorrowDateObj = new DateTime($scheduleDate.' '.$scheduleTimeStart);
        //     $scheduleTomorrowDateObj->modify('+1 day');

        //     $dayHrs = 60 * 60;

        //     //checks if schedule end time is smaller than schedule start time. if yes, adds 1 day to schedule end datetime
        //     if($schedEnd->getTimestamp() < $schedStart->getTimestamp()) {
        //     //if clock in time is smaller than clock out time, this checks if the clockin time is smaller than clock out time, if yes, adds 1 day to clock in (meaning the user clocked in in date after the scheduled date)
        //     if($clockStart->getTimestamp() < $clockEnd->getTimestamp()){
        //         $clockStart->modify('+1 day');
        //     }
            
        //     //if clock out time is smaller than schedule start time, adds 1 day to clock out datetime
        //     if($clockEnd->getTimestamp() < $schedStart->getTimestamp()) {
        //         $clockEnd->modify('+1 day');
        //     }

        //     $schedEnd->modify('+1 day');
        //     }

        //     $lateHours = 0;
        //     $overHours = 0;
        //     $underHours = 0;
        //     $regularHours = ($schedEnd->getTimestamp() - $schedStart->getTimestamp()) / $dayHrs;

        //     if($clockStart->getTimestamp() > $schedStart->getTimestamp()){
        //     $lateHours = ($clockStart->getTimestamp() - $schedStart->getTimestamp()) / $dayHrs;
        //     }

        //     if($clockEnd->getTimestamp() > $schedEnd->getTimestamp()){
        //     $overHours = ($clockEnd->getTimestamp() - $schedEnd->getTimestamp()) / $dayHrs;
        //     }

        //     if($schedEnd->getTimestamp() > $clockEnd->getTimestamp()){
        //     $underHours = ($schedEnd->getTimestamp() - $clockEnd->getTimestamp()) / $dayHrs;
        //     }

        //     $regularHours = $regularHours - ($lateHours + $underHours);

        //     if($regularHours <= 0) $regularHours = 0;

        //     /* computable values:
        //     $lateHours;
        //     $overHours;
        //     $underHours;
        //     $regularHours */
        // }
    }