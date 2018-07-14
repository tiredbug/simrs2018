<?php

// kd_akun
// kel2
// nmkel2

?>
<?php if ($keu_akun2->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $keu_akun2->TableCaption() ?></h4> -->
<table id="tbl_keu_akun2master" class="table table-bordered table-striped ewViewTable">
<?php echo $keu_akun2->TableCustomInnerHtml ?>
	<tbody>
<?php if ($keu_akun2->kd_akun->Visible) { // kd_akun ?>
		<tr id="r_kd_akun">
			<td><?php echo $keu_akun2->kd_akun->FldCaption() ?></td>
			<td<?php echo $keu_akun2->kd_akun->CellAttributes() ?>>
<span id="el_keu_akun2_kd_akun">
<span<?php echo $keu_akun2->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun2->kd_akun->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun2->kel2->Visible) { // kel2 ?>
		<tr id="r_kel2">
			<td><?php echo $keu_akun2->kel2->FldCaption() ?></td>
			<td<?php echo $keu_akun2->kel2->CellAttributes() ?>>
<span id="el_keu_akun2_kel2">
<span<?php echo $keu_akun2->kel2->ViewAttributes() ?>>
<?php echo $keu_akun2->kel2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun2->nmkel2->Visible) { // nmkel2 ?>
		<tr id="r_nmkel2">
			<td><?php echo $keu_akun2->nmkel2->FldCaption() ?></td>
			<td<?php echo $keu_akun2->nmkel2->CellAttributes() ?>>
<span id="el_keu_akun2_nmkel2">
<span<?php echo $keu_akun2->nmkel2->ViewAttributes() ?>>
<?php echo $keu_akun2->nmkel2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
