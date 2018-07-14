<?php

// status_spp
// no_spp
// tgl_spp
// keterangan

?>
<?php if ($vw_spp_ls_gaji_tunjangan->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_spp_ls_gaji_tunjangan->TableCaption() ?></h4> -->
<table id="tbl_vw_spp_ls_gaji_tunjanganmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_spp_ls_gaji_tunjangan->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
		<tr id="r_status_spp">
			<td><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_status_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
		<tr id="r_no_spp">
			<td><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_no_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
		<tr id="r_tgl_spp">
			<td><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_keterangan">
<span<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
