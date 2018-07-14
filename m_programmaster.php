<?php

// id
// kode_program

?>
<?php if ($m_program->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $m_program->TableCaption() ?></h4> -->
<table id="tbl_m_programmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $m_program->TableCustomInnerHtml ?>
	<tbody>
<?php if ($m_program->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $m_program->id->FldCaption() ?></td>
			<td<?php echo $m_program->id->CellAttributes() ?>>
<span id="el_m_program_id">
<span<?php echo $m_program->id->ViewAttributes() ?>>
<?php echo $m_program->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($m_program->kode_program->Visible) { // kode_program ?>
		<tr id="r_kode_program">
			<td><?php echo $m_program->kode_program->FldCaption() ?></td>
			<td<?php echo $m_program->kode_program->CellAttributes() ?>>
<span id="el_m_program_kode_program">
<span<?php echo $m_program->kode_program->ViewAttributes() ?>>
<?php echo $m_program->kode_program->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
