<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Authmodel extends CI_Model{
        protected $emailaddress;
        protected $password;

        //getters for email
        public function getEmail(){
            return $this->emailaddress;
        }
        
        //setters for email
        public function setEmail($data){
            if(!empty($data))
            {
                if(!filter_var($data, FILTER_VALIDATE_EMAIL)){
                    throw new InvalidArgumentException('Invalid Email!');
                }
                $this->emailaddress = $data;
            }else{
                throw new InvalidArgumentException('Email is required');
            }
        }

        //getters for password
        public function getPassword(){
            return $this->password;
        }

        //setters for password
        public function setPassword($data){
            if(!empty($data))
            {
                $this->password = $data;
            }else{
                throw new InvalidArgumentException('Password is required');
            }
        }
    }