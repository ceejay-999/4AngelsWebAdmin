<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class RoleDbContext extends CI_Model{
        protected $table_name;
        protected $db;

        public function __construct() {
            parent::__construct();
            $this->db = $this->load->database('default',true);
            $this->table_name = 'roles';
        }

        //Create
        public function create_Role($data){
            if(!isset($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db->get_where($this->table_name,array('role_color' => $data['role_color']));
            if($query->num_rows() >= 1){
                throw new InvalidArgumentException('Role color already taken');
            }
            $this->db->insert($this->table_name, $data);
            if(!empty($this->db->insert_id())){
                $roleId = $this->db->insert_id();
                $query = $this->db->get($this->table_name);
                return $query->result();
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }
        //Delete
        public function delete_Role($id){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $isdeleted = $this->db->delete($this->table_name, array('role_id' => $id));

            if($isdeleted){
                return true;
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }
        //Update
        public function update_Role($id,$data){
            if(empty($id)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
            $query = $this->db->get_where($this->table_name, array('role_color' => $data['role_color']));
            if($query->num_rows() == 0){
                $res = $this->db
                    ->where('role_id',$id)
                    ->update($this->table_name,$data);

                if($res){
                    $query = $this->db->get($this->table_name);
                    return $query->result();
                }else{
                    throw new InvalidArgumentException('Something went wrong! Try again later.');
                }
            }else{
                throw new InvalidArgumentException('Role color already taken');
            }
        }
        //Search
        public function search_Role($data){
            if(empty($data)){
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }

            $query = $this->db
                        ->like('role_name', $data)
                        ->or_like('role_id', $data)
                        ->get($this->table_name);

            return $query->result();
        }
        //View
        public function view_Role(){
            $query = $this->db->get($this->table_name);
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
        //View specific
        public function view_Arole($id){

            $query = $this->db->get_where($this->table_name,array('role_id' => $id));
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }
        
        //Role_Profession

        public function insert_profession($data){
            if(isset($data)){
                $this->db->insert('role_professions',$data);
                $query = $this->db->insert_id();
                return $query;
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }

        public function edit_profession($data){
            if(isset($data)){
                $query = $this->db
                ->where('prof_id',$data['prof_id'])
                ->update('role_professions',$data);

                return $query;
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }

        public function view_profession($data){
            if(isset($data)){
                $query = $this->db
                         ->select('role_professions.*,roles.*,facilities.*')
                         ->from('role_professions')
                         ->join('roles','roles.role_id = role_professions.prof_role_id')
                         ->join('facilities','facilities.facility_id = role_professions.prof_facility_id')
                         ->where('role_professions.prof_id', $data)
                         ->get();
                return $query->result();
            }else{
                throw new InvalidArgumentException('Something went wrong! Try again later.');
            }
        }

    }