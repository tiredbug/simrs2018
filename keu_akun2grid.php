<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($keu_akun2_grid)) $keu_akun2_grid = new ckeu_akun2_grid();

// Page init
$keu_akun2_grid->Page_Init();

// Page main
$keu_akun2_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$keu_akun2_grid->Page_Render();
?>
<?php if ($keu_akun2->Export == "") { ?>
<script type="text/javascript">

// Form object
var fkeu_akun2grid = new ew_Form("fkeu_akun2grid", "grid");
fkeu_akun2grid.FormKeyCountName = '<?php echo $keu_akun2_grid->FormKeyCountName ?>';

// Validate form
fkeu_akun2grid.Validate = function() {
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
fkeu_akun2grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_akun", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kel2", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nmkel2", false)) return false;
	return true;
}

// Form_CustomValidate event
fkeu_akun2grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkeu_akun2grid.ValidateRequired = true;
<?php } else { ?>
fkeu_akun2grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($keu_akun2->CurrentAction == "gridadd") {
	if ($keu_akun2->CurrentMode == "copy") {
		$bSelectLimit = $keu_akun2_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$keu_akun2_grid->TotalRecs = $keu_akun2->SelectRecordCount();
			$keu_akun2_grid->Recordset = $keu_akun2_grid->LoadRecordset($keu_akun2_grid->StartRec-1, $keu_akun2_grid->DisplayRecs);
		} else {
			if ($keu_akun2_grid->Recordset = $keu_akun2_grid->LoadRecordset())
				$keu_akun2_grid->TotalRecs = $keu_akun2_grid->Recordset->RecordCount();
		}
		$keu_akun2_grid->StartRec = 1;
		$keu_akun2_grid->DisplayRecs = $keu_akun2_grid->TotalRecs;
	} else {
		$keu_akun2->CurrentFilter = "0=1";
		$keu_akun2_grid->StartRec = 1;
		$keu_akun2_grid->DisplayRecs = $keu_akun2->GridAddRowCount;
	}
	$keu_akun2_grid->TotalRecs = $keu_akun2_grid->DisplayRecs;
	$keu_akun2_grid->StopRec = $keu_akun2_grid->DisplayRecs;
} else {
	$bSelectLimit = $keu_akun2_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($keu_akun2_grid->TotalRecs <= 0)
			$keu_akun2_grid->TotalRecs = $keu_akun2->SelectRecordCount();
	} else {
		if (!$keu_akun2_grid->Recordset && ($keu_akun2_grid->Recordset = $keu_akun2_grid->LoadRecordset()))
			$keu_akun2_grid->TotalRecs = $keu_akun2_grid->Recordset->RecordCount();
	}
	$keu_akun2_grid->StartRec = 1;
	$keu_akun2_grid->DisplayRecs = $keu_akun2_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$keu_akun2_grid->Recordset = $keu_akun2_grid->LoadRecordset($keu_akun2_grid->StartRec-1, $keu_akun2_grid->DisplayRecs);

	// Set no record found message
	if ($keu_akun2->CurrentAction == "" && $keu_akun2_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$keu_akun2_grid->setWarningMessage(ew_DeniedMsg());
		if ($keu_akun2_grid->SearchWhere == "0=101")
			$keu_akun2_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$keu_akun2_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$keu_akun2_grid->RenderOtherOptions();
?>
<?php $keu_akun2_grid->ShowPageHeader(); ?>
<?php
$keu_akun2_grid->ShowMessage();
?>
<?php if ($keu_akun2_grid->TotalRecs > 0 || $keu_akun2->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid keu_akun2">
<div id="fkeu_akun2grid" class="ewForm form-inline">
<div id="gmp_keu_akun2" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_keu_akun2grid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $keu_akun2->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$keu_akun2_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$keu_akun2_grid->RenderListOptions();

// Render list options (header, left)
$keu_akun2_grid->ListOptions->Render("header", "left");
?>
<?php if ($keu_akun2->kd_akun->Visible) { // kd_akun ?>
	<?php if ($keu_akun2->SortUrl($keu_akun2->kd_akun) == "") { ?>
		<th data-name="kd_akun"><div id="elh_keu_akun2_kd_akun" class="keu_akun2_kd_akun"><div class="ewTableHeaderCaption"><?php echo $keu_akun2->kd_akun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_akun"><div><div id="elh_keu_akun2_kd_akun" class="keu_akun2_kd_akun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun2->kd_akun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun2->kd_akun->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun2->kd_akun->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun2->kel2->Visible) { // kel2 ?>
	<?php if ($keu_akun2->SortUrl($keu_akun2->kel2) == "") { ?>
		<th data-name="kel2"><div id="elh_keu_akun2_kel2" class="keu_akun2_kel2"><div class="ewTableHeaderCaption"><?php echo $keu_akun2->kel2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel2"><div><div id="elh_keu_akun2_kel2" class="keu_akun2_kel2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun2->kel2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun2->kel2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun2->kel2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun2->nmkel2->Visible) { // nmkel2 ?>
	<?php if ($keu_akun2->SortUrl($keu_akun2->nmkel2) == "") { ?>
		<th data-name="nmkel2"><div id="elh_keu_akun2_nmkel2" class="keu_akun2_nmkel2"><div class="ewTableHeaderCaption"><?php echo $keu_akun2->nmkel2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nmkel2"><div><div id="elh_keu_akun2_nmkel2" class="keu_akun2_nmkel2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun2->nmkel2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun2->nmkel2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun2->nmkel2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$keu_akun2_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$keu_akun2_grid->StartRec = 1;
$keu_akun2_grid->StopRec = $keu_akun2_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($keu_akun2_grid->FormKeyCountName) && ($keu_akun2->CurrentAction == "gridadd" || $keu_akun2->CurrentAction == "gridedit" || $keu_akun2->CurrentAction == "F")) {
		$keu_akun2_grid->KeyCount = $objForm->GetValue($keu_akun2_grid->FormKeyCountName);
		$keu_akun2_grid->StopRec = $keu_akun2_grid->StartRec + $keu_akun2_grid->KeyCount - 1;
	}
}
$keu_akun2_grid->RecCnt = $keu_akun2_grid->StartRec - 1;
if ($keu_akun2_grid->Recordset && !$keu_akun2_grid->Recordset->EOF) {
	$keu_akun2_grid->Recordset->MoveFirst();
	$bSelectLimit = $keu_akun2_grid->UseSelectLimit;
	if (!$bSelectLimit && $keu_akun2_grid->StartRec > 1)
		$keu_akun2_grid->Recordset->Move($keu_akun2_grid->StartRec - 1);
} elseif (!$keu_akun2->AllowAddDeleteRow && $keu_akun2_grid->StopRec == 0) {
	$keu_akun2_grid->StopRec = $keu_akun2->GridAddRowCount;
}

// Initialize aggregate
$keu_akun2->RowType = EW_ROWTYPE_AGGREGATEINIT;
$keu_akun2->ResetAttrs();
$keu_akun2_grid->RenderRow();
if ($keu_akun2->CurrentAction == "gridadd")
	$keu_akun2_grid->RowIndex = 0;
if ($keu_akun2->CurrentAction == "gridedit")
	$keu_akun2_grid->RowIndex = 0;
while ($keu_akun2_grid->RecCnt < $keu_akun2_grid->StopRec) {
	$keu_akun2_grid->RecCnt++;
	if (intval($keu_akun2_grid->RecCnt) >= intval($keu_akun2_grid->StartRec)) {
		$keu_akun2_grid->RowCnt++;
		if ($keu_akun2->CurrentAction == "gridadd" || $keu_akun2->CurrentAction == "gridedit" || $keu_akun2->CurrentAction == "F") {
			$keu_akun2_grid->RowIndex++;
			$objForm->Index = $keu_akun2_grid->RowIndex;
			if ($objForm->HasValue($keu_akun2_grid->FormActionName))
				$keu_akun2_grid->RowAction = strval($objForm->GetValue($keu_akun2_grid->FormActionName));
			elseif ($keu_akun2->CurrentAction == "gridadd")
				$keu_akun2_grid->RowAction = "insert";
			else
				$keu_akun2_grid->RowAction = "";
		}

		// Set up key count
		$keu_akun2_grid->KeyCount = $keu_akun2_grid->RowIndex;

		// Init row class and style
		$keu_akun2->ResetAttrs();
		$keu_akun2->CssClass = "";
		if ($keu_akun2->CurrentAction == "gridadd") {
			if ($keu_akun2->CurrentMode == "copy") {
				$keu_akun2_grid->LoadRowValues($keu_akun2_grid->Recordset); // Load row values
				$keu_akun2_grid->SetRecordKey($keu_akun2_grid->RowOldKey, $keu_akun2_grid->Recordset); // Set old record key
			} else {
				$keu_akun2_grid->LoadDefaultValues(); // Load default values
				$keu_akun2_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$keu_akun2_grid->LoadRowValues($keu_akun2_grid->Recordset); // Load row values
		}
		$keu_akun2->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($keu_akun2->CurrentAction == "gridadd") // Grid add
			$keu_akun2->RowType = EW_ROWTYPE_ADD; // Render add
		if ($keu_akun2->CurrentAction == "gridadd" && $keu_akun2->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$keu_akun2_grid->RestoreCurrentRowFormValues($keu_akun2_grid->RowIndex); // Restore form values
		if ($keu_akun2->CurrentAction == "gridedit") { // Grid edit
			if ($keu_akun2->EventCancelled) {
				$keu_akun2_grid->RestoreCurrentRowFormValues($keu_akun2_grid->RowIndex); // Restore form values
			}
			if ($keu_akun2_grid->RowAction == "insert")
				$keu_akun2->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$keu_akun2->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($keu_akun2->CurrentAction == "gridedit" && ($keu_akun2->RowType == EW_ROWTYPE_EDIT || $keu_akun2->RowType == EW_ROWTYPE_ADD) && $keu_akun2->EventCancelled) // Update failed
			$keu_akun2_grid->RestoreCurrentRowFormValues($keu_akun2_grid->RowIndex); // Restore form values
		if ($keu_akun2->RowType == EW_ROWTYPE_EDIT) // Edit row
			$keu_akun2_grid->EditRowCnt++;
		if ($keu_akun2->CurrentAction == "F") // Confirm row
			$keu_akun2_grid->RestoreCurrentRowFormValues($keu_akun2_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$keu_akun2->RowAttrs = array_merge($keu_akun2->RowAttrs, array('data-rowindex'=>$keu_akun2_grid->RowCnt, 'id'=>'r' . $keu_akun2_grid->RowCnt . '_keu_akun2', 'data-rowtype'=>$keu_akun2->RowType));

		// Render row
		$keu_akun2_grid->RenderRow();

		// Render list options
		$keu_akun2_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($keu_akun2_grid->RowAction <> "delete" && $keu_akun2_grid->RowAction <> "insertdelete" && !($keu_akun2_grid->RowAction == "insert" && $keu_akun2->CurrentAction == "F" && $keu_akun2_grid->EmptyRow())) {
?>
	<tr<?php echo $keu_akun2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun2_grid->ListOptions->Render("body", "left", $keu_akun2_grid->RowCnt);
?>
	<?php if ($keu_akun2->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun"<?php echo $keu_akun2->kd_akun->CellAttributes() ?>>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kd_akun" class="form-group keu_akun2_kd_akun">
<input type="text" data-table="keu_akun2" data-field="x_kd_akun" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kd_akun->EditValue ?>"<?php echo $keu_akun2->kd_akun->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kd_akun" class="form-group keu_akun2_kd_akun">
<input type="text" data-table="keu_akun2" data-field="x_kd_akun" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kd_akun->EditValue ?>"<?php echo $keu_akun2->kd_akun->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kd_akun" class="keu_akun2_kd_akun">
<span<?php echo $keu_akun2->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun2->kd_akun->ListViewValue() ?></span>
</span>
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $keu_akun2_grid->PageObjName . "_row_" . $keu_akun2_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="keu_akun2" data-field="x_id" name="x<?php echo $keu_akun2_grid->RowIndex ?>_id" id="x<?php echo $keu_akun2_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun2->id->CurrentValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_id" name="o<?php echo $keu_akun2_grid->RowIndex ?>_id" id="o<?php echo $keu_akun2_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun2->id->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_EDIT || $keu_akun2->CurrentMode == "edit") { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_id" name="x<?php echo $keu_akun2_grid->RowIndex ?>_id" id="x<?php echo $keu_akun2_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun2->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($keu_akun2->kel2->Visible) { // kel2 ?>
		<td data-name="kel2"<?php echo $keu_akun2->kel2->CellAttributes() ?>>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kel2" class="form-group keu_akun2_kel2">
<input type="text" data-table="keu_akun2" data-field="x_kel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kel2->EditValue ?>"<?php echo $keu_akun2->kel2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kel2" class="form-group keu_akun2_kel2">
<input type="text" data-table="keu_akun2" data-field="x_kel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kel2->EditValue ?>"<?php echo $keu_akun2->kel2->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_kel2" class="keu_akun2_kel2">
<span<?php echo $keu_akun2->kel2->ViewAttributes() ?>>
<?php echo $keu_akun2->kel2->ListViewValue() ?></span>
</span>
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($keu_akun2->nmkel2->Visible) { // nmkel2 ?>
		<td data-name="nmkel2"<?php echo $keu_akun2->nmkel2->CellAttributes() ?>>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_nmkel2" class="form-group keu_akun2_nmkel2">
<input type="text" data-table="keu_akun2" data-field="x_nmkel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->nmkel2->EditValue ?>"<?php echo $keu_akun2->nmkel2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_nmkel2" class="form-group keu_akun2_nmkel2">
<input type="text" data-table="keu_akun2" data-field="x_nmkel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->nmkel2->EditValue ?>"<?php echo $keu_akun2->nmkel2->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun2_grid->RowCnt ?>_keu_akun2_nmkel2" class="keu_akun2_nmkel2">
<span<?php echo $keu_akun2->nmkel2->ViewAttributes() ?>>
<?php echo $keu_akun2->nmkel2->ListViewValue() ?></span>
</span>
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="fkeu_akun2grid$x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->FormValue) ?>">
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="fkeu_akun2grid$o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun2_grid->ListOptions->Render("body", "right", $keu_akun2_grid->RowCnt);
?>
	</tr>
<?php if ($keu_akun2->RowType == EW_ROWTYPE_ADD || $keu_akun2->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fkeu_akun2grid.UpdateOpts(<?php echo $keu_akun2_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($keu_akun2->CurrentAction <> "gridadd" || $keu_akun2->CurrentMode == "copy")
		if (!$keu_akun2_grid->Recordset->EOF) $keu_akun2_grid->Recordset->MoveNext();
}
?>
<?php
	if ($keu_akun2->CurrentMode == "add" || $keu_akun2->CurrentMode == "copy" || $keu_akun2->CurrentMode == "edit") {
		$keu_akun2_grid->RowIndex = '$rowindex$';
		$keu_akun2_grid->LoadDefaultValues();

		// Set row properties
		$keu_akun2->ResetAttrs();
		$keu_akun2->RowAttrs = array_merge($keu_akun2->RowAttrs, array('data-rowindex'=>$keu_akun2_grid->RowIndex, 'id'=>'r0_keu_akun2', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($keu_akun2->RowAttrs["class"], "ewTemplate");
		$keu_akun2->RowType = EW_ROWTYPE_ADD;

		// Render row
		$keu_akun2_grid->RenderRow();

		// Render list options
		$keu_akun2_grid->RenderListOptions();
		$keu_akun2_grid->StartRowCnt = 0;
?>
	<tr<?php echo $keu_akun2->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun2_grid->ListOptions->Render("body", "left", $keu_akun2_grid->RowIndex);
?>
	<?php if ($keu_akun2->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun">
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun2_kd_akun" class="form-group keu_akun2_kd_akun">
<input type="text" data-table="keu_akun2" data-field="x_kd_akun" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kd_akun->EditValue ?>"<?php echo $keu_akun2->kd_akun->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun2_kd_akun" class="form-group keu_akun2_kd_akun">
<span<?php echo $keu_akun2->kd_akun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun2->kd_akun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kd_akun" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun2->kel2->Visible) { // kel2 ?>
		<td data-name="kel2">
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun2_kel2" class="form-group keu_akun2_kel2">
<input type="text" data-table="keu_akun2" data-field="x_kel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kel2->EditValue ?>"<?php echo $keu_akun2->kel2->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun2_kel2" class="form-group keu_akun2_kel2">
<span<?php echo $keu_akun2->kel2->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun2->kel2->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun2" data-field="x_kel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_kel2" value="<?php echo ew_HtmlEncode($keu_akun2->kel2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun2->nmkel2->Visible) { // nmkel2 ?>
		<td data-name="nmkel2">
<?php if ($keu_akun2->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun2_nmkel2" class="form-group keu_akun2_nmkel2">
<input type="text" data-table="keu_akun2" data-field="x_nmkel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->nmkel2->EditValue ?>"<?php echo $keu_akun2->nmkel2->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun2_nmkel2" class="form-group keu_akun2_nmkel2">
<span<?php echo $keu_akun2->nmkel2->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun2->nmkel2->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="x<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun2" data-field="x_nmkel2" name="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" id="o<?php echo $keu_akun2_grid->RowIndex ?>_nmkel2" value="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun2_grid->ListOptions->Render("body", "right", $keu_akun2_grid->RowCnt);
?>
<script type="text/javascript">
fkeu_akun2grid.UpdateOpts(<?php echo $keu_akun2_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($keu_akun2->CurrentMode == "add" || $keu_akun2->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $keu_akun2_grid->FormKeyCountName ?>" id="<?php echo $keu_akun2_grid->FormKeyCountName ?>" value="<?php echo $keu_akun2_grid->KeyCount ?>">
<?php echo $keu_akun2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun2->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $keu_akun2_grid->FormKeyCountName ?>" id="<?php echo $keu_akun2_grid->FormKeyCountName ?>" value="<?php echo $keu_akun2_grid->KeyCount ?>">
<?php echo $keu_akun2_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun2->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fkeu_akun2grid">
</div>
<?php

// Close recordset
if ($keu_akun2_grid->Recordset)
	$keu_akun2_grid->Recordset->Close();
?>
<?php if ($keu_akun2_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($keu_akun2_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($keu_akun2_grid->TotalRecs == 0 && $keu_akun2->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($keu_akun2_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($keu_akun2->Export == "") { ?>
<script type="text/javascript">
fkeu_akun2grid.Init();
</script>
<?php } ?>
<?php
$keu_akun2_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$keu_akun2_grid->Page_Terminate();
?>
