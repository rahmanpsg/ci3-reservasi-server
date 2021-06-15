<?php
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
        $this->load->library('session');

        if (!$this->session->has_userdata('hasLogin')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['totalCustomer'] = $this->Model->ambilTotalData('tbl_customer');
        $data['totalReservasi'] = $this->Model->ambilTotalData('tbl_order');
        $data['totalMeja'] = $this->Model->ambilTotalData('tbl_meja');
        $this->load->view('admin/index', $data);
    }

    public function customer()
    {
        $data['TBL_URL'] = base_url('api/getDaftarCustomer');
        $this->load->view('admin/customer', $data);
    }

    public function order()
    {
        $data['TBL_URL'] = base_url('api/getDaftarPesanan');
        $this->load->view('admin/order', $data);
    }

    public function meja()
    {
        $data['TBL_URL'] = base_url('api/getDaftarHargaMeja');
        $this->load->view('admin/meja', $data);
    }

    public function bank()
    {
        // $data['TBL_URL'] = 
        // $this->load->view('admin/bank', $data);
    }
}
