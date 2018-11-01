<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lokasi_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Lokasi_barang_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','lokasi_barang/tbl_lokasi_barang_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Lokasi_barang_model->json();
    }

    public function read($id) 
    {
        $row = $this->Lokasi_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_lokasi_barang' => $row->id_lokasi_barang,
		'lokasi_barang_simpan' => $row->lokasi_barang_simpan,
		'kode_lokasi' => $row->kode_lokasi,
	    );
            $this->template->load('template','lokasi_barang/tbl_lokasi_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('lokasi_barang/create_action'),
	    'id_lokasi_barang' => set_value('id_lokasi_barang'),
	    'lokasi_barang_simpan' => set_value('lokasi_barang_simpan'),
	    'kode_lokasi' => set_value('kode_lokasi'),
	);
        $this->template->load('template','lokasi_barang/tbl_lokasi_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'lokasi_barang_simpan' => $this->input->post('lokasi_barang_simpan',TRUE),
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
	    );

            $this->Lokasi_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('lokasi_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Lokasi_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('lokasi_barang/update_action'),
		'id_lokasi_barang' => set_value('id_lokasi_barang', $row->id_lokasi_barang),
		'lokasi_barang_simpan' => set_value('lokasi_barang_simpan', $row->lokasi_barang_simpan),
		'kode_lokasi' => set_value('kode_lokasi', $row->kode_lokasi),
	    );
            $this->template->load('template','lokasi_barang/tbl_lokasi_barang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_lokasi_barang', TRUE));
        } else {
            $data = array(
		'lokasi_barang_simpan' => $this->input->post('lokasi_barang_simpan',TRUE),
		'kode_lokasi' => $this->input->post('kode_lokasi',TRUE),
	    );

            $this->Lokasi_barang_model->update($this->input->post('id_lokasi_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('lokasi_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Lokasi_barang_model->get_by_id($id);

        if ($row) {
            $this->Lokasi_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('lokasi_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('lokasi_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('lokasi_barang_simpan', 'lokasi barang simpan', 'trim|required');
	$this->form_validation->set_rules('kode_lokasi', 'kode lokasi', 'trim|required');

	$this->form_validation->set_rules('id_lokasi_barang', 'id_lokasi_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Lokasi_barang.php */
/* Location: ./application/controllers/Lokasi_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 19:26:25 */
/* http://harviacode.com */