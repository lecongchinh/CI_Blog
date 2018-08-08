<?php 

class User extends CI_Model {
    public function __construct() {
        $this->load->database();

    }

    public function create_user() {
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );
        return $this->db->insert('user', $data);
    }

    public function read_user() {
        $query = $this->db->get('user');
        return $query->result();
    }

    public function find_user($id) {
        // $this->db->select();
        // $this->db->from('user');
        // $this->db->where('id',$id);

        // $query = $this->input->get()->result_array();
        // return $query;

        return $this->db->get_where('user', array('id' => $id))->row();
    }

    public function edit_user($id) {
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );
        $this->db->where('id',$id);
        return $this->db->update('user', $data);
    }

    public function get_edit($id) {
        $this->db->select();
        $this->db->from('user');
        $this->db->where('id',$id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete_user($id) {
       return $this->db->delete('user', array('id' => $id));
    }

}