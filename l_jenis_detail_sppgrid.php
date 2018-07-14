<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($l_jenis_detail_spp_grid)) $l_jenis_detail_spp_grid = new cl_jenis_detail_spp_grid();

// Page init
$l_jenis_detail_spp_grid->Page_Init();

// Page main
$l_jenis_detail_spp_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$l_jenis_detail_spp_grid->Page_Render();
?>
<?php if ($l_jenis_detail_spp->Export == "") { ?>
<script type="text/javascript">

// Form object
var fl_jenis_detail_sppgrid = new ew_Form("fl_jenis_detail_sppgrid", "grid");
fl_jenis_detail_sppgrid.FormKeyCountName = '<?php echo $l_jenis_detail_spp_grid->FormKeyCountName ?>';

// Validate form
fl_jenis_detail_sppgrid.Validate = function() {
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
fl_jenis_detail_sppgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "detail_jenis_spp", false)) return false;
	return true;
}

// Form_CustomValidate event
fl_jenis_detail_sppgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fl_jenis_detail_sppgrid.ValidateRequired = true;
<?php } else { ?>
fl_jenis_detail_sppgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($l_jenis_detail_spp->CurrentAction == "gridadd") {
	if ($l_jenis_detail_spp->CurrentMode == "copy") {
		$bSelectLimit = $l_jenis_detail_spp_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$l_jenis_detail_spp_grid->TotalRecs = $l_jenis_detail_spp->SelectRecordCount();
			$l_jenis_detail_spp_grid->Recordset = $l_jenis_detail_spp_grid->LoadRecordset($l_jenis_detail_spp_grid->StartRec-1, $l_jenis_detail_spp_grid->DisplayRecs);
		} else {
			if ($l_jenis_detail_spp_grid->Recordset = $l_jenis_detail_spp_grid->LoadRecordset())
				$l_jenis_detail_spp_grid->TotalRecs = $l_jenis_detail_spp_grid->Recordset->RecordCount();
		}
		$l_jenis_detail_spp_grid->StartRec = 1;
		$l_jenis_detail_spp_grid->DisplayRecs = $l_jenis_detail_spp_grid->TotalRecs;
	} else {
		$l_jenis_detail_spp->CurrentFilter = "0=1";
		$l_jenis_detail_spp_grid->StartRec = 1;
		$l_jenis_detail_spp_grid->DisplayRecs = $l_jenis_detail_spp->GridAddRowCount;
	}
	$l_jenis_detail_spp_grid->TotalRecs = $l_jenis_detail_spp_grid->DisplayRecs;
	$l_jenis_detail_spp_grid->StopRec = $l_jenis_detail_spp_grid->DisplayRecs;
} else {
	$bSelectLimit = $l_jenis_detail_spp_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($l_jenis_detail_spp_grid->TotalRecs <= 0)
			$l_jenis_detail_spp_grid->TotalRecs = $l_jenis_detail_spp->SelectRecordCount();
	} else {
		if (!$l_jenis_detail_spp_grid->Recordset && ($l_jenis_detail_spp_grid->Recordset = $l_jenis_detail_spp_grid->LoadRecordset()))
			$l_jenis_detail_spp_grid->TotalRecs = $l_jenis_detail_spp_grid->Recordset->RecordCount();
	}
	$l_jenis_detail_spp_grid->StartRec = 1;
	$l_jenis_detail_spp_grid->DisplayRecs = $l_jenis_detail_spp_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$l_jenis_detail_spp_grid->Recordset = $l_jenis_detail_spp_grid->LoadRecordset($l_jenis_detail_spp_grid->StartRec-1, $l_jenis_detail_spp_grid->DisplayRecs);

	// Set no record found message
	if ($l_jenis_detail_spp->CurrentAction == "" && $l_jenis_detail_spp_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$l_jenis_detail_spp_grid->setWarningMessage(ew_DeniedMsg());
		if ($l_jenis_detail_spp_grid->SearchWhere == "0=101")
			$l_jenis_detail_spp_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$l_jenis_detail_spp_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$l_jenis_detail_spp_grid->RenderOtherOptions();
?>
<?php $l_jenis_detail_spp_grid->ShowPageHeader(); ?>
<?php
$l_jenis_detail_spp_grid->ShowMessage();
?>
<?php if ($l_jenis_detail_spp_grid->TotalRecs > 0 || $l_jenis_detail_spp->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid l_jenis_detail_spp">
<div id="fl_jenis_detail_sppgrid" class="ewForm form-inline">
<div id="gmp_l_jenis_detail_spp" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_l_jenis_detail_sppgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $l_jenis_detail_spp->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$l_jenis_detail_spp_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$l_jenis_detail_spp_grid->RenderListOptions();

// Render list options (header, left)
$l_jenis_detail_spp_grid->ListOptions->Render("header", "left");
?>
<?php if ($l_jenis_detail_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<?php if ($l_jenis_detail_spp->SortUrl($l_jenis_detail_spp->detail_jenis_spp) == "") { ?>
		<th data-name="detail_jenis_spp"><div id="elh_l_jenis_detail_spp_detail_jenis_spp" class="l_jenis_detail_spp_detail_jenis_spp"><div class="ewTableHeaderCaption"><?php echo $l_jenis_detail_spp->detail_jenis_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="detail_jenis_spp"><div><div id="elh_l_jenis_detail_spp_detail_jenis_spp" class="l_jenis_detail_spp_detail_jenis_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $l_jenis_detail_spp->detail_jenis_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($l_jenis_detail_spp->detail_jenis_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($l_jenis_detail_spp->detail_jenis_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$l_jenis_detail_spp_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$l_jenis_detail_spp_grid->StartRec = 1;
$l_jenis_detail_spp_grid->StopRec = $l_jenis_detail_spp_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($l_jenis_detail_spp_grid->FormKeyCountName) && ($l_jenis_detail_spp->CurrentAction == "gridadd" || $l_jenis_detail_spp->CurrentAction == "gridedit" || $l_jenis_detail_spp->CurrentAction == "F")) {
		$l_jenis_detail_spp_grid->KeyCount = $objForm->GetValue($l_jenis_detail_spp_grid->FormKeyCountName);
		$l_jenis_detail_spp_grid->StopRec = $l_jenis_detail_spp_grid->StartRec + $l_jenis_detail_spp_grid->KeyCount - 1;
	}
}
$l_jenis_detail_spp_grid->RecCnt = $l_jenis_detail_spp_grid->StartRec - 1;
if ($l_jenis_detail_spp_grid->Recordset && !$l_jenis_detail_spp_grid->Recordset->EOF) {
	$l_jenis_detail_spp_grid->Recordset->MoveFirst();
	$bSelectLimit = $l_jenis_detail_spp_grid->UseSelectLimit;
	if (!$bSelectLimit && $l_jenis_detail_spp_grid->StartRec > 1)
		$l_jenis_detail_spp_grid->Recordset->Move($l_jenis_detail_spp_grid->StartRec - 1);
} elseif (!$l_jenis_detail_spp->AllowAddDeleteRow && $l_jenis_detail_spp_grid->StopRec == 0) {
	$l_jenis_detail_spp_grid->StopRec = $l_jenis_detail_spp->GridAddRowCount;
}

// Initialize aggregate
$l_jenis_detail_spp->RowType = EW_ROWTYPE_AGGREGATEINIT;
$l_jenis_detail_spp->ResetAttrs();
$l_jenis_detail_spp_grid->RenderRow();
if ($l_jenis_detail_spp->CurrentAction == "gridadd")
	$l_jenis_detail_spp_grid->RowIndex = 0;
if ($l_jenis_detail_spp->CurrentAction == "gridedit")
	$l_jenis_detail_spp_grid->RowIndex = 0;
while ($l_jenis_detail_spp_grid->RecCnt < $l_jenis_detail_spp_grid->StopRec) {
	$l_jenis_detail_spp_grid->RecCnt++;
	if (intval($l_jenis_detail_spp_grid->RecCnt) >= intval($l_jenis_detail_spp_grid->StartRec)) {
		$l_jenis_detail_spp_grid->RowCnt++;
		if ($l_jenis_detail_spp->CurrentAction == "gridadd" || $l_jenis_detail_spp->CurrentAction == "gridedit" || $l_jenis_detail_spp->CurrentAction == "F") {
			$l_jenis_detail_spp_grid->RowIndex++;
			$objForm->Index = $l_jenis_detail_spp_grid->RowIndex;
			if ($objForm->HasValue($l_jenis_detail_spp_grid->FormActionName))
				$l_jenis_detail_spp_grid->RowAction = strval($objForm->GetValue($l_jenis_detail_spp_grid->FormActionName));
			elseif ($l_jenis_detail_spp->CurrentAction == "gridadd")
				$l_jenis_detail_spp_grid->RowAction = "insert";
			else
				$l_jenis_detail_spp_grid->RowAction = "";
		}

		// Set up key count
		$l_jenis_detail_spp_grid->KeyCount = $l_jenis_detail_spp_grid->RowIndex;

		// Init row class and style
		$l_jenis_detail_spp->ResetAttrs();
		$l_jenis_detail_spp->CssClass = "";
		if ($l_jenis_detail_spp->CurrentAction == "gridadd") {
			if ($l_jenis_detail_spp->CurrentMode == "copy") {
				$l_jenis_detail_spp_grid->LoadRowValues($l_jenis_detail_spp_grid->Recordset); // Load row values
				$l_jenis_detail_spp_grid->SetRecordKey($l_jenis_detail_spp_grid->RowOldKey, $l_jenis_detail_spp_grid->Recordset); // Set old record key
			} else {
				$l_jenis_detail_spp_grid->LoadDefaultValues(); // Load default values
				$l_jenis_detail_spp_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$l_jenis_detail_spp_grid->LoadRowValues($l_jenis_detail_spp_grid->Recordset); // Load row values
		}
		$l_jenis_detail_spp->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($l_jenis_detail_spp->CurrentAction == "gridadd") // Grid add
			$l_jenis_detail_spp->RowType = EW_ROWTYPE_ADD; // Render add
		if ($l_jenis_detail_spp->CurrentAction == "gridadd" && $l_jenis_detail_spp->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$l_jenis_detail_spp_grid->RestoreCurrentRowFormValues($l_jenis_detail_spp_grid->RowIndex); // Restore form values
		if ($l_jenis_detail_spp->CurrentAction == "gridedit") { // Grid edit
			if ($l_jenis_detail_spp->EventCancelled) {
				$l_jenis_detail_spp_grid->RestoreCurrentRowFormValues($l_jenis_detail_spp_grid->RowIndex); // Restore form values
			}
			if ($l_jenis_detail_spp_grid->RowAction == "insert")
				$l_jenis_detail_spp->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$l_jenis_detail_spp->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($l_jenis_detail_spp->CurrentAction == "gridedit" && ($l_jenis_detail_spp->RowType == EW_ROWTYPE_EDIT || $l_jenis_detail_spp->RowType == EW_ROWTYPE_ADD) && $l_jenis_detail_spp->EventCancelled) // Update failed
			$l_jenis_detail_spp_grid->RestoreCurrentRowFormValues($l_jenis_detail_spp_grid->RowIndex); // Restore form values
		if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_EDIT) // Edit row
			$l_jenis_detail_spp_grid->EditRowCnt++;
		if ($l_jenis_detail_spp->CurrentAction == "F") // Confirm row
			$l_jenis_detail_spp_grid->RestoreCurrentRowFormValues($l_jenis_detail_spp_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$l_jenis_detail_spp->RowAttrs = array_merge($l_jenis_detail_spp->RowAttrs, array('data-rowindex'=>$l_jenis_detail_spp_grid->RowCnt, 'id'=>'r' . $l_jenis_detail_spp_grid->RowCnt . '_l_jenis_detail_spp', 'data-rowtype'=>$l_jenis_detail_spp->RowType));

		// Render row
		$l_jenis_detail_spp_grid->RenderRow();

		// Render list options
		$l_jenis_detail_spp_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($l_jenis_detail_spp_grid->RowAction <> "delete" && $l_jenis_detail_spp_grid->RowAction <> "insertdelete" && !($l_jenis_detail_spp_grid->RowAction == "insert" && $l_jenis_detail_spp->CurrentAction == "F" && $l_jenis_detail_spp_grid->EmptyRow())) {
?>
	<tr<?php echo $l_jenis_detail_spp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$l_jenis_detail_spp_grid->ListOptions->Render("body", "left", $l_jenis_detail_spp_grid->RowCnt);
?>
	<?php if ($l_jenis_detail_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
		<td data-name="detail_jenis_spp"<?php echo $l_jenis_detail_spp->detail_jenis_spp->CellAttributes() ?>>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $l_jenis_detail_spp_grid->RowCnt ?>_l_jenis_detail_spp_detail_jenis_spp" class="form-group l_jenis_detail_spp_detail_jenis_spp">
<input type="text" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->getPlaceHolder()) ?>" value="<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditValue ?>"<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->OldValue) ?>">
<?php } ?>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $l_jenis_detail_spp_grid->RowCnt ?>_l_jenis_detail_spp_detail_jenis_spp" class="form-group l_jenis_detail_spp_detail_jenis_spp">
<input type="text" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->getPlaceHolder()) ?>" value="<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditValue ?>"<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $l_jenis_detail_spp_grid->RowCnt ?>_l_jenis_detail_spp_detail_jenis_spp" class="l_jenis_detail_spp_detail_jenis_spp">
<span<?php echo $l_jenis_detail_spp->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $l_jenis_detail_spp->detail_jenis_spp->ListViewValue() ?></span>
</span>
<?php if ($l_jenis_detail_spp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->FormValue) ?>">
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="fl_jenis_detail_sppgrid$x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="fl_jenis_detail_sppgrid$x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->FormValue) ?>">
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="fl_jenis_detail_sppgrid$o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="fl_jenis_detail_sppgrid$o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $l_jenis_detail_spp_grid->PageObjName . "_row_" . $l_jenis_detail_spp_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_id" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->id->CurrentValue) ?>">
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_id" name="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" id="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->id->OldValue) ?>">
<?php } ?>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_EDIT || $l_jenis_detail_spp->CurrentMode == "edit") { ?>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_id" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->id->CurrentValue) ?>">
<?php } ?>
<?php

// Render list options (body, right)
$l_jenis_detail_spp_grid->ListOptions->Render("body", "right", $l_jenis_detail_spp_grid->RowCnt);
?>
	</tr>
<?php if ($l_jenis_detail_spp->RowType == EW_ROWTYPE_ADD || $l_jenis_detail_spp->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fl_jenis_detail_sppgrid.UpdateOpts(<?php echo $l_jenis_detail_spp_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($l_jenis_detail_spp->CurrentAction <> "gridadd" || $l_jenis_detail_spp->CurrentMode == "copy")
		if (!$l_jenis_detail_spp_grid->Recordset->EOF) $l_jenis_detail_spp_grid->Recordset->MoveNext();
}
?>
<?php
	if ($l_jenis_detail_spp->CurrentMode == "add" || $l_jenis_detail_spp->CurrentMode == "copy" || $l_jenis_detail_spp->CurrentMode == "edit") {
		$l_jenis_detail_spp_grid->RowIndex = '$rowindex$';
		$l_jenis_detail_spp_grid->LoadDefaultValues();

		// Set row properties
		$l_jenis_detail_spp->ResetAttrs();
		$l_jenis_detail_spp->RowAttrs = array_merge($l_jenis_detail_spp->RowAttrs, array('data-rowindex'=>$l_jenis_detail_spp_grid->RowIndex, 'id'=>'r0_l_jenis_detail_spp', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($l_jenis_detail_spp->RowAttrs["class"], "ewTemplate");
		$l_jenis_detail_spp->RowType = EW_ROWTYPE_ADD;

		// Render row
		$l_jenis_detail_spp_grid->RenderRow();

		// Render list options
		$l_jenis_detail_spp_grid->RenderListOptions();
		$l_jenis_detail_spp_grid->StartRowCnt = 0;
?>
	<tr<?php echo $l_jenis_detail_spp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$l_jenis_detail_spp_grid->ListOptions->Render("body", "left", $l_jenis_detail_spp_grid->RowIndex);
?>
	<?php if ($l_jenis_detail_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
		<td data-name="detail_jenis_spp">
<?php if ($l_jenis_detail_spp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_l_jenis_detail_spp_detail_jenis_spp" class="form-group l_jenis_detail_spp_detail_jenis_spp">
<input type="text" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->getPlaceHolder()) ?>" value="<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditValue ?>"<?php echo $l_jenis_detail_spp->detail_jenis_spp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_l_jenis_detail_spp_detail_jenis_spp" class="form-group l_jenis_detail_spp_detail_jenis_spp">
<span<?php echo $l_jenis_detail_spp->detail_jenis_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $l_jenis_detail_spp->detail_jenis_spp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="x<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="l_jenis_detail_spp" data-field="x_detail_jenis_spp" name="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" id="o<?php echo $l_jenis_detail_spp_grid->RowIndex ?>_detail_jenis_spp" value="<?php echo ew_HtmlEncode($l_jenis_detail_spp->detail_jenis_spp->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$l_jenis_detail_spp_grid->ListOptions->Render("body", "right", $l_jenis_detail_spp_grid->RowCnt);
?>
<script type="text/javascript">
fl_jenis_detail_sppgrid.UpdateOpts(<?php echo $l_jenis_detail_spp_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($l_jenis_detail_spp->CurrentMode == "add" || $l_jenis_detail_spp->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $l_jenis_detail_spp_grid->FormKeyCountName ?>" id="<?php echo $l_jenis_detail_spp_grid->FormKeyCountName ?>" value="<?php echo $l_jenis_detail_spp_grid->KeyCount ?>">
<?php echo $l_jenis_detail_spp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($l_jenis_detail_spp->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $l_jenis_detail_spp_grid->FormKeyCountName ?>" id="<?php echo $l_jenis_detail_spp_grid->FormKeyCountName ?>" value="<?php echo $l_jenis_detail_spp_grid->KeyCount ?>">
<?php echo $l_jenis_detail_spp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($l_jenis_detail_spp->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fl_jenis_detail_sppgrid">
</div>
<?php

// Close recordset
if ($l_jenis_detail_spp_grid->Recordset)
	$l_jenis_detail_spp_grid->Recordset->Close();
?>
<?php if ($l_jenis_detail_spp_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($l_jenis_detail_spp_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($l_jenis_detail_spp_grid->TotalRecs == 0 && $l_jenis_detail_spp->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($l_jenis_detail_spp_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($l_jenis_detail_spp->Export == "") { ?>
<script type="text/javascript">
fl_jenis_detail_sppgrid.Init();
</script>
<?php } ?>
<?php
$l_jenis_detail_spp_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$l_jenis_detail_spp_grid->Page_Terminate();
?>
