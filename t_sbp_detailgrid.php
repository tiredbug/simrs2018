<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($t_sbp_detail_grid)) $t_sbp_detail_grid = new ct_sbp_detail_grid();

// Page init
$t_sbp_detail_grid->Page_Init();

// Page main
$t_sbp_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sbp_detail_grid->Page_Render();
?>
<?php if ($t_sbp_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_sbp_detailgrid = new ew_Form("ft_sbp_detailgrid", "grid");
ft_sbp_detailgrid.FormKeyCountName = '<?php echo $t_sbp_detail_grid->FormKeyCountName ?>';

// Validate form
ft_sbp_detailgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sbp_detail->jumlah_belanja->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_sbp_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_rekening_belanja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah_belanja", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_sbp_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sbp_detailgrid.ValidateRequired = true;
<?php } else { ?>
ft_sbp_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t_sbp_detail->CurrentAction == "gridadd") {
	if ($t_sbp_detail->CurrentMode == "copy") {
		$bSelectLimit = $t_sbp_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_sbp_detail_grid->TotalRecs = $t_sbp_detail->SelectRecordCount();
			$t_sbp_detail_grid->Recordset = $t_sbp_detail_grid->LoadRecordset($t_sbp_detail_grid->StartRec-1, $t_sbp_detail_grid->DisplayRecs);
		} else {
			if ($t_sbp_detail_grid->Recordset = $t_sbp_detail_grid->LoadRecordset())
				$t_sbp_detail_grid->TotalRecs = $t_sbp_detail_grid->Recordset->RecordCount();
		}
		$t_sbp_detail_grid->StartRec = 1;
		$t_sbp_detail_grid->DisplayRecs = $t_sbp_detail_grid->TotalRecs;
	} else {
		$t_sbp_detail->CurrentFilter = "0=1";
		$t_sbp_detail_grid->StartRec = 1;
		$t_sbp_detail_grid->DisplayRecs = $t_sbp_detail->GridAddRowCount;
	}
	$t_sbp_detail_grid->TotalRecs = $t_sbp_detail_grid->DisplayRecs;
	$t_sbp_detail_grid->StopRec = $t_sbp_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_sbp_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_sbp_detail_grid->TotalRecs <= 0)
			$t_sbp_detail_grid->TotalRecs = $t_sbp_detail->SelectRecordCount();
	} else {
		if (!$t_sbp_detail_grid->Recordset && ($t_sbp_detail_grid->Recordset = $t_sbp_detail_grid->LoadRecordset()))
			$t_sbp_detail_grid->TotalRecs = $t_sbp_detail_grid->Recordset->RecordCount();
	}
	$t_sbp_detail_grid->StartRec = 1;
	$t_sbp_detail_grid->DisplayRecs = $t_sbp_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_sbp_detail_grid->Recordset = $t_sbp_detail_grid->LoadRecordset($t_sbp_detail_grid->StartRec-1, $t_sbp_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t_sbp_detail->CurrentAction == "" && $t_sbp_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_sbp_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_sbp_detail_grid->SearchWhere == "0=101")
			$t_sbp_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_sbp_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_sbp_detail_grid->RenderOtherOptions();
