<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Department_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','department/tbl_department_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Department_model->json();
    }

    public function read($id) 
    {
        $row = $this->Department_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_department' => $row->id_department,
		'department_karyawan' => $row->department_karyawan,
	    );
            $this->template->load('template','department/tbl_department_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('department'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('department/create_action'),
	    'id_department' => set_value('id_department'),
	    'department_karyawan' => set_value('department_karyawan'),
	);
        $this->template->load('template','department/tbl_department_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'department_karyawan' => $this->input->post('department_karyawan',TRUE),
	    );

            $this->Department_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('department'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Department_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('department/update_action'),
		'id_department' => set_value('id_department', $row->id_department),
		'department_karyawan' => set_value('department_karyawan', $row->department_karyawan),
	    );
            $this->template->load('template','department/tbl_department_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('department'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_department', TRUE));
        } else {
            $data = array(
		'department_karyawan' => $this->input->post('department_karyawan',TRUE),
	    );

            $this->Department_model->update($this->input->post('id_department', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('department'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Department_model->get_by_id($id);

        if ($row) {
            $this->Department_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('department'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('department'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('department_karyawan', 'department karyawan', 'trim|required');

	$this->form_validation->set_rules('id_department', 'id_department', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Department.php */
/* Location: ./application/controllers/Department.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 18:49:09 */
/* http://harviacode.com */