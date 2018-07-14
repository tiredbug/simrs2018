<?php

// sub_kegiatan
// no_kontrak
// tgl_kontrak
// nama_perusahaan

?>
<?php if ($data_kontrak->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $data_kontrak->TableCaption() ?></h4> -->
<table id="tbl_data_kontrakmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $data_kontrak->TableCustomInnerHtml ?>
	<tbody>
<?php if ($data_kontrak->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<tr id="r_sub_kegiatan">
			<td><?php echo $data_kontrak->sub_kegiatan->FldCaption() ?></td>
			<td<?php echo $data_kontrak->sub_kegiatan->CellAttributes() ?>>
<span id="el_data_kontrak_sub_kegiatan">
<span<?php echo $data_kontrak->sub_kegiatan->ViewAttributes() ?>>
<?php echo $data_kontrak->sub_kegiatan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($data_kontrak->no_kontrak->Visible) { // no_kontrak ?>
		<tr id="r_no_kontrak">
			<td><?php echo $data_kontrak->no_kontrak->FldCaption() ?></td>
			<td<?php echo $data_kontrak->no_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_no_kontrak">
<span<?php echo $data_kontrak->no_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->no_kontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($data_kontrak->tgl_kontrak->Visible) { // tgl_kontrak ?>
		<tr id="r_tgl_kontrak">
			<td><?php echo $data_kontrak->tgl_kontrak->FldCaption() ?></td>
			<td<?php echo $data_kontrak->tgl_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_kontrak">
<span<?php echo $data_kontrak->tgl_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->tgl_kontrak->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($data_kontrak->nama_perusahaan->Visible) { // nama_perusahaan ?>
		<tr id="r_nama_perusahaan">
			<td><?php echo $data_kontrak->nama_perusahaan->FldCaption() ?></td>
			<td<?php echo $data_kontrak->nama_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_nama_perusahaan">
<span<?php echo $data_kontrak->nama_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_perusahaan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
