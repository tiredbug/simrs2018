<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($keu_akun3_grid)) $keu_akun3_grid = new ckeu_akun3_grid();

// Page init
$keu_akun3_grid->Page_Init();

// Page main
$keu_akun3_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$keu_akun3_grid->Page_Render();
?>
<?php if ($keu_akun3->Export == "") { ?>
<script type="text/javascript">

// Form object
var fkeu_akun3grid = new ew_Form("fkeu_akun3grid", "grid");
fkeu_akun3grid.FormKeyCountName = '<?php echo $keu_akun3_grid->FormKeyCountName ?>';

// Validate form
fkeu_akun3grid.Validate = function() {
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
fkeu_akun3grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_akun", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kel3", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nmkel3", false)) return false;
	return true;
}

// Form_CustomValidate event
fkeu_akun3grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkeu_akun3grid.ValidateRequired = true;
<?php } else { ?>
fkeu_akun3grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($keu_akun3->CurrentAction == "gridadd") {
	if ($keu_akun3->CurrentMode == "copy") {
		$bSelectLimit = $keu_akun3_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$keu_akun3_grid->TotalRecs = $keu_akun3->SelectRecordCount();
			$keu_akun3_grid->Recordset = $keu_akun3_grid->LoadRecordset($keu_akun3_grid->StartRec-1, $keu_akun3_grid->DisplayRecs);
		} else {
			if ($keu_akun3_grid->Recordset = $keu_akun3_grid->LoadRecordset())
				$keu_akun3_grid->TotalRecs = $keu_akun3_grid->Recordset->RecordCount();
		}
		$keu_akun3_grid->StartRec = 1;
		$keu_akun3_grid->DisplayRecs = $keu_akun3_grid->TotalRecs;
	} else {
		$keu_akun3->CurrentFilter = "0=1";
		$keu_akun3_grid->StartRec = 1;
		$keu_akun3_grid->DisplayRecs = $keu_akun3->GridAddRowCount;
	}
	$keu_akun3_grid->TotalRecs = $keu_akun3_grid->DisplayRecs;
	$keu_akun3_grid->StopRec = $keu_akun3_grid->DisplayRecs;
} else {
	$bSelectLimit = $keu_akun3_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($keu_akun3_grid->TotalRecs <= 0)
			$keu_akun3_grid->TotalRecs = $keu_akun3->SelectRecordCount();
	} else {
		if (!$keu_akun3_grid->Recordset && ($keu_akun3_grid->Recordset = $keu_akun3_grid->LoadRecordset()))
			$keu_akun3_grid->TotalRecs = $keu_akun3_grid->Recordset->RecordCount();
	}
	$keu_akun3_grid->StartRec = 1;
	$keu_akun3_grid->DisplayRecs = $keu_akun3_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$keu_akun3_grid->Recordset = $keu_akun3_grid->LoadRecordset($keu_akun3_grid->StartRec-1, $keu_akun3_grid->DisplayRecs);

	// Set no record found message
	if ($keu_akun3->CurrentAction == "" && $keu_akun3_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$keu_akun3_grid->setWarningMessage(ew_DeniedMsg());
		if ($keu_akun3_grid->SearchWhere == "0=101")
			$keu_akun3_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$keu_akun3_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$keu_akun3_grid->RenderOtherOptions();
?>
<?php $keu_akun3_grid->ShowPageHeader(); ?>
<?php
$keu_akun3_grid->ShowMessage();
?>
<?php if ($keu_akun3_grid->TotalRecs > 0 || $keu_akun3->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid keu_akun3">
<div id="fkeu_akun3grid" class="ewForm form-inline">
<div id="gmp_keu_akun3" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_keu_akun3grid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $keu_akun3->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$keu_akun3_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$keu_akun3_grid->RenderListOptions();

// Render list options (header, left)
$keu_akun3_grid->ListOptions->Render("header", "left");
?>
<?php if ($keu_akun3->kd_akun->Visible) { // kd_akun ?>
	<?php if ($keu_akun3->SortUrl($keu_akun3->kd_akun) == "") { ?>
		<th data-name="kd_akun"><div id="elh_keu_akun3_kd_akun" class="keu_akun3_kd_akun"><div class="ewTableHeaderCaption"><?php echo $keu_akun3->kd_akun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_akun"><div><div id="elh_keu_akun3_kd_akun" class="keu_akun3_kd_akun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun3->kd_akun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun3->kd_akun->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun3->kd_akun->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun3->kel3->Visible) { // kel3 ?>
	<?php if ($keu_akun3->SortUrl($keu_akun3->kel3) == "") { ?>
		<th data-name="kel3"><div id="elh_keu_akun3_kel3" class="keu_akun3_kel3"><div class="ewTableHeaderCaption"><?php echo $keu_akun3->kel3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel3"><div><div id="elh_keu_akun3_kel3" class="keu_akun3_kel3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun3->kel3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun3->kel3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun3->kel3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun3->nmkel3->Visible) { // nmkel3 ?>
	<?php if ($keu_akun3->SortUrl($keu_akun3->nmkel3) == "") { ?>
		<th data-name="nmkel3"><div id="elh_keu_akun3_nmkel3" class="keu_akun3_nmkel3"><div class="ewTableHeaderCaption"><?php echo $keu_akun3->nmkel3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nmkel3"><div><div id="elh_keu_akun3_nmkel3" class="keu_akun3_nmkel3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun3->nmkel3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun3->nmkel3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun3->nmkel3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$keu_akun3_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$keu_akun3_grid->StartRec = 1;
$keu_akun3_grid->StopRec = $keu_akun3_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($keu_akun3_grid->FormKeyCountName) && ($keu_akun3->CurrentAction == "gridadd" || $keu_akun3->CurrentAction == "gridedit" || $keu_akun3->CurrentAction == "F")) {
		$keu_akun3_grid->KeyCount = $objForm->GetValue($keu_akun3_grid->FormKeyCountName);
		$keu_akun3_grid->StopRec = $keu_akun3_grid->StartRec + $keu_akun3_grid->KeyCount - 1;
	}
}
$keu_akun3_grid->RecCnt = $keu_akun3_grid->StartRec - 1;
if ($keu_akun3_grid->Recordset && !$keu_akun3_grid->Recordset->EOF) {
	$keu_akun3_grid->Recordset->MoveFirst();
	$bSelectLimit = $keu_akun3_grid->UseSelectLimit;
	if (!$bSelectLimit && $keu_akun3_grid->StartRec > 1)
		$keu_akun3_grid->Recordset->Move($keu_akun3_grid->StartRec - 1);
} elseif (!$keu_akun3->AllowAddDeleteRow && $keu_akun3_grid->StopRec == 0) {
	$keu_akun3_grid->StopRec = $keu_akun3->GridAddRowCount;
}

// Initialize aggregate
$keu_akun3->RowType = EW_ROWTYPE_AGGREGATEINIT;
$keu_akun3->ResetAttrs();
$keu_akun3_grid->RenderRow();
if ($keu_akun3->CurrentAction == "gridadd")
	$keu_akun3_grid->RowIndex = 0;
if ($keu_akun3->CurrentAction == "gridedit")
	$keu_akun3_grid->RowIndex = 0;
while ($keu_akun3_grid->RecCnt < $keu_akun3_grid->StopRec) {
	$keu_akun3_grid->RecCnt++;
	if (intval($keu_akun3_grid->RecCnt) >= intval($keu_akun3_grid->StartRec)) {
		$keu_akun3_grid->RowCnt++;
		if ($keu_akun3->CurrentAction == "gridadd" || $keu_akun3->CurrentAction == "gridedit" || $keu_akun3->CurrentAction == "F") {
			$keu_akun3_grid->RowIndex++;
			$objForm->Index = $keu_akun3_grid->RowIndex;
			if ($objForm->HasValue($keu_akun3_grid->FormActionName))
				$keu_akun3_grid->RowAction = strval($objForm->GetValue($keu_akun3_grid->FormActionName));
			elseif ($keu_akun3->CurrentAction == "gridadd")
				$keu_akun3_grid->RowAction = "insert";
			else
				$keu_akun3_grid->RowAction = "";
		}

		// Set up key count
		$keu_akun3_grid->KeyCount = $keu_akun3_grid->RowIndex;

		// Init row class and style
		$keu_akun3->ResetAttrs();
		$keu_akun3->CssClass = "";
		if ($keu_akun3->CurrentAction == "gridadd") {
			if ($keu_akun3->CurrentMode == "copy") {
				$keu_akun3_grid->LoadRowValues($keu_akun3_grid->Recordset); // Load row values
				$keu_akun3_grid->SetRecordKey($keu_akun3_grid->RowOldKey, $keu_akun3_grid->Recordset); // Set old record key
			} else {
				$keu_akun3_grid->LoadDefaultValues(); // Load default values
				$keu_akun3_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$keu_akun3_grid->LoadRowValues($keu_akun3_grid->Recordset); // Load row values
		}
		$keu_akun3->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($keu_akun3->CurrentAction == "gridadd") // Grid add
			$keu_akun3->RowType = EW_ROWTYPE_ADD; // Render add
		if ($keu_akun3->CurrentAction == "gridadd" && $keu_akun3->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$keu_akun3_grid->RestoreCurrentRowFormValues($keu_akun3_grid->RowIndex); // Restore form values
		if ($keu_akun3->CurrentAction == "gridedit") { // Grid edit
			if ($keu_akun3->EventCancelled) {
				$keu_akun3_grid->RestoreCurrentRowFormValues($keu_akun3_grid->RowIndex); // Restore form values
			}
			if ($keu_akun3_grid->RowAction == "insert")
				$keu_akun3->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$keu_akun3->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($keu_akun3->CurrentAction == "gridedit" && ($keu_akun3->RowType == EW_ROWTYPE_EDIT || $keu_akun3->RowType == EW_ROWTYPE_ADD) && $keu_akun3->EventCancelled) // Update failed
			$keu_akun3_grid->RestoreCurrentRowFormValues($keu_akun3_grid->RowIndex); // Restore form values
		if ($keu_akun3->RowType == EW_ROWTYPE_EDIT) // Edit row
			$keu_akun3_grid->EditRowCnt++;
		if ($keu_akun3->CurrentAction == "F") // Confirm row
			$keu_akun3_grid->RestoreCurrentRowFormValues($keu_akun3_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$keu_akun3->RowAttrs = array_merge($keu_akun3->RowAttrs, array('data-rowindex'=>$keu_akun3_grid->RowCnt, 'id'=>'r' . $keu_akun3_grid->RowCnt . '_keu_akun3', 'data-rowtype'=>$keu_akun3->RowType));

		// Render row
		$keu_akun3_grid->RenderRow();

		// Render list options
		$keu_akun3_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($keu_akun3_grid->RowAction <> "delete" && $keu_akun3_grid->RowAction <> "insertdelete" && !($keu_akun3_grid->RowAction == "insert" && $keu_akun3->CurrentAction == "F" && $keu_akun3_grid->EmptyRow())) {
?>
	<tr<?php echo $keu_akun3->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun3_grid->ListOptions->Render("body", "left", $keu_akun3_grid->RowCnt);
?>
	<?php if ($keu_akun3->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun"<?php echo $keu_akun3->kd_akun->CellAttributes() ?>>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kd_akun" class="form-group keu_akun3_kd_akun">
<input type="text" data-table="keu_akun3" data-field="x_kd_akun" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kd_akun->EditValue ?>"<?php echo $keu_akun3->kd_akun->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kd_akun" class="form-group keu_akun3_kd_akun">
<input type="text" data-table="keu_akun3" data-field="x_kd_akun" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kd_akun->EditValue ?>"<?php echo $keu_akun3->kd_akun->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kd_akun" class="keu_akun3_kd_akun">
<span<?php echo $keu_akun3->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun3->kd_akun->ListViewValue() ?></span>
</span>
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $keu_akun3_grid->PageObjName . "_row_" . $keu_akun3_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="keu_akun3" data-field="x_id" name="x<?php echo $keu_akun3_grid->RowIndex ?>_id" id="x<?php echo $keu_akun3_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun3->id->CurrentValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_id" name="o<?php echo $keu_akun3_grid->RowIndex ?>_id" id="o<?php echo $keu_akun3_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun3->id->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_EDIT || $keu_akun3->CurrentMode == "edit") { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_id" name="x<?php echo $keu_akun3_grid->RowIndex ?>_id" id="x<?php echo $keu_akun3_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun3->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($keu_akun3->kel3->Visible) { // kel3 ?>
		<td data-name="kel3"<?php echo $keu_akun3->kel3->CellAttributes() ?>>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kel3" class="form-group keu_akun3_kel3">
<input type="text" data-table="keu_akun3" data-field="x_kel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kel3->EditValue ?>"<?php echo $keu_akun3->kel3->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kel3" class="form-group keu_akun3_kel3">
<input type="text" data-table="keu_akun3" data-field="x_kel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kel3->EditValue ?>"<?php echo $keu_akun3->kel3->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_kel3" class="keu_akun3_kel3">
<span<?php echo $keu_akun3->kel3->ViewAttributes() ?>>
<?php echo $keu_akun3->kel3->ListViewValue() ?></span>
</span>
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($keu_akun3->nmkel3->Visible) { // nmkel3 ?>
		<td data-name="nmkel3"<?php echo $keu_akun3->nmkel3->CellAttributes() ?>>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_nmkel3" class="form-group keu_akun3_nmkel3">
<input type="text" data-table="keu_akun3" data-field="x_nmkel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->nmkel3->EditValue ?>"<?php echo $keu_akun3->nmkel3->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_nmkel3" class="form-group keu_akun3_nmkel3">
<input type="text" data-table="keu_akun3" data-field="x_nmkel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->nmkel3->EditValue ?>"<?php echo $keu_akun3->nmkel3->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun3_grid->RowCnt ?>_keu_akun3_nmkel3" class="keu_akun3_nmkel3">
<span<?php echo $keu_akun3->nmkel3->ViewAttributes() ?>>
<?php echo $keu_akun3->nmkel3->ListViewValue() ?></span>
</span>
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="fkeu_akun3grid$x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->FormValue) ?>">
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="fkeu_akun3grid$o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun3_grid->ListOptions->Render("body", "right", $keu_akun3_grid->RowCnt);
?>
	</tr>
<?php if ($keu_akun3->RowType == EW_ROWTYPE_ADD || $keu_akun3->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fkeu_akun3grid.UpdateOpts(<?php echo $keu_akun3_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($keu_akun3->CurrentAction <> "gridadd" || $keu_akun3->CurrentMode == "copy")
		if (!$keu_akun3_grid->Recordset->EOF) $keu_akun3_grid->Recordset->MoveNext();
}
?>
<?php
	if ($keu_akun3->CurrentMode == "add" || $keu_akun3->CurrentMode == "copy" || $keu_akun3->CurrentMode == "edit") {
		$keu_akun3_grid->RowIndex = '$rowindex$';
		$keu_akun3_grid->LoadDefaultValues();

		// Set row properties
		$keu_akun3->ResetAttrs();
		$keu_akun3->RowAttrs = array_merge($keu_akun3->RowAttrs, array('data-rowindex'=>$keu_akun3_grid->RowIndex, 'id'=>'r0_keu_akun3', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($keu_akun3->RowAttrs["class"], "ewTemplate");
		$keu_akun3->RowType = EW_ROWTYPE_ADD;

		// Render row
		$keu_akun3_grid->RenderRow();

		// Render list options
		$keu_akun3_grid->RenderListOptions();
		$keu_akun3_grid->StartRowCnt = 0;
?>
	<tr<?php echo $keu_akun3->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun3_grid->ListOptions->Render("body", "left", $keu_akun3_grid->RowIndex);
?>
	<?php if ($keu_akun3->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun">
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun3_kd_akun" class="form-group keu_akun3_kd_akun">
<input type="text" data-table="keu_akun3" data-field="x_kd_akun" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kd_akun->EditValue ?>"<?php echo $keu_akun3->kd_akun->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun3_kd_akun" class="form-group keu_akun3_kd_akun">
<span<?php echo $keu_akun3->kd_akun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun3->kd_akun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kd_akun" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun3->kd_akun->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun3->kel3->Visible) { // kel3 ?>
		<td data-name="kel3">
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun3_kel3" class="form-group keu_akun3_kel3">
<input type="text" data-table="keu_akun3" data-field="x_kel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun3->kel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->kel3->EditValue ?>"<?php echo $keu_akun3->kel3->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun3_kel3" class="form-group keu_akun3_kel3">
<span<?php echo $keu_akun3->kel3->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun3->kel3->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun3" data-field="x_kel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_kel3" value="<?php echo ew_HtmlEncode($keu_akun3->kel3->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun3->nmkel3->Visible) { // nmkel3 ?>
		<td data-name="nmkel3">
<?php if ($keu_akun3->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun3_nmkel3" class="form-group keu_akun3_nmkel3">
<input type="text" data-table="keu_akun3" data-field="x_nmkel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->getPlaceHolder()) ?>" value="<?php echo $keu_akun3->nmkel3->EditValue ?>"<?php echo $keu_akun3->nmkel3->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun3_nmkel3" class="form-group keu_akun3_nmkel3">
<span<?php echo $keu_akun3->nmkel3->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun3->nmkel3->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="x<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun3" data-field="x_nmkel3" name="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" id="o<?php echo $keu_akun3_grid->RowIndex ?>_nmkel3" value="<?php echo ew_HtmlEncode($keu_akun3->nmkel3->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun3_grid->ListOptions->Render("body", "right", $keu_akun3_grid->RowCnt);
?>
<script type="text/javascript">
fkeu_akun3grid.UpdateOpts(<?php echo $keu_akun3_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($keu_akun3->CurrentMode == "add" || $keu_akun3->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $keu_akun3_grid->FormKeyCountName ?>" id="<?php echo $keu_akun3_grid->FormKeyCountName ?>" value="<?php echo $keu_akun3_grid->KeyCount ?>">
<?php echo $keu_akun3_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun3->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $keu_akun3_grid->FormKeyCountName ?>" id="<?php echo $keu_akun3_grid->FormKeyCountName ?>" value="<?php echo $keu_akun3_grid->KeyCount ?>">
<?php echo $keu_akun3_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun3->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fkeu_akun3grid">
</div>
<?php

// Close recordset
if ($keu_akun3_grid->Recordset)
	$keu_akun3_grid->Recordset->Close();
?>
<?php if ($keu_akun3_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($keu_akun3_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($keu_akun3_grid->TotalRecs == 0 && $keu_akun3->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($keu_akun3_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($keu_akun3->Export == "") { ?>
<script type="text/javascript">
fkeu_akun3grid.Init();
</script>
<?php } ?>
<?php
$keu_akun3_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$keu_akun3_grid->Page_Terminate();
?>