?>
<?php $t_sbp_detail_grid->ShowPageHeader(); ?>
<?php
$t_sbp_detail_grid->ShowMessage();
?>
<?php if ($t_sbp_detail_grid->TotalRecs > 0 || $t_sbp_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_sbp_detail">
<div id="ft_sbp_detailgrid" class="ewForm form-inline">
<div id="gmp_t_sbp_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_t_sbp_detailgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_sbp_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_sbp_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_sbp_detail_grid->RenderListOptions();

// Render list options (header, left)
$t_sbp_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_sbp_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
	<?php if ($t_sbp_detail->SortUrl($t_sbp_detail->kd_rekening_belanja) == "") { ?>
		<th data-name="kd_rekening_belanja"><div id="elh_t_sbp_detail_kd_rekening_belanja" class="t_sbp_detail_kd_rekening_belanja"><div class="ewTableHeaderCaption"><?php echo $t_sbp_detail->kd_rekening_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_rekening_belanja"><div><div id="elh_t_sbp_detail_kd_rekening_belanja" class="t_sbp_detail_kd_rekening_belanja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sbp_detail->kd_rekening_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sbp_detail->kd_rekening_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sbp_detail->kd_rekening_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sbp_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<?php if ($t_sbp_detail->SortUrl($t_sbp_detail->jumlah_belanja) == "") { ?>
		<th data-name="jumlah_belanja"><div id="elh_t_sbp_detail_jumlah_belanja" class="t_sbp_detail_jumlah_belanja"><div class="ewTableHeaderCaption"><?php echo $t_sbp_detail->jumlah_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_belanja"><div><div id="elh_t_sbp_detail_jumlah_belanja" class="t_sbp_detail_jumlah_belanja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sbp_detail->jumlah_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sbp_detail->jumlah_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sbp_detail->jumlah_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_sbp_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_sbp_detail_grid->StartRec = 1;
$t_sbp_detail_grid->StopRec = $t_sbp_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_sbp_detail_grid->FormKeyCountName) && ($t_sbp_detail->CurrentAction == "gridadd" || $t_sbp_detail->CurrentAction == "gridedit" || $t_sbp_detail->CurrentAction == "F")) {
		$t_sbp_detail_grid->KeyCount = $objForm->GetValue($t_sbp_detail_grid->FormKeyCountName);
		$t_sbp_detail_grid->StopRec = $t_sbp_detail_grid->StartRec + $t_sbp_detail_grid->KeyCount - 1;
	}
}
$t_sbp_detail_grid->RecCnt = $t_sbp_detail_grid->StartRec - 1;
if ($t_sbp_detail_grid->Recordset && !$t_sbp_detail_grid->Recordset->EOF) {
	$t_sbp_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_sbp_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_sbp_detail_grid->StartRec > 1)
		$t_sbp_detail_grid->Recordset->Move($t_sbp_detail_grid->StartRec - 1);
} elseif (!$t_sbp_detail->AllowAddDeleteRow && $t_sbp_detail_grid->StopRec == 0) {
	$t_sbp_detail_grid->StopRec = $t_sbp_detail->GridAddRowCount;
}

// Initialize aggregate
$t_sbp_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_sbp_detail->ResetAttrs();
$t_sbp_detail_grid->RenderRow();
if ($t_sbp_detail->CurrentAction == "gridadd")
	$t_sbp_detail_grid->RowIndex = 0;
if ($t_sbp_detail->CurrentAction == "gridedit")
	$t_sbp_detail_grid->RowIndex = 0;
