<?php

// kd_akun
// kel3
// nmkel3

?>
<?php if ($keu_akun3->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $keu_akun3->TableCaption() ?></h4> -->
<table id="tbl_keu_akun3master" class="table table-bordered table-striped ewViewTable">
<?php echo $keu_akun3->TableCustomInnerHtml ?>
	<tbody>
<?php if ($keu_akun3->kd_akun->Visible) { // kd_akun ?>
		<tr id="r_kd_akun">
			<td><?php echo $keu_akun3->kd_akun->FldCaption() ?></td>
			<td<?php echo $keu_akun3->kd_akun->CellAttributes() ?>>
<span id="el_keu_akun3_kd_akun">
<span<?php echo $keu_akun3->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun3->kd_akun->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun3->kel3->Visible) { // kel3 ?>
		<tr id="r_kel3">
			<td><?php echo $keu_akun3->kel3->FldCaption() ?></td>
			<td<?php echo $keu_akun3->kel3->CellAttributes() ?>>
<span id="el_keu_akun3_kel3">
<span<?php echo $keu_akun3->kel3->ViewAttributes() ?>>
<?php echo $keu_akun3->kel3->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun3->nmkel3->Visible) { // nmkel3 ?>
		<tr id="r_nmkel3">
			<td><?php echo $keu_akun3->nmkel3->FldCaption() ?></td>
			<td<?php echo $keu_akun3->nmkel3->CellAttributes() ?>>
<span id="el_keu_akun3_nmkel3">
<span<?php echo $keu_akun3->nmkel3->ViewAttributes() ?>>
<?php echo $keu_akun3->nmkel3->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
