<?php

// id
// status_spp
// no_spp
// tgl_spp

?>
<?php if ($vw_spp_pengembalian_penerimaan->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_spp_pengembalian_penerimaan->TableCaption() ?></h4> -->
<table id="tbl_vw_spp_pengembalian_penerimaanmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_spp_pengembalian_penerimaan->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_spp_pengembalian_penerimaan->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $vw_spp_pengembalian_penerimaan->id->FldCaption() ?></td>
			<td<?php echo $vw_spp_pengembalian_penerimaan->id->CellAttributes() ?>>
<div id="orig_vw_spp_pengembalian_penerimaan_id" class="hide">
<span id="el_vw_spp_pengembalian_penerimaan_id">
<span<?php echo $vw_spp_pengembalian_penerimaan->id->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->id->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r == 7)
{ ?>
	<a class="btn btn-success btn-xs"  target="_blank" href="cetak_spp_pp.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPP
	 <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
<?php
}else {
 }
?>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->status_spp->Visible) { // status_spp ?>
		<tr id="r_status_spp">
			<td><?php echo $vw_spp_pengembalian_penerimaan->status_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_pengembalian_penerimaan->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_pengembalian_penerimaan_status_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->status_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->no_spp->Visible) { // no_spp ?>
		<tr id="r_no_spp">
			<td><?php echo $vw_spp_pengembalian_penerimaan->no_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_pengembalian_penerimaan->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_pengembalian_penerimaan_no_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->no_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->tgl_spp->Visible) { // tgl_spp ?>
		<tr id="r_tgl_spp">
			<td><?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_pengembalian_penerimaan_tgl_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
