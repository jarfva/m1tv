<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Jenis_barang_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','jenis_barang/tbl_jenis_barang_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Jenis_barang_model->json();
    }

    public function read($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_jenis_barang' => $row->id_jenis_barang,
		'jenis_barang_kode' => $row->jenis_barang_kode,
		'kode_jenis_barang' => $row->kode_jenis_barang,
	    );
            $this->template->load('template','jenis_barang/tbl_jenis_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jenis_barang/create_action'),
	    'id_jenis_barang' => set_value('id_jenis_barang'),
	    'jenis_barang_kode' => set_value('jenis_barang_kode'),
	    'kode_jenis_barang' => set_value('kode_jenis_barang'),
	);
        $this->template->load('template','jenis_barang/tbl_jenis_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis_barang_kode' => $this->input->post('jenis_barang_kode',TRUE),
		'kode_jenis_barang' => $this->input->post('kode_jenis_barang',TRUE),
	    );

            $this->Jenis_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jenis_barang/update_action'),
		'id_jenis_barang' => set_value('id_jenis_barang', $row->id_jenis_barang),
		'jenis_barang_kode' => set_value('jenis_barang_kode', $row->jenis_barang_kode),
		'kode_jenis_barang' => set_value('kode_jenis_barang', $row->kode_jenis_barang),
	    );
            $this->template->load('template','jenis_barang/tbl_jenis_barang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jenis_barang', TRUE));
        } else {
            $data = array(
		'jenis_barang_kode' => $this->input->post('jenis_barang_kode',TRUE),
		'kode_jenis_barang' => $this->input->post('kode_jenis_barang',TRUE),
	    );

            $this->Jenis_barang_model->update($this->input->post('id_jenis_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);

        if ($row) {
            $this->Jenis_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jenis_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_barang_kode', 'jenis barang kode', 'trim|required');
	$this->form_validation->set_rules('kode_jenis_barang', 'kode jenis barang', 'trim|required');

	$this->form_validation->set_rules('id_jenis_barang', 'id_jenis_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jenis_barang.php */
/* Location: ./application/controllers/Jenis_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 16:31:35 */
/* http://harviacode.com */