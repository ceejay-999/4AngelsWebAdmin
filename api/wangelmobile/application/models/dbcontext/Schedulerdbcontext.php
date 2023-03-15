<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedulerdbcontext extends CI_Model{
    protected $table_name;
    protected $db;
    protected $FacilityModel;

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default',true);
        $this->table_schedules = 'facilities';
        $this->table_assigns = 'schedule_assigns';
        $this->table_assigns = 'schedule_details';
        $this->load->model('app-models/Facilitymodel');
        $this->FacilityModel = $this->Facilitymodel;
    }

    public function fetch($where = null){
        if($where == null){
            $res = (array) $this->db
            ->join('schedules','schedule_details.schedule_detail_schedule_id=schedules.schedule_id')
            ->get('schedule_details')->result();
        }else{
            $res = (array) $this->db
            ->join('schedules','schedule_details.schedule_detail_schedule_id=schedules.schedule_id')
            ->get_where('schedule_details',$where)->result();
        }

        if(count($res) > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function fetchWithAssigned($where = null){
        $res = null;
        if($where == null){
            $res = (array) $this->db
            ->join('schedules','schedule_details.schedule_detail_schedule_id=schedules.schedule_id')
            ->get('schedule_details')->result();
        }else{
            $res = (array) $this->db
            ->join('schedules','schedule_details.schedule_detail_schedule_id=schedules.schedule_id')
            ->get_where('schedule_details',$where)->result();
        }

        foreach($res as $k => $v){
            $res[$k]->schedule_assigns = array();
            $res2 = (array) $this->db
            ->get_where('schedule_assigns',array('schedule_assigns_schedules_id',$v->schedule_detail_schedule_id))
            ->result();
            $res[$k]->schedule_assigns = $res2;
        }

        if(count($res) > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function create($schedules,$scheduleDetails){
        $this->db->insert('schedules', $schedules);
        
        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Adding schedule failed!');

        $this->db->insert('schedule_details', $scheduleDetails);

        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Adding schedule details failed!');
        
    }

    public function update($schedules,$scheduleDetails,$id){
        $this->db->set($schedules)->where('schedule_id', $id)->update('schedules');

        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Updating schedule failed!');

        $this->db->set($scheduleDetails)->where('schedule_detail_schedule_id', $id)->update('schedule_details');

        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Updating schedule details failed!');
    }

    public function delete($id){
        $this->db
        ->where('schedule_detail_schedule_id',$id)
        ->delete('schedule_details');

        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Deleting schedule details failed!');

        $this->db
        ->where('schedule_id',$id)
        ->delete('schedules');

        if ($this->db->affected_rows() == 0) 
            throw new InvalidArgumentException('Deleting schedule failed!');
    }

}