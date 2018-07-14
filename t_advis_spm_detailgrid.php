<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($t_advis_spm_detail_grid)) $t_advis_spm_detail_grid = new ct_advis_spm_detail_grid();

// Page init
$t_advis_spm_detail_grid->Page_Init();

// Page main
$t_advis_spm_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_advis_spm_detail_grid->Page_Render();
?>
<?php if ($t_advis_spm_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_advis_spm_detailgrid = new ew_Form("ft_advis_spm_detailgrid", "grid");
ft_advis_spm_detailgrid.FormKeyCountName = '<?php echo $t_advis_spm_detail_grid->FormKeyCountName ?>';

// Validate form
ft_advis_spm_detailgrid.Validate = function() {
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

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_advis_spm_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "no_spm", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nama_rekanan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nama_bank", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_advis_spm_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_advis_spm_detailgrid.ValidateRequired = true;
<?php } else { ?>
ft_advis_spm_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t_advis_spm_detail->CurrentAction == "gridadd") {
	if ($t_advis_spm_detail->CurrentMode == "copy") {
		$bSelectLimit = $t_advis_spm_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_advis_spm_detail_grid->TotalRecs = $t_advis_spm_detail->SelectRecordCount();
			$t_advis_spm_detail_grid->Recordset = $t_advis_spm_detail_grid->LoadRecordset($t_advis_spm_detail_grid->StartRec-1, $t_advis_spm_detail_grid->DisplayRecs);
		} else {
			if ($t_advis_spm_detail_grid->Recordset = $t_advis_spm_detail_grid->LoadRecordset())
				$t_advis_spm_detail_grid->TotalRecs = $t_advis_spm_detail_grid->Recordset->RecordCount();
		}
		$t_advis_spm_detail_grid->StartRec = 1;
		$t_advis_spm_detail_grid->DisplayRecs = $t_advis_spm_detail_grid->TotalRecs;
	} else {
		$t_advis_spm_detail->CurrentFilter = "0=1";
		$t_advis_spm_detail_grid->StartRec = 1;
		$t_advis_spm_detail_grid->DisplayRecs = $t_advis_spm_detail->GridAddRowCount;
	}
	$t_advis_spm_detail_grid->TotalRecs = $t_advis_spm_detail_grid->DisplayRecs;
	$t_advis_spm_detail_grid->StopRec = $t_advis_spm_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_advis_spm_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_advis_spm_detail_grid->TotalRecs <= 0)
			$t_advis_spm_detail_grid->TotalRecs = $t_advis_spm_detail->SelectRecordCount();
	} else {
		if (!$t_advis_spm_detail_grid->Recordset && ($t_advis_spm_detail_grid->Recordset = $t_advis_spm_detail_grid->LoadRecordset()))
			$t_advis_spm_detail_grid->TotalRecs = $t_advis_spm_detail_grid->Recordset->RecordCount();
	}
	$t_advis_spm_detail_grid->StartRec = 1;
	$t_advis_spm_detail_grid->DisplayRecs = $t_advis_spm_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_advis_spm_detail_grid->Recordset = $t_advis_spm_detail_grid->LoadRecordset($t_advis_spm_detail_grid->StartRec-1, $t_advis_spm_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t_advis_spm_detail->CurrentAction == "" && $t_advis_spm_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_advis_spm_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_advis_spm_detail_grid->SearchWhere == "0=101")
			$t_advis_spm_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_advis_spm_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_advis_spm_detail_grid->RenderOtherOptions();
