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
                     ->select('schedule_assigns.*, schedule_details.*,schedule_clock_event.*,users.*,roles.role_name')
                     ->from ('schedule_assigns')
                     ->join('schedules', 'schedules.schedule_id = schedule_assigns.schedule_assigns_schedules_id')
                     ->join('schedule_details', 'schedule_details.schedule_detail_schedule_id = schedules.schedule_id')
                     ->join('users','users.user_id = schedule_assigns.schedule_assigns_user_id')
                     ->join('schedule_clock_event', 'schedule_clock_event.clock_event_schedule_assigns_id = schedules.schedule_id')
                     ->join('roles','roles.role_id = schedule_details.schedule_detail_role_id')
                     ->where(array('schedule_details.schedule_detail_date' => $date))
                     ->where(array('schedule_details.schedule_detail_facilit_id' => $facilities))
                     ->get();
            return $query->result();
        }

        public function get_Clockevent($clockid){
            if(empty($clockid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db
                     ->select('schedule_assigns.schedule_assigns_id,schedule_clock_event.*')
                     ->from ('schedule_assigns')
                     ->join('schedules', 'schedules.schedule_id = schedule_assigns.schedule_assigns_schedules_id')
                     ->join('schedule_clock_event', 'schedule_clock_event.clock_event_schedule_assigns_id = schedules.schedule_id')
                     ->where(array('schedule_clock_event.clock_event_id' => $clockid))
                     ->get();
            return $query->result();
        }
        public function update_Clockevent($clockid,$schedid,$data){
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($schedid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($clockid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $this->db->where('schedule_assigns_id',$schedid)
            ->update('schedule_assigns',array('schedule_assign_isComplete' => 0, 'schedule_assign_isRecordTimesheet' => 0));
            $query = $this->db->where('clock_event_id', $clockid)
                            ->update('schedule_clock_event', $data);

            return $query;
        }
        public function calculate_CompletedSched($data){
            if(isset($data)){
                //First thing is to update is Complete and isrecord column para ma think nga recorded na siya sa timesheet
                $upassign = [
                    'schedule_assign_isComplete' => 1,
                    'schedule_assign_isRecordTimesheet' => 1 
                ];
                $this->db->where('schedule_assigns_id', $data->schedule_assigns_id)
                         ->update('schedule_assigns', $upassign);
                //Next is calculate the clock_event_totalhour and clock_event_totalwage for the employee nga nakaassign sa kani nga sched
                //and check if clock event status is complete, undertime or missing clockout
                $totalactualhours = 0;
                
                // Calculate total wage
                $total_wage = 0;
                if (strtotime($data->clock_event_outtime) > strtotime($data->schedule_detail_start_time))
                {
                    $time_diff = 0;
                    if(strtotime($data->clock_event_intime) >= strtotime($data->schedule_detail_start_time)){
                        $time_diff = strtotime($data->clock_event_outtime) - strtotime($data->clock_event_intime);
                    }
                    if(strtotime($data->clock_event_intime) < strtotime($data->schedule_detail_start_time)){
                        $time_diff = strtotime($data->clock_event_outtime) - strtotime($data->schedule_detail_start_time);
                    }
                    $totalactualhours = round($time_diff / 3600, 2);
                    
                    //Calculate the total wage
                    $scheduled_hours = floatval($data->schedule_detail_hours);
                    $actual_hours = floatval($totalactualhours);
                    $hourly_rate = floatval($data->schedule_assign_wage);
                    if ($scheduled_hours > 8) {
                        // Calculate unpaid breaks for every 8 hours of work
                        $unpaid_breaks = floor($scheduled_hours / 8) * 0.5;
                        // Deduct unpaid breaks from actual hours
                        $actual_hours -= $unpaid_breaks;
                    }
    
                    if ($actual_hours <= $scheduled_hours) {
                        // Calculate total wage based on actual hours and hourly rate
                        $total_wage = $actual_hours * $hourly_rate;
                    } else {
                        // Calculate overtime wage based on hourly rate plus half
                        $overtime_rate = $hourly_rate * 1.5;
                        $overtime_hours = $actual_hours - $scheduled_hours;
                        $regular_hours = $actual_hours - $overtime_hours;
                        $total_wage = ($regular_hours * $hourly_rate) + ($overtime_hours * $overtime_rate);
                    }
                }
                
                
                $upclockevent = [
                    'clock_event_totalhour' => $totalactualhours,
                    'clock_event_totalwage' => $total_wage,
                ];
                $this->db->where('clock_event_id', $data->clock_event_id)
                         ->update('schedule_clock_event', $upclockevent);
                //
            }else{
                throw new InvalidArgumentException('Something went wrong!');
            }
        }
    }