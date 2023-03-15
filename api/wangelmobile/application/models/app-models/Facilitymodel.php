<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Facilitymodel extends CI_Model{
        protected $facilityid;
        protected $facilityphoto;
        protected $facilityname;
        protected $facilitylocation;
        protected $facilitylong;
        protected $facilitylat;
        protected $userid;

        public function getUserid(){
            return $this->userid;
        }
        //setter of facilityid
        public function setUserid($data){
            if(!empty($data)){
                $this->userid = $data;
            }else{
                throw new InvalidArgumentException('User Id is required');
            }
        }
        //getter of facilityid
        public function getFacilityid(){
            return $this->facilityid;
        }
        //setter of facilityid
        public function setFacilityid($data){
            if(!empty($data)){
                $this->facilityid = $data;
            }else{
                throw new InvalidArgumentException('Facility ID is required');
            }
        }
        //getter of facilityphoto
        public function getFacilityphoto(){
            return $this->facilityphoto;
        }
        //setter of facilityphoto
        public function setFacilityphoto($data){
            $this->facilityphoto = $data;
        }
        //getter of facilityname
        public function getFacilityname(){
            return $this->facilityname;
        }
        //setter of facilityname
        public function setFacilityname($data){
            if(!empty($data)){
                $this->facilityname = $data;
            }else{
                throw new InvalidArgumentException('Facility name is required');
            }
        }
        //getter of facilitylocation
        public function getFacilityLocation(){
            return $this->facilitylocation;
        }
        //setter of facilitylocation
        public function setFacilityLocation($data,$long,$lat){
            if(!empty($data)&&!empty($lat)&&!empty($long)){
                $this->facilitylocation = $data;
            }else{
                throw new InvalidArgumentException('Facility location is required');
            }
        }
        //getter of facilitylong
        public function getFacilitylong(){
            return $this->facilitylong;
        }
        //setter of facilitylong
        public function setFacilitylong($data){
            if(!empty($data)){
                $this->facilitylong = $data;
            }else{
                throw new InvalidArgumentException('Facility longitude is required');
            }
        }
        //getter of facilitylat
        public function getFacilitylat(){
            return $this->facilitylat;
        }
        //setter of facilitylat
        public function setFacilitylat($data){
            if(!empty($data)){
                $this->facilitylat = $data;
            }else{
                throw new InvalidArgumentException('Facility latitude is required');
            }
        }
        
    }