<?php

class SchedulerFilterModel extends CI_Model{
    private $date = null;
    private $dateend = null;
    private $facility = null;
    private $role = null;
    private $type = null;
    private $limit = null;
    private $offset = null;
    private $id = null;

    public function setDate($date){
        if(empty($date)) return;
        
        if(!$this->isMatch('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date))
            throw new InvalidArgumentException('Date must be a YYYY-MM-DD date format!');

        $this->date = $date;
    }

    public function setDateEnd($dateend){
        if(empty($dateend)) return;
        
        if(!$this->isMatch('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $dateend))
            throw new InvalidArgumentException('Date End must be a YYYY-MM-DD date format!');

        $this->dateend = $dateend;
    }

    public function setFacility($facility){
        if(empty($facility)) return;
        
        if(!$this->isMatch('/^[0-9]+$/', $facility))
            throw new InvalidArgumentException('Facility must be an integer!');

        $this->facility = $facility;
    }

    public function setRole($role){
        if(empty($role)) return;
        
        if(!$this->isMatch('/^[0-9]+$/', $role))
            throw new InvalidArgumentException('Role must be an integer!');

        $this->role = $role;
    }

    public function setType($type){
        if(empty($type)) return;
        
        if(!$this->isMatch('/^(open|close)$/', $type))
            throw new InvalidArgumentException('Type can only be "open" or "close"!');

        $this->type = $type;
    }

    public function setID($id){
        if(empty($id)) return;
        $this->id = $id;
    }

    // public function setLimit($limit){
    //     if(empty($limit)) return;
        
    //     if(!$this->isMatch('/^[0-9]+$/', $limit))
    //         throw new InvalidArgumentException('Limit must be an integer!');

    //     $this->limit = $limit;
    // }

    // public function setOffset($offset){
    //     if(empty($offset)) return;
        
    //     if(!$this->isMatch('/^[0-9]+$/', $offset))
    //         throw new InvalidArgumentException('Offset must be an integer!');

    //     $this->offset = $offset;
    // }

    private function isMatch($regex,$string){
        $matches = [];
        preg_match($regex,$string,$matches);
        return count($matches) > 0 ? true : false;
    }

    public function getWhereQuery(){
        $query = array();
        if($this->id != null) $query['schedule_id'] = $this->id;
        if($this->facility != null) $query['schedule_detail_facilit_id'] = $this->facility;
        if($this->role != null) $query['schedule_detail_role_id'] = $this->role;
        if($this->type != null) $query['schedule_type'] = $this->type == 'open' ? 1 : $this->type == 'close' ? 0 : -1;
        if($this->date != null && $this->dateend == null) $query['schedule_detail_date'] = $this->date;
        else if($this->date != null && $this->dateend != null){
            $query['schedule_detail_date >='] = $this->date;
            $query['schedule_detail_date <='] = $this->dateend;
        }

        return count($query) > 0 ? $query : null;

    }

}
