<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_spp_ls_gaji_tunjangan_grid)) $vw_spp_ls_gaji_tunjangan_grid = new cvw_spp_ls_gaji_tunjangan_grid();

// Page init
$vw_spp_ls_gaji_tunjangan_grid->Page_Init();

// Page main
$vw_spp_ls_gaji_tunjangan_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_gaji_tunjangan_grid->Page_Render();
?>
<?php if ($vw_spp_ls_gaji_tunjangan->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_spp_ls_gaji_tunjangangrid = new ew_Form("fvw_spp_ls_gaji_tunjangangrid", "grid");
fvw_spp_ls_gaji_tunjangangrid.FormKeyCountName = '<?php echo $vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName ?>';

// Validate form
fvw_spp_ls_gaji_tunjangangrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_status_spp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->status_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_spp");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->tgl_spp->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_spp_ls_gaji_tunjangangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "status_spp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_spp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tgl_spp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "keterangan", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_spp_ls_gaji_tunjangangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_gaji_tunjangangrid.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_gaji_tunjangangrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd") {
	if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "copy") {
		$bSelectLimit = $vw_spp_ls_gaji_tunjangan_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_spp_ls_gaji_tunjangan_grid->TotalRecs = $vw_spp_ls_gaji_tunjangan->SelectRecordCount();
			$vw_spp_ls_gaji_tunjangan_grid->Recordset = $vw_spp_ls_gaji_tunjangan_grid->LoadRecordset($vw_spp_ls_gaji_tunjangan_grid->StartRec-1, $vw_spp_ls_gaji_tunjangan_grid->DisplayRecs);
		} else {
			if ($vw_spp_ls_gaji_tunjangan_grid->Recordset = $vw_spp_ls_gaji_tunjangan_grid->LoadRecordset())
				$vw_spp_ls_gaji_tunjangan_grid->TotalRecs = $vw_spp_ls_gaji_tunjangan_grid->Recordset->RecordCount();
		}
		$vw_spp_ls_gaji_tunjangan_grid->StartRec = 1;
		$vw_spp_ls_gaji_tunjangan_grid->DisplayRecs = $vw_spp_ls_gaji_tunjangan_grid->TotalRecs;
	} else {
		$vw_spp_ls_gaji_tunjangan->CurrentFilter = "0=1";
		$vw_spp_ls_gaji_tunjangan_grid->StartRec = 1;
		$vw_spp_ls_gaji_tunjangan_grid->DisplayRecs = $vw_spp_ls_gaji_tunjangan->GridAddRowCount;
	}
	$vw_spp_ls_gaji_tunjangan_grid->TotalRecs = $vw_spp_ls_gaji_tunjangan_grid->DisplayRecs;
	$vw_spp_ls_gaji_tunjangan_grid->StopRec = $vw_spp_ls_gaji_tunjangan_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_spp_ls_gaji_tunjangan_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_spp_ls_gaji_tunjangan_grid->TotalRecs <= 0)
			$vw_spp_ls_gaji_tunjangan_grid->TotalRecs = $vw_spp_ls_gaji_tunjangan->SelectRecordCount();
	} else {
		if (!$vw_spp_ls_gaji_tunjangan_grid->Recordset && ($vw_spp_ls_gaji_tunjangan_grid->Recordset = $vw_spp_ls_gaji_tunjangan_grid->LoadRecordset()))
			$vw_spp_ls_gaji_tunjangan_grid->TotalRecs = $vw_spp_ls_gaji_tunjangan_grid->Recordset->RecordCount();
	}
	$vw_spp_ls_gaji_tunjangan_grid->StartRec = 1;
	$vw_spp_ls_gaji_tunjangan_grid->DisplayRecs = $vw_spp_ls_gaji_tunjangan_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_spp_ls_gaji_tunjangan_grid->Recordset = $vw_spp_ls_gaji_tunjangan_grid->LoadRecordset($vw_spp_ls_gaji_tunjangan_grid->StartRec-1, $vw_spp_ls_gaji_tunjangan_grid->DisplayRecs);

	// Set no record found message
	if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "" && $vw_spp_ls_gaji_tunjangan_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_spp_ls_gaji_tunjangan_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_spp_ls_gaji_tunjangan_grid->SearchWhere == "0=101")
			$vw_spp_ls_gaji_tunjangan_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_spp_ls_gaji_tunjangan_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_spp_ls_gaji_tunjangan_grid->RenderOtherOptions();
