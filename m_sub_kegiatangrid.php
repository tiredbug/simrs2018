<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($m_sub_kegiatan_grid)) $m_sub_kegiatan_grid = new cm_sub_kegiatan_grid();

// Page init
$m_sub_kegiatan_grid->Page_Init();

// Page main
$m_sub_kegiatan_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_sub_kegiatan_grid->Page_Render();
?>
<?php if ($m_sub_kegiatan->Export == "") { ?>
<script type="text/javascript">

// Form object
var fm_sub_kegiatangrid = new ew_Form("fm_sub_kegiatangrid", "grid");
fm_sub_kegiatangrid.FormKeyCountName = '<?php echo $m_sub_kegiatan_grid->FormKeyCountName ?>';

// Validate form
fm_sub_kegiatangrid.Validate = function() {
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
fm_sub_kegiatangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kode_program", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_kegiatan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_sub_kegiatan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nama_sub_kegiatan", false)) return false;
	return true;
}

// Form_CustomValidate event
fm_sub_kegiatangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_sub_kegiatangrid.ValidateRequired = true;
<?php } else { ?>
fm_sub_kegiatangrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($m_sub_kegiatan->CurrentAction == "gridadd") {
	if ($m_sub_kegiatan->CurrentMode == "copy") {
		$bSelectLimit = $m_sub_kegiatan_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$m_sub_kegiatan_grid->TotalRecs = $m_sub_kegiatan->SelectRecordCount();
			$m_sub_kegiatan_grid->Recordset = $m_sub_kegiatan_grid->LoadRecordset($m_sub_kegiatan_grid->StartRec-1, $m_sub_kegiatan_grid->DisplayRecs);
		} else {
			if ($m_sub_kegiatan_grid->Recordset = $m_sub_kegiatan_grid->LoadRecordset())
				$m_sub_kegiatan_grid->TotalRecs = $m_sub_kegiatan_grid->Recordset->RecordCount();
		}
		$m_sub_kegiatan_grid->StartRec = 1;
		$m_sub_kegiatan_grid->DisplayRecs = $m_sub_kegiatan_grid->TotalRecs;
	} else {
		$m_sub_kegiatan->CurrentFilter = "0=1";
		$m_sub_kegiatan_grid->StartRec = 1;
		$m_sub_kegiatan_grid->DisplayRecs = $m_sub_kegiatan->GridAddRowCount;
	}
	$m_sub_kegiatan_grid->TotalRecs = $m_sub_kegiatan_grid->DisplayRecs;
	$m_sub_kegiatan_grid->StopRec = $m_sub_kegiatan_grid->DisplayRecs;
} else {
	$bSelectLimit = $m_sub_kegiatan_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($m_sub_kegiatan_grid->TotalRecs <= 0)
			$m_sub_kegiatan_grid->TotalRecs = $m_sub_kegiatan->SelectRecordCount();
	} else {
		if (!$m_sub_kegiatan_grid->Recordset && ($m_sub_kegiatan_grid->Recordset = $m_sub_kegiatan_grid->LoadRecordset()))
			$m_sub_kegiatan_grid->TotalRecs = $m_sub_kegiatan_grid->Recordset->RecordCount();
	}
	$m_sub_kegiatan_grid->StartRec = 1;
	$m_sub_kegiatan_grid->DisplayRecs = $m_sub_kegiatan_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$m_sub_kegiatan_grid->Recordset = $m_sub_kegiatan_grid->LoadRecordset($m_sub_kegiatan_grid->StartRec-1, $m_sub_kegiatan_grid->DisplayRecs);

	// Set no record found message
	if ($m_sub_kegiatan->CurrentAction == "" && $m_sub_kegiatan_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$m_sub_kegiatan_grid->setWarningMessage(ew_DeniedMsg());
		if ($m_sub_kegiatan_grid->SearchWhere == "0=101")
			$m_sub_kegiatan_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$m_sub_kegiatan_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$m_sub_kegiatan_grid->RenderOtherOptions();
?>
<?php $m_sub_kegiatan_grid->ShowPageHeader(); ?>
<?php
$m_sub_kegiatan_grid->ShowMessage();
?>
<?php if ($m_sub_kegiatan_grid->TotalRecs > 0 || $m_sub_kegiatan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid m_sub_kegiatan">
<div id="fm_sub_kegiatangrid" class="ewForm form-inline">
<div id="gmp_m_sub_kegiatan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_m_sub_kegiatangrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_sub_kegiatan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$m_sub_kegiatan_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$m_sub_kegiatan_grid->RenderListOptions();

// Render list options (header, left)
$m_sub_kegiatan_grid->ListOptions->Render("header", "left");
?>
<?php if ($m_sub_kegiatan->id->Visible) { // id ?>
	<?php if ($m_sub_kegiatan->SortUrl($m_sub_kegiatan->id) == "") { ?>
		<th data-name="id"><div id="elh_m_sub_kegiatan_id" class="m_sub_kegiatan_id"><div class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_m_sub_kegiatan_id" class="m_sub_kegiatan_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_sub_kegiatan->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_sub_kegiatan->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_sub_kegiatan->kode_program->Visible) { // kode_program ?>
	<?php if ($m_sub_kegiatan->SortUrl($m_sub_kegiatan->kode_program) == "") { ?>
		<th data-name="kode_program"><div id="elh_m_sub_kegiatan_kode_program" class="m_sub_kegiatan_kode_program"><div class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_program->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_program"><div><div id="elh_m_sub_kegiatan_kode_program" class="m_sub_kegiatan_kode_program">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_program->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_sub_kegiatan->kode_program->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_sub_kegiatan->kode_program->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_sub_kegiatan->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<?php if ($m_sub_kegiatan->SortUrl($m_sub_kegiatan->kode_kegiatan) == "") { ?>
		<th data-name="kode_kegiatan"><div id="elh_m_sub_kegiatan_kode_kegiatan" class="m_sub_kegiatan_kode_kegiatan"><div class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_kegiatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_kegiatan"><div><div id="elh_m_sub_kegiatan_kode_kegiatan" class="m_sub_kegiatan_kode_kegiatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_kegiatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_sub_kegiatan->kode_kegiatan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_sub_kegiatan->kode_kegiatan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_sub_kegiatan->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<?php if ($m_sub_kegiatan->SortUrl($m_sub_kegiatan->kode_sub_kegiatan) == "") { ?>
		<th data-name="kode_sub_kegiatan"><div id="elh_m_sub_kegiatan_kode_sub_kegiatan" class="m_sub_kegiatan_kode_sub_kegiatan"><div class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_sub_kegiatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_sub_kegiatan"><div><div id="elh_m_sub_kegiatan_kode_sub_kegiatan" class="m_sub_kegiatan_kode_sub_kegiatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->kode_sub_kegiatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_sub_kegiatan->kode_sub_kegiatan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_sub_kegiatan->kode_sub_kegiatan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_sub_kegiatan->nama_sub_kegiatan->Visible) { // nama_sub_kegiatan ?>
	<?php if ($m_sub_kegiatan->SortUrl($m_sub_kegiatan->nama_sub_kegiatan) == "") { ?>
		<th data-name="nama_sub_kegiatan"><div id="elh_m_sub_kegiatan_nama_sub_kegiatan" class="m_sub_kegiatan_nama_sub_kegiatan"><div class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->nama_sub_kegiatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_sub_kegiatan"><div><div id="elh_m_sub_kegiatan_nama_sub_kegiatan" class="m_sub_kegiatan_nama_sub_kegiatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_sub_kegiatan->nama_sub_kegiatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_sub_kegiatan->nama_sub_kegiatan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_sub_kegiatan->nama_sub_kegiatan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$m_sub_kegiatan_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$m_sub_kegiatan_grid->StartRec = 1;
$m_sub_kegiatan_grid->StopRec = $m_sub_kegiatan_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($m_sub_kegiatan_grid->FormKeyCountName) && ($m_sub_kegiatan->CurrentAction == "gridadd" || $m_sub_kegiatan->CurrentAction == "gridedit" || $m_sub_kegiatan->CurrentAction == "F")) {
		$m_sub_kegiatan_grid->KeyCount = $objForm->GetValue($m_sub_kegiatan_grid->FormKeyCountName);
		$m_sub_kegiatan_grid->StopRec = $m_sub_kegiatan_grid->StartRec + $m_sub_kegiatan_grid->KeyCount - 1;
	}
}
$m_sub_kegiatan_grid->RecCnt = $m_sub_kegiatan_grid->StartRec - 1;
if ($m_sub_kegiatan_grid->Recordset && !$m_sub_kegiatan_grid->Recordset->EOF) {
	$m_sub_kegiatan_grid->Recordset->MoveFirst();
	$bSelectLimit = $m_sub_kegiatan_grid->UseSelectLimit;
	if (!$bSelectLimit && $m_sub_kegiatan_grid->StartRec > 1)
		$m_sub_kegiatan_grid->Recordset->Move($m_sub_kegiatan_grid->StartRec - 1);
} elseif (!$m_sub_kegiatan->AllowAddDeleteRow && $m_sub_kegiatan_grid->StopRec == 0) {
	$m_sub_kegiatan_grid->StopRec = $m_sub_kegiatan->GridAddRowCount;
}

// Initialize aggregate
$m_sub_kegiatan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$m_sub_kegiatan->ResetAttrs();
$m_sub_kegiatan_grid->RenderRow();
if ($m_sub_kegiatan->CurrentAction == "gridadd")
	$m_sub_kegiatan_grid->RowIndex = 0;
if ($m_sub_kegiatan->CurrentAction == "gridedit")
	$m_sub_kegiatan_grid->RowIndex = 0;
while ($m_sub_kegiatan_grid->RecCnt < $m_sub_kegiatan_grid->StopRec) {
	$m_sub_kegiatan_grid->RecCnt++;
	if (intval($m_sub_kegiatan_grid->RecCnt) >= intval($m_sub_kegiatan_grid->StartRec)) {
		$m_sub_kegiatan_grid->RowCnt++;
		if ($m_sub_kegiatan->CurrentAction == "gridadd" || $m_sub_kegiatan->CurrentAction == "gridedit" || $m_sub_kegiatan->CurrentAction == "F") {
			$m_sub_kegiatan_grid->RowIndex++;
			$objForm->Index = $m_sub_kegiatan_grid->RowIndex;
			if ($objForm->HasValue($m_sub_kegiatan_grid->FormActionName))
				$m_sub_kegiatan_grid->RowAction = strval($objForm->GetValue($m_sub_kegiatan_grid->FormActionName));
			elseif ($m_sub_kegiatan->CurrentAction == "gridadd")
				$m_sub_kegiatan_grid->RowAction = "insert";
			else
				$m_sub_kegiatan_grid->RowAction = "";
		}

		// Set up key count
		$m_sub_kegiatan_grid->KeyCount = $m_sub_kegiatan_grid->RowIndex;

		// Init row class and style
		$m_sub_kegiatan->ResetAttrs();
		$m_sub_kegiatan->CssClass = "";
		if ($m_sub_kegiatan->CurrentAction == "gridadd") {
			if ($m_sub_kegiatan->CurrentMode == "copy") {
				$m_sub_kegiatan_grid->LoadRowValues($m_sub_kegiatan_grid->Recordset); // Load row values
				$m_sub_kegiatan_grid->SetRecordKey($m_sub_kegiatan_grid->RowOldKey, $m_sub_kegiatan_grid->Recordset); // Set old record key
			} else {
				$m_sub_kegiatan_grid->LoadDefaultValues(); // Load default values
				$m_sub_kegiatan_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$m_sub_kegiatan_grid->LoadRowValues($m_sub_kegiatan_grid->Recordset); // Load row values
		}
		$m_sub_kegiatan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($m_sub_kegiatan->CurrentAction == "gridadd") // Grid add
			$m_sub_kegiatan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($m_sub_kegiatan->CurrentAction == "gridadd" && $m_sub_kegiatan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$m_sub_kegiatan_grid->RestoreCurrentRowFormValues($m_sub_kegiatan_grid->RowIndex); // Restore form values
		if ($m_sub_kegiatan->CurrentAction == "gridedit") { // Grid edit
			if ($m_sub_kegiatan->EventCancelled) {
				$m_sub_kegiatan_grid->RestoreCurrentRowFormValues($m_sub_kegiatan_grid->RowIndex); // Restore form values
			}
			if ($m_sub_kegiatan_grid->RowAction == "insert")
				$m_sub_kegiatan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$m_sub_kegiatan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($m_sub_kegiatan->CurrentAction == "gridedit" && ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT || $m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) && $m_sub_kegiatan->EventCancelled) // Update failed
			$m_sub_kegiatan_grid->RestoreCurrentRowFormValues($m_sub_kegiatan_grid->RowIndex); // Restore form values
		if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$m_sub_kegiatan_grid->EditRowCnt++;
		if ($m_sub_kegiatan->CurrentAction == "F") // Confirm row
			$m_sub_kegiatan_grid->RestoreCurrentRowFormValues($m_sub_kegiatan_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$m_sub_kegiatan->RowAttrs = array_merge($m_sub_kegiatan->RowAttrs, array('data-rowindex'=>$m_sub_kegiatan_grid->RowCnt, 'id'=>'r' . $m_sub_kegiatan_grid->RowCnt . '_m_sub_kegiatan', 'data-rowtype'=>$m_sub_kegiatan->RowType));

		// Render row
		$m_sub_kegiatan_grid->RenderRow();

		// Render list options
		$m_sub_kegiatan_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($m_sub_kegiatan_grid->RowAction <> "delete" && $m_sub_kegiatan_grid->RowAction <> "insertdelete" && !($m_sub_kegiatan_grid->RowAction == "insert" && $m_sub_kegiatan->CurrentAction == "F" && $m_sub_kegiatan_grid->EmptyRow())) {
?>
	<tr<?php echo $m_sub_kegiatan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_sub_kegiatan_grid->ListOptions->Render("body", "left", $m_sub_kegiatan_grid->RowCnt);
?>
	<?php if ($m_sub_kegiatan->id->Visible) { // id ?>
		<td data-name="id"<?php echo $m_sub_kegiatan->id->CellAttributes() ?>>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->OldValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_id" class="form-group m_sub_kegiatan_id">
<span<?php echo $m_sub_kegiatan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->CurrentValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_id" class="m_sub_kegiatan_id">
<span<?php echo $m_sub_kegiatan->id->ViewAttributes() ?>>
<?php echo $m_sub_kegiatan->id->ListViewValue() ?></span>
</span>
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $m_sub_kegiatan_grid->PageObjName . "_row_" . $m_sub_kegiatan_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_program->Visible) { // kode_program ?>
		<td data-name="kode_program"<?php echo $m_sub_kegiatan->kode_program->CellAttributes() ?>>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($m_sub_kegiatan->kode_program->getSessionValue() <> "") { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<span<?php echo $m_sub_kegiatan->kode_program->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_program->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_program->EditValue ?>"<?php echo $m_sub_kegiatan->kode_program->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->OldValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($m_sub_kegiatan->kode_program->getSessionValue() <> "") { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<span<?php echo $m_sub_kegiatan->kode_program->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_program->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_program->EditValue ?>"<?php echo $m_sub_kegiatan->kode_program->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_program" class="m_sub_kegiatan_kode_program">
<span<?php echo $m_sub_kegiatan->kode_program->ViewAttributes() ?>>
<?php echo $m_sub_kegiatan->kode_program->ListViewValue() ?></span>
</span>
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_kegiatan->Visible) { // kode_kegiatan ?>
		<td data-name="kode_kegiatan"<?php echo $m_sub_kegiatan->kode_kegiatan->CellAttributes() ?>>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($m_sub_kegiatan->kode_kegiatan->getSessionValue() <> "") { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->OldValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($m_sub_kegiatan->kode_kegiatan->getSessionValue() <> "") { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_kegiatan" class="m_sub_kegiatan_kode_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<?php echo $m_sub_kegiatan->kode_kegiatan->ListViewValue() ?></span>
</span>
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
		<td data-name="kode_sub_kegiatan"<?php echo $m_sub_kegiatan->kode_sub_kegiatan->CellAttributes() ?>>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_sub_kegiatan" class="form-group m_sub_kegiatan_kode_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_sub_kegiatan" class="form-group m_sub_kegiatan_kode_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_kode_sub_kegiatan" class="m_sub_kegiatan_kode_sub_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_sub_kegiatan->ViewAttributes() ?>>
<?php echo $m_sub_kegiatan->kode_sub_kegiatan->ListViewValue() ?></span>
</span>
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->nama_sub_kegiatan->Visible) { // nama_sub_kegiatan ?>
		<td data-name="nama_sub_kegiatan"<?php echo $m_sub_kegiatan->nama_sub_kegiatan->CellAttributes() ?>>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_nama_sub_kegiatan" class="form-group m_sub_kegiatan_nama_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_nama_sub_kegiatan" class="form-group m_sub_kegiatan_nama_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $m_sub_kegiatan_grid->RowCnt ?>_m_sub_kegiatan_nama_sub_kegiatan" class="m_sub_kegiatan_nama_sub_kegiatan">
<span<?php echo $m_sub_kegiatan->nama_sub_kegiatan->ViewAttributes() ?>>
<?php echo $m_sub_kegiatan->nama_sub_kegiatan->ListViewValue() ?></span>
</span>
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="fm_sub_kegiatangrid$x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="fm_sub_kegiatangrid$o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_sub_kegiatan_grid->ListOptions->Render("body", "right", $m_sub_kegiatan_grid->RowCnt);
?>
	</tr>
<?php if ($m_sub_kegiatan->RowType == EW_ROWTYPE_ADD || $m_sub_kegiatan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fm_sub_kegiatangrid.UpdateOpts(<?php echo $m_sub_kegiatan_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($m_sub_kegiatan->CurrentAction <> "gridadd" || $m_sub_kegiatan->CurrentMode == "copy")
		if (!$m_sub_kegiatan_grid->Recordset->EOF) $m_sub_kegiatan_grid->Recordset->MoveNext();
}
?>
<?php
	if ($m_sub_kegiatan->CurrentMode == "add" || $m_sub_kegiatan->CurrentMode == "copy" || $m_sub_kegiatan->CurrentMode == "edit") {
		$m_sub_kegiatan_grid->RowIndex = '$rowindex$';
		$m_sub_kegiatan_grid->LoadDefaultValues();

		// Set row properties
		$m_sub_kegiatan->ResetAttrs();
		$m_sub_kegiatan->RowAttrs = array_merge($m_sub_kegiatan->RowAttrs, array('data-rowindex'=>$m_sub_kegiatan_grid->RowIndex, 'id'=>'r0_m_sub_kegiatan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($m_sub_kegiatan->RowAttrs["class"], "ewTemplate");
		$m_sub_kegiatan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$m_sub_kegiatan_grid->RenderRow();

		// Render list options
		$m_sub_kegiatan_grid->RenderListOptions();
		$m_sub_kegiatan_grid->StartRowCnt = 0;
?>
	<tr<?php echo $m_sub_kegiatan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_sub_kegiatan_grid->ListOptions->Render("body", "left", $m_sub_kegiatan_grid->RowIndex);
?>
	<?php if ($m_sub_kegiatan->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_id" class="form-group m_sub_kegiatan_id">
<span<?php echo $m_sub_kegiatan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_id" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_program->Visible) { // kode_program ?>
		<td data-name="kode_program">
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<?php if ($m_sub_kegiatan->kode_program->getSessionValue() <> "") { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<span<?php echo $m_sub_kegiatan->kode_program->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_program->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_program->EditValue ?>"<?php echo $m_sub_kegiatan->kode_program->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_program" class="form-group m_sub_kegiatan_kode_program">
<span<?php echo $m_sub_kegiatan->kode_program->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_program->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_program" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_program" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_program->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_kegiatan->Visible) { // kode_kegiatan ?>
		<td data-name="kode_kegiatan">
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<?php if ($m_sub_kegiatan->kode_kegiatan->getSessionValue() <> "") { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_kegiatan" class="form-group m_sub_kegiatan_kode_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_kegiatan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
		<td data-name="kode_sub_kegiatan">
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_sub_kegiatan" class="form-group m_sub_kegiatan_kode_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->kode_sub_kegiatan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_kode_sub_kegiatan" class="form-group m_sub_kegiatan_kode_sub_kegiatan">
<span<?php echo $m_sub_kegiatan->kode_sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->kode_sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_kode_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_kode_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->kode_sub_kegiatan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($m_sub_kegiatan->nama_sub_kegiatan->Visible) { // nama_sub_kegiatan ?>
		<td data-name="nama_sub_kegiatan">
<?php if ($m_sub_kegiatan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_m_sub_kegiatan_nama_sub_kegiatan" class="form-group m_sub_kegiatan_nama_sub_kegiatan">
<input type="text" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditValue ?>"<?php echo $m_sub_kegiatan->nama_sub_kegiatan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_m_sub_kegiatan_nama_sub_kegiatan" class="form-group m_sub_kegiatan_nama_sub_kegiatan">
<span<?php echo $m_sub_kegiatan->nama_sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_sub_kegiatan->nama_sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="x<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="m_sub_kegiatan" data-field="x_nama_sub_kegiatan" name="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" id="o<?php echo $m_sub_kegiatan_grid->RowIndex ?>_nama_sub_kegiatan" value="<?php echo ew_HtmlEncode($m_sub_kegiatan->nama_sub_kegiatan->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_sub_kegiatan_grid->ListOptions->Render("body", "right", $m_sub_kegiatan_grid->RowCnt);
?>
<script type="text/javascript">
fm_sub_kegiatangrid.UpdateOpts(<?php echo $m_sub_kegiatan_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($m_sub_kegiatan->CurrentMode == "add" || $m_sub_kegiatan->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $m_sub_kegiatan_grid->FormKeyCountName ?>" id="<?php echo $m_sub_kegiatan_grid->FormKeyCountName ?>" value="<?php echo $m_sub_kegiatan_grid->KeyCount ?>">
<?php echo $m_sub_kegiatan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($m_sub_kegiatan->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $m_sub_kegiatan_grid->FormKeyCountName ?>" id="<?php echo $m_sub_kegiatan_grid->FormKeyCountName ?>" value="<?php echo $m_sub_kegiatan_grid->KeyCount ?>">
<?php echo $m_sub_kegiatan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($m_sub_kegiatan->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fm_sub_kegiatangrid">
</div>
<?php

// Close recordset
if ($m_sub_kegiatan_grid->Recordset)
	$m_sub_kegiatan_grid->Recordset->Close();
?>
<?php if ($m_sub_kegiatan_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($m_sub_kegiatan_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($m_sub_kegiatan_grid->TotalRecs == 0 && $m_sub_kegiatan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_sub_kegiatan_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($m_sub_kegiatan->Export == "") { ?>
<script type="text/javascript">
fm_sub_kegiatangrid.Init();
</script>
<?php } ?>
<?php
$m_sub_kegiatan_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$m_sub_kegiatan_grid->Page_Terminate();
?>
