<?php

// id
// kode_program
// kode_kegiatan
// nama_kegiatan

?>
<?php if ($m_kegiatan->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $m_kegiatan->TableCaption() ?></h4> -->
<table id="tbl_m_kegiatanmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $m_kegiatan->TableCustomInnerHtml ?>
	<tbody>
<?php if ($m_kegiatan->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $m_kegiatan->id->FldCaption() ?></td>
			<td<?php echo $m_kegiatan->id->CellAttributes() ?>>
<span id="el_m_kegiatan_id">
<span<?php echo $m_kegiatan->id->ViewAttributes() ?>>
<?php echo $m_kegiatan->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($m_kegiatan->kode_program->Visible) { // kode_program ?>
		<tr id="r_kode_program">
			<td><?php echo $m_kegiatan->kode_program->FldCaption() ?></td>
			<td<?php echo $m_kegiatan->kode_program->CellAttributes() ?>>
<span id="el_m_kegiatan_kode_program">
<span<?php echo $m_kegiatan->kode_program->ViewAttributes() ?>>
<?php echo $m_kegiatan->kode_program->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($m_kegiatan->kode_kegiatan->Visible) { // kode_kegiatan ?>
		<tr id="r_kode_kegiatan">
			<td><?php echo $m_kegiatan->kode_kegiatan->FldCaption() ?></td>
			<td<?php echo $m_kegiatan->kode_kegiatan->CellAttributes() ?>>
<span id="el_m_kegiatan_kode_kegiatan">
<span<?php echo $m_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<?php echo $m_kegiatan->kode_kegiatan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($m_kegiatan->nama_kegiatan->Visible) { // nama_kegiatan ?>
		<tr id="r_nama_kegiatan">
			<td><?php echo $m_kegiatan->nama_kegiatan->FldCaption() ?></td>
			<td<?php echo $m_kegiatan->nama_kegiatan->CellAttributes() ?>>
<span id="el_m_kegiatan_nama_kegiatan">
<span<?php echo $m_kegiatan->nama_kegiatan->ViewAttributes() ?>>
<?php echo $m_kegiatan->nama_kegiatan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
