<?php

// id_admission
// nomr
// statusbayar
// masukrs
// noruang
// KELASPERAWATAN_ID
// nott

?>
<?php if ($vw_bill_ranap->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_bill_ranap->TableCaption() ?></h4> -->
<table id="tbl_vw_bill_ranapmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_bill_ranap->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_bill_ranap->id_admission->Visible) { // id_admission ?>
		<tr id="r_id_admission">
			<td><?php echo $vw_bill_ranap->id_admission->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->id_admission->CellAttributes() ?>>
<div id="orig_vw_bill_ranap_id_admission" class="hide">
<span id="el_vw_bill_ranap_id_admission">
<span<?php echo $vw_bill_ranap->id_admission->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->id_admission->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r==5)
{ ?>
<div class="btn-group">
	<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Pilihan Menu</button>
		<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul style="background:#605CA8" class="dropdown-menu" role="menu" >
                  	<li class="divider"></li>
                    <li><a style="color:#ffffff" href="vw_bill_ranapedit.php?showdetail=vw_bill_ranap_detail_visitekonsul_dokter,vw_bill_ranap_detail_konsul_dokter,vw_bill_ranap_detail_tmno,vw_bill_ranap_detail_tindakan_perawat,vw_bill_ranap_detail_tindakan_kebidanan,vw_bill_ranap_detail_visite_gizi,vw_bill_ranap_detail_visite_farmasi,vw_bill_ranap_detail_tindakan_penunjang,vw_bill_ranap_detail_konsul_vct,vw_bill_ranap_detail_pelayanan_los,vw_bill_ranap_detail_tindakan_lain&id_admission=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>"><b>-  </b><b>Input Billing</b></a></li>
                    <li><a style="color:#ffffff" target="_self" href="vw_set_tanggal_pulangedit.php?id_admission=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>"><b>-  </b><b>Set Resume Pulang </b></a></li>
                    <li class="divider"></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_tmno_rawat_inap.php?home=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>&p1=<?php echo urlencode(CurrentPage()->nomr->CurrentValue)?>&p2=<?php echo urlencode(CurrentPage()->statusbayar->CurrentValue) ?>&p3=<?php echo urlencode(CurrentPage()->KELASPERAWATAN_ID->CurrentValue) ?>"><b>-  </b><b>Cetak rincian TMNO </b></a></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_rincian_adm_rawat_inap.php?home=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>&p1=<?php echo urlencode(CurrentPage()->nomr->CurrentValue)?>&p2=<?php echo urlencode(CurrentPage()->statusbayar->CurrentValue) ?>&p3=<?php echo urlencode(CurrentPage()->KELASPERAWATAN_ID->CurrentValue) ?>"><b>-  </b><b>Cetak Rincian Adm/Inadrg </b></a></li>
                    <li class="divider"></li>
                  </ul>
</div>
<?php
}else { print '-'; }
?>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->nomr->Visible) { // nomr ?>
		<tr id="r_nomr">
			<td><?php echo $vw_bill_ranap->nomr->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->nomr->CellAttributes() ?>>
<span id="el_vw_bill_ranap_nomr">
<span<?php echo $vw_bill_ranap->nomr->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->nomr->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->statusbayar->Visible) { // statusbayar ?>
		<tr id="r_statusbayar">
			<td><?php echo $vw_bill_ranap->statusbayar->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->statusbayar->CellAttributes() ?>>
<span id="el_vw_bill_ranap_statusbayar">
<span<?php echo $vw_bill_ranap->statusbayar->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->statusbayar->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->masukrs->Visible) { // masukrs ?>
		<tr id="r_masukrs">
			<td><?php echo $vw_bill_ranap->masukrs->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->masukrs->CellAttributes() ?>>
<span id="el_vw_bill_ranap_masukrs">
<span<?php echo $vw_bill_ranap->masukrs->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->masukrs->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->noruang->Visible) { // noruang ?>
		<tr id="r_noruang">
			<td><?php echo $vw_bill_ranap->noruang->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->noruang->CellAttributes() ?>>
<span id="el_vw_bill_ranap_noruang">
<span<?php echo $vw_bill_ranap->noruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->noruang->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
		<tr id="r_KELASPERAWATAN_ID">
			<td><?php echo $vw_bill_ranap->KELASPERAWATAN_ID->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el_vw_bill_ranap_KELASPERAWATAN_ID">
<span<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_bill_ranap->nott->Visible) { // nott ?>
		<tr id="r_nott">
			<td><?php echo $vw_bill_ranap->nott->FldCaption() ?></td>
			<td<?php echo $vw_bill_ranap->nott->CellAttributes() ?>>
<span id="el_vw_bill_ranap_nott">
<span<?php echo $vw_bill_ranap->nott->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->nott->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
