<?php

// detail_jenis_spp
?>
<?php if ($l_jenis_detail_spp->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $l_jenis_detail_spp->TableCaption() ?></h4> -->
<table id="tbl_l_jenis_detail_sppmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $l_jenis_detail_spp->TableCustomInnerHtml ?>
	<tbody>
<?php if ($l_jenis_detail_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
		<tr id="r_detail_jenis_spp">
			<td><?php echo $l_jenis_detail_spp->detail_jenis_spp->FldCaption() ?></td>
			<td<?php echo $l_jenis_detail_spp->detail_jenis_spp->CellAttributes() ?>>
<span id="el_l_jenis_detail_spp_detail_jenis_spp">
<span<?php echo $l_jenis_detail_spp->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $l_jenis_detail_spp->detail_jenis_spp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