?>
<?php $vw_spp_ls_gaji_tunjangan_grid->ShowPageHeader(); ?>
<?php
$vw_spp_ls_gaji_tunjangan_grid->ShowMessage();
?>
<?php if ($vw_spp_ls_gaji_tunjangan_grid->TotalRecs > 0 || $vw_spp_ls_gaji_tunjangan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_spp_ls_gaji_tunjangan">
<div id="fvw_spp_ls_gaji_tunjangangrid" class="ewForm form-inline">
<div id="gmp_vw_spp_ls_gaji_tunjangan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_spp_ls_gaji_tunjangangrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spp_ls_gaji_tunjangan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_spp_ls_gaji_tunjangan_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_spp_ls_gaji_tunjangan_grid->RenderListOptions();

// Render list options (header, left)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->status_spp) == "") { ?>
		<th data-name="status_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status_spp"><div><div id="elh_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->status_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->status_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->no_spp) == "") { ?>
		<th data-name="no_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_spp"><div><div id="elh_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->no_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->no_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->tgl_spp) == "") { ?>
		<th data-name="tgl_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_spp"><div><div id="elh_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->tgl_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->keterangan) == "") { ?>
		<th data-name="keterangan"><div id="elh_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan"><div><div id="elh_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->keterangan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->keterangan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_spp_ls_gaji_tunjangan_grid->StartRec = 1;
$vw_spp_ls_gaji_tunjangan_grid->StopRec = $vw_spp_ls_gaji_tunjangan_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName) && ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd" || $vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit" || $vw_spp_ls_gaji_tunjangan->CurrentAction == "F")) {
		$vw_spp_ls_gaji_tunjangan_grid->KeyCount = $objForm->GetValue($vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName);
		$vw_spp_ls_gaji_tunjangan_grid->StopRec = $vw_spp_ls_gaji_tunjangan_grid->StartRec + $vw_spp_ls_gaji_tunjangan_grid->KeyCount - 1;
	}
}
$vw_spp_ls_gaji_tunjangan_grid->RecCnt = $vw_spp_ls_gaji_tunjangan_grid->StartRec - 1;
if ($vw_spp_ls_gaji_tunjangan_grid->Recordset && !$vw_spp_ls_gaji_tunjangan_grid->Recordset->EOF) {
	$vw_spp_ls_gaji_tunjangan_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_spp_ls_gaji_tunjangan_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_spp_ls_gaji_tunjangan_grid->StartRec > 1)
		$vw_spp_ls_gaji_tunjangan_grid->Recordset->Move($vw_spp_ls_gaji_tunjangan_grid->StartRec - 1);
} elseif (!$vw_spp_ls_gaji_tunjangan->AllowAddDeleteRow && $vw_spp_ls_gaji_tunjangan_grid->StopRec == 0) {
	$vw_spp_ls_gaji_tunjangan_grid->StopRec = $vw_spp_ls_gaji_tunjangan->GridAddRowCount;
}

// Initialize aggregate
$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_spp_ls_gaji_tunjangan->ResetAttrs();
$vw_spp_ls_gaji_tunjangan_grid->RenderRow();
if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd")
	$vw_spp_ls_gaji_tunjangan_grid->RowIndex = 0;
if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit")
	$vw_spp_ls_gaji_tunjangan_grid->RowIndex = 0;
