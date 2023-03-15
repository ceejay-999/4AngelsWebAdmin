<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
    class Usermanagermodel extends CI_Model{
        protected $userid;
        protected $firstname;
        protected $lastname;
        protected $email;
        protected $birthday;
        protected $phone;
        protected $newpass;
        protected $photo;
        protected $datehired;
        protected $status;

        public function getDatehired(){
            return $this->datehired;
        }
        public function setDatehired($data){
            $this->datehired = $data;
        }
        public function getStatus(){
            return $this->status;
        }
        public function setStatus($data){
            if(empty($data)){
                throw new InvalidArgumentException('Access Level is required!');
            }
            $this->status = $data;
        }
        //getters of userid
        public function getUserid(){
            return $this->userid;
        }
        //setters of userid
        public function setUserid($data){
            if(empty($data)){
                throw new InvalidArgumentException('Id is required!');
            }
            $this->userid = $data;
        }
        //getters of firstname
        public function getFirstname(){
            return $this->firstname;
        }
        //setters of firstname
        public function setFirstname($data){
            if(empty($data)){
                throw new InvalidArgumentException('Firstname is required!');
            }
            $this->firstname = $data;
        }

        //getters of lastname
        public function getLastname(){
            return $this->lastname;
        }
        //setters of lastname
        public function setLastname($data){
            if(empty($data)){
                throw new InvalidArgumentException('Lastname is required!');
            }
            $this->lastname = $data;
        }
        //getters of email
        public function getEmail(){
            return $this->email;
        }
        //setters of email
        public function setEmail($data){
            if(empty($data)){
                throw new InvalidArgumentException('Email is required!');
            }
            if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
                throw new InvalidArgumentException('Invalid Email!');
            }
            $this->email = $data;
        }
        //getters of birthday
        public function getBirthday(){
            return $this->birthday;
        }
        //setters of birthday
        public function setBirthday($data){
            $this->birthday = $data;
        }
        //getters of phone
        public function getPhone(){
            return $this->phone;
        }
        //setters of phone
        public function setPhone($data){
            $this->phone = $data;
        }
        //getters of newpass
        public function getNewpass(){
            return $this->newpass;
        }
        //setters of newpass
        public function setNewpass($pass,$cpass){
            if(!empty($pass) && !empty($cpass)){
                if(strcmp($pass,$cpass) == 0){
                    $this->newpass = password_hash($pass, PASSWORD_DEFAULT);
                }else{
                    throw new InvalidArgumentException('Password and confirmpassword doesn`t match!');
                }
            }else{
                throw new InvalidArgumentException('Something went wrong');
            }
        }
        //getters of photo
        public function getPhoto(){
            return $this->photo;
        }
        //setters of photo
        public function setPhoto(){
            $this->photo = $data;
        }

    }