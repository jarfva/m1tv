<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Barang_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }
    public function index()
    {
        $this->template->load('template','barang/tbl_barang_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Barang_model->json();
    }
    public function read($id) 
    {
        $row = $this->Barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_barang' => $row->id_barang,
		'group_barang' => $row->group_barang,
		'jenis_barang' => $row->jenis_barang,
		'merk_barang' => $row->merk_barang,
		'type_barang' => $row->type_barang,
		'uraian_barang' => $row->uraian_barang,
		'barcode_barang' => $row->barcode_barang,
		'barcode_barang_detail' => $row->barcode_barang_detail,
		'serial_number' => $row->serial_number,
		'lokasi_barang' => $row->lokasi_barang,
		'aset_barang' => $row->aset_barang,
        'tag_form_pinjam' => $row->tag_form_pinjam,
        'kondisi' => $row->kondisi,
	    );
            $this->template->load('template','barang/tbl_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
        }
    }
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('barang/create_action'),
	    'id_barang' => set_value('id_barang'),
	    'group_barang' => set_value('group_barang'),
	    'jenis_barang' => set_value('jenis_barang'),
	    'merk_barang' => set_value('merk_barang'),
	    'type_barang' => set_value('type_barang'),
	    'uraian_barang' => set_value('uraian_barang'),
	    'barcode_barang' => set_value('barcode_barang'),
	    'barcode_barang_detail' => set_value('barcode_barang_detail'),
	    'serial_number' => set_value('serial_number'),
	    'lokasi_barang' => set_value('lokasi_barang'),
	    'aset_barang' => set_value('aset_barang'),
	    'tag_form_pinjam' => set_value('tag_form_pinjam','AVAILABLE'),
        'kondisi' => set_value('kondisi'),
	);
        $this->template->load('template','barang/tbl_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
        $barcode = barcode($_POST['aset_barang'],$_POST['group_barang'],$_POST['jenis_barang'],$_POST['lokasi_barang']);
        $param = substr($barcode,0,10);
        $lok = substr($barcode,11,14);
        $barcode_detail = barcode_detail($param,$lok);
        
        $this->load->library('ciqrcode');
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);    
        $image_name=$barcode_detail.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $barcode_detail; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data = array(
		'group_barang' => $this->input->post('group_barang',TRUE),
		'jenis_barang' => $this->input->post('jenis_barang',TRUE),
		'merk_barang' => $this->input->post('merk_barang',TRUE),
		'type_barang' => $this->input->post('type_barang',TRUE),
		'uraian_barang' => $this->input->post('uraian_barang',TRUE),
		'barcode_barang' => $barcode,
		'barcode_barang_detail' => $barcode_detail,
		'serial_number' => $this->input->post('serial_number',TRUE),
		'lokasi_barang' => $this->input->post('lokasi_barang',TRUE),
		'aset_barang' => $this->input->post('aset_barang',TRUE),
        'tag_form_pinjam' => $this->input->post('tag_form_pinjam',TRUE),
        'kondisi' => $this->input->post('kondisi',TRUE),
        'qr_code' => $image_name
	    );
            $this->Barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Barang_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('barang/update_action'),
		'id_barang' => set_value('id_barang', $row->id_barang),
		'group_barang' => set_value('group_barang', $row->group_barang),
		'jenis_barang' => set_value('jenis_barang', $row->jenis_barang),
		'merk_barang' => set_value('merk_barang', $row->merk_barang),
		'type_barang' => set_value('type_barang', $row->type_barang),
		'uraian_barang' => set_value('uraian_barang', $row->uraian_barang),
		'barcode_barang' => set_value('barcode_barang', $row->barcode_barang),
		'barcode_barang_detail' => set_value('barcode_barang_detail', $row->barcode_barang_detail),
		'serial_number' => set_value('serial_number', $row->serial_number),
		'lokasi_barang' => set_value('lokasi_barang', $row->lokasi_barang),
		'aset_barang' => set_value('aset_barang', $row->aset_barang),
		'tag_form_pinjam' => set_value('tag_form_pinjam', $row->tag_form_pinjam),
        'kondisi' => set_value('kondisi', $row->kondisi),
	    );
            $this->template->load('template','barang/tbl_barang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_barang', TRUE));
        } else {
            $barcode = barcode($_POST['aset_barang'],$_POST['group_barang'],$_POST['jenis_barang'],$_POST['lokasi_barang']);
            $param = substr($barcode,0,10);
            $lok = substr($barcode,11,14);
            $barcode_detail = barcode_detail($param,$lok);
            
            $this->load->library('ciqrcode');
    
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(70,130,180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);    
    
            $image_name=$barcode_detail.'.png'; //buat name dari qr code sesuai dengan nim
     
            $params['data'] = $barcode_detail; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $data = array(
		'group_barang' => $this->input->post('group_barang',TRUE),
		'jenis_barang' => $this->input->post('jenis_barang',TRUE),
		'merk_barang' => $this->input->post('merk_barang',TRUE),
		'type_barang' => $this->input->post('type_barang',TRUE),
		'uraian_barang' => $this->input->post('uraian_barang',TRUE),
		'barcode_barang' => $barcode,
		'barcode_barang_detail' => $barcode_detail,
		'serial_number' => $this->input->post('serial_number',TRUE),
		'lokasi_barang' => $this->input->post('lokasi_barang',TRUE),
		'aset_barang' => $this->input->post('aset_barang',TRUE),
        'tag_form_pinjam' => $this->input->post('tag_form_pinjam',TRUE),
        'kondisi' => $this->input->post('kondisi',TRUE),
        'qr_code' => $image_name
	    );
            $this->Barang_model->update($this->input->post('id_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Barang_model->get_by_id($id);
        if ($row) {
            $this->Barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('barang'));
        }
    }
    public function _rules() 
    {
	$this->form_validation->set_rules('group_barang', 'group barang', 'trim|required');
	$this->form_validation->set_rules('jenis_barang', 'jenis barang', 'trim|required');
	$this->form_validation->set_rules('merk_barang', 'merk barang', 'trim|required');
	$this->form_validation->set_rules('type_barang', 'type barang', 'trim|required');
	$this->form_validation->set_rules('uraian_barang', 'uraian barang', 'trim|required');
	// $this->form_validation->set_rules('barcode_barang', 'barcode barang', 'trim|required');
	// $this->form_validation->set_rules('barcode_barang_detail', 'barcode barang detail', 'trim|required');
	$this->form_validation->set_rules('serial_number', 'serial number', 'trim|required');
	$this->form_validation->set_rules('lokasi_barang', 'lokasi barang', 'trim|required');
	$this->form_validation->set_rules('aset_barang', 'aset barang', 'trim|required');
	$this->form_validation->set_rules('tag_form_pinjam', 'tag form pinjam', 'trim|required');
    $this->form_validation->set_rules('kondisi', 'kondisi barang', 'trim|required');
	$this->form_validation->set_rules('id_barang', 'id_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_barang.xls";
        $judul = "tbl_barang";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");
        xlsBOF();
        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Group Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Merk Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Type Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Uraian Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Barcode Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Barcode Barang Detail");
	xlsWriteLabel($tablehead, $kolomhead++, "Serial Number");
	xlsWriteLabel($tablehead, $kolomhead++, "Lokasi Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Aset Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Tag Form Pinjam");
    xlsWriteLabel($tablehead, $kolomhead++, "Kondisi Barang");
	foreach ($this->Barang_model->get_all() as $data) {
            $kolombody = 0;
            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->group_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->merk_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->type_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->uraian_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->barcode_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->barcode_barang_detail);
	    xlsWriteLabel($tablebody, $kolombody++, $data->serial_number);
	    xlsWriteLabel($tablebody, $kolombody++, $data->lokasi_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->aset_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tag_form_pinjam);
        xlsWriteLabel($tablebody, $kolombody++, $data->kondisi);
	    $tablebody++;
            $nourut++;
        }
        xlsEOF();
        exit();
    }
}
/* End of file Barang.php */
/* Location: ./application/controllers/Barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 18:18:55 */
/* http://harviacode.com */
