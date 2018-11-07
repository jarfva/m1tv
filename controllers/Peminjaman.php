<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Peminjaman_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function testing(){
        echo date("Y-m-d H:i:s");
    }

    public function index()
    {
        $this->template->load('template','peminjaman/tbl_peminjaman_list');
    } 

    public function laporan()
    {
        $this->template->load('template','peminjaman/tbl_peminjaman_laporan');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Peminjaman_model->json();
    }

    public function json2() {
        header('Content-Type: application/json2');
        echo $this->Peminjaman_model->json2();
    }

    public function read($id) 
    {
        $row = $this->Peminjaman_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_peminjaman' => $row->id_peminjaman,
		'no_form_peminjaman' => $row->no_form_peminjaman,
		'id_form_barang' => $row->id_form_barang,
		'user_peminjaman' => $row->user_peminjaman,
		'nama_program' => $row->nama_program,
		'tgl_peminjaman' => $row->tgl_peminjaman,
		'tgl_pengembalian' => $row->tgl_pengembalian,
		'status_peminjaman' => $row->status_peminjaman,
	    );
            $this->template->load('template','peminjaman/tbl_peminjaman_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peminjaman'));
        }
    }

    public function create() {
        $nopinjam = noPeminjaman();
        $query = "SELECT * FROM `tbl_barang` where tag_form_pinjam='$nopinjam'";
        $data2 = $this->db->query($query)->result();
        $jum = $this->db->query($query)->num_rows();
        $data = array(
        'jumlah' => $jum,
        'db' => $data2,
        'test' => 'imam',
        'button' => 'Save',
        'action' => site_url('peminjaman/create_action'),
	    'id_peminjaman' => set_value('id_peminjaman'),
	    'no_form_peminjaman' => set_value('no_form_peminjaman',noPeminjaman()),
	    'id_form_barang' => set_value('id_form_barang'),
	    'user_peminjaman' => set_value('user_peminjaman'),
	    'nama_program' => set_value('nama_program'),
	    'tgl_peminjaman' => set_value('tgl_peminjaman',date("Y-m-d H:i:s")),
	    'tgl_pengembalian' => set_value('tgl_pengembalian',date("Y-m-d H:i:s")),
	    'status_peminjaman' => set_value('status_peminjaman','DIPINJAM'),
    );

        $this->template->load('template','peminjaman/tbl_peminjaman_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_form_peminjaman' => $this->input->post('no_form_peminjaman',TRUE),
		'id_form_barang' => $this->input->post('id_form_barang',TRUE),
		'user_peminjaman' => $this->input->post('user_peminjaman',TRUE),
		'nama_program' => $this->input->post('nama_program',TRUE),
		'tgl_peminjaman' => $this->input->post('tgl_peminjaman',TRUE),
		'tgl_pengembalian' => $this->input->post('tgl_pengembalian',TRUE),
		'status_peminjaman' => $this->input->post('status_peminjaman',TRUE),
	    );

            $this->Peminjaman_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('peminjaman'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Peminjaman_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('peminjaman/update_action'),
		'id_peminjaman' => set_value('id_peminjaman', $row->id_peminjaman),
		'no_form_peminjaman' => set_value('no_form_peminjaman', $row->no_form_peminjaman),
		'id_form_barang' => set_value('id_form_barang', $row->id_form_barang),
		'user_peminjaman' => set_value('user_peminjaman', $row->user_peminjaman),
		'nama_program' => set_value('nama_program', $row->nama_program),
		'tgl_peminjaman' => set_value('tgl_peminjaman', $row->tgl_peminjaman),
		'tgl_pengembalian' => set_value('tgl_pengembalian', $row->tgl_pengembalian),
		'status_peminjaman' => set_value('status_peminjaman', $row->status_peminjaman),
	    );
            $this->template->load('template','peminjaman/tbl_peminjaman_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peminjaman'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_peminjaman', TRUE));
        } else {
            $data = array(
		'no_form_peminjaman' => $this->input->post('no_form_peminjaman',TRUE),
		'id_form_barang' => $this->input->post('id_form_barang',TRUE),
		'user_peminjaman' => $this->input->post('user_peminjaman',TRUE),
		'nama_program' => $this->input->post('nama_program',TRUE),
		'tgl_peminjaman' => $this->input->post('tgl_peminjaman',TRUE),
		'tgl_pengembalian' => $this->input->post('tgl_pengembalian',TRUE),
		'status_peminjaman' => $this->input->post('status_peminjaman',TRUE),
	    );

            $this->Peminjaman_model->update($this->input->post('id_peminjaman', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('peminjaman'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Peminjaman_model->get_by_id($id);

        if ($row) {
            $this->Peminjaman_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('peminjaman'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peminjaman'));
        }
    }

    function clears(){
        $noPem = $this->input->get('noPeminjaman');
        $query = "UPDATE `tbl_barang` SET `tag_form_pinjam` = 'AVAILABLE' WHERE `tag_form_pinjam` = '$noPem'";
        $this->db->query($query);
    }

    function nik_ajax(){
        $nik = $this->input->get('nik');
        $user = $this->db->get_where('tbl_karyawan',array('nik_karyawan'=>$nik));
        $num = $user->num_rows();
        if ($num == 0){
            $data = array(
                'nama' => 'Not Found'
            );
            echo json_encode($data);
        } else {
            $karyawan = $user->row_array();
            $data = array(
                'nama' => $karyawan['nama_lengkap'],
                'id_karyawan' => $karyawan['id_karyawan']
            );
            echo json_encode($data);
        }
    }

    public function savebarang(){
        $status = 'DIPINJAM';
        $date = date("Y-m-d H:i:s");
        $nprogram = $this->input->get('nama_program');
        $niks = $this->input->get('nik');
        $nomer = $this->input->get('noPeminjaman');
        $query = "SELECT * FROM `tbl_barang` where tag_form_pinjam='$nomer'";
        $hasil = $this->db->query($query)->result_array();
        $jumlah = $this->db->query($query)->num_rows();
        for($i=0;$i<=$jumlah-1;$i++){
            $id_barang = $hasil[$i]['id_barang'];
            $query = "INSERT INTO `tbl_peminjaman` (`id_peminjaman`, `no_form_peminjaman`, `id_form_barang`, `user_peminjaman`, `nama_program`, `tgl_peminjaman`, `tgl_pengembalian`, `status_peminjaman`) VALUES (NULL, '$nomer', '$id_barang', '$niks', '$nprogram', '$date', '', '$status')";
            $this->db->query($query);
        }
    }


    public function add_product_ajax(){
        $barcode = $this->input->get('barcode');
        $noPeminjaman = $this->input->get('noPeminjaman');
        $barang = $this->db->query("SELECT * FROM `tbl_barang` WHERE `tag_form_pinjam`='AVAILABLE' and `kondisi` = 'OK' and `barcode_barang` LIKE '$barcode%' or uraian_barang LIKE '$%barcode%' LIMIT 5")->result(); 
        echo "
        <table class='table table-bordered'>
        <tr><th>Barcode Detail</th><th>Nama Barang</th><th>S/N</th><th>Add</th></tr>
        " ;
        foreach ($barang as $peminjaman)
            {
                echo "<tr><td>$peminjaman->barcode_barang_detail</td>
                <td>$peminjaman->uraian_barang</td>
                <td>$peminjaman->serial_number</td>
                <td>";
                //echo anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>','class="btn btn-danger btn-sm"','onclick="testlagi()"'); 
                //echo anchor('peminjaman/create', '<i class="fa fa-eye" aria-hidden="true"></i>', array('id'=>'tambahin','value'=>$peminjaman->serial_number,'class'=>'btn btn-danger btn-sm', 'onclick'=>'testlagi();'));
                //echo "<input type='button' id='tombol' onclick='testlagi()' value=$peminjaman->serial_number>";
                echo "<button type='button' class='btn btn-danger'  onclick=pinjam($peminjaman->id_barang) id='tombol'><i class='fa fa-floppy-o'></i> Pinjam</button>";
                echo "</td></tr>" ;
                
            }
        echo "
        </table>
        </div>" ;
    }

    public function pinjam_action(){
        $id = $this->input->get('barcode');
        $no = $this->input->get('noPeminjaman');
        $query = "UPDATE tbl_barang SET tag_form_pinjam = '$no' WHERE id_barang= '$id'";
        $this->db->query($query);
        $query2 = "SELECT * FROM `tbl_barang` where tag_form_pinjam = '$no'";
        $data = $this->db->query($query2)->result();
        $jumlah = $this->db->query($query2)->num_rows();
        echo "<table class='table table-bordered'>
        <tr><th>Barcode Detail</th><th>Nama Barang</th><th>S/N</th><th>Add</th></tr>
        <input type='hidden' class='form-control' name='addbarangs' id='addbarangs' value=$jumlah />
        " ;
        foreach ($data as $peminjaman) {
            echo "<tr><td>$peminjaman->barcode_barang_detail</td>
            <td>$peminjaman->uraian_barang</td>
            <td>$peminjaman->serial_number</td>
            <td> 
            <button type='button' class='btn btn-danger'  onclick='deleteds($peminjaman->id_barang)' id='tombol'><i class='fa fa-floppy-o'></i> Delete</button>
            </td></tr>" ;
        }
    }

    public function delete_action(){
        $id = $this->input->get('id');
        $no = $this->input->get('no_form_barang');
        $query = "UPDATE `tbl_barang` SET `tag_form_pinjam` = 'AVAILABLE' WHERE id_barang = $id";
        $this->db->query($query);
        $query2 = "SELECT * FROM `tbl_barang` where tag_form_pinjam = '$no'";
        $data = $this->db->query($query2)->result();
        $jumlah = $this->db->query($query2)->num_rows();
        echo "<table class='table table-bordered'>
        <tr><th>Barcode Detail</th><th>Nama Barang</th><th>S/N</th><th>Add</th></tr>
        <input type='hidden' class='form-control' name='addbarangs' id='addbarangs' value=$jumlah />
        " ;
        foreach ($data as $peminjaman) {
            echo "<tr><td>$peminjaman->barcode_barang_detail</td>
            <td>$peminjaman->uraian_barang</td>
            <td>$peminjaman->serial_number</td>
            <td> 
            <button type='button' class='btn btn-danger'  onclick='deleteds($peminjaman->id_barang)' id='tombol'><i class='fa fa-floppy-o'></i> Delete</button>
            </td></tr>" ;
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_form_peminjaman', 'no form peminjaman', 'trim|required');
	$this->form_validation->set_rules('id_form_barang', 'id form barang', 'trim|required');
	$this->form_validation->set_rules('user_peminjaman', 'user peminjaman', 'trim|required');
	$this->form_validation->set_rules('nama_program', 'nama program', 'trim|required');
	$this->form_validation->set_rules('tgl_peminjaman', 'tgl peminjaman', 'trim|required');
	$this->form_validation->set_rules('tgl_pengembalian', 'tgl pengembalian', 'trim|required');
	$this->form_validation->set_rules('status_peminjaman', 'status peminjaman', 'trim|required');

	$this->form_validation->set_rules('id_peminjaman', 'id_peminjaman', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function pdf(){
        $uriString = $this->uri->uri_string();
        $noPinjam = substr($uriString, 15);
        $query ="SELECT * FROM `tbl_peminjaman` JOIN tbl_karyawan ON tbl_karyawan.id_karyawan = tbl_peminjaman.user_peminjaman where no_form_peminjaman='$noPinjam'";
        $query_no = $this->db->query($query);
        $data = $query_no->row_array();
        $tgl = substr($data['tgl_peminjaman'],0,10);
        $jam = substr($data['tgl_peminjaman'],10);
        $id_kar = $data['user_peminjaman'];
        $this->db->select('*');
        $this->db->where('id_karyawan', $id_kar);
        $this->db->from('tbl_karyawan');
        $this->db->join('tbl_department', 'tbl_department.id_department = tbl_karyawan.id_karyawan');
        $query2 = $this->db->get()->row_array();

        
        //$query3 = "SELECT * FROM `tbl_barang` JOIN tbl_merk_barang ON tbl_merk_barang.id_merk_barang = tbl_barang.merk_barang where tag_form_pinjam='$noPinjam' group by type_barang, jenis_barang";

        $query3 = "SELECT kode_jenis_barang, merk_barang_kode, type_barang, COUNT(merk_barang_kode) jmlBarang
FROM `tbl_barang`
JOIN tbl_merk_barang ON tbl_merk_barang.id_merk_barang = tbl_barang.merk_barang
JOIN tbl_jenis_barang ON tbl_jenis_barang.id_jenis_barang = tbl_barang.jenis_barang
where tag_form_pinjam='$noPinjam'
group by type_barang, jenis_barang, kode_jenis_barang";

        $data2 = $this->db->query($query3)->result();
        $total = $this->db->query($query3)->num_rows();
        $petugas = $this->session->userdata('full_name');

        $this->load->library('pdf');
        $pdf = new FPDF('P','mm','A4');
        // membuat halaman baru
        $pdf->AddPage('P');
        // setting jenis font yang akan digunakan
        $image = base_url()."assets/img/KopSurat.PNG";
        $pdf->Image($image,10,10,190);
        $pdf->line(9,55,251-50,55);
        $pdf->line(14,56,217-20,56);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->cell(46,46,'',0,1);
        //tanggal
        $pdf->cell(37,5,'Tanggal',1,0,'1');
        $pdf->cell(58,5,$tgl,1,0,'10');
        //no
        $pdf->cell(25,5,'no',1,0,'10');
        $pdf->cell(70,5,$noPinjam,1,1,'10');
        //permohonan
        $pdf->cell(37,5,'Pemohon',1,0,'1');
        $pdf->cell(58,5,$data['nama_lengkap'],1,0,'10');
        //no
        $pdf->cell(25,5,'Persiapan',1,0,'10');
        $pdf->cell(70,5,'',1,1,'10');
        //tanggal
        $pdf->cell(37,5,'Departemen Pemohon ',1,0,'1');
        $pdf->cell(58,5,$query2['department_karyawan'],1,0,'10');
        //no
        $pdf->cell(25,5,'Penggunaan',1,0,'10');
        $pdf->cell(70,5,$data['nama_program'],1,1,'10');
        //tanggal
        $pdf->cell(37,5,'Departemen Terkait',1,0,'1');
        $pdf->cell(58,5,'BROADCAST',1,0,'10');
        //no
        $pdf->cell(25,5,'Lokasi',1,0,'10');
        $pdf->cell(70,5,'',1,1,'10');
        //tanggal
        $pdf->cell(37,5,'',1,0,'1');
        $pdf->cell(58,5,'',1,0,'10');
        //no
        $pdf->cell(25,5,'',1,0,'10');
        $pdf->cell(70,5,'',1,1,'10');
        //spasi
        $pdf->cell(1,1,'',0,1);
        // label kolom
        $pdf->cell(10,5,'No.',1,0,'C');
        $pdf->cell(76,5,'Nama Barang',1,0,'C');
        $pdf->cell(75,5,'Keterangan',1,0,'C');
        $pdf->cell(15,5,'Quantity',1,0,'C');
        $pdf->cell(14,5,'Satuan',1,1,'C');
        // isi data
        $i = 1;
        foreach ($data2 as $d ){
        
        $pdf->cell(10,5,$i,0,0,'C');
        $pdf->cell(76,5,$d->kode_jenis_barang.'  '.$d->merk_barang_kode.'  '.$d->type_barang,0,0,'L');
        $pdf->cell(75,5,'',0,0,'C');
        $pdf->cell(15,5,$d->jmlBarang,0,0,'C');
        $pdf->cell(14,5,'pcs',0,1,'C');
        $i++;
        }

        $jumlah = 16-$total;
        for($i=0;$i<=$jumlah-1;$i++){
            $pdf->cell(10,5,'',0,0,'C');
            $pdf->cell(76,5,'',0,0,'L');
            $pdf->cell(75,5,'',0,0,'C');
            $pdf->cell(15,5,'',0,0,'C');
            $pdf->cell(14,5,'',0,1,'C');
        }

        // $jml = 



        // $pdf->SetFont('Arial', 'B', 7);
        // $pdf->cell(75,5,'Total :',1,0,'T');
        // $pdf->cell(75,5,$d->jumlah,1,1,'T');

        // 0 = 80
        // 1 = 76
        // 2 = 72
        // $pengurangan = $total*4;
        // $cell = 78 - $pengurangan;


        // $pdf->cell(10,$cell,'',1,0,'C');
        // $pdf->cell(76,$cell,'',1,0,'C');
        // $pdf->cell(75,$cell,'',1,0,'C');
        // $pdf->cell(15,$cell,'',1,0,'C');
        // $pdf->cell(14,$cell,'',1,1,'C');
        //keterangan
        // $pdf->cell(190,7,'KETERANGAN',0,1);
        $pdf->cell(190,50,'keterangan :',1,1,'T');

        $pdf->cell(95,7,'KELUAR BARANG',1,0,'C');
        $pdf->cell(95,7,'KEMBALI BARANG',1,1,'C');

        $pdf->cell(47,6,'TGL :'.' '.$tgl,1,0,'L');
        $pdf->cell(48,6,'JAM :'.' '.$jam,1,0,'L');
        $pdf->cell(47,6,'TGL :',1,0,'L');
        $pdf->cell(48,6,'JAM :',1,1,'L');

        $pdf->cell(47,6,'Dimohon',1,0,'C');
        $pdf->cell(48,6,'Diperiksa',1,0,'C');
        $pdf->cell(47,6,'Dimohon',1,0,'C');
        $pdf->cell(48,6,'Diperiksa',1,1,'C');

        $pdf->cell(47,6,$data['nama_lengkap'],1,0,'C');
        $pdf->cell(48,6,$petugas,1,0,'C');
        $pdf->cell(47,6,$data['nama_lengkap'],1,0,'C');
        $pdf->cell(48,6,$petugas,1,1,'C');

        $pdf->cell(47,20,'',1,0,'C');
        $pdf->cell(48,20,'',1,0,'C');
        $pdf->cell(47,20,'',1,0,'C');
        $pdf->cell(48,20,'',1,1,'C');

        $pdf->cell(48,7,'',0,1);

        $pdf->cell(48,7,'1. Putih Logistik',0,0);
        $pdf->cell(47,7,'2. Kuning Security',0,0);
        $pdf->cell(50,7,'3. Biru Pemohon',0,1);
        //kotak luar
        $pdf->Line(9, 9,210-9,9); // Horizontal line at top
        $pdf->Line(9, 285-9,210-9,285-9); // Horizontal line at bottom
        $pdf->Line(9, 9,9,285-9); // Vetical line at left 
        $pdf->Line(210-9, 9,210-9,285-9); // Vetical line at Right
        //kotak data
        $pdf->Line(10, 87,10,177-10);
        $pdf->Line(20, 87,20,187-20);
        $pdf->Line(96, 87,96,263-96);
        $pdf->Line(171, 87,171,338-171);
        $pdf->Line(186, 87,186,353-186);
        $pdf->Line(200, 87,200,367-200);
        
        
        $pdf->Output('D',$noPinjam.'.pdf');
    }

    // public function pdf(){
    //     $uriString = $this->uri->uri_string();
    //     $noPinjam = substr($uriString, 15);
    //     $query ="SELECT * FROM `tbl_peminjaman` JOIN tbl_karyawan ON tbl_karyawan.id_karyawan = tbl_peminjaman.user_peminjaman where no_form_peminjaman='$noPinjam'";
    //     $query_no = $this->db->query($query);
    //     $data = $query_no->row_array();
    //     $tgl = substr($data['tgl_peminjaman'],0,10);
    //     $jam = substr($data['tgl_peminjaman'],10);
    //     $id_kar = $data['user_peminjaman'];
    //     $this->db->select('*');
    //     $this->db->where('id_karyawan', $id_kar);
    //     $this->db->from('tbl_karyawan');
    //     $this->db->join('tbl_department', 'tbl_department.id_department = tbl_karyawan.id_karyawan');
    //     $query2 = $this->db->get()->row_array();

        
    //     $query3 = "SELECT * FROM `tbl_barang` JOIN tbl_merk_barang ON tbl_merk_barang.id_merk_barang = tbl_barang.merk_barang where tag_form_pinjam='$noPinjam'";
    //     $data2 = $this->db->query($query3)->result();
    //     $total = $this->db->query($query3)->num_rows();
    //     $petugas = $this->session->userdata('full_name');

    //     $this->load->library('pdf');
    //     $pdf = new FPDF('P','mm','A4');
    //     // membuat halaman baru
    //     $pdf->AddPage('P');
    //     // setting jenis font yang akan digunakan
    //     $image = base_url()."assets/img/KopSurat.PNG";
    //     $pdf->Image($image,10,10,190);
    //     $pdf->line(9,55,251-50,55);
    //     $pdf->line(14,56,217-20,56);
    //     $pdf->SetFont('Arial', 'B', 8);
    //     $pdf->cell(46,46,'',0,1);
    //     //tanggal
    //     $pdf->cell(37,5,'Tanggal',1,0,'1');
    //     $pdf->cell(58,5,$tgl,1,0,'10');
    //     //no
    //     $pdf->cell(25,5,'no',1,0,'10');
    //     $pdf->cell(70,5,$noPinjam,1,1,'10');
    //     //permohonan
    //     $pdf->cell(37,5,'Pemohon',1,0,'1');
    //     $pdf->cell(58,5,$data['nama_lengkap'],1,0,'10');
    //     //no
    //     $pdf->cell(25,5,'Persiapan',1,0,'10');
    //     $pdf->cell(70,5,'',1,1,'10');
    //     //tanggal
    //     $pdf->cell(37,5,'Departemen Pemohon ',1,0,'1');
    //     $pdf->cell(58,5,$query2['department_karyawan'],1,0,'10');
    //     //no
    //     $pdf->cell(25,5,'Penggunaan',1,0,'10');
    //     $pdf->cell(70,5,$data['nama_program'],1,1,'10');
    //     //tanggal
    //     $pdf->cell(37,5,'Departemen Terkait',1,0,'1');
    //     $pdf->cell(58,5,'BROADCAST',1,0,'10');
    //     //no
    //     $pdf->cell(25,5,'Lokasi',1,0,'10');
    //     $pdf->cell(70,5,'',1,1,'10');
    //     //tanggal
    //     $pdf->cell(37,5,'',1,0,'1');
    //     $pdf->cell(58,5,'',1,0,'10');
    //     //no
    //     $pdf->cell(25,5,'',1,0,'10');
    //     $pdf->cell(70,5,'',1,1,'10');
    //     //spasi
    //     $pdf->cell(1,1,'',0,1);
    //     // label kolom
    //     $pdf->cell(10,5,'No.',1,0,'C');
    //     $pdf->cell(76,5,'Nama Barang',1,0,'C');
    //     $pdf->cell(75,5,'Keterangan',1,0,'C');
    //     $pdf->cell(15,5,'Quantity',1,0,'C');
    //     $pdf->cell(14,5,'Satuan',1,1,'C');
    //     // isi data
    //     $i = 1;
    //     foreach ($data2 as $d ){
        
    //     $pdf->cell(10,5,$i,0,0,'C');
    //     $pdf->cell(76,5,$d->merk_barang_kode.'  '.$d->type_barang,0,0,'L');
    //     $pdf->cell(75,5,'',0,0,'C');
    //     $pdf->cell(15,5,1,0,0,'C');
    //     $pdf->cell(14,5,1,0,1,'C');
    //     $i++;
    //     }

    //     $jumlah = 16-$total;
    //     for($i=0;$i<=$jumlah-1;$i++){
    //         $pdf->cell(10,5,'',0,0,'C');
    //         $pdf->cell(76,5,'',0,0,'L');
    //         $pdf->cell(75,5,'',0,0,'C');
    //         $pdf->cell(15,5,'',0,0,'C');
    //         $pdf->cell(14,5,'',0,1,'C');
    //     }
    //     // 0 = 80
    //     // 1 = 76
    //     // 2 = 72
    //     // $pengurangan = $total*4;
    //     // $cell = 78 - $pengurangan;


    //     // $pdf->cell(10,$cell,'',1,0,'C');
    //     // $pdf->cell(76,$cell,'',1,0,'C');
    //     // $pdf->cell(75,$cell,'',1,0,'C');
    //     // $pdf->cell(15,$cell,'',1,0,'C');
    //     // $pdf->cell(14,$cell,'',1,1,'C');
    //     //keterangan
    //     // $pdf->cell(190,7,'KETERANGAN',0,1);
    //     $pdf->cell(190,50,'keterangan :',1,1,'T');
    //     $pdf->SetFont('Arial', 'B', 7);

    //     $pdf->cell(95,7,'KELUAR BARANG',1,0,'C');
    //     $pdf->cell(95,7,'KEMBALI BARANG',1,1,'C');

    //     $pdf->cell(47,6,'TGL :'.' '.$tgl,1,0,'L');
    //     $pdf->cell(48,6,'JAM :'.' '.$jam,1,0,'L');
    //     $pdf->cell(47,6,'TGL :',1,0,'L');
    //     $pdf->cell(48,6,'JAM :',1,1,'L');

    //     $pdf->cell(47,6,'Dimohon',1,0,'C');
    //     $pdf->cell(48,6,'Diperiksa',1,0,'C');
    //     $pdf->cell(47,6,'Dimohon',1,0,'C');
    //     $pdf->cell(48,6,'Diperiksa',1,1,'C');

    //     $pdf->cell(47,6,$data['nama_lengkap'],1,0,'C');
    //     $pdf->cell(48,6,$petugas,1,0,'C');
    //     $pdf->cell(47,6,$data['nama_lengkap'],1,0,'C');
    //     $pdf->cell(48,6,$petugas,1,1,'C');

    //     $pdf->cell(47,20,'',1,0,'C');
    //     $pdf->cell(48,20,'',1,0,'C');
    //     $pdf->cell(47,20,'',1,0,'C');
    //     $pdf->cell(48,20,'',1,1,'C');

    //     $pdf->cell(48,7,'',0,1);

    //     $pdf->cell(48,7,'1. Putih Logistik',0,0);
    //     $pdf->cell(47,7,'2. Kuning Security',0,0);
    //     $pdf->cell(50,7,'3. Biru Pemohon',0,1);
    //     //kotak luar
    //     $pdf->Line(9, 9,210-9,9); // Horizontal line at top
    //     $pdf->Line(9, 285-9,210-9,285-9); // Horizontal line at bottom
    //     $pdf->Line(9, 9,9,285-9); // Vetical line at left 
    //     $pdf->Line(210-9, 9,210-9,285-9); // Vetical line at Right
    //     //kotak data
    //     $pdf->Line(10, 87,10,177-10);
    //     $pdf->Line(20, 87,20,187-20);
    //     $pdf->Line(96, 87,96,263-96);
    //     $pdf->Line(171, 87,171,338-171);
    //     $pdf->Line(186, 87,186,353-186);
    //     $pdf->Line(200, 87,200,367-200);
        
        
    //     $pdf->Output('D',$noPinjam.'.pdf');
    // }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_peminjaman.xls";
        $judul = "tbl_peminjaman";
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
	xlsWriteLabel($tablehead, $kolomhead++, "No Form Peminjaman");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Form Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "User Peminjaman");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Program");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Peminjaman");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Pengembalian");
	xlsWriteLabel($tablehead, $kolomhead++, "Status Peminjaman");

	foreach ($this->Peminjaman_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_form_peminjaman);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_form_barang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->user_peminjaman);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_program);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_peminjaman);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_pengembalian);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status_peminjaman);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Peminjaman.php */
/* Location: ./application/controllers/Peminjaman.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-10-21 18:19:53 */
/* http://harviacode.com */