<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($data_kontrak_detail_termin_grid)) $data_kontrak_detail_termin_grid = new cdata_kontrak_detail_termin_grid();

// Page init
$data_kontrak_detail_termin_grid->Page_Init();

// Page main
$data_kontrak_detail_termin_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$data_kontrak_detail_termin_grid->Page_Render();
?>
<?php if ($data_kontrak_detail_termin->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdata_kontrak_detail_termingrid = new ew_Form("fdata_kontrak_detail_termingrid", "grid");
fdata_kontrak_detail_termingrid.FormKeyCountName = '<?php echo $data_kontrak_detail_termin_grid->FormKeyCountName ?>';

// Validate form
fdata_kontrak_detail_termingrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_terminke");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->terminke->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_target_fisik");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->target_fisik->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_detail");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->id_detail->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdata_kontrak_detail_termingrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "terminke", false)) return false;
	if (ew_ValueChanged(fobj, infix, "target_fisik", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nilai", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_detail", false)) return false;
	return true;
}

// Form_CustomValidate event
fdata_kontrak_detail_termingrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdata_kontrak_detail_termingrid.ValidateRequired = true;
<?php } else { ?>
fdata_kontrak_detail_termingrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($data_kontrak_detail_termin->CurrentAction == "gridadd") {
	if ($data_kontrak_detail_termin->CurrentMode == "copy") {
		$bSelectLimit = $data_kontrak_detail_termin_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$data_kontrak_detail_termin_grid->TotalRecs = $data_kontrak_detail_termin->SelectRecordCount();
			$data_kontrak_detail_termin_grid->Recordset = $data_kontrak_detail_termin_grid->LoadRecordset($data_kontrak_detail_termin_grid->StartRec-1, $data_kontrak_detail_termin_grid->DisplayRecs);
		} else {
			if ($data_kontrak_detail_termin_grid->Recordset = $data_kontrak_detail_termin_grid->LoadRecordset())
				$data_kontrak_detail_termin_grid->TotalRecs = $data_kontrak_detail_termin_grid->Recordset->RecordCount();
		}
		$data_kontrak_detail_termin_grid->StartRec = 1;
		$data_kontrak_detail_termin_grid->DisplayRecs = $data_kontrak_detail_termin_grid->TotalRecs;
	} else {
		$data_kontrak_detail_termin->CurrentFilter = "0=1";
		$data_kontrak_detail_termin_grid->StartRec = 1;
		$data_kontrak_detail_termin_grid->DisplayRecs = $data_kontrak_detail_termin->GridAddRowCount;
	}
	$data_kontrak_detail_termin_grid->TotalRecs = $data_kontrak_detail_termin_grid->DisplayRecs;
	$data_kontrak_detail_termin_grid->StopRec = $data_kontrak_detail_termin_grid->DisplayRecs;
} else {
	$bSelectLimit = $data_kontrak_detail_termin_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($data_kontrak_detail_termin_grid->TotalRecs <= 0)
			$data_kontrak_detail_termin_grid->TotalRecs = $data_kontrak_detail_termin->SelectRecordCount();
	} else {
		if (!$data_kontrak_detail_termin_grid->Recordset && ($data_kontrak_detail_termin_grid->Recordset = $data_kontrak_detail_termin_grid->LoadRecordset()))
			$data_kontrak_detail_termin_grid->TotalRecs = $data_kontrak_detail_termin_grid->Recordset->RecordCount();
	}
	$data_kontrak_detail_termin_grid->StartRec = 1;
	$data_kontrak_detail_termin_grid->DisplayRecs = $data_kontrak_detail_termin_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$data_kontrak_detail_termin_grid->Recordset = $data_kontrak_detail_termin_grid->LoadRecordset($data_kontrak_detail_termin_grid->StartRec-1, $data_kontrak_detail_termin_grid->DisplayRecs);

	// Set no record found message
	if ($data_kontrak_detail_termin->CurrentAction == "" && $data_kontrak_detail_termin_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$data_kontrak_detail_termin_grid->setWarningMessage(ew_DeniedMsg());
		if ($data_kontrak_detail_termin_grid->SearchWhere == "0=101")
			$data_kontrak_detail_termin_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$data_kontrak_detail_termin_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$data_kontrak_detail_termin_grid->RenderOtherOptions();
?>
<?php $data_kontrak_detail_termin_grid->ShowPageHeader(); ?>
<?php
$data_kontrak_detail_termin_grid->ShowMessage();
?>
<?php if ($data_kontrak_detail_termin_grid->TotalRecs > 0 || $data_kontrak_detail_termin->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid data_kontrak_detail_termin">
<div id="fdata_kontrak_detail_termingrid" class="ewForm form-inline">
<div id="gmp_data_kontrak_detail_termin" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_data_kontrak_detail_termingrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $data_kontrak_detail_termin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$data_kontrak_detail_termin_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$data_kontrak_detail_termin_grid->RenderListOptions();

// Render list options (header, left)
$data_kontrak_detail_termin_grid->ListOptions->Render("header", "left");
?>
<?php if ($data_kontrak_detail_termin->id->Visible) { // id ?>
	<?php if ($data_kontrak_detail_termin->SortUrl($data_kontrak_detail_termin->id) == "") { ?>
		<th data-name="id"><div id="elh_data_kontrak_detail_termin_id" class="data_kontrak_detail_termin_id"><div class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_data_kontrak_detail_termin_id" class="data_kontrak_detail_termin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($data_kontrak_detail_termin->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($data_kontrak_detail_termin->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($data_kontrak_detail_termin->terminke->Visible) { // terminke ?>
	<?php if ($data_kontrak_detail_termin->SortUrl($data_kontrak_detail_termin->terminke) == "") { ?>
		<th data-name="terminke"><div id="elh_data_kontrak_detail_termin_terminke" class="data_kontrak_detail_termin_terminke"><div class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->terminke->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="terminke"><div><div id="elh_data_kontrak_detail_termin_terminke" class="data_kontrak_detail_termin_terminke">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->terminke->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($data_kontrak_detail_termin->terminke->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($data_kontrak_detail_termin->terminke->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($data_kontrak_detail_termin->target_fisik->Visible) { // target_fisik ?>
	<?php if ($data_kontrak_detail_termin->SortUrl($data_kontrak_detail_termin->target_fisik) == "") { ?>
		<th data-name="target_fisik"><div id="elh_data_kontrak_detail_termin_target_fisik" class="data_kontrak_detail_termin_target_fisik"><div class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->target_fisik->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="target_fisik"><div><div id="elh_data_kontrak_detail_termin_target_fisik" class="data_kontrak_detail_termin_target_fisik">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->target_fisik->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($data_kontrak_detail_termin->target_fisik->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($data_kontrak_detail_termin->target_fisik->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($data_kontrak_detail_termin->nilai->Visible) { // nilai ?>
	<?php if ($data_kontrak_detail_termin->SortUrl($data_kontrak_detail_termin->nilai) == "") { ?>
		<th data-name="nilai"><div id="elh_data_kontrak_detail_termin_nilai" class="data_kontrak_detail_termin_nilai"><div class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nilai"><div><div id="elh_data_kontrak_detail_termin_nilai" class="data_kontrak_detail_termin_nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($data_kontrak_detail_termin->nilai->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($data_kontrak_detail_termin->nilai->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($data_kontrak_detail_termin->id_detail->Visible) { // id_detail ?>
	<?php if ($data_kontrak_detail_termin->SortUrl($data_kontrak_detail_termin->id_detail) == "") { ?>
		<th data-name="id_detail"><div id="elh_data_kontrak_detail_termin_id_detail" class="data_kontrak_detail_termin_id_detail"><div class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->id_detail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_detail"><div><div id="elh_data_kontrak_detail_termin_id_detail" class="data_kontrak_detail_termin_id_detail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $data_kontrak_detail_termin->id_detail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($data_kontrak_detail_termin->id_detail->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($data_kontrak_detail_termin->id_detail->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$data_kontrak_detail_termin_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$data_kontrak_detail_termin_grid->StartRec = 1;
$data_kontrak_detail_termin_grid->StopRec = $data_kontrak_detail_termin_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($data_kontrak_detail_termin_grid->FormKeyCountName) && ($data_kontrak_detail_termin->CurrentAction == "gridadd" || $data_kontrak_detail_termin->CurrentAction == "gridedit" || $data_kontrak_detail_termin->CurrentAction == "F")) {
		$data_kontrak_detail_termin_grid->KeyCount = $objForm->GetValue($data_kontrak_detail_termin_grid->FormKeyCountName);
		$data_kontrak_detail_termin_grid->StopRec = $data_kontrak_detail_termin_grid->StartRec + $data_kontrak_detail_termin_grid->KeyCount - 1;
	}
}
$data_kontrak_detail_termin_grid->RecCnt = $data_kontrak_detail_termin_grid->StartRec - 1;
if ($data_kontrak_detail_termin_grid->Recordset && !$data_kontrak_detail_termin_grid->Recordset->EOF) {
	$data_kontrak_detail_termin_grid->Recordset->MoveFirst();
	$bSelectLimit = $data_kontrak_detail_termin_grid->UseSelectLimit;
	if (!$bSelectLimit && $data_kontrak_detail_termin_grid->StartRec > 1)
		$data_kontrak_detail_termin_grid->Recordset->Move($data_kontrak_detail_termin_grid->StartRec - 1);
} elseif (!$data_kontrak_detail_termin->AllowAddDeleteRow && $data_kontrak_detail_termin_grid->StopRec == 0) {
	$data_kontrak_detail_termin_grid->StopRec = $data_kontrak_detail_termin->GridAddRowCount;
}

// Initialize aggregate
$data_kontrak_detail_termin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$data_kontrak_detail_termin->ResetAttrs();
$data_kontrak_detail_termin_grid->RenderRow();
if ($data_kontrak_detail_termin->CurrentAction == "gridadd")
	$data_kontrak_detail_termin_grid->RowIndex = 0;
if ($data_kontrak_detail_termin->CurrentAction == "gridedit")
	$data_kontrak_detail_termin_grid->RowIndex = 0;
while ($data_kontrak_detail_termin_grid->RecCnt < $data_kontrak_detail_termin_grid->StopRec) {
	$data_kontrak_detail_termin_grid->RecCnt++;
	if (intval($data_kontrak_detail_termin_grid->RecCnt) >= intval($data_kontrak_detail_termin_grid->StartRec)) {
		$data_kontrak_detail_termin_grid->RowCnt++;
		if ($data_kontrak_detail_termin->CurrentAction == "gridadd" || $data_kontrak_detail_termin->CurrentAction == "gridedit" || $data_kontrak_detail_termin->CurrentAction == "F") {
			$data_kontrak_detail_termin_grid->RowIndex++;
			$objForm->Index = $data_kontrak_detail_termin_grid->RowIndex;
			if ($objForm->HasValue($data_kontrak_detail_termin_grid->FormActionName))
				$data_kontrak_detail_termin_grid->RowAction = strval($objForm->GetValue($data_kontrak_detail_termin_grid->FormActionName));
			elseif ($data_kontrak_detail_termin->CurrentAction == "gridadd")
				$data_kontrak_detail_termin_grid->RowAction = "insert";
			else
				$data_kontrak_detail_termin_grid->RowAction = "";
		}

		// Set up key count
		$data_kontrak_detail_termin_grid->KeyCount = $data_kontrak_detail_termin_grid->RowIndex;

		// Init row class and style
		$data_kontrak_detail_termin->ResetAttrs();
		$data_kontrak_detail_termin->CssClass = "";
		if ($data_kontrak_detail_termin->CurrentAction == "gridadd") {
			if ($data_kontrak_detail_termin->CurrentMode == "copy") {
				$data_kontrak_detail_termin_grid->LoadRowValues($data_kontrak_detail_termin_grid->Recordset); // Load row values
				$data_kontrak_detail_termin_grid->SetRecordKey($data_kontrak_detail_termin_grid->RowOldKey, $data_kontrak_detail_termin_grid->Recordset); // Set old record key
			} else {
				$data_kontrak_detail_termin_grid->LoadDefaultValues(); // Load default values
				$data_kontrak_detail_termin_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$data_kontrak_detail_termin_grid->LoadRowValues($data_kontrak_detail_termin_grid->Recordset); // Load row values
		}
		$data_kontrak_detail_termin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($data_kontrak_detail_termin->CurrentAction == "gridadd") // Grid add
			$data_kontrak_detail_termin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($data_kontrak_detail_termin->CurrentAction == "gridadd" && $data_kontrak_detail_termin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$data_kontrak_detail_termin_grid->RestoreCurrentRowFormValues($data_kontrak_detail_termin_grid->RowIndex); // Restore form values
		if ($data_kontrak_detail_termin->CurrentAction == "gridedit") { // Grid edit
			if ($data_kontrak_detail_termin->EventCancelled) {
				$data_kontrak_detail_termin_grid->RestoreCurrentRowFormValues($data_kontrak_detail_termin_grid->RowIndex); // Restore form values
			}
			if ($data_kontrak_detail_termin_grid->RowAction == "insert")
				$data_kontrak_detail_termin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$data_kontrak_detail_termin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($data_kontrak_detail_termin->CurrentAction == "gridedit" && ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT || $data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) && $data_kontrak_detail_termin->EventCancelled) // Update failed
			$data_kontrak_detail_termin_grid->RestoreCurrentRowFormValues($data_kontrak_detail_termin_grid->RowIndex); // Restore form values
		if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$data_kontrak_detail_termin_grid->EditRowCnt++;
		if ($data_kontrak_detail_termin->CurrentAction == "F") // Confirm row
			$data_kontrak_detail_termin_grid->RestoreCurrentRowFormValues($data_kontrak_detail_termin_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$data_kontrak_detail_termin->RowAttrs = array_merge($data_kontrak_detail_termin->RowAttrs, array('data-rowindex'=>$data_kontrak_detail_termin_grid->RowCnt, 'id'=>'r' . $data_kontrak_detail_termin_grid->RowCnt . '_data_kontrak_detail_termin', 'data-rowtype'=>$data_kontrak_detail_termin->RowType));

		// Render row
		$data_kontrak_detail_termin_grid->RenderRow();

		// Render list options
		$data_kontrak_detail_termin_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($data_kontrak_detail_termin_grid->RowAction <> "delete" && $data_kontrak_detail_termin_grid->RowAction <> "insertdelete" && !($data_kontrak_detail_termin_grid->RowAction == "insert" && $data_kontrak_detail_termin->CurrentAction == "F" && $data_kontrak_detail_termin_grid->EmptyRow())) {
?>
	<tr<?php echo $data_kontrak_detail_termin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$data_kontrak_detail_termin_grid->ListOptions->Render("body", "left", $data_kontrak_detail_termin_grid->RowCnt);
?>
	<?php if ($data_kontrak_detail_termin->id->Visible) { // id ?>
		<td data-name="id"<?php echo $data_kontrak_detail_termin->id->CellAttributes() ?>>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->OldValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id" class="form-group data_kontrak_detail_termin_id">
<span<?php echo $data_kontrak_detail_termin->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->CurrentValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id" class="data_kontrak_detail_termin_id">
<span<?php echo $data_kontrak_detail_termin->id->ViewAttributes() ?>>
<?php echo $data_kontrak_detail_termin->id->ListViewValue() ?></span>
</span>
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $data_kontrak_detail_termin_grid->PageObjName . "_row_" . $data_kontrak_detail_termin_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->terminke->Visible) { // terminke ?>
		<td data-name="terminke"<?php echo $data_kontrak_detail_termin->terminke->CellAttributes() ?>>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_terminke" class="form-group data_kontrak_detail_termin_terminke">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->terminke->EditValue ?>"<?php echo $data_kontrak_detail_termin->terminke->EditAttributes() ?>>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->OldValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_terminke" class="form-group data_kontrak_detail_termin_terminke">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->terminke->EditValue ?>"<?php echo $data_kontrak_detail_termin->terminke->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_terminke" class="data_kontrak_detail_termin_terminke">
<span<?php echo $data_kontrak_detail_termin->terminke->ViewAttributes() ?>>
<?php echo $data_kontrak_detail_termin->terminke->ListViewValue() ?></span>
</span>
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->target_fisik->Visible) { // target_fisik ?>
		<td data-name="target_fisik"<?php echo $data_kontrak_detail_termin->target_fisik->CellAttributes() ?>>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_target_fisik" class="form-group data_kontrak_detail_termin_target_fisik">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->target_fisik->EditValue ?>"<?php echo $data_kontrak_detail_termin->target_fisik->EditAttributes() ?>>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->OldValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_target_fisik" class="form-group data_kontrak_detail_termin_target_fisik">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->target_fisik->EditValue ?>"<?php echo $data_kontrak_detail_termin->target_fisik->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_target_fisik" class="data_kontrak_detail_termin_target_fisik">
<span<?php echo $data_kontrak_detail_termin->target_fisik->ViewAttributes() ?>>
<?php echo $data_kontrak_detail_termin->target_fisik->ListViewValue() ?></span>
</span>
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->nilai->Visible) { // nilai ?>
		<td data-name="nilai"<?php echo $data_kontrak_detail_termin->nilai->CellAttributes() ?>>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_nilai" class="form-group data_kontrak_detail_termin_nilai">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->nilai->EditValue ?>"<?php echo $data_kontrak_detail_termin->nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->OldValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_nilai" class="form-group data_kontrak_detail_termin_nilai">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->nilai->EditValue ?>"<?php echo $data_kontrak_detail_termin->nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_nilai" class="data_kontrak_detail_termin_nilai">
<span<?php echo $data_kontrak_detail_termin->nilai->ViewAttributes() ?>>
<?php echo $data_kontrak_detail_termin->nilai->ListViewValue() ?></span>
</span>
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->id_detail->Visible) { // id_detail ?>
		<td data-name="id_detail"<?php echo $data_kontrak_detail_termin->id_detail->CellAttributes() ?>>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($data_kontrak_detail_termin->id_detail->getSessionValue() <> "") { ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<span<?php echo $data_kontrak_detail_termin->id_detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id_detail->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->id_detail->EditValue ?>"<?php echo $data_kontrak_detail_termin->id_detail->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->OldValue) ?>">
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($data_kontrak_detail_termin->id_detail->getSessionValue() <> "") { ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<span<?php echo $data_kontrak_detail_termin->id_detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id_detail->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->id_detail->EditValue ?>"<?php echo $data_kontrak_detail_termin->id_detail->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $data_kontrak_detail_termin_grid->RowCnt ?>_data_kontrak_detail_termin_id_detail" class="data_kontrak_detail_termin_id_detail">
<span<?php echo $data_kontrak_detail_termin->id_detail->ViewAttributes() ?>>
<?php echo $data_kontrak_detail_termin->id_detail->ListViewValue() ?></span>
</span>
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="fdata_kontrak_detail_termingrid$x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->FormValue) ?>">
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="fdata_kontrak_detail_termingrid$o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$data_kontrak_detail_termin_grid->ListOptions->Render("body", "right", $data_kontrak_detail_termin_grid->RowCnt);
?>
	</tr>
<?php if ($data_kontrak_detail_termin->RowType == EW_ROWTYPE_ADD || $data_kontrak_detail_termin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdata_kontrak_detail_termingrid.UpdateOpts(<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($data_kontrak_detail_termin->CurrentAction <> "gridadd" || $data_kontrak_detail_termin->CurrentMode == "copy")
		if (!$data_kontrak_detail_termin_grid->Recordset->EOF) $data_kontrak_detail_termin_grid->Recordset->MoveNext();
}
?>
<?php
	if ($data_kontrak_detail_termin->CurrentMode == "add" || $data_kontrak_detail_termin->CurrentMode == "copy" || $data_kontrak_detail_termin->CurrentMode == "edit") {
		$data_kontrak_detail_termin_grid->RowIndex = '$rowindex$';
		$data_kontrak_detail_termin_grid->LoadDefaultValues();

		// Set row properties
		$data_kontrak_detail_termin->ResetAttrs();
		$data_kontrak_detail_termin->RowAttrs = array_merge($data_kontrak_detail_termin->RowAttrs, array('data-rowindex'=>$data_kontrak_detail_termin_grid->RowIndex, 'id'=>'r0_data_kontrak_detail_termin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($data_kontrak_detail_termin->RowAttrs["class"], "ewTemplate");
		$data_kontrak_detail_termin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$data_kontrak_detail_termin_grid->RenderRow();

		// Render list options
		$data_kontrak_detail_termin_grid->RenderListOptions();
		$data_kontrak_detail_termin_grid->StartRowCnt = 0;
?>
	<tr<?php echo $data_kontrak_detail_termin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$data_kontrak_detail_termin_grid->ListOptions->Render("body", "left", $data_kontrak_detail_termin_grid->RowIndex);
?>
	<?php if ($data_kontrak_detail_termin->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_id" class="form-group data_kontrak_detail_termin_id">
<span<?php echo $data_kontrak_detail_termin->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->terminke->Visible) { // terminke ?>
		<td data-name="terminke">
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_terminke" class="form-group data_kontrak_detail_termin_terminke">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->terminke->EditValue ?>"<?php echo $data_kontrak_detail_termin->terminke->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_terminke" class="form-group data_kontrak_detail_termin_terminke">
<span<?php echo $data_kontrak_detail_termin->terminke->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->terminke->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_terminke" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->target_fisik->Visible) { // target_fisik ?>
		<td data-name="target_fisik">
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_target_fisik" class="form-group data_kontrak_detail_termin_target_fisik">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->target_fisik->EditValue ?>"<?php echo $data_kontrak_detail_termin->target_fisik->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_target_fisik" class="form-group data_kontrak_detail_termin_target_fisik">
<span<?php echo $data_kontrak_detail_termin->target_fisik->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->target_fisik->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_target_fisik" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->nilai->Visible) { // nilai ?>
		<td data-name="nilai">
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_nilai" class="form-group data_kontrak_detail_termin_nilai">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->nilai->EditValue ?>"<?php echo $data_kontrak_detail_termin->nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_nilai" class="form-group data_kontrak_detail_termin_nilai">
<span<?php echo $data_kontrak_detail_termin->nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_nilai" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($data_kontrak_detail_termin->id_detail->Visible) { // id_detail ?>
		<td data-name="id_detail">
<?php if ($data_kontrak_detail_termin->CurrentAction <> "F") { ?>
<?php if ($data_kontrak_detail_termin->id_detail->getSessionValue() <> "") { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<span<?php echo $data_kontrak_detail_termin->id_detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id_detail->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->id_detail->EditValue ?>"<?php echo $data_kontrak_detail_termin->id_detail->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_data_kontrak_detail_termin_id_detail" class="form-group data_kontrak_detail_termin_id_detail">
<span<?php echo $data_kontrak_detail_termin->id_detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id_detail->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="x<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" id="o<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>_id_detail" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$data_kontrak_detail_termin_grid->ListOptions->Render("body", "right", $data_kontrak_detail_termin_grid->RowCnt);
?>
<script type="text/javascript">
fdata_kontrak_detail_termingrid.UpdateOpts(<?php echo $data_kontrak_detail_termin_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($data_kontrak_detail_termin->CurrentMode == "add" || $data_kontrak_detail_termin->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $data_kontrak_detail_termin_grid->FormKeyCountName ?>" id="<?php echo $data_kontrak_detail_termin_grid->FormKeyCountName ?>" value="<?php echo $data_kontrak_detail_termin_grid->KeyCount ?>">
<?php echo $data_kontrak_detail_termin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($data_kontrak_detail_termin->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $data_kontrak_detail_termin_grid->FormKeyCountName ?>" id="<?php echo $data_kontrak_detail_termin_grid->FormKeyCountName ?>" value="<?php echo $data_kontrak_detail_termin_grid->KeyCount ?>">
<?php echo $data_kontrak_detail_termin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($data_kontrak_detail_termin->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdata_kontrak_detail_termingrid">
</div>
<?php

// Close recordset
if ($data_kontrak_detail_termin_grid->Recordset)
	$data_kontrak_detail_termin_grid->Recordset->Close();
?>
<?php if ($data_kontrak_detail_termin_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($data_kontrak_detail_termin_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($data_kontrak_detail_termin_grid->TotalRecs == 0 && $data_kontrak_detail_termin->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($data_kontrak_detail_termin_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($data_kontrak_detail_termin->Export == "") { ?>
<script type="text/javascript">
fdata_kontrak_detail_termingrid.Init();
</script>
<?php } ?>
<?php
$data_kontrak_detail_termin_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$data_kontrak_detail_termin_grid->Page_Terminate();
?>