?>
<?php $t_advis_spm_detail_grid->ShowPageHeader(); ?>
<?php
$t_advis_spm_detail_grid->ShowMessage();
?>
<?php if ($t_advis_spm_detail_grid->TotalRecs > 0 || $t_advis_spm_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_advis_spm_detail">
<div id="ft_advis_spm_detailgrid" class="ewForm form-inline">
<div id="gmp_t_advis_spm_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_t_advis_spm_detailgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_advis_spm_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_advis_spm_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_advis_spm_detail_grid->RenderListOptions();

// Render list options (header, left)
$t_advis_spm_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_advis_spm_detail->no_spm->Visible) { // no_spm ?>
	<?php if ($t_advis_spm_detail->SortUrl($t_advis_spm_detail->no_spm) == "") { ?>
		<th data-name="no_spm"><div id="elh_t_advis_spm_detail_no_spm" class="t_advis_spm_detail_no_spm"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_advis_spm_detail->no_spm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_spm"><div><div id="elh_t_advis_spm_detail_no_spm" class="t_advis_spm_detail_no_spm">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_advis_spm_detail->no_spm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_advis_spm_detail->no_spm->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_advis_spm_detail->no_spm->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_advis_spm_detail->nama_rekanan->Visible) { // nama_rekanan ?>
	<?php if ($t_advis_spm_detail->SortUrl($t_advis_spm_detail->nama_rekanan) == "") { ?>
		<th data-name="nama_rekanan"><div id="elh_t_advis_spm_detail_nama_rekanan" class="t_advis_spm_detail_nama_rekanan"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_advis_spm_detail->nama_rekanan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_rekanan"><div><div id="elh_t_advis_spm_detail_nama_rekanan" class="t_advis_spm_detail_nama_rekanan">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_advis_spm_detail->nama_rekanan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_advis_spm_detail->nama_rekanan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_advis_spm_detail->nama_rekanan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_advis_spm_detail->nama_bank->Visible) { // nama_bank ?>
	<?php if ($t_advis_spm_detail->SortUrl($t_advis_spm_detail->nama_bank) == "") { ?>
		<th data-name="nama_bank"><div id="elh_t_advis_spm_detail_nama_bank" class="t_advis_spm_detail_nama_bank"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_advis_spm_detail->nama_bank->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_bank"><div><div id="elh_t_advis_spm_detail_nama_bank" class="t_advis_spm_detail_nama_bank">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_advis_spm_detail->nama_bank->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_advis_spm_detail->nama_bank->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_advis_spm_detail->nama_bank->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_advis_spm_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_advis_spm_detail_grid->StartRec = 1;
$t_advis_spm_detail_grid->StopRec = $t_advis_spm_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_advis_spm_detail_grid->FormKeyCountName) && ($t_advis_spm_detail->CurrentAction == "gridadd" || $t_advis_spm_detail->CurrentAction == "gridedit" || $t_advis_spm_detail->CurrentAction == "F")) {
		$t_advis_spm_detail_grid->KeyCount = $objForm->GetValue($t_advis_spm_detail_grid->FormKeyCountName);
		$t_advis_spm_detail_grid->StopRec = $t_advis_spm_detail_grid->StartRec + $t_advis_spm_detail_grid->KeyCount - 1;
	}
}
$t_advis_spm_detail_grid->RecCnt = $t_advis_spm_detail_grid->StartRec - 1;
if ($t_advis_spm_detail_grid->Recordset && !$t_advis_spm_detail_grid->Recordset->EOF) {
	$t_advis_spm_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_advis_spm_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_advis_spm_detail_grid->StartRec > 1)
		$t_advis_spm_detail_grid->Recordset->Move($t_advis_spm_detail_grid->StartRec - 1);
} elseif (!$t_advis_spm_detail->AllowAddDeleteRow && $t_advis_spm_detail_grid->StopRec == 0) {
	$t_advis_spm_detail_grid->StopRec = $t_advis_spm_detail->GridAddRowCount;
}

// Initialize aggregate
$t_advis_spm_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_advis_spm_detail->ResetAttrs();
$t_advis_spm_detail_grid->RenderRow();
if ($t_advis_spm_detail->CurrentAction == "gridadd")
	$t_advis_spm_detail_grid->RowIndex = 0;
if ($t_advis_spm_detail->CurrentAction == "gridedit")
	$t_advis_spm_detail_grid->RowIndex = 0;
