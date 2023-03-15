<?php
    /* Version 2.0 */

function decryptError(){
}
    
    class Token extends CI_Model{
        private $key = 'JiNwcm93ZWF2ZXJraW0yMDIyOw==';

        public function __construct(){
            parent::__construct();    
        }
        
        private function encrypt($data){
            $enckey = base64_decode($this->key);
            $iv = openssl_random_pseudo_bytes(16);
            while(strlen($iv) !== 16 || strpos($iv, "\x00") !== false){
                $iv = openssl_random_pseudo_bytes(16);
            }
            
            $encrypted = openssl_encrypt($data,'aes-256-cbc',$enckey,0,$iv);
            return base64_encode($encrypted . '::' . $iv);
        }

        public function decrypt($data){
            try{
                set_error_handler(function(){throw new Exception('Decryption failed');});
                $enckey = base64_decode($this->key);
                list($encrypted_data,$iv) = array_pad(explode('::',base64_decode($data),2),2,null);
                $decrypted = openssl_decrypt($encrypted_data, 'aes-256-cbc',$enckey,0,$iv);
                restore_error_handler();
                return $decrypted;
            }catch(Exception $e){
                return false;
            }
            
        }

        public function generate($user_id,$opts=array()){
            $token = array(
                'user_id' => $user_id,
                'created_at' => $user_id,
                'expired_at' => date("Y-m-d H:i:s",strtotime(date("Y-m-d")." +1 months"))
            );
            foreach($opts as $k => $v) $token[$k] = $v;
            $token = $this->encrypt(json_encode($token));
            return $token;
        }

        public function validate($token){
            $token = $this->get_info($token);
            if($token === false) return false;
            if(strtotime(date('Y-m-d H:i:s')) >  strtotime($token['expired_at'])) return false;
            return true;
        }

        public function get_info($token){
                $token = (array) json_decode($this->decrypt($token));
                if(count($token) == 0)  return false;
                return $token;
            
        }

        
    }
