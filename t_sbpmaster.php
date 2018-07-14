<?php

// id
// tipe_sbp
// no_sbp

?>
<?php if ($t_sbp->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_sbp->TableCaption() ?></h4> -->
<table id="tbl_t_sbpmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_sbp->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_sbp->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $t_sbp->id->FldCaption() ?></td>
			<td<?php echo $t_sbp->id->CellAttributes() ?>>
<div id="orig_t_sbp_id" class="hide">
<span id="el_t_sbp_id">
<span<?php echo $t_sbp->id->ViewAttributes() ?>>
<?php echo $t_sbp->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_sbp.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
CETAK SBP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
</td>
		</tr>
<?php } ?>
<?php if ($t_sbp->tipe_sbp->Visible) { // tipe_sbp ?>
		<tr id="r_tipe_sbp">
			<td><?php echo $t_sbp->tipe_sbp->FldCaption() ?></td>
			<td<?php echo $t_sbp->tipe_sbp->CellAttributes() ?>>
<span id="el_t_sbp_tipe_sbp">
<span<?php echo $t_sbp->tipe_sbp->ViewAttributes() ?>>
<?php echo $t_sbp->tipe_sbp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_sbp->no_sbp->Visible) { // no_sbp ?>
		<tr id="r_no_sbp">
			<td><?php echo $t_sbp->no_sbp->FldCaption() ?></td>
			<td<?php echo $t_sbp->no_sbp->CellAttributes() ?>>
<span id="el_t_sbp_no_sbp">
<span<?php echo $t_sbp->no_sbp->ViewAttributes() ?>>
<?php echo $t_sbp->no_sbp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