while ($t_sbp_detail_grid->RecCnt < $t_sbp_detail_grid->StopRec) {
	$t_sbp_detail_grid->RecCnt++;
	if (intval($t_sbp_detail_grid->RecCnt) >= intval($t_sbp_detail_grid->StartRec)) {
		$t_sbp_detail_grid->RowCnt++;
		if ($t_sbp_detail->CurrentAction == "gridadd" || $t_sbp_detail->CurrentAction == "gridedit" || $t_sbp_detail->CurrentAction == "F") {
			$t_sbp_detail_grid->RowIndex++;
			$objForm->Index = $t_sbp_detail_grid->RowIndex;
			if ($objForm->HasValue($t_sbp_detail_grid->FormActionName))
				$t_sbp_detail_grid->RowAction = strval($objForm->GetValue($t_sbp_detail_grid->FormActionName));
			elseif ($t_sbp_detail->CurrentAction == "gridadd")
				$t_sbp_detail_grid->RowAction = "insert";
			else
				$t_sbp_detail_grid->RowAction = "";
		}

		// Set up key count
		$t_sbp_detail_grid->KeyCount = $t_sbp_detail_grid->RowIndex;

		// Init row class and style
		$t_sbp_detail->ResetAttrs();
		$t_sbp_detail->CssClass = "";
		if ($t_sbp_detail->CurrentAction == "gridadd") {
			if ($t_sbp_detail->CurrentMode == "copy") {
				$t_sbp_detail_grid->LoadRowValues($t_sbp_detail_grid->Recordset); // Load row values
				$t_sbp_detail_grid->SetRecordKey($t_sbp_detail_grid->RowOldKey, $t_sbp_detail_grid->Recordset); // Set old record key
			} else {
				$t_sbp_detail_grid->LoadDefaultValues(); // Load default values
				$t_sbp_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_sbp_detail_grid->LoadRowValues($t_sbp_detail_grid->Recordset); // Load row values
		}
		$t_sbp_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_sbp_detail->CurrentAction == "gridadd") // Grid add
			$t_sbp_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_sbp_detail->CurrentAction == "gridadd" && $t_sbp_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_sbp_detail_grid->RestoreCurrentRowFormValues($t_sbp_detail_grid->RowIndex); // Restore form values
		if ($t_sbp_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_sbp_detail->EventCancelled) {
				$t_sbp_detail_grid->RestoreCurrentRowFormValues($t_sbp_detail_grid->RowIndex); // Restore form values
			}
			if ($t_sbp_detail_grid->RowAction == "insert")
				$t_sbp_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_sbp_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_sbp_detail->CurrentAction == "gridedit" && ($t_sbp_detail->RowType == EW_ROWTYPE_EDIT || $t_sbp_detail->RowType == EW_ROWTYPE_ADD) && $t_sbp_detail->EventCancelled) // Update failed
			$t_sbp_detail_grid->RestoreCurrentRowFormValues($t_sbp_detail_grid->RowIndex); // Restore form values
		if ($t_sbp_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_sbp_detail_grid->EditRowCnt++;
		if ($t_sbp_detail->CurrentAction == "F") // Confirm row
			$t_sbp_detail_grid->RestoreCurrentRowFormValues($t_sbp_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_sbp_detail->RowAttrs = array_merge($t_sbp_detail->RowAttrs, array('data-rowindex'=>$t_sbp_detail_grid->RowCnt, 'id'=>'r' . $t_sbp_detail_grid->RowCnt . '_t_sbp_detail', 'data-rowtype'=>$t_sbp_detail->RowType));

		// Render row
		$t_sbp_detail_grid->RenderRow();

		// Render list options
		$t_sbp_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_sbp_detail_grid->RowAction <> "delete" && $t_sbp_detail_grid->RowAction <> "insertdelete" && !($t_sbp_detail_grid->RowAction == "insert" && $t_sbp_detail->CurrentAction == "F" && $t_sbp_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t_sbp_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_sbp_detail_grid->ListOptions->Render("body", "left", $t_sbp_detail_grid->RowCnt);
?>
	<?php if ($t_sbp_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja"<?php echo $t_sbp_detail->kd_rekening_belanja->CellAttributes() ?>>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_kd_rekening_belanja" class="form-group t_sbp_detail_kd_rekening_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->kd_rekening_belanja->EditValue ?>"<?php echo $t_sbp_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_kd_rekening_belanja" class="form-group t_sbp_detail_kd_rekening_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->kd_rekening_belanja->EditValue ?>"<?php echo $t_sbp_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_kd_rekening_belanja" class="t_sbp_detail_kd_rekening_belanja">
<span<?php echo $t_sbp_detail->kd_rekening_belanja->ViewAttributes() ?>>
<?php echo $t_sbp_detail->kd_rekening_belanja->ListViewValue() ?></span>
</span>
<?php if ($t_sbp_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="ft_sbp_detailgrid$x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="ft_sbp_detailgrid$x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="ft_sbp_detailgrid$o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="ft_sbp_detailgrid$o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_sbp_detail_grid->PageObjName . "_row_" . $t_sbp_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_id" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_id" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sbp_detail->id->CurrentValue) ?>">
<input type="hidden" data-table="t_sbp_detail" data-field="x_id" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_id" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sbp_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_EDIT || $t_sbp_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_id" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_id" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sbp_detail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_sbp_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja"<?php echo $t_sbp_detail->jumlah_belanja->CellAttributes() ?>>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_jumlah_belanja" class="form-group t_sbp_detail_jumlah_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->jumlah_belanja->EditValue ?>"<?php echo $t_sbp_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_jumlah_belanja" class="form-group t_sbp_detail_jumlah_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->jumlah_belanja->EditValue ?>"<?php echo $t_sbp_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sbp_detail_grid->RowCnt ?>_t_sbp_detail_jumlah_belanja" class="t_sbp_detail_jumlah_belanja">
<span<?php echo $t_sbp_detail->jumlah_belanja->ViewAttributes() ?>>
<?php echo $t_sbp_detail->jumlah_belanja->ListViewValue() ?></span>
</span>
<?php if ($t_sbp_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="ft_sbp_detailgrid$x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="ft_sbp_detailgrid$x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="ft_sbp_detailgrid$o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="ft_sbp_detailgrid$o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_sbp_detail_grid->ListOptions->Render("body", "right", $t_sbp_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t_sbp_detail->RowType == EW_ROWTYPE_ADD || $t_sbp_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_sbp_detailgrid.UpdateOpts(<?php echo $t_sbp_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_sbp_detail->CurrentAction <> "gridadd" || $t_sbp_detail->CurrentMode == "copy")
		if (!$t_sbp_detail_grid->Recordset->EOF) $t_sbp_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_sbp_detail->CurrentMode == "add" || $t_sbp_detail->CurrentMode == "copy" || $t_sbp_detail->CurrentMode == "edit") {
		$t_sbp_detail_grid->RowIndex = '$rowindex$';
		$t_sbp_detail_grid->LoadDefaultValues();

		// Set row properties
		$t_sbp_detail->ResetAttrs();
		$t_sbp_detail->RowAttrs = array_merge($t_sbp_detail->RowAttrs, array('data-rowindex'=>$t_sbp_detail_grid->RowIndex, 'id'=>'r0_t_sbp_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_sbp_detail->RowAttrs["class"], "ewTemplate");
		$t_sbp_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_sbp_detail_grid->RenderRow();

		// Render list options
		$t_sbp_detail_grid->RenderListOptions();
		$t_sbp_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_sbp_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_sbp_detail_grid->ListOptions->Render("body", "left", $t_sbp_detail_grid->RowIndex);
?>
	<?php if ($t_sbp_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja">
<?php if ($t_sbp_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sbp_detail_kd_rekening_belanja" class="form-group t_sbp_detail_kd_rekening_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->kd_rekening_belanja->EditValue ?>"<?php echo $t_sbp_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sbp_detail_kd_rekening_belanja" class="form-group t_sbp_detail_kd_rekening_belanja">
<span<?php echo $t_sbp_detail->kd_rekening_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sbp_detail->kd_rekening_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->kd_rekening_belanja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sbp_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja">
<?php if ($t_sbp_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sbp_detail_jumlah_belanja" class="form-group t_sbp_detail_jumlah_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->jumlah_belanja->EditValue ?>"<?php echo $t_sbp_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sbp_detail_jumlah_belanja" class="form-group t_sbp_detail_jumlah_belanja">
<span<?php echo $t_sbp_detail->jumlah_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sbp_detail->jumlah_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $t_sbp_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_sbp_detail_grid->ListOptions->Render("body", "right", $t_sbp_detail_grid->RowCnt);
?>
<script type="text/javascript">
ft_sbp_detailgrid.UpdateOpts(<?php echo $t_sbp_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_sbp_detail->CurrentMode == "add" || $t_sbp_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_sbp_detail_grid->FormKeyCountName ?>" id="<?php echo $t_sbp_detail_grid->FormKeyCountName ?>" value="<?php echo $t_sbp_detail_grid->KeyCount ?>">
<?php echo $t_sbp_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_sbp_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_sbp_detail_grid->FormKeyCountName ?>" id="<?php echo $t_sbp_detail_grid->FormKeyCountName ?>" value="<?php echo $t_sbp_detail_grid->KeyCount ?>">
<?php echo $t_sbp_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_sbp_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_sbp_detailgrid">
</div>
<?php

// Close recordset
if ($t_sbp_detail_grid->Recordset)
	$t_sbp_detail_grid->Recordset->Close();
?>
<?php if ($t_sbp_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_sbp_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_sbp_detail_grid->TotalRecs == 0 && $t_sbp_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_sbp_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_sbp_detail->Export == "") { ?>
<script type="text/javascript">
ft_sbp_detailgrid.Init();
</script>
<?php } ?>
<?php
$t_sbp_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_sbp_detail_grid->Page_Terminate();
?>
