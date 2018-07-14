<?php

// id
// no_spj
// tgl_spj
// tipe_sbp
// no_sbp
// tgl_sbp
// uraian
// nama_penerima

?>
<?php if ($vw_spj_gu->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_spj_gu->TableCaption() ?></h4> -->
<table id="tbl_vw_spj_gumaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_spj_gu->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_spj_gu->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $vw_spj_gu->id->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->id->CellAttributes() ?>>
<div id="orig_vw_spj_gu_id" class="hide">
<span id="el_vw_spj_gu_id">
<span<?php echo $vw_spj_gu->id->ViewAttributes() ?>>
<?php echo $vw_spj_gu->id->ListViewValue() ?></span>
</span>
</div>
<div>
<?php
	$no_spj = urlencode(CurrentPage()->no_spj->CurrentValue);
	if($no_spj == null)
	{
?>
<a class="btn btn-info btn-xs"  
target="_self" 
href="vw_spj_guedit.php?id=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
PROSES SPJ <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}else{  
?><a class="btn btn-success btn-xs"  target="_blank" href="cetak_spm_up.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPJ  <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a><?php
}
?>
</div>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
		<tr id="r_no_spj">
			<td><?php echo $vw_spj_gu->no_spj->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->no_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_spj">
<span<?php echo $vw_spj_gu->no_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_spj->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
		<tr id="r_tgl_spj">
			<td><?php echo $vw_spj_gu->tgl_spj->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->tgl_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_spj">
<span<?php echo $vw_spj_gu->tgl_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_spj->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
		<tr id="r_tipe_sbp">
			<td><?php echo $vw_spj_gu->tipe_sbp->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->tipe_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe_sbp">
<span<?php echo $vw_spj_gu->tipe_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tipe_sbp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
		<tr id="r_no_sbp">
			<td><?php echo $vw_spj_gu->no_sbp->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->no_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_sbp">
<span<?php echo $vw_spj_gu->no_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_sbp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
		<tr id="r_tgl_sbp">
			<td><?php echo $vw_spj_gu->tgl_sbp->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->tgl_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_sbp">
<span<?php echo $vw_spj_gu->tgl_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_sbp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
		<tr id="r_uraian">
			<td><?php echo $vw_spj_gu->uraian->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->uraian->CellAttributes() ?>>
<span id="el_vw_spj_gu_uraian">
<span<?php echo $vw_spj_gu->uraian->ViewAttributes() ?>>
<?php echo $vw_spj_gu->uraian->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
		<tr id="r_nama_penerima">
			<td><?php echo $vw_spj_gu->nama_penerima->FldCaption() ?></td>
			<td<?php echo $vw_spj_gu->nama_penerima->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_penerima">
<span<?php echo $vw_spj_gu->nama_penerima->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nama_penerima->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
