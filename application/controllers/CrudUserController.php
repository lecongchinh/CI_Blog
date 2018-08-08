<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudUserController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User');
        $this->data = new User();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    private function validateForm() {
        $rules = array(
            array(
              'field' => 'username',
              'label' => 'Công ty',
              'rules' => 'required'
            ),
            array(
              'field' => 'email',
              'label' => 'email',
              'rules' => 'required|valid_email'
            ),

            array(
              'field' => 'password',
              'label' => 'password',
              'rules' => 'required'
            )

          );
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == false) {
            if(!empty($rules)) foreach ($rules as $item){
                if(!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $mess['mess'] = $valid;
            echo json_encode($mess);
            exit();
        }
        
    }

    public function index() {
        $data['data'] = $this->data->read_user();
        $this->load->view('header');
        $this->load->view('readUser', $data);
        $this->load->view('footer');
    }

    public function get_create_user() {
        $this->load->view('createUser');
    }
    // public function post_create_user() {
    //     $this->validateForm();
    //     if($this->form_validation->run() == false) {
    //         $this->load->view('createUser');
    //     }else {
    //         $this->data->create_user();
    //         redirect(base_url('user'));
    //     }
        
    // }

    public function post_create_user() {
        $data = $this->input->post();
        $status = false;        
        $this->validateForm();
        // if($this->form_validation->run() == false) {
        //     echo json_encode(form_e);
        // }else {
        $reponsive = $this->data->create_user();
        if($reponsive!=false){
            $data_mess = array(
                'status' => true,
                'mess'=> 'Thanh cong'
            );
        }else{
            $data_mess = array(
                'mess'=> 'loi vui long thu lai'
            );
        }
        echo json_encode($data_mess);
        // }
        
    }
    // public function get_edit_user($id) {
    //     $user['user'] = $this->data->find_user($id);
    //     $this->load->view('editUser',$user);
    // }

    // public function post_edit_user() {
    //     $this->data->edit_user();
    //     redirect(base_url('user/read'));
    // }

    // public function delete_user($id) {
    //     $this->data->delete_user($id);
    //     redirect(base_url('user/read'));
    // }

    public function delete_user($id) {
        $data = $this->input->post();
        $reponsive = $this->data->delete_user($id);
        $status = true;
        if($reponsive!=false){
            $data_mess = array(
                'status' => $status,
                'mess'=> 'Thanh cong'
            );
        }else{
            $data_mess = array(
                'mess'=> 'loi vui long thu lai'
            );
        }
        echo json_encode($data_mess);
    }

    public function get_edit_user($id)
    {
        $data = $this->input->post();
        $reponsive = $this->data->get_edit($id);
        echo json_encode($reponsive);
    }

    public function post_edit_user($id) {
        $data = $this->input->post();
        $responsive = $this->data->edit_user($id);
        $status = true;
        if(!empty($responsive)){
            $data_mess = array(
                'status' => $status,
                'mess'=> 'Thanh cong'
            );
        }else{
            $data_mess = array(
                'mess'=> 'loi vui long thu lai'
            );
        }
        echo json_encode($data_mess);
    }

    public function load_list_user() {
        $data['data'] = $this->data->read_user();
        $this->load->view('readUser', $data);        
    }

}
?>