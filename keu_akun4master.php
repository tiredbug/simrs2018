<?php

// kd_akun
// kel4
// nmkel4

?>
<?php if ($keu_akun4->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $keu_akun4->TableCaption() ?></h4> -->
<table id="tbl_keu_akun4master" class="table table-bordered table-striped ewViewTable">
<?php echo $keu_akun4->TableCustomInnerHtml ?>
	<tbody>
<?php if ($keu_akun4->kd_akun->Visible) { // kd_akun ?>
		<tr id="r_kd_akun">
			<td><?php echo $keu_akun4->kd_akun->FldCaption() ?></td>
			<td<?php echo $keu_akun4->kd_akun->CellAttributes() ?>>
<span id="el_keu_akun4_kd_akun">
<span<?php echo $keu_akun4->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun4->kd_akun->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun4->kel4->Visible) { // kel4 ?>
		<tr id="r_kel4">
			<td><?php echo $keu_akun4->kel4->FldCaption() ?></td>
			<td<?php echo $keu_akun4->kel4->CellAttributes() ?>>
<span id="el_keu_akun4_kel4">
<span<?php echo $keu_akun4->kel4->ViewAttributes() ?>>
<?php echo $keu_akun4->kel4->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun4->nmkel4->Visible) { // nmkel4 ?>
		<tr id="r_nmkel4">
			<td><?php echo $keu_akun4->nmkel4->FldCaption() ?></td>
			<td<?php echo $keu_akun4->nmkel4->CellAttributes() ?>>
<span id="el_keu_akun4_nmkel4">
<span<?php echo $keu_akun4->nmkel4->ViewAttributes() ?>>
<?php echo $keu_akun4->nmkel4->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
