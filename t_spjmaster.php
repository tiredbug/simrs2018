<?php

// id
// no_spj
// tgl_spj

?>
<?php if ($t_spj->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t_spj->TableCaption() ?></h4> -->
<table id="tbl_t_spjmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t_spj->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t_spj->id->Visible) { // id ?>
		<tr id="r_id">
			<td><?php echo $t_spj->id->FldCaption() ?></td>
			<td<?php echo $t_spj->id->CellAttributes() ?>>
<div id="orig_t_spj_id" class="hide">
<span id="el_t_spj_id">
<span<?php echo $t_spj->id->ViewAttributes() ?>>
<?php echo $t_spj->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_spj_gu.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
CETAK SPJ <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
</div>
</td>
		</tr>
<?php } ?>
<?php if ($t_spj->no_spj->Visible) { // no_spj ?>
		<tr id="r_no_spj">
			<td><?php echo $t_spj->no_spj->FldCaption() ?></td>
			<td<?php echo $t_spj->no_spj->CellAttributes() ?>>
<span id="el_t_spj_no_spj">
<span<?php echo $t_spj->no_spj->ViewAttributes() ?>>
<?php echo $t_spj->no_spj->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t_spj->tgl_spj->Visible) { // tgl_spj ?>
		<tr id="r_tgl_spj">
			<td><?php echo $t_spj->tgl_spj->FldCaption() ?></td>
			<td<?php echo $t_spj->tgl_spj->CellAttributes() ?>>
<span id="el_t_spj_tgl_spj">
<span<?php echo $t_spj->tgl_spj->ViewAttributes() ?>>
<?php echo $t_spj->tgl_spj->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
