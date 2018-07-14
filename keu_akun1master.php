<?php

// kel1
// nmkel1

?>
<?php if ($keu_akun1->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $keu_akun1->TableCaption() ?></h4> -->
<table id="tbl_keu_akun1master" class="table table-bordered table-striped ewViewTable">
<?php echo $keu_akun1->TableCustomInnerHtml ?>
	<tbody>
<?php if ($keu_akun1->kel1->Visible) { // kel1 ?>
		<tr id="r_kel1">
			<td><?php echo $keu_akun1->kel1->FldCaption() ?></td>
			<td<?php echo $keu_akun1->kel1->CellAttributes() ?>>
<span id="el_keu_akun1_kel1">
<span<?php echo $keu_akun1->kel1->ViewAttributes() ?>>
<?php echo $keu_akun1->kel1->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($keu_akun1->nmkel1->Visible) { // nmkel1 ?>
		<tr id="r_nmkel1">
			<td><?php echo $keu_akun1->nmkel1->FldCaption() ?></td>
			<td<?php echo $keu_akun1->nmkel1->CellAttributes() ?>>
<span id="el_keu_akun1_nmkel1">
<span<?php echo $keu_akun1->nmkel1->ViewAttributes() ?>>
<?php echo $keu_akun1->nmkel1->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