while ($vw_spp_ls_gaji_tunjangan_grid->RecCnt < $vw_spp_ls_gaji_tunjangan_grid->StopRec) {
	$vw_spp_ls_gaji_tunjangan_grid->RecCnt++;
	if (intval($vw_spp_ls_gaji_tunjangan_grid->RecCnt) >= intval($vw_spp_ls_gaji_tunjangan_grid->StartRec)) {
		$vw_spp_ls_gaji_tunjangan_grid->RowCnt++;
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd" || $vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit" || $vw_spp_ls_gaji_tunjangan->CurrentAction == "F") {
			$vw_spp_ls_gaji_tunjangan_grid->RowIndex++;
			$objForm->Index = $vw_spp_ls_gaji_tunjangan_grid->RowIndex;
			if ($objForm->HasValue($vw_spp_ls_gaji_tunjangan_grid->FormActionName))
				$vw_spp_ls_gaji_tunjangan_grid->RowAction = strval($objForm->GetValue($vw_spp_ls_gaji_tunjangan_grid->FormActionName));
			elseif ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd")
				$vw_spp_ls_gaji_tunjangan_grid->RowAction = "insert";
			else
				$vw_spp_ls_gaji_tunjangan_grid->RowAction = "";
		}

		// Set up key count
		$vw_spp_ls_gaji_tunjangan_grid->KeyCount = $vw_spp_ls_gaji_tunjangan_grid->RowIndex;

		// Init row class and style
		$vw_spp_ls_gaji_tunjangan->ResetAttrs();
		$vw_spp_ls_gaji_tunjangan->CssClass = "";
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd") {
			if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "copy") {
				$vw_spp_ls_gaji_tunjangan_grid->LoadRowValues($vw_spp_ls_gaji_tunjangan_grid->Recordset); // Load row values
				$vw_spp_ls_gaji_tunjangan_grid->SetRecordKey($vw_spp_ls_gaji_tunjangan_grid->RowOldKey, $vw_spp_ls_gaji_tunjangan_grid->Recordset); // Set old record key
			} else {
				$vw_spp_ls_gaji_tunjangan_grid->LoadDefaultValues(); // Load default values
				$vw_spp_ls_gaji_tunjangan_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_spp_ls_gaji_tunjangan_grid->LoadRowValues($vw_spp_ls_gaji_tunjangan_grid->Recordset); // Load row values
		}
		$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd") // Grid add
			$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd" && $vw_spp_ls_gaji_tunjangan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_spp_ls_gaji_tunjangan_grid->RestoreCurrentRowFormValues($vw_spp_ls_gaji_tunjangan_grid->RowIndex); // Restore form values
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit") { // Grid edit
			if ($vw_spp_ls_gaji_tunjangan->EventCancelled) {
				$vw_spp_ls_gaji_tunjangan_grid->RestoreCurrentRowFormValues($vw_spp_ls_gaji_tunjangan_grid->RowIndex); // Restore form values
			}
			if ($vw_spp_ls_gaji_tunjangan_grid->RowAction == "insert")
				$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit" && ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT || $vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) && $vw_spp_ls_gaji_tunjangan->EventCancelled) // Update failed
			$vw_spp_ls_gaji_tunjangan_grid->RestoreCurrentRowFormValues($vw_spp_ls_gaji_tunjangan_grid->RowIndex); // Restore form values
		if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_spp_ls_gaji_tunjangan_grid->EditRowCnt++;
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "F") // Confirm row
			$vw_spp_ls_gaji_tunjangan_grid->RestoreCurrentRowFormValues($vw_spp_ls_gaji_tunjangan_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_spp_ls_gaji_tunjangan->RowAttrs = array_merge($vw_spp_ls_gaji_tunjangan->RowAttrs, array('data-rowindex'=>$vw_spp_ls_gaji_tunjangan_grid->RowCnt, 'id'=>'r' . $vw_spp_ls_gaji_tunjangan_grid->RowCnt . '_vw_spp_ls_gaji_tunjangan', 'data-rowtype'=>$vw_spp_ls_gaji_tunjangan->RowType));

		// Render row
		$vw_spp_ls_gaji_tunjangan_grid->RenderRow();

		// Render list options
		$vw_spp_ls_gaji_tunjangan_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_spp_ls_gaji_tunjangan_grid->RowAction <> "delete" && $vw_spp_ls_gaji_tunjangan_grid->RowAction <> "insertdelete" && !($vw_spp_ls_gaji_tunjangan_grid->RowAction == "insert" && $vw_spp_ls_gaji_tunjangan->CurrentAction == "F" && $vw_spp_ls_gaji_tunjangan_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_spp_ls_gaji_tunjangan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("body", "left", $vw_spp_ls_gaji_tunjangan_grid->RowCnt);
?>
	<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
		<td data-name="status_spp"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_status_spp" class="form-group vw_spp_ls_gaji_tunjangan_status_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_status_spp" class="form-group vw_spp_ls_gaji_tunjangan_status_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_spp_ls_gaji_tunjangan_grid->PageObjName . "_row_" . $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_id" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_id" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT || $vw_spp_ls_gaji_tunjangan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_id" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
		<td data-name="no_spp"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_no_spp" class="form-group vw_spp_ls_gaji_tunjangan_no_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_no_spp" class="form-group vw_spp_ls_gaji_tunjangan_no_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
		<td data-name="tgl_spp"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_tgl_spp" class="form-group vw_spp_ls_gaji_tunjangan_tgl_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_tgl_spp" class="form-group vw_spp_ls_gaji_tunjangan_tgl_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_keterangan" class="form-group vw_spp_ls_gaji_tunjangan_keterangan">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_keterangan" class="form-group vw_spp_ls_gaji_tunjangan_keterangan">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowCnt ?>_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan">
<span<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="fvw_spp_ls_gaji_tunjangangrid$x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="fvw_spp_ls_gaji_tunjangangrid$o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("body", "right", $vw_spp_ls_gaji_tunjangan_grid->RowCnt);
?>
	</tr>
<?php if ($vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_ADD || $vw_spp_ls_gaji_tunjangan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_spp_ls_gaji_tunjangangrid.UpdateOpts(<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "gridadd" || $vw_spp_ls_gaji_tunjangan->CurrentMode == "copy")
		if (!$vw_spp_ls_gaji_tunjangan_grid->Recordset->EOF) $vw_spp_ls_gaji_tunjangan_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "add" || $vw_spp_ls_gaji_tunjangan->CurrentMode == "copy" || $vw_spp_ls_gaji_tunjangan->CurrentMode == "edit") {
		$vw_spp_ls_gaji_tunjangan_grid->RowIndex = '$rowindex$';
		$vw_spp_ls_gaji_tunjangan_grid->LoadDefaultValues();

		// Set row properties
		$vw_spp_ls_gaji_tunjangan->ResetAttrs();
		$vw_spp_ls_gaji_tunjangan->RowAttrs = array_merge($vw_spp_ls_gaji_tunjangan->RowAttrs, array('data-rowindex'=>$vw_spp_ls_gaji_tunjangan_grid->RowIndex, 'id'=>'r0_vw_spp_ls_gaji_tunjangan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_spp_ls_gaji_tunjangan->RowAttrs["class"], "ewTemplate");
		$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_spp_ls_gaji_tunjangan_grid->RenderRow();

		// Render list options
		$vw_spp_ls_gaji_tunjangan_grid->RenderListOptions();
		$vw_spp_ls_gaji_tunjangan_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_spp_ls_gaji_tunjangan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("body", "left", $vw_spp_ls_gaji_tunjangan_grid->RowIndex);
?>
	<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
		<td data-name="status_spp">
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_status_spp" class="form-group vw_spp_ls_gaji_tunjangan_status_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_status_spp" class="form-group vw_spp_ls_gaji_tunjangan_status_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_status_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
		<td data-name="no_spp">
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_no_spp" class="form-group vw_spp_ls_gaji_tunjangan_no_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_no_spp" class="form-group vw_spp_ls_gaji_tunjangan_no_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_no_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
		<td data-name="tgl_spp">
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_tgl_spp" class="form-group vw_spp_ls_gaji_tunjangan_tgl_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_tgl_spp" class="form-group vw_spp_ls_gaji_tunjangan_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan">
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_keterangan" class="form-group vw_spp_ls_gaji_tunjangan_keterangan">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_gaji_tunjangan_keterangan" class="form-group vw_spp_ls_gaji_tunjangan_keterangan">
<span<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="x<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" id="o<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_ls_gaji_tunjangan_grid->ListOptions->Render("body", "right", $vw_spp_ls_gaji_tunjangan_grid->RowCnt);
?>
<script type="text/javascript">
fvw_spp_ls_gaji_tunjangangrid.UpdateOpts(<?php echo $vw_spp_ls_gaji_tunjangan_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "add" || $vw_spp_ls_gaji_tunjangan->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan_grid->KeyCount ?>">
<?php echo $vw_spp_ls_gaji_tunjangan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_ls_gaji_tunjangan_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan_grid->KeyCount ?>">
<?php echo $vw_spp_ls_gaji_tunjangan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_spp_ls_gaji_tunjangangrid">
</div>
<?php

// Close recordset
if ($vw_spp_ls_gaji_tunjangan_grid->Recordset)
	$vw_spp_ls_gaji_tunjangan_grid->Recordset->Close();
?>
<?php if ($vw_spp_ls_gaji_tunjangan_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_spp_ls_gaji_tunjangan_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan_grid->TotalRecs == 0 && $vw_spp_ls_gaji_tunjangan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_ls_gaji_tunjangan_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->Export == "") { ?>
<script type="text/javascript">
fvw_spp_ls_gaji_tunjangangrid.Init();
</script>
<?php } ?>
<?php
$vw_spp_ls_gaji_tunjangan_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_spp_ls_gaji_tunjangan_grid->Page_Terminate();
?>
