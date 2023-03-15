<?php

class SchedulerModel extends CI_Model{
    private $id = null;
    private $type = null;
    private $wage = null;
    private $description = null;
    private $facility = null;
    private $role = null;
    private $start_time = null;
    private $end_time = null;
    private $hours = null;
    private $date = null;
    private $created_by = null;

    public function clear(){
        $this->id = null;
        $this->type = null;
        $this->wage = null;
        $this->description = null;
        $this->facility = null;
        $this->role = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->hours = null;
        $this->date = null;
        $this->created_by = null;
    }

    private function isMatch($regex,$string){
        $matches = [];
        preg_match($regex,$string,$matches);
        return count($matches) > 0 ? true : false;
    }

    public function setID($val){
        if(empty($val)) throw new InvalidArgumentException('ID is null!');
        $this->id = $val;
    }

    public function setType($val){
        if(!$this->isMatch('/^(0|1)$/', $val)) throw new InvalidArgumentException('Type should be 0 or 1!');
        $this->type = $val;
    }

    public function setWage($val){
        if(!$this->isMatch('/^([0-9]+|[0-9]+.[0-9]+)$/', $val)) throw new InvalidArgumentException('Wage should be an integer or a float!');
        $this->wage = $val;
    }

    public function setDescription($val){
        $this->description = $val;
    }

    public function setFacility($val){
        if(empty($val)) throw new InvalidArgumentException('Facility is null!');
        if(!$this->isMatch('/^[0-9]+$/', $val)) throw new InvalidArgumentException('Facility should be an integer!');
        $this->facility = $val;
    }

    public function setRole($val){
        if(empty($val)) throw new InvalidArgumentException('Role is null!');
        if(!$this->isMatch('/^[0-9]+$/', $val)) throw new InvalidArgumentException('Role should be an integer!');
        $this->role = $val;
    }

    public function setStartTime($val){
        if(empty($val)) throw new InvalidArgumentException('Start Time is null!');
        if(!$this->isMatch('/^([0-9]{2}:[0-9]{2}|[0-9]{2}:[0-9]{2}:[0-9]{2})$/', $val)) throw new InvalidArgumentException('Start Time is not properly formatted!');
        $this->start_time = $val;
    }

    public function setEndTime($val){
        if(empty($val)) throw new InvalidArgumentException('End Time is null!');
        if(!$this->isMatch('/^([0-9]{2}:[0-9]{2}|[0-9]{2}:[0-9]{2}:[0-9]{2})$/', $val)) throw new InvalidArgumentException('End Time is not properly formatted!');
        $this->end_time = $val;
    }

    public function setDate($val){
        if(empty($val)) throw new InvalidArgumentException('Date is null!');
        
        if(!$this->isMatch('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $val))
            throw new InvalidArgumentException('Date must be a YYYY-MM-DD date format!');

        $this->date = $val;
    }

    public function setCreatedBy($val){
        $this->created_by = $val;
    }

    private function getScheduleEnd($date,$schedStart,$schedEnd){
        $scheduleStart = strtotime($date.' '.$schedStart);
        $scheduleEnd = strtotime($date.' '.$schedEnd);
        if($scheduleStart >= $scheduleEnd) $scheduleEnd = date('Y-m-d H:i:s', strtotime($date.' '.$schedEnd.' +1 days'));
        return $scheduleEnd;
    }

    public function toAssocArray(){
        $this->hours = $this->getScheduleEnd($this->date,$this->start_time,$this->end_time) > strtotime($this->date.' '.$this->start_time);

        $setSchedule = array(
            'schedule_id' => $this->id,
            'schedule_type' => $this->type,
            'schedule_wage' => $this->wage,
        );

        $setScheduleDetail = array(
            'schedule_detail_description' => $this->description,
            'schedule_detail_facilit_id ' => $this->facility,
            'schedule_detail_role_id ' => $this->role,
            'schedule_detail_start_time' => $this->start_time,
            'schedule_detail_end_time' => $this->end_time,
            'schedule_detail_hours' => $this->hours,
            'schedule_detail_date' => $this->date,
            'schedule_detail_created_by' => $this->created_by,
            'schedule_detail_schedule_id' => $this->id
        );

        return array(
            'schedules' => $setSchedule,
            'schedule_details' => $setScheduleDetail
        );
        // if($this->id != null) 
    }
    

}