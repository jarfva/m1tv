<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA BARANG</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200'>Group Barang <?php echo form_error('group_barang') ?></td><td>
		<?php echo cmb_dinamis('group_barang', 'tbl_group_barang', 'group_barang', 'kode_group',$group_barang) ?>
		</td></tr>
	    <tr><td width='200'>Jenis Barang <?php echo form_error('jenis_barang') ?></td><td>
		<?php echo cmb_dinamis('jenis_barang', 'tbl_jenis_barang', 'jenis_barang_kode', 'id_jenis_barang',$jenis_barang) ?>
		</td></tr>
	    <tr><td width='200'>Merk Barang <?php echo form_error('merk_barang') ?></td><td>
		<?php echo cmb_dinamis('merk_barang', 'tbl_merk_barang', 'merk_barang_kode', 'id_merk_barang',$merk_barang) ?>
		</td></tr>
	    <tr><td width='200'>Type Barang <?php echo form_error('type_barang') ?></td><td><input type="text" class="form-control" name="type_barang" id="type_barang" placeholder="Type Barang" value="<?php echo $type_barang; ?>" /></td></tr>
	    <tr><td width='200'>Uraian Barang <?php echo form_error('uraian_barang') ?></td><td><input type="text" class="form-control" name="uraian_barang" id="uraian_barang" placeholder="Uraian Barang" value="<?php echo $uraian_barang; ?>" /></td></tr>
	    <input type="hidden" class="form-control" name="barcode_barang" id="barcode_barang" placeholder="Barcode Barang" value="<?php echo $barcode_barang; ?>" />
	    <input type="hidden" class="form-control" name="barcode_barang_detail" id="barcode_barang_detail" placeholder="Barcode Barang Detail" value="<?php echo $barcode_barang_detail; ?>" />
	    <tr><td width='200'>Serial Number <?php echo form_error('serial_number') ?></td><td><input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="Serial Number" value="<?php echo $serial_number; ?>" /></td></tr>
	    <tr><td width='200'>Lokasi Barang <?php echo form_error('lokasi_barang') ?></td><td>
		<?php echo cmb_dinamis('lokasi_barang', 'tbl_lokasi_barang', 'lokasi_barang_simpan', 'id_lokasi_barang',$lokasi_barang) ?>
		</td></tr>
	    <tr><td width='200'>Aset Barang <?php echo form_error('aset_barang') ?></td><td>
		<?php echo cmb_dinamis('aset_barang', 'tbl_asset', 'asset', 'id_asset',$aset_barang) ?>
		</td></tr>

<tr>
<td width='200'>Kondisi Barang</td>
<td>
<select class="form-control" id="kondisi" name="kondisi" value="<?php echo $kondisi; ?>">
    <option selected='selected' value="<?php echo $kondisi; ?>"><?php echo $kondisi; ?></option>
    <option value="NOT OK">NOT OK</option>
    <option value="OK">OK</option>
</select>
</td>
</tr>

	    <input type="hidden" class="form-control" name="tag_form_pinjam" id="tag_form_pinjam" placeholder="Tag Form Pinjam" value="<?php echo $tag_form_pinjam; ?>" />
	    <tr><td></td><td><input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('barang') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>


<!-- <tr>
<td width='200'>Kondisi Barang</td>
<td>
<input type="hidden" class="form-control" name="kondisi" id="kondisi"/>
<select class="form-control" id="kondisi" name="kondisi" value="<?php echo $kondisi; ?>">
    <option>OK</option>
    <option>NOT OK</option>
</select>
</td>
</tr> -->