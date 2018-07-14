<?php

// jenis_spp
?>
<?php if ($l_jenis_spp->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $l_jenis_spp->TableCaption() ?></h4> -->
<table id="tbl_l_jenis_sppmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $l_jenis_spp->TableCustomInnerHtml ?>
	<tbody>
<?php if ($l_jenis_spp->jenis_spp->Visible) { // jenis_spp ?>
		<tr id="r_jenis_spp">
			<td><?php echo $l_jenis_spp->jenis_spp->FldCaption() ?></td>
			<td<?php echo $l_jenis_spp->jenis_spp->CellAttributes() ?>>
<span id="el_l_jenis_spp_jenis_spp">
<span<?php echo $l_jenis_spp->jenis_spp->ViewAttributes() ?>>
<?php echo $l_jenis_spp->jenis_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
