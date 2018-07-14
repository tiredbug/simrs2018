<?php

// id
// kode_advis
// tgl_advis
// tahun_anggaran

?>
<?php if ($t_advis_spm->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_advis_spm->TableCaption() ?></h4> -->
<table id="tbl_t_advis_spmmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_advis_spm->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_advis_spm->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $t_advis_spm->id->FldCaption() ?></td>
			<td<?php echo $t_advis_spm->id->CellAttributes() ?>>
<div id="orig_t_advis_spm_id" class="hide">
<span id="el_t_advis_spm_id">
<span<?php echo $t_advis_spm->id->ViewAttributes() ?>>
<?php echo $t_advis_spm->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"  target="_blank" href="cetak_advis.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK ADVIS  <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
</td>
		</tr>
<?php } ?>
<?php if ($t_advis_spm->kode_advis->Visible) { // kode_advis ?>
		<tr id="r_kode_advis">
			<td><?php echo $t_advis_spm->kode_advis->FldCaption() ?></td>
			<td<?php echo $t_advis_spm->kode_advis->CellAttributes() ?>>
<span id="el_t_advis_spm_kode_advis">
<span<?php echo $t_advis_spm->kode_advis->ViewAttributes() ?>>
<?php echo $t_advis_spm->kode_advis->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_advis_spm->tgl_advis->Visible) { // tgl_advis ?>
		<tr id="r_tgl_advis">
			<td><?php echo $t_advis_spm->tgl_advis->FldCaption() ?></td>
			<td<?php echo $t_advis_spm->tgl_advis->CellAttributes() ?>>
<span id="el_t_advis_spm_tgl_advis">
<span<?php echo $t_advis_spm->tgl_advis->ViewAttributes() ?>>
<?php echo $t_advis_spm->tgl_advis->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_advis_spm->tahun_anggaran->Visible) { // tahun_anggaran ?>
		<tr id="r_tahun_anggaran">
			<td><?php echo $t_advis_spm->tahun_anggaran->FldCaption() ?></td>
			<td<?php echo $t_advis_spm->tahun_anggaran->CellAttributes() ?>>
<span id="el_t_advis_spm_tahun_anggaran">
<span<?php echo $t_advis_spm->tahun_anggaran->ViewAttributes() ?>>
<?php echo $t_advis_spm->tahun_anggaran->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
