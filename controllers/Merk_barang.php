<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merk_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Merk_barang_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','merk_barang/tbl_merk_barang_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Merk_barang_model->json();
    }

    public function read($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_merk_barang' => $row->id_merk_barang,
		'merk_barang_kode' => $row->merk_barang_kode,
	    );
            $this->template->load('template','merk_barang/tbl_merk_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merk_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('merk_barang/create_action'),
	    'id_merk_barang' => set_value('id_merk_barang'),
	    'merk_barang_kode' => set_value('merk_barang_kode'),
	);
        $this->template->load('template','merk_barang/tbl_merk_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'merk_barang_kode' => $this->input->post('merk_barang_kode',TRUE),
	    );

            $this->Merk_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('merk_barang/update_action'),
		'id_merk_barang' => set_value('id_merk_barang', $row->id_merk_barang),
		'merk_barang_kode' => set_value('merk_barang_kode', $row->merk_barang_kode),
	    );
            $this->template->load('template','merk_barang/tbl_merk_barang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_merk_barang', TRUE));
        } else {
            $data = array(
		'merk_barang_kode' => $this->input->post('merk_barang_kode',TRUE),
	    );

            $this->Merk_barang_model->update($this->input->post('id_merk_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);

        if ($row) {
            $this->Merk_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('merk_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merk_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('merk_barang_kode', 'merk barang kode', 'trim|required');

	$this->form_validation->set_rules('id_merk_barang', 'id_merk_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Merk_barang.php */
/* Location: ./application/controllers/Merk_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 19:19:31 */
/* http://harviacode.com */