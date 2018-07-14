<?php

// id
// status_spp
// no_spp
// tgl_spp
// keterangan
// tahun_anggaran
// id_spj

?>
<?php if ($vw_spp_gu_nihil_list->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $vw_spp_gu_nihil_list->TableCaption() ?></h4> -->
<table id="tbl_vw_spp_gu_nihil_listmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $vw_spp_gu_nihil_list->TableCustomInnerHtml ?>
	<tbody>
<?php if ($vw_spp_gu_nihil_list->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $vw_spp_gu_nihil_list->id->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->id->CellAttributes() ?>>
<div id="orig_vw_spp_gu_nihil_list_id" class="hide">
<span id="el_vw_spp_gu_nihil_list_id">
<span<?php echo $vw_spp_gu_nihil_list->id->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"
target="_blank"
href="cetak_spp_gu_nihil.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>Cetak </b> SPP</a>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->status_spp->Visible) { // status_spp ?>
		<tr id="r_status_spp">
			<td><?php echo $vw_spp_gu_nihil_list->status_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_status_spp">
<span<?php echo $vw_spp_gu_nihil_list->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->status_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->no_spp->Visible) { // no_spp ?>
		<tr id="r_no_spp">
			<td><?php echo $vw_spp_gu_nihil_list->no_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_no_spp">
<span<?php echo $vw_spp_gu_nihil_list->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->no_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->tgl_spp->Visible) { // tgl_spp ?>
		<tr id="r_tgl_spp">
			<td><?php echo $vw_spp_gu_nihil_list->tgl_spp->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_tgl_spp">
<span<?php echo $vw_spp_gu_nihil_list->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->tgl_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td><?php echo $vw_spp_gu_nihil_list->keterangan->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_keterangan">
<span<?php echo $vw_spp_gu_nihil_list->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->tahun_anggaran->Visible) { // tahun_anggaran ?>
		<tr id="r_tahun_anggaran">
			<td><?php echo $vw_spp_gu_nihil_list->tahun_anggaran->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_tahun_anggaran">
<span<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->id_spj->Visible) { // id_spj ?>
		<tr id="r_id_spj">
			<td><?php echo $vw_spp_gu_nihil_list->id_spj->FldCaption() ?></td>
			<td<?php echo $vw_spp_gu_nihil_list->id_spj->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_id_spj">
<span<?php echo $vw_spp_gu_nihil_list->id_spj->ViewAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->id_spj->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
