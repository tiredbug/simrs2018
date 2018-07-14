<?php

// id
// status_spp
// no_spp
// tgl_spp
// keterangan

?>
<?php if ($vw_spp_ls_gaji_list->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_spp_ls_gaji_list->TableCaption() ?></h4> -->
<table id="tbl_vw_spp_ls_gaji_listmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_spp_ls_gaji_list->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_spp_ls_gaji_list->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $vw_spp_ls_gaji_list->id->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_list->id->CellAttributes() ?>>
<div id="orig_vw_spp_ls_gaji_list_id" class="hide">
<span id="el_vw_spp_ls_gaji_list_id">
<span<?php echo $vw_spp_ls_gaji_list->id->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->id->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r == 7)
{ ?>
	<a class="btn btn-success btn-xs"  target="_blank" href="cetak_spp_ls_gaji.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPP
	 <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
<?php
}else {
 }
?>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->status_spp->Visible) { // status_spp ?>
		<tr id="r_status_spp">
			<td><?php echo $vw_spp_ls_gaji_list->status_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_status_spp">
<span<?php echo $vw_spp_ls_gaji_list->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->status_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->no_spp->Visible) { // no_spp ?>
		<tr id="r_no_spp">
			<td><?php echo $vw_spp_ls_gaji_list->no_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_no_spp">
<span<?php echo $vw_spp_ls_gaji_list->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->no_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->tgl_spp->Visible) { // tgl_spp ?>
		<tr id="r_tgl_spp">
			<td><?php echo $vw_spp_ls_gaji_list->tgl_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_list->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->tgl_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td><?php echo $vw_spp_ls_gaji_list->keterangan->FldCaption() ?></td>
			<td<?php echo $vw_spp_ls_gaji_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_keterangan">
<span<?php echo $vw_spp_ls_gaji_list->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
