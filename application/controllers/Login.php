<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
        $this->load->library('session');

        if ($this->session->has_userdata('hasLogin')) {
            redirect('/admin');
        }
    }


    public function index()
    {
        $this->load->view('login/index');
    }

    public function cekLogin()
    {
        $keys = array_column($this->input->post('data'), 'name');
        $values = array_column($this->input->post('data'), 'value');

        $data = array_combine($keys, $values);

        $user = $data['username'];
        $pass = $data['password'];

        $cek = $this->db->get_where('tbl_admin', array('username' => $user, 'password' => $pass))->result_array();

        if (count($cek) >= 1) {
            $res = array(true);
            $set = array("hasLogin" => true);
            $this->session->set_userdata($set);
        } else {
            $res = array(false);
        }

        echo json_encode($res);
    }
}
