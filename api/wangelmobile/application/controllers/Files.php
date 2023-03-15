<?php
///public_html/mobile/application/models

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Accept, PWAuth');
header("Access-Control-Allow-Methods: FILES, GET, POST, OPTIONS");

class Files extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('PWFileManager');
        $this->Filemanager = $this->PWFileManager;
    }

    public function index(){
        echo json_encode($this->Filemanager->viewfiles($this->input->get('path')));
    }

    public function upload(){
        $get = $this->input->get();
        $post = $this->input->post();
        if(isset($this->session->post_data)) $post = $this->session->post_data;
        
        $file = $_FILES;

        echo json_encode($this->Filemanager->upload($get,$post,$file['file']));

    }

    public function delete(){
        $path = $this->input->get('path');
        $this->Filemanager->deletefile($path);
        
    }
}

?>