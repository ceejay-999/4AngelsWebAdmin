<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Userdbcontext extends CI_Model {
        protected $table_name;
        protected $db;

        public function __construct() {
            parent::__construct();
            $this->db = $this->load->database('default',true);
            $this->table_name = 'users';
        }

        public function AuthenticateUser($email,$pass){
            if(!isset($email)){
                throw new InvalidArgumentException('Email is required!');
            }
            if(!isset($pass)){
                throw new InvalidArgumentException('Password is required!');
            }
            // checking if user is available
            $query = $this->db->get_where($this->table_name, array('user_email' => $email));
            if($query->num_rows() == 1){
                if(password_verify($pass,$query->row()->user_password) && $query->row()->user_access_level_id == 1){
                    return $query->result();
                }else if(password_verify($pass,$query->row()->user_password) && $query->row()->user_access_level_id == 2){
                    return $query->result();
                }else if(password_verify($pass,$query->row()->user_password) && $query->row()->user_access_level_id == 3){
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Email or password doesn`t match');
                }
            }else{
                throw new InvalidArgumentException('Email or password doesn`t match');
            }
        }
        //Update a user in the database
        public function update_user($id,$data){
            if(isset($id) && isset($data))
            {
                $this->db->where('user_id',$id);
                $res = $this->db->update($this->table_name, $data);
                if($res){
                    $query = $this->db->get_where($this->table_name, array('user_id' => $id));
                    return $query->row();
                }else{
                    throw new InvalidArgumentException('Sorry something went wrong! Try again later');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }
        public function check_pass($data){
            $query = $this->db->get_where($this->table_name,array('user_id' => $data));
            return $query->row();
        }
        public function view_allusersmanagers($data){
            if(isset($data)){
                if($data == 1){
                    $query = $this->db
                            ->where_in('user_access_level_id',array(1,2,3))
                            ->get($this->table_name);
                    
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Sorry you don`t have permission to access the data!');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }
        public function view_searchusermanager($id,$key){
            if(isset($id)){
                if($id == 1){
                    $query = $this->db
                            ->like('user_firstname', $key)
                            ->or_like('user_lastname', $key)
                            ->or_like('user_email', $key)
                            ->where_in('user_access_level_id',array(1,2,3))
                            ->get($this->table_name);
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Sorry you don`t have permission to access the data!');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }
        public function create_usermanagers($data){
            if(isset($data)){
                $query = $this->db->get_where($this->table_name,array('user_email' => $data['user_email']));
                if($query->num_rows() >= 1){
                    throw new InvalidArgumentException('Email already taken');
                }
                $this->db->insert($this->table_name, $data);
                if(!empty($this->db->insert_id())){
                    $userId = $this->db->insert_id();
                    return $userId;
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }
        public function update_usermanagers($id,$data){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(array_key_exists('user_email', $data)){
                $query = $this->db->get_where($this->table_name, array('user_email' => $data['user_email']));
                if($query->num_rows() == 0){
                    $res = $this->db
                    ->where('user_id',$id)
                    ->update($this->table_name,$data);

                    if($res){
                        $query = $this->db
                                    ->where_in('user_access_level_id',array(1, 2, 3))
                                    ->get($this->table_name);
                        return $query->result();
                    }else{
                        throw new InvalidArgumentException('Something went wrong! Try again later.');
                    }
                }else{
                    throw new InvalidArgumentException('Email already taken');
                }
            }else{
                $res = $this->db
                    ->where('user_id',$id)
                    ->update($this->table_name,$data);

                if($res){
                    $query = $this->db
                                ->where_in('user_access_level_id',array(1, 2, 3))
                                ->get($this->table_name);
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }
        }
        public function SpecificUsermanager($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db->get_where($this->table_name,array('user_id' => $id));

            $facility = $this->db
                        ->select('facilities.*')
                        ->from('facilities')
                        ->join('facilities_permission','facilities_permission.facilities_permission_facilityid = facilities.facility_id')
                        ->where('facilities_permission.facilities_permission_userid', $id)
                        ->get();

            


            $count = $this->db->get_where('facilities_permission', array('facilities_permission_userid' => $id));

            $totalfacilities = $count->num_rows();
            $data = [
                'totalfacility' => $totalfacilities
            ];
            $data['user'] = $query->result();
            $data['facility'] = $facility->result();

            return $data;
        }
        //Employee side

        //Create
        public function create_employeerole(){
            
        }
        //Update
        public function update_employee(){

        }
        //Read
        public function read_employee(){
            $query = $this->db
                    ->where_not_in('user_access_level_id',array(1,2,3))
                    ->where('user_status', 1)
                    ->get($this->table_name);
            
            return $query->result();
        }
        //Read
        public function readwithtermi_employee(){
            $query = $this->db
                    ->where_not_in('user_access_level_id',array(1,2,3))
                    ->get($this->table_name);
            
            return $query->result();
        }
        //Terminate
        public function terminate_employee($userid, $value, $comment){
            if(!isset($userid)){
                throw new InvalidArgumentException('User id is required!');
            }
            if(!isset($value)){
                throw new InvalidArgumentException('Value is required!');
            }
            if(!isset($comment)){
                throw new InvalidArgumentException('Comment is required!');
            }
            if($value == 0){
                //Terminate employee
                $data = [
                    'user_comment' => $comment,
                    'user_status' => 0,
                ];
                $res = $this->db
                        ->where('user_id', $userid)
                        ->update($this->table_name, $data);

                if($res > 0)
                {
                    $query = $this->db->get_where($this->table_name, array('user_id',$userid));
                    return $query;
                }else{
                    throw new InvalidArgumentException('Something went wrong!');
                }
            }else{
                //Rehire employee
                $data = [
                    'user_comment' => null,
                    'user_status' => 1,
                ];

                $res = $this->db
                        ->where('user_id', $userid)
                        ->update($this->table_name, $data);
                if($res > 0)
                {
                    $query = $this->db->get_where($this->table_name, array('user_id',$userid));
                    return $query;
                }else{
                    throw new InvalidArgumentException('Something went wrong!');
                }
            }
        }
        //For printing employee
        public function print_employee(){
            $query = $this->db
                    ->where_not_in('user_access_level_id', array(1, 2, 3))
                    ->get($this->table_name);

            $facility = $this->db
                        ->select('facilities.*,role_professions.*')
                        ->from('facilities')
                        ->join('role_professions','role_professions.prof_facility_id = facilities.facility_id')
                        ->get();

            $data = [];

            foreach($query->result() as $q)
            {
                $newemp = array();
                $newemp = (array)$q;
                $newemp['facility'] = array();
                foreach($facility->result() as $f)
                {
                    if($q->user_id == $f->prof_user_id){
                        $newemp['facility'][] = $f;
                    }
                }
                $data[] = $newemp;
            }
            return $data;
        }

        public function read_specificemployee($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db->get_where($this->table_name,array('user_id' => $id));
            $facility = $this->db
                        ->select('facilities.*,role_professions.*,roles.*')
                        ->from('facilities')
                        ->join('role_professions','role_professions.prof_facility_id = facilities.facility_id')
                        ->join('roles','roles.role_id = role_professions.prof_role_id')
                        ->get();
            $data = [];
            $result = $query->result();
            $data = $result[0];
            foreach($facility->result() as $f)
            {
                if($data->user_id == $f->prof_user_id){
                    $data->facility[] = (array) $f;
                }
            }
            return $query->result();
        }

        //Mobile Controller Functions

        public function MAuthenticateUser($email,$pass){
            if(!isset($email)){
                throw new InvalidArgumentException('Email is required!');
            }
            if(!isset($pass)){
                throw new InvalidArgumentException('Password is required!');
            }
            // checking if user is available
            $query = $this->db->get_where($this->table_name, array('user_email' => $email));
            if($query->num_rows() == 1){
                if(password_verify($pass,$query->row()->user_password) && $query->row()->user_access_level_id == 0){
                    if($query->row()->user_status == 0){ throw new InvalidArgumentException('You have been terminated! Please Contact your supervisor'); }
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Employee email or password doesn`t match');
                }
            }else{
                throw new InvalidArgumentException('Employee email or password doesn`t match');
            }
        }

        public function MEditEmployee($id,$data){
            if(isset($id) && isset($data))
            {
                $this->db->where('user_id',$id);
                $res = $this->db->update($this->table_name, $data);
                if($res){
                    $query = $this->db->get_where($this->table_name, array('user_id' => $id));
                    return $query->row();
                }else{
                    throw new InvalidArgumentException('Sorry something went wrong! Try again later');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }

        public function MSetEmployeeImage($id,$data){
            if(isset($id) && isset($data))
            {
                $this->db->where('user_id',$id);
                $res = $this->db->update($this->table_name, $data);
                if($res){
                    $query = $this->db->get_where($this->table_name, array('user_id' => $id));
                    return $query->row();
                }else{
                    throw new InvalidArgumentException('Sorry something went wrong! Try again later');
                }
            }else{
                throw new InvalidArgumentException('Sorry something went wrong! Try again later');
            }
        }

        public function Mtimesheets($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db->get_where($this->table_name,array('user_id' => $id));
            $timesheet = $this->db
                        ->select('timesheets.*,timesheet_details.*,roles.*,schedules.*, schedule_details.*')
                        ->from('timesheets')
                        ->join('timesheet_details','timesheet_details.timesheet_detail_id = timesheets.timesheet_detail_id')
                        ->join('schedules','schedules.schedule_id = timesheet_details.timesheet_detail_schedule_id')
                        ->join('schedule_details','schedule_details.schedule_detail_schedule_id = schedules.schedule_id')
                        ->join('role_professions','role_professions.prof_user_id=' .  $id)
                        ->join('roles','roles.role_id = role_professions.prof_role_id')
                        ->get();
            $data = [];
            $result = $query->result();
            $data = $result[0];
            foreach($timesheet->result() as $f)
            {
                if($data->user_id == $f->prof_user_id){
                    $data->timesheet[] = (array) $f;
                }
            }
            return $query->result();
        }

        public function Mnotifications($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db->get_where($this->table_name,array('user_id' => $id));
            $notif = $this->db
                        ->select('requests.*')
                        ->from('requests')
                        ->get();
            $data = [];
            $result = $query->result();
            $data = $result[0];
            foreach($notif->result() as $f)
            {
                if($data->user_id == $f->prof_user_id){
                    $data->notif[] = (array) $f;
                }
            }
            return $query->result();
        }

        public function MScheduleAssign($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db->get_where($this->table_name,array('user_id' => $id));
            $notif = $this->db
                        ->select('schedule_assigns.*')
                        ->from('schedule_assigns')
                        ->get();
            $data = [];
            $result = $query->result();
            $data = $result[0];
            foreach($schedule->result() as $f)
            {
                if($data->user_id == $f->prof_user_id){
                    $data->schedule[] = (array) $f;
                }
            }
            return $query->result();
        }

        public function MReadFacility(){

            $notif = $this->db
                        ->select('facilities.*')
                        ->from('facilities')
                        ->get();

            return $notif->result();
        }

    }