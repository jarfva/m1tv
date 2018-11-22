<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">FORM PENGEMBALIAN</h3>
            </div>
            
            
<table class='table table-bordered'>        

	    <tr><td width='200'>No Form Peminjaman </td><td colspan="2"><input readonly type="text" class="form-control" name="no_form_peminjaman" id="no_form_peminjaman" placeholder="No Form Peminjaman" value="<?php echo $no_form; ?>" readonly /></td></tr>
	   
	
	    <tr><td width='200'>NIK </td>
        <td width='200'><input readonly type="text" onkeyup='nik()' class="form-control" name="user_cari" id="user_cari" placeholder="Nik" value="<?php echo $nik; ?>" /></td>
        <td><input type="text" class="form-control" name="nama_cari" readonly id="nama_lenkap" placeholder="Nama Lengkap" value="<?php echo $nama; ?>" /></td>
        </tr>
		<tr><td width='200'>Nama Program </td><td colspan="2"><input readonly type="text" class="form-control" name="nama_program" id="nama_program" placeholder="Nama Program" value="<?php echo $program; ?>" /></td></tr>
	  
	    <!-- <tr><td></td><td colspan="2">
	    <button type="submit" class="btn btn-danger" onclick='savebarang()'><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
		 <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-check-o"></i> Add Barang</button> 
	    <button type="submit" class="btn btn-danger" onclick='clears()'><i class="fa fa-floppy-o"></i>Clear</button>  
		</td></tr> -->
	</table>       
    
    </div>
	<div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">LIST BARANG YANG DI PINJAM</h3>
            </div>
			<div id='list_pinjaman'> 
            <table class='table table-bordered'>
        <tr><th>Barcode Detail</th><th>Nama Barang</th><th>S/N</th><th>Kembali</th></tr>
        <input type="hidden" class="form-control" name="addbarangs" id="addbarangs" value="<?php echo $jumlah?>" />
        <?php foreach ($db as $peminjaman)
            {
                echo "<tr><td>$peminjaman->barcode_barang_detail</td>
                <td>$peminjaman->uraian_barang</td>
                <td>$peminjaman->serial_number</td>
                <td>
                <button type='submit' class='btn btn-info' data-toggle='modal' data-target='#myModal' onclick=ceklis('$peminjaman->barcode_barang_detail',$peminjaman->id_barang) )><i class='fa fa-share'></i> Return</button>
                </td></tr>" ;
            }
                 ?>
        </table>
            </div>
</div>
<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ceklist Kondisi Barang</h4>
      </div>
      <div class="modal-body">
      <form action="<?php echo site_url('pengembalian/ceklist'); ?>" method="post">
	  <table class='table table-bordered'>        
      <tr><td width='200'>No Form Peminajam</td><td><input readonly type="text" class="form-control" name="no_form_peminajam" id="no_form_peminajam" placeholder="No Form Peminajam" value="<?php echo $no_form; ?>" /></td></tr>
<tr><td width='200'>Barcode Barang</td><td>
<input type="text" class="form-control" name="barcode_detail" id="barcode_detail" readonly/></td>
</tr>
<tr><td width='200'>Kondisi Barang</td><td>
<input type="hidden" class="form-control" name="idBarang" id="idBarang"/>
<select class="form-control" id="status" name="status">
    <option>OK</option>
    <option>NOT OK</option>
  </select></td>
</tr>
<tr><td width='200'>Keterangan</td><td>
<textarea class="form-control" rows="5" id="keterangan" name="keterangan"></textarea></td>
</tr>

<tr>
<td>
</td>
<td><button type="submit" onclick='addBarang()' class="btn btn-warning"><i class="fa fa-eye"></i> Ceklist</button></td>
</tr>
</table>        </div>
</form>


<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
        
      </div>
	  </div>
      
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
		function ceklis(barcode,id){
            $("#idBarang").val(id);
			$("#barcode_detail").val(barcode);
		}

        function deleteds(id){
            var noPeminjaman = $("#no_form_peminjaman").val();
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/delete_action",
                data:"id=" + id + "&no_form_barang="+ noPeminjaman ,
                success: function(html)
                { 
                   // alert('berhasil');
                    //$("#product").val(''),
                    //$("#list").html(html);
                    // $("#addbarang").val("addklik");
                    $("#list_pinjaman").html(html);
                    addBarang();
                }
            });
        }

        function nik() {
            if ($("#user_cari").val() == ''){
                var barcode = 'm'
            } else {
            var nik = $("#user_cari").val();
            
            }
          //  alert(noPeminjaman);
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/nik_ajax",
                data:"nik=" + nik,
                success: function(data)
                { 
                    var json = data,
                    obj = JSON.parse(json);
                  //  alert('berhasil');
                    $("#nama_lenkap").val(obj.nama);
					$("#user_peminjaman").val(obj.id_karyawan);
                  
                }
            });
        }

		function savebarang(){
            if($("#nama_program").val() == ''){
                var namaProgram = 'NON-PROGRAM';
            } else {
                var namaProgram = $("#nama_program").val();
            }
            if($("#user_peminjaman").val() == ''){
                alert('Mohon Masukan NIK');
            } else if($("#nama_lenkap").val() == 'Not Found'){
                alert('Karyawan tidak terdaftar');
            } else if($("#addbarangs").val() == '0'){
                alert('Mohon Add Barang');
            } 
             else {
            var noPeminjaman = $("#no_form_peminjaman").val();
            var nik = $("#user_peminjaman").val();
			// var id_form_barang = $("#id_form_barang").val();
			// var nama_program = $("#nama_program").val();
			// var tanggal_pinjam = $("#tgl_peminjaman").val();
			// var status_peminjaman = $("#status_peminjaman").val();
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/savebarang",
                data:"nik=" + nik + "&noPeminjaman="+ noPeminjaman +  "&nama_program="+ namaProgram,
                success: function(html)
                { 
                    window.location.href = "<?php echo base_url()?>index.php/peminjaman/create";
                }
            });
            }

        }

        function addBarang() {
            if ($("#barcode_peminjaman").val() == ''){
                var barcode = 'mmm'
            } else {
            var barcode = $("#barcode_peminjaman").val();
            // var noPeminjaman = $("#no_form_peminajam").val(); 
            // alert(barcode);
            // alert(noPeminjaman);
            }
          //  alert(noPeminjaman);
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/add_product_ajax",
                data:"barcode=" + barcode  ,
                success: function(html)
                { 

                    //alert('berhasil');
                    //$("#product").val(''),
                    $("#list").html(html);
                    //$("#list2").html(html);
                }
            });
        }

        function pinjam(noBarang){
            var noPeminjaman = $("#no_form_peminajam").val();
            //var tambahin = $("#tombol").val();
            //alert(noBarang+"<br>"+noPeminjaman);
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/pinjam_action",
                data:"barcode=" + noBarang  + "&noPeminjaman="+ noPeminjaman,
                success: function(html)
                { 
                   // alert('berhasil');
                    //$("#product").val(''),
                    //$("#list").html(html);
                    $("#addbarang").val("addklik");
                    $("#list_pinjaman").html(html);
                    addBarang();
                }
            });
        }

        function clears(){
            var noPeminjaman = $("#no_form_peminajam").val();
            $.ajax({
                url:"<?php echo base_url()?>index.php/peminjaman/clears",
                data:"noPeminjaman="+ noPeminjaman,
                success: function(html)
                { 
                    window.location.href = "<?php echo base_url()?>index.php/peminjaman/create"
                }
            });
        }
</script>