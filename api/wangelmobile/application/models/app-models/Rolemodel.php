<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

    class Rolemodel extends CI_Model{
        protected $role_name;
        protected $role_color;
        protected $profuserid;
        protected $profroleid;
        protected $proffacilityid;
        protected $profwage;

        //getters of Rolename
        public function getRoleName(){
            return $this->role_name;
        }

        //setters of Rolename
        public function setRoleName($data){
            if(!empty($data)){
                $this->role_name = $data;
            }else{
                throw new InvalidArgumentException('Rolename is required');
            }
        }

        //getters of RoleColor
        public function getRoleColor(){
            return $this->role_color;
        }
        
        //setters of RoleColor
        public function setRoleColor($data){
            if(!empty($data)){
                $this->role_color = $data;
            }else{
                throw new InvalidArgumentException('Rolecolor is required');
            }
        }
        
        public function getProfuserid(){
            return $this->profuserid;
        }
        public function setProfuserid($data){
            if(!empty($data)){
                $this->profuserid = $data;
            }else{
                throw new InvalidArgumentException('Something went wrong!');
            }
        }
        public function getProffacilityid(){
            return $this->proffacilityid;
        }
        public function setProffacilityid($data){
            if(!empty($data)){
                $this->proffacilityid = $data;
            }else{
                throw new InvalidArgumentException('Something went wrong!');
            }
        }
        public function getProfroleid(){
            return $this->profroleid;
        }
        public function setProfroleid($data){
            if(!empty($data)){
                $this->profroleid = $data;
            }else{
                throw new InvalidArgumentException('Something went wrong!');
            }
        }
        public function getProfwage(){
            return $this->profwage;
        }
        public function setProfwage($data){
            if(!empty($data)){
                $this->profwage = $data;
            }else{
                throw new InvalidArgumentException('Something went wrong!');
            }
        }
    }