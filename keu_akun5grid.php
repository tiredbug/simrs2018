<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($keu_akun5_grid)) $keu_akun5_grid = new ckeu_akun5_grid();

// Page init
$keu_akun5_grid->Page_Init();

// Page main
$keu_akun5_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$keu_akun5_grid->Page_Render();
?>
<?php if ($keu_akun5->Export == "") { ?>
<script type="text/javascript">

// Form object
var fkeu_akun5grid = new ew_Form("fkeu_akun5grid", "grid");
fkeu_akun5grid.FormKeyCountName = '<?php echo $keu_akun5_grid->FormKeyCountName ?>';

// Validate form
fkeu_akun5grid.Validate = function() {
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
fkeu_akun5grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_akun", false)) return false;
	if (ew_ValueChanged(fobj, infix, "akun5", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nama_akun", false)) return false;
	return true;
}

// Form_CustomValidate event
fkeu_akun5grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkeu_akun5grid.ValidateRequired = true;
<?php } else { ?>
fkeu_akun5grid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($keu_akun5->CurrentAction == "gridadd") {
	if ($keu_akun5->CurrentMode == "copy") {
		$bSelectLimit = $keu_akun5_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$keu_akun5_grid->TotalRecs = $keu_akun5->SelectRecordCount();
			$keu_akun5_grid->Recordset = $keu_akun5_grid->LoadRecordset($keu_akun5_grid->StartRec-1, $keu_akun5_grid->DisplayRecs);
		} else {
			if ($keu_akun5_grid->Recordset = $keu_akun5_grid->LoadRecordset())
				$keu_akun5_grid->TotalRecs = $keu_akun5_grid->Recordset->RecordCount();
		}
		$keu_akun5_grid->StartRec = 1;
		$keu_akun5_grid->DisplayRecs = $keu_akun5_grid->TotalRecs;
	} else {
		$keu_akun5->CurrentFilter = "0=1";
		$keu_akun5_grid->StartRec = 1;
		$keu_akun5_grid->DisplayRecs = $keu_akun5->GridAddRowCount;
	}
	$keu_akun5_grid->TotalRecs = $keu_akun5_grid->DisplayRecs;
	$keu_akun5_grid->StopRec = $keu_akun5_grid->DisplayRecs;
} else {
	$bSelectLimit = $keu_akun5_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($keu_akun5_grid->TotalRecs <= 0)
			$keu_akun5_grid->TotalRecs = $keu_akun5->SelectRecordCount();
	} else {
		if (!$keu_akun5_grid->Recordset && ($keu_akun5_grid->Recordset = $keu_akun5_grid->LoadRecordset()))
			$keu_akun5_grid->TotalRecs = $keu_akun5_grid->Recordset->RecordCount();
	}
	$keu_akun5_grid->StartRec = 1;
	$keu_akun5_grid->DisplayRecs = $keu_akun5_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$keu_akun5_grid->Recordset = $keu_akun5_grid->LoadRecordset($keu_akun5_grid->StartRec-1, $keu_akun5_grid->DisplayRecs);

	// Set no record found message
	if ($keu_akun5->CurrentAction == "" && $keu_akun5_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$keu_akun5_grid->setWarningMessage(ew_DeniedMsg());
		if ($keu_akun5_grid->SearchWhere == "0=101")
			$keu_akun5_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$keu_akun5_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$keu_akun5_grid->RenderOtherOptions();
?>
<?php $keu_akun5_grid->ShowPageHeader(); ?>
<?php
$keu_akun5_grid->ShowMessage();
?>
<?php if ($keu_akun5_grid->TotalRecs > 0 || $keu_akun5->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid keu_akun5">
<div id="fkeu_akun5grid" class="ewForm form-inline">
<div id="gmp_keu_akun5" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_keu_akun5grid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $keu_akun5->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$keu_akun5_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$keu_akun5_grid->RenderListOptions();

// Render list options (header, left)
$keu_akun5_grid->ListOptions->Render("header", "left");
?>
<?php if ($keu_akun5->kd_akun->Visible) { // kd_akun ?>
	<?php if ($keu_akun5->SortUrl($keu_akun5->kd_akun) == "") { ?>
		<th data-name="kd_akun"><div id="elh_keu_akun5_kd_akun" class="keu_akun5_kd_akun"><div class="ewTableHeaderCaption"><?php echo $keu_akun5->kd_akun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_akun"><div><div id="elh_keu_akun5_kd_akun" class="keu_akun5_kd_akun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun5->kd_akun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun5->kd_akun->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun5->kd_akun->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun5->akun5->Visible) { // akun5 ?>
	<?php if ($keu_akun5->SortUrl($keu_akun5->akun5) == "") { ?>
		<th data-name="akun5"><div id="elh_keu_akun5_akun5" class="keu_akun5_akun5"><div class="ewTableHeaderCaption"><?php echo $keu_akun5->akun5->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun5"><div><div id="elh_keu_akun5_akun5" class="keu_akun5_akun5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun5->akun5->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun5->akun5->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun5->akun5->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($keu_akun5->nama_akun->Visible) { // nama_akun ?>
	<?php if ($keu_akun5->SortUrl($keu_akun5->nama_akun) == "") { ?>
		<th data-name="nama_akun"><div id="elh_keu_akun5_nama_akun" class="keu_akun5_nama_akun"><div class="ewTableHeaderCaption"><?php echo $keu_akun5->nama_akun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_akun"><div><div id="elh_keu_akun5_nama_akun" class="keu_akun5_nama_akun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $keu_akun5->nama_akun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($keu_akun5->nama_akun->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($keu_akun5->nama_akun->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$keu_akun5_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$keu_akun5_grid->StartRec = 1;
$keu_akun5_grid->StopRec = $keu_akun5_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($keu_akun5_grid->FormKeyCountName) && ($keu_akun5->CurrentAction == "gridadd" || $keu_akun5->CurrentAction == "gridedit" || $keu_akun5->CurrentAction == "F")) {
		$keu_akun5_grid->KeyCount = $objForm->GetValue($keu_akun5_grid->FormKeyCountName);
		$keu_akun5_grid->StopRec = $keu_akun5_grid->StartRec + $keu_akun5_grid->KeyCount - 1;
	}
}
$keu_akun5_grid->RecCnt = $keu_akun5_grid->StartRec - 1;
if ($keu_akun5_grid->Recordset && !$keu_akun5_grid->Recordset->EOF) {
	$keu_akun5_grid->Recordset->MoveFirst();
	$bSelectLimit = $keu_akun5_grid->UseSelectLimit;
	if (!$bSelectLimit && $keu_akun5_grid->StartRec > 1)
		$keu_akun5_grid->Recordset->Move($keu_akun5_grid->StartRec - 1);
} elseif (!$keu_akun5->AllowAddDeleteRow && $keu_akun5_grid->StopRec == 0) {
	$keu_akun5_grid->StopRec = $keu_akun5->GridAddRowCount;
}

// Initialize aggregate
$keu_akun5->RowType = EW_ROWTYPE_AGGREGATEINIT;
$keu_akun5->ResetAttrs();
$keu_akun5_grid->RenderRow();
if ($keu_akun5->CurrentAction == "gridadd")
	$keu_akun5_grid->RowIndex = 0;
if ($keu_akun5->CurrentAction == "gridedit")
	$keu_akun5_grid->RowIndex = 0;
while ($keu_akun5_grid->RecCnt < $keu_akun5_grid->StopRec) {
	$keu_akun5_grid->RecCnt++;
	if (intval($keu_akun5_grid->RecCnt) >= intval($keu_akun5_grid->StartRec)) {
		$keu_akun5_grid->RowCnt++;
		if ($keu_akun5->CurrentAction == "gridadd" || $keu_akun5->CurrentAction == "gridedit" || $keu_akun5->CurrentAction == "F") {
			$keu_akun5_grid->RowIndex++;
			$objForm->Index = $keu_akun5_grid->RowIndex;
			if ($objForm->HasValue($keu_akun5_grid->FormActionName))
				$keu_akun5_grid->RowAction = strval($objForm->GetValue($keu_akun5_grid->FormActionName));
			elseif ($keu_akun5->CurrentAction == "gridadd")
				$keu_akun5_grid->RowAction = "insert";
			else
				$keu_akun5_grid->RowAction = "";
		}

		// Set up key count
		$keu_akun5_grid->KeyCount = $keu_akun5_grid->RowIndex;

		// Init row class and style
		$keu_akun5->ResetAttrs();
		$keu_akun5->CssClass = "";
		if ($keu_akun5->CurrentAction == "gridadd") {
			if ($keu_akun5->CurrentMode == "copy") {
				$keu_akun5_grid->LoadRowValues($keu_akun5_grid->Recordset); // Load row values
				$keu_akun5_grid->SetRecordKey($keu_akun5_grid->RowOldKey, $keu_akun5_grid->Recordset); // Set old record key
			} else {
				$keu_akun5_grid->LoadDefaultValues(); // Load default values
				$keu_akun5_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$keu_akun5_grid->LoadRowValues($keu_akun5_grid->Recordset); // Load row values
		}
		$keu_akun5->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($keu_akun5->CurrentAction == "gridadd") // Grid add
			$keu_akun5->RowType = EW_ROWTYPE_ADD; // Render add
		if ($keu_akun5->CurrentAction == "gridadd" && $keu_akun5->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$keu_akun5_grid->RestoreCurrentRowFormValues($keu_akun5_grid->RowIndex); // Restore form values
		if ($keu_akun5->CurrentAction == "gridedit") { // Grid edit
			if ($keu_akun5->EventCancelled) {
				$keu_akun5_grid->RestoreCurrentRowFormValues($keu_akun5_grid->RowIndex); // Restore form values
			}
			if ($keu_akun5_grid->RowAction == "insert")
				$keu_akun5->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$keu_akun5->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($keu_akun5->CurrentAction == "gridedit" && ($keu_akun5->RowType == EW_ROWTYPE_EDIT || $keu_akun5->RowType == EW_ROWTYPE_ADD) && $keu_akun5->EventCancelled) // Update failed
			$keu_akun5_grid->RestoreCurrentRowFormValues($keu_akun5_grid->RowIndex); // Restore form values
		if ($keu_akun5->RowType == EW_ROWTYPE_EDIT) // Edit row
			$keu_akun5_grid->EditRowCnt++;
		if ($keu_akun5->CurrentAction == "F") // Confirm row
			$keu_akun5_grid->RestoreCurrentRowFormValues($keu_akun5_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$keu_akun5->RowAttrs = array_merge($keu_akun5->RowAttrs, array('data-rowindex'=>$keu_akun5_grid->RowCnt, 'id'=>'r' . $keu_akun5_grid->RowCnt . '_keu_akun5', 'data-rowtype'=>$keu_akun5->RowType));

		// Render row
		$keu_akun5_grid->RenderRow();

		// Render list options
		$keu_akun5_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($keu_akun5_grid->RowAction <> "delete" && $keu_akun5_grid->RowAction <> "insertdelete" && !($keu_akun5_grid->RowAction == "insert" && $keu_akun5->CurrentAction == "F" && $keu_akun5_grid->EmptyRow())) {
?>
	<tr<?php echo $keu_akun5->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun5_grid->ListOptions->Render("body", "left", $keu_akun5_grid->RowCnt);
?>
	<?php if ($keu_akun5->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun"<?php echo $keu_akun5->kd_akun->CellAttributes() ?>>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_kd_akun" class="form-group keu_akun5_kd_akun">
<input type="text" data-table="keu_akun5" data-field="x_kd_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->kd_akun->EditValue ?>"<?php echo $keu_akun5->kd_akun->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_kd_akun" class="form-group keu_akun5_kd_akun">
<input type="text" data-table="keu_akun5" data-field="x_kd_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->kd_akun->EditValue ?>"<?php echo $keu_akun5->kd_akun->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_kd_akun" class="keu_akun5_kd_akun">
<span<?php echo $keu_akun5->kd_akun->ViewAttributes() ?>>
<?php echo $keu_akun5->kd_akun->ListViewValue() ?></span>
</span>
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $keu_akun5_grid->PageObjName . "_row_" . $keu_akun5_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="keu_akun5" data-field="x_id" name="x<?php echo $keu_akun5_grid->RowIndex ?>_id" id="x<?php echo $keu_akun5_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun5->id->CurrentValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_id" name="o<?php echo $keu_akun5_grid->RowIndex ?>_id" id="o<?php echo $keu_akun5_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun5->id->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_EDIT || $keu_akun5->CurrentMode == "edit") { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_id" name="x<?php echo $keu_akun5_grid->RowIndex ?>_id" id="x<?php echo $keu_akun5_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($keu_akun5->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($keu_akun5->akun5->Visible) { // akun5 ?>
		<td data-name="akun5"<?php echo $keu_akun5->akun5->CellAttributes() ?>>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_akun5" class="form-group keu_akun5_akun5">
<input type="text" data-table="keu_akun5" data-field="x_akun5" name="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun5->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun5->EditValue ?>"<?php echo $keu_akun5->akun5->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_akun5" class="form-group keu_akun5_akun5">
<input type="text" data-table="keu_akun5" data-field="x_akun5" name="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun5->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun5->EditValue ?>"<?php echo $keu_akun5->akun5->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_akun5" class="keu_akun5_akun5">
<span<?php echo $keu_akun5->akun5->ViewAttributes() ?>>
<?php echo $keu_akun5->akun5->ListViewValue() ?></span>
</span>
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($keu_akun5->nama_akun->Visible) { // nama_akun ?>
		<td data-name="nama_akun"<?php echo $keu_akun5->nama_akun->CellAttributes() ?>>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_nama_akun" class="form-group keu_akun5_nama_akun">
<input type="text" data-table="keu_akun5" data-field="x_nama_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->nama_akun->EditValue ?>"<?php echo $keu_akun5->nama_akun->EditAttributes() ?>>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->OldValue) ?>">
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_nama_akun" class="form-group keu_akun5_nama_akun">
<input type="text" data-table="keu_akun5" data-field="x_nama_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->nama_akun->EditValue ?>"<?php echo $keu_akun5->nama_akun->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $keu_akun5_grid->RowCnt ?>_keu_akun5_nama_akun" class="keu_akun5_nama_akun">
<span<?php echo $keu_akun5->nama_akun->ViewAttributes() ?>>
<?php echo $keu_akun5->nama_akun->ListViewValue() ?></span>
</span>
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="fkeu_akun5grid$x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->FormValue) ?>">
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="fkeu_akun5grid$o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun5_grid->ListOptions->Render("body", "right", $keu_akun5_grid->RowCnt);
?>
	</tr>
<?php if ($keu_akun5->RowType == EW_ROWTYPE_ADD || $keu_akun5->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fkeu_akun5grid.UpdateOpts(<?php echo $keu_akun5_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($keu_akun5->CurrentAction <> "gridadd" || $keu_akun5->CurrentMode == "copy")
		if (!$keu_akun5_grid->Recordset->EOF) $keu_akun5_grid->Recordset->MoveNext();
}
?>
<?php
	if ($keu_akun5->CurrentMode == "add" || $keu_akun5->CurrentMode == "copy" || $keu_akun5->CurrentMode == "edit") {
		$keu_akun5_grid->RowIndex = '$rowindex$';
		$keu_akun5_grid->LoadDefaultValues();

		// Set row properties
		$keu_akun5->ResetAttrs();
		$keu_akun5->RowAttrs = array_merge($keu_akun5->RowAttrs, array('data-rowindex'=>$keu_akun5_grid->RowIndex, 'id'=>'r0_keu_akun5', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($keu_akun5->RowAttrs["class"], "ewTemplate");
		$keu_akun5->RowType = EW_ROWTYPE_ADD;

		// Render row
		$keu_akun5_grid->RenderRow();

		// Render list options
		$keu_akun5_grid->RenderListOptions();
		$keu_akun5_grid->StartRowCnt = 0;
?>
	<tr<?php echo $keu_akun5->RowAttributes() ?>>
<?php

// Render list options (body, left)
$keu_akun5_grid->ListOptions->Render("body", "left", $keu_akun5_grid->RowIndex);
?>
	<?php if ($keu_akun5->kd_akun->Visible) { // kd_akun ?>
		<td data-name="kd_akun">
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun5_kd_akun" class="form-group keu_akun5_kd_akun">
<input type="text" data-table="keu_akun5" data-field="x_kd_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->kd_akun->EditValue ?>"<?php echo $keu_akun5->kd_akun->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun5_kd_akun" class="form-group keu_akun5_kd_akun">
<span<?php echo $keu_akun5->kd_akun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->kd_akun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun5" data-field="x_kd_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_kd_akun" value="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun5->akun5->Visible) { // akun5 ?>
		<td data-name="akun5">
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun5_akun5" class="form-group keu_akun5_akun5">
<input type="text" data-table="keu_akun5" data-field="x_akun5" name="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun5->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun5->EditValue ?>"<?php echo $keu_akun5->akun5->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun5_akun5" class="form-group keu_akun5_akun5">
<span<?php echo $keu_akun5->akun5->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->akun5->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="x<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun5" data-field="x_akun5" name="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" id="o<?php echo $keu_akun5_grid->RowIndex ?>_akun5" value="<?php echo ew_HtmlEncode($keu_akun5->akun5->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($keu_akun5->nama_akun->Visible) { // nama_akun ?>
		<td data-name="nama_akun">
<?php if ($keu_akun5->CurrentAction <> "F") { ?>
<span id="el$rowindex$_keu_akun5_nama_akun" class="form-group keu_akun5_nama_akun">
<input type="text" data-table="keu_akun5" data-field="x_nama_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->nama_akun->EditValue ?>"<?php echo $keu_akun5->nama_akun->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_keu_akun5_nama_akun" class="form-group keu_akun5_nama_akun">
<span<?php echo $keu_akun5->nama_akun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->nama_akun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="x<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="keu_akun5" data-field="x_nama_akun" name="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" id="o<?php echo $keu_akun5_grid->RowIndex ?>_nama_akun" value="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$keu_akun5_grid->ListOptions->Render("body", "right", $keu_akun5_grid->RowCnt);
?>
<script type="text/javascript">
fkeu_akun5grid.UpdateOpts(<?php echo $keu_akun5_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($keu_akun5->CurrentMode == "add" || $keu_akun5->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $keu_akun5_grid->FormKeyCountName ?>" id="<?php echo $keu_akun5_grid->FormKeyCountName ?>" value="<?php echo $keu_akun5_grid->KeyCount ?>">
<?php echo $keu_akun5_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun5->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $keu_akun5_grid->FormKeyCountName ?>" id="<?php echo $keu_akun5_grid->FormKeyCountName ?>" value="<?php echo $keu_akun5_grid->KeyCount ?>">
<?php echo $keu_akun5_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($keu_akun5->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fkeu_akun5grid">
</div>
<?php

// Close recordset
if ($keu_akun5_grid->Recordset)
	$keu_akun5_grid->Recordset->Close();
?>
<?php if ($keu_akun5_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($keu_akun5_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($keu_akun5_grid->TotalRecs == 0 && $keu_akun5->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($keu_akun5_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($keu_akun5->Export == "") { ?>
<script type="text/javascript">
fkeu_akun5grid.Init();
</script>
<?php } ?>
<?php
$keu_akun5_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$keu_akun5_grid->Page_Terminate();
?>
