<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Notificationdbcontext extends CI_Model{
        protected $db;

        public function __construct() {
            parent::__construct();
            $this->db = $this->load->database('default',true);
        }

        public function MakeNotifyForMissingClockinToManagers($userid,$scheduleassignid,$redcode){
            $this->db
                ->where('schedule_assigns_id', $scheduleassignid)
                ->update('schedule_assigns',array('schedule_assign_tracker' => 1));

            $user = $this->db->get_where('users',array('user_id' => $userid));
            $usermanagers = $this->db->where_in('user_access_level_id', array(1,2,3))
                                    ->get('users');
            foreach($usermanagers->result() as $key){
                $data = [
                    'notification_title' => 'Missing Clockin',
                    'notification_description' => 'User '.$user->row()->user_lastname.' schedule started and missing clock in',
                    'notification_to_user_id' => $key->user_id,
                    'notification_created_at' => date('Y-m-d H:i:s', time()),
                    'notification_isRead' => 1,
                    'notification_status' => 0,
                    'notification_link' => '/dashboard'
                ];
                $this->db->insert('notifications', $data);
            }
        }

        public function ViewNotification($userid){
            $query = $this->db->get_where('notifications',array('notification_to_user_id' => $userid));
            $count = $this->db->where('notification_to_user_id', $userid)
                            ->where('notification_isRead', 1)
                            ->get('notifications');
            $notifs = $count->num_rows();

            $data['notifications'] = $query->result();
            $data['notifcount'] = $notifs;
            return $data;
        }
        public function isReadNotification($notifid){
            $this->db->where('notification_id', $notifid)
                     ->update('notifications', array('notification_isRead' => 0));
        }

    }