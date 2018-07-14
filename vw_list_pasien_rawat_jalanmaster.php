<?php

// IDXDAFTAR
// TGLREG
// NOMR
// KDPOLY
// KDCARABAYAR
// SHIFT
// NIP
// MASUKPOLY

?>
<?php if ($vw_list_pasien_rawat_jalan->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_list_pasien_rawat_jalan->TableCaption() ?></h4> -->
<table id="tbl_vw_list_pasien_rawat_jalanmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_list_pasien_rawat_jalan->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_list_pasien_rawat_jalan->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
		<tr id="r_IDXDAFTAR">
			<td><?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->CellAttributes() ?>>
<div id="orig_vw_list_pasien_rawat_jalan_IDXDAFTAR" class="hide">
<span id="el_vw_list_pasien_rawat_jalan_IDXDAFTAR">
<span<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r==4)
{ ?>
<a class="btn btn-success btn-xs"  
target="_self" 
href="vw_list_pasien_rawat_jalanedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>">
ORDER RAWAT INAP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_label_pasien_rajal.php?idx=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>&nomr=<?php echo urlencode(CurrentPage()->NOMR->CurrentValue)?>">
Cetak Label(Modul Sementara)<span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_gelang_pasien_ranap.php?idx=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>&nomr=<?php echo urlencode(CurrentPage()->NOMR->CurrentValue)?>">
Cetak Gelang (Modul Sementara)<span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}else {
?>
<a class="btn btn-success btn-xs"  
target="_self" 
href="vw_list_pasien_rawat_jalanedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>">
ORDER RAWAT INAP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}
?>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->TGLREG->Visible) { // TGLREG ?>
		<tr id="r_TGLREG">
			<td><?php echo $vw_list_pasien_rawat_jalan->TGLREG->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->TGLREG->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_TGLREG">
<span<?php echo $vw_list_pasien_rawat_jalan->TGLREG->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->TGLREG->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOMR->Visible) { // NOMR ?>
		<tr id="r_NOMR">
			<td><?php echo $vw_list_pasien_rawat_jalan->NOMR->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->NOMR->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NOMR">
<span<?php echo $vw_list_pasien_rawat_jalan->NOMR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOMR->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
		<tr id="r_KDPOLY">
			<td><?php echo $vw_list_pasien_rawat_jalan->KDPOLY->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDPOLY">
<span<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<tr id="r_KDCARABAYAR">
			<td><?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDCARABAYAR">
<span<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->SHIFT->Visible) { // SHIFT ?>
		<tr id="r_SHIFT">
			<td><?php echo $vw_list_pasien_rawat_jalan->SHIFT->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->SHIFT->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_SHIFT">
<span<?php echo $vw_list_pasien_rawat_jalan->SHIFT->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->SHIFT->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NIP->Visible) { // NIP ?>
		<tr id="r_NIP">
			<td><?php echo $vw_list_pasien_rawat_jalan->NIP->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->NIP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NIP">
<span<?php echo $vw_list_pasien_rawat_jalan->NIP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NIP->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->MASUKPOLY->Visible) { // MASUKPOLY ?>
		<tr id="r_MASUKPOLY">
			<td><?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->FldCaption() ?></td>
			<td<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_MASUKPOLY">
<span<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