while ($t_advis_spm_detail_grid->RecCnt < $t_advis_spm_detail_grid->StopRec) {
	$t_advis_spm_detail_grid->RecCnt++;
	if (intval($t_advis_spm_detail_grid->RecCnt) >= intval($t_advis_spm_detail_grid->StartRec)) {
		$t_advis_spm_detail_grid->RowCnt++;
		if ($t_advis_spm_detail->CurrentAction == "gridadd" || $t_advis_spm_detail->CurrentAction == "gridedit" || $t_advis_spm_detail->CurrentAction == "F") {
			$t_advis_spm_detail_grid->RowIndex++;
			$objForm->Index = $t_advis_spm_detail_grid->RowIndex;
			if ($objForm->HasValue($t_advis_spm_detail_grid->FormActionName))
				$t_advis_spm_detail_grid->RowAction = strval($objForm->GetValue($t_advis_spm_detail_grid->FormActionName));
			elseif ($t_advis_spm_detail->CurrentAction == "gridadd")
				$t_advis_spm_detail_grid->RowAction = "insert";
			else
				$t_advis_spm_detail_grid->RowAction = "";
		}

		// Set up key count
		$t_advis_spm_detail_grid->KeyCount = $t_advis_spm_detail_grid->RowIndex;

		// Init row class and style
		$t_advis_spm_detail->ResetAttrs();
		$t_advis_spm_detail->CssClass = "";
		if ($t_advis_spm_detail->CurrentAction == "gridadd") {
			if ($t_advis_spm_detail->CurrentMode == "copy") {
				$t_advis_spm_detail_grid->LoadRowValues($t_advis_spm_detail_grid->Recordset); // Load row values
				$t_advis_spm_detail_grid->SetRecordKey($t_advis_spm_detail_grid->RowOldKey, $t_advis_spm_detail_grid->Recordset); // Set old record key
			} else {
				$t_advis_spm_detail_grid->LoadDefaultValues(); // Load default values
				$t_advis_spm_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_advis_spm_detail_grid->LoadRowValues($t_advis_spm_detail_grid->Recordset); // Load row values
		}
		$t_advis_spm_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_advis_spm_detail->CurrentAction == "gridadd") // Grid add
			$t_advis_spm_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_advis_spm_detail->CurrentAction == "gridadd" && $t_advis_spm_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_advis_spm_detail_grid->RestoreCurrentRowFormValues($t_advis_spm_detail_grid->RowIndex); // Restore form values
		if ($t_advis_spm_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t_advis_spm_detail->EventCancelled) {
				$t_advis_spm_detail_grid->RestoreCurrentRowFormValues($t_advis_spm_detail_grid->RowIndex); // Restore form values
			}
			if ($t_advis_spm_detail_grid->RowAction == "insert")
				$t_advis_spm_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_advis_spm_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_advis_spm_detail->CurrentAction == "gridedit" && ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT || $t_advis_spm_detail->RowType == EW_ROWTYPE_ADD) && $t_advis_spm_detail->EventCancelled) // Update failed
			$t_advis_spm_detail_grid->RestoreCurrentRowFormValues($t_advis_spm_detail_grid->RowIndex); // Restore form values
		if ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_advis_spm_detail_grid->EditRowCnt++;
		if ($t_advis_spm_detail->CurrentAction == "F") // Confirm row
			$t_advis_spm_detail_grid->RestoreCurrentRowFormValues($t_advis_spm_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_advis_spm_detail->RowAttrs = array_merge($t_advis_spm_detail->RowAttrs, array('data-rowindex'=>$t_advis_spm_detail_grid->RowCnt, 'id'=>'r' . $t_advis_spm_detail_grid->RowCnt . '_t_advis_spm_detail', 'data-rowtype'=>$t_advis_spm_detail->RowType));

		// Render row
		$t_advis_spm_detail_grid->RenderRow();

		// Render list options
		$t_advis_spm_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_advis_spm_detail_grid->RowAction <> "delete" && $t_advis_spm_detail_grid->RowAction <> "insertdelete" && !($t_advis_spm_detail_grid->RowAction == "insert" && $t_advis_spm_detail->CurrentAction == "F" && $t_advis_spm_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t_advis_spm_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_advis_spm_detail_grid->ListOptions->Render("body", "left", $t_advis_spm_detail_grid->RowCnt);
?>
	<?php if ($t_advis_spm_detail->no_spm->Visible) { // no_spm ?>
		<td data-name="no_spm"<?php echo $t_advis_spm_detail->no_spm->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_no_spm" class="form-group t_advis_spm_detail_no_spm">
<input type="text" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->no_spm->EditValue ?>"<?php echo $t_advis_spm_detail->no_spm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->OldValue) ?>">
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_no_spm" class="form-group t_advis_spm_detail_no_spm">
<input type="text" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->no_spm->EditValue ?>"<?php echo $t_advis_spm_detail->no_spm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_no_spm" class="t_advis_spm_detail_no_spm">
<span<?php echo $t_advis_spm_detail->no_spm->ViewAttributes() ?>>
<?php echo $t_advis_spm_detail->no_spm->ListViewValue() ?></span>
</span>
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_advis_spm_detail_grid->PageObjName . "_row_" . $t_advis_spm_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_id" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->id->CurrentValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_id" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT || $t_advis_spm_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_id" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t_advis_spm_detail->nama_rekanan->Visible) { // nama_rekanan ?>
		<td data-name="nama_rekanan"<?php echo $t_advis_spm_detail->nama_rekanan->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_rekanan" class="form-group t_advis_spm_detail_nama_rekanan">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_rekanan->EditValue ?>"<?php echo $t_advis_spm_detail->nama_rekanan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->OldValue) ?>">
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_rekanan" class="form-group t_advis_spm_detail_nama_rekanan">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_rekanan->EditValue ?>"<?php echo $t_advis_spm_detail->nama_rekanan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_rekanan" class="t_advis_spm_detail_nama_rekanan">
<span<?php echo $t_advis_spm_detail->nama_rekanan->ViewAttributes() ?>>
<?php echo $t_advis_spm_detail->nama_rekanan->ListViewValue() ?></span>
</span>
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_advis_spm_detail->nama_bank->Visible) { // nama_bank ?>
		<td data-name="nama_bank"<?php echo $t_advis_spm_detail->nama_bank->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_bank" class="form-group t_advis_spm_detail_nama_bank">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_bank->EditValue ?>"<?php echo $t_advis_spm_detail->nama_bank->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->OldValue) ?>">
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_bank" class="form-group t_advis_spm_detail_nama_bank">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_bank->EditValue ?>"<?php echo $t_advis_spm_detail->nama_bank->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_advis_spm_detail_grid->RowCnt ?>_t_advis_spm_detail_nama_bank" class="t_advis_spm_detail_nama_bank">
<span<?php echo $t_advis_spm_detail->nama_bank->ViewAttributes() ?>>
<?php echo $t_advis_spm_detail->nama_bank->ListViewValue() ?></span>
</span>
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="ft_advis_spm_detailgrid$x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->FormValue) ?>">
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="ft_advis_spm_detailgrid$o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_advis_spm_detail_grid->ListOptions->Render("body", "right", $t_advis_spm_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t_advis_spm_detail->RowType == EW_ROWTYPE_ADD || $t_advis_spm_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_advis_spm_detailgrid.UpdateOpts(<?php echo $t_advis_spm_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_advis_spm_detail->CurrentAction <> "gridadd" || $t_advis_spm_detail->CurrentMode == "copy")
		if (!$t_advis_spm_detail_grid->Recordset->EOF) $t_advis_spm_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_advis_spm_detail->CurrentMode == "add" || $t_advis_spm_detail->CurrentMode == "copy" || $t_advis_spm_detail->CurrentMode == "edit") {
		$t_advis_spm_detail_grid->RowIndex = '$rowindex$';
		$t_advis_spm_detail_grid->LoadDefaultValues();

		// Set row properties
		$t_advis_spm_detail->ResetAttrs();
		$t_advis_spm_detail->RowAttrs = array_merge($t_advis_spm_detail->RowAttrs, array('data-rowindex'=>$t_advis_spm_detail_grid->RowIndex, 'id'=>'r0_t_advis_spm_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_advis_spm_detail->RowAttrs["class"], "ewTemplate");
		$t_advis_spm_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_advis_spm_detail_grid->RenderRow();

		// Render list options
		$t_advis_spm_detail_grid->RenderListOptions();
		$t_advis_spm_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_advis_spm_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_advis_spm_detail_grid->ListOptions->Render("body", "left", $t_advis_spm_detail_grid->RowIndex);
?>
	<?php if ($t_advis_spm_detail->no_spm->Visible) { // no_spm ?>
		<td data-name="no_spm">
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_advis_spm_detail_no_spm" class="form-group t_advis_spm_detail_no_spm">
<input type="text" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->no_spm->EditValue ?>"<?php echo $t_advis_spm_detail->no_spm->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_advis_spm_detail_no_spm" class="form-group t_advis_spm_detail_no_spm">
<span<?php echo $t_advis_spm_detail->no_spm->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->no_spm->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_no_spm" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_no_spm" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_advis_spm_detail->nama_rekanan->Visible) { // nama_rekanan ?>
		<td data-name="nama_rekanan">
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_advis_spm_detail_nama_rekanan" class="form-group t_advis_spm_detail_nama_rekanan">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_rekanan->EditValue ?>"<?php echo $t_advis_spm_detail->nama_rekanan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_advis_spm_detail_nama_rekanan" class="form-group t_advis_spm_detail_nama_rekanan">
<span<?php echo $t_advis_spm_detail->nama_rekanan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->nama_rekanan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_rekanan" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_advis_spm_detail->nama_bank->Visible) { // nama_bank ?>
		<td data-name="nama_bank">
<?php if ($t_advis_spm_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_advis_spm_detail_nama_bank" class="form-group t_advis_spm_detail_nama_bank">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_bank->EditValue ?>"<?php echo $t_advis_spm_detail->nama_bank->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_advis_spm_detail_nama_bank" class="form-group t_advis_spm_detail_nama_bank">
<span<?php echo $t_advis_spm_detail->nama_bank->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->nama_bank->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="x<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" id="o<?php echo $t_advis_spm_detail_grid->RowIndex ?>_nama_bank" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_advis_spm_detail_grid->ListOptions->Render("body", "right", $t_advis_spm_detail_grid->RowCnt);
?>
<script type="text/javascript">
ft_advis_spm_detailgrid.UpdateOpts(<?php echo $t_advis_spm_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_advis_spm_detail->CurrentMode == "add" || $t_advis_spm_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_advis_spm_detail_grid->FormKeyCountName ?>" id="<?php echo $t_advis_spm_detail_grid->FormKeyCountName ?>" value="<?php echo $t_advis_spm_detail_grid->KeyCount ?>">
<?php echo $t_advis_spm_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_advis_spm_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_advis_spm_detail_grid->FormKeyCountName ?>" id="<?php echo $t_advis_spm_detail_grid->FormKeyCountName ?>" value="<?php echo $t_advis_spm_detail_grid->KeyCount ?>">
<?php echo $t_advis_spm_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_advis_spm_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_advis_spm_detailgrid">
</div>
<?php

// Close recordset
if ($t_advis_spm_detail_grid->Recordset)
	$t_advis_spm_detail_grid->Recordset->Close();
?>
<?php if ($t_advis_spm_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_advis_spm_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_advis_spm_detail_grid->TotalRecs == 0 && $t_advis_spm_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_advis_spm_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_advis_spm_detail->Export == "") { ?>
<script type="text/javascript">
ft_advis_spm_detailgrid.Init();
</script>
<?php } ?>
<?php
$t_advis_spm_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_advis_spm_detail_grid->Page_Terminate();
?>
