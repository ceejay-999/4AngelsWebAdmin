<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Facilitydbcontext extends CI_Model{
        protected $table_name;
        protected $db;
        protected $FacilityModel;

        public function __construct() {
            parent::__construct();
            $this->db = $this->load->database('default',true);
            $this->table_name = 'facilities';
            $this->load->model('app-models/Facilitymodel');
            $this->FacilityModel = $this->Facilitymodel;
        }

        //create facility
        public function create_facility($data){
            if(!isset($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $que = $this->db->get_where($this->table_name,array('facility_name' => $data['facility_name']));
            if($que->num_rows() >= 1){
                throw new InvalidArgumentException('Facility name is already taken');
            }
            $this->db->insert($this->table_name, $data);
            if($this->db->insert_id()){
                $faid = $this->db->insert_id();
                $facilityid = $this->db->insert_id();
                $addpermi = $this->db->insert('facilities_permission',array('facilities_permission_facilityid' => $facilityid, 'facilities_permission_userid' => $this->FacilityModel->getUserid()));
                if($this->db->insert_id()){
                    return $faid;
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }
        //update facility
        public function update_Facility($id,$data){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(isset($data['facility_name'])){
                $query = $this->db->get_where($this->table_name, array('facility_name' => $data['facility_name']));
                if($query->num_rows() == 0){
                    $res = $this->db
                        ->where('facility_id',$id)
                        ->update($this->table_name,$data);

                    if($res){
                        $query = $this->db->get($this->table_name);
                        return $query->result();
                    }else{
                        throw new InvalidArgumentException('Something went wrong! Try again later.');
                    }
                }else{
                    throw new InvalidArgumentException('Facility name is already taken');
                }
            }else{
                $res = $this->db
                        ->where('facility_id',$id)
                        ->update($this->table_name,$data);

                if($res){
                    $query = $this->db->get($this->table_name);
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }
        }
        //View All Facility
        public function view_AllFacility(){
            $query = $this->db
                     ->get($this->table_name);
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
        //View Facility that has permission
        public function view_PermissionFacility($userid){
            $query = $this->db
                     ->select('facilities.*')
                     ->from($this->table_name)
                     ->join('facilities_permission','facilities_permission_facilityid = facilities.facility_id')
                     ->where('facilities_permission_userid', $userid)
                     ->get();
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
        public function view_SpecificFacilitiy($facilityid){
            if(!isset($facilityid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db->get_where($this->table_name, array('facility_id' => $facilityid));
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }
        //Search Facility
        public function search_Facility($data){
            if(!isset($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if($data['useraccess'] == 1){
                $query = $this->db
                        ->like('facility_name', $data['searchkey'])
                        ->or_like('facility_id', $data['searchkey'])
                        ->or_like('facility_location', $data['searchkey'])
                        ->get($this->table_name);   
                        return $query->result();
            }else if($data['useraccess'] == 2){
                $query = $this->db
                        ->select('facilities.*')
                        ->from($this->table_name)
                        ->join('facilities_permission','facilities_permission.facilities_permission_facility = facilities.facility_id')
                        ->where('facilities_permission_userid',$data['userid'])
                        ->like('facility_name', $data['searchkey'])
                        ->or_like('facility_id', $data['searchkey'])
                        ->or_like('facility_location', $data['searchkey'])
                        ->get();
                        return $query->result();
            }else if($data['useraccess'] == 3){
                $query = $this->db
                        ->select('facilities.*')
                        ->from($this->table_name)
                        ->join('facilities_permission','facilities_permission.facilities_permission_facility = facilities.facility_id')
                        ->where('facilities_permission_userid',$data['userid'])
                        ->like('facility_name', $data['searchkey'])
                        ->or_like('facility_id', $data['searchkey'])
                        ->or_like('facility_location', $data['searchkey'])
                        ->get();
                        return $query->result();
            }else{
                throw new InvalidArgumentException('Something went wrong');
            }
        }
        public function createpermition($facilityid,$userid){
            if(!isset($facilityid) && !isset($userid)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $data = [
                'facilities_permission_facilityid' => $facilityid,
                'facilities_permission_userid' => $userid,
            ];
            $query = $this->db->insert('facilities_permission',$data);
            return $query;
        }
    }