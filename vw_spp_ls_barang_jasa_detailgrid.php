<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_spp_ls_barang_jasa_detail_grid)) $vw_spp_ls_barang_jasa_detail_grid = new cvw_spp_ls_barang_jasa_detail_grid();

// Page init
$vw_spp_ls_barang_jasa_detail_grid->Page_Init();

// Page main
$vw_spp_ls_barang_jasa_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_barang_jasa_detail_grid->Page_Render();
?>
<?php if ($vw_spp_ls_barang_jasa_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_spp_ls_barang_jasa_detailgrid = new ew_Form("fvw_spp_ls_barang_jasa_detailgrid", "grid");
fvw_spp_ls_barang_jasa_detailgrid.FormKeyCountName = '<?php echo $vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName ?>';

// Validate form
fvw_spp_ls_barang_jasa_detailgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kd_rekening_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FldCaption(), $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_barang_jasa_detail->jumlah_belanja->FldCaption(), $vw_spp_ls_barang_jasa_detail->jumlah_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_barang_jasa_detail->jumlah_belanja->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_spp_ls_barang_jasa_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_rekening_belanja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah_belanja", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_spp_ls_barang_jasa_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_barang_jasa_detailgrid.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_barang_jasa_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd") {
	if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "copy") {
		$bSelectLimit = $vw_spp_ls_barang_jasa_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_spp_ls_barang_jasa_detail_grid->TotalRecs = $vw_spp_ls_barang_jasa_detail->SelectRecordCount();
			$vw_spp_ls_barang_jasa_detail_grid->Recordset = $vw_spp_ls_barang_jasa_detail_grid->LoadRecordset($vw_spp_ls_barang_jasa_detail_grid->StartRec-1, $vw_spp_ls_barang_jasa_detail_grid->DisplayRecs);
		} else {
			if ($vw_spp_ls_barang_jasa_detail_grid->Recordset = $vw_spp_ls_barang_jasa_detail_grid->LoadRecordset())
				$vw_spp_ls_barang_jasa_detail_grid->TotalRecs = $vw_spp_ls_barang_jasa_detail_grid->Recordset->RecordCount();
		}
		$vw_spp_ls_barang_jasa_detail_grid->StartRec = 1;
		$vw_spp_ls_barang_jasa_detail_grid->DisplayRecs = $vw_spp_ls_barang_jasa_detail_grid->TotalRecs;
	} else {
		$vw_spp_ls_barang_jasa_detail->CurrentFilter = "0=1";
		$vw_spp_ls_barang_jasa_detail_grid->StartRec = 1;
		$vw_spp_ls_barang_jasa_detail_grid->DisplayRecs = $vw_spp_ls_barang_jasa_detail->GridAddRowCount;
	}
	$vw_spp_ls_barang_jasa_detail_grid->TotalRecs = $vw_spp_ls_barang_jasa_detail_grid->DisplayRecs;
	$vw_spp_ls_barang_jasa_detail_grid->StopRec = $vw_spp_ls_barang_jasa_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_spp_ls_barang_jasa_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_spp_ls_barang_jasa_detail_grid->TotalRecs <= 0)
			$vw_spp_ls_barang_jasa_detail_grid->TotalRecs = $vw_spp_ls_barang_jasa_detail->SelectRecordCount();
	} else {
		if (!$vw_spp_ls_barang_jasa_detail_grid->Recordset && ($vw_spp_ls_barang_jasa_detail_grid->Recordset = $vw_spp_ls_barang_jasa_detail_grid->LoadRecordset()))
			$vw_spp_ls_barang_jasa_detail_grid->TotalRecs = $vw_spp_ls_barang_jasa_detail_grid->Recordset->RecordCount();
	}
	$vw_spp_ls_barang_jasa_detail_grid->StartRec = 1;
	$vw_spp_ls_barang_jasa_detail_grid->DisplayRecs = $vw_spp_ls_barang_jasa_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_spp_ls_barang_jasa_detail_grid->Recordset = $vw_spp_ls_barang_jasa_detail_grid->LoadRecordset($vw_spp_ls_barang_jasa_detail_grid->StartRec-1, $vw_spp_ls_barang_jasa_detail_grid->DisplayRecs);

	// Set no record found message
	if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "" && $vw_spp_ls_barang_jasa_detail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_spp_ls_barang_jasa_detail_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_spp_ls_barang_jasa_detail_grid->SearchWhere == "0=101")
			$vw_spp_ls_barang_jasa_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_spp_ls_barang_jasa_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_spp_ls_barang_jasa_detail_grid->RenderOtherOptions();
?>
<?php $vw_spp_ls_barang_jasa_detail_grid->ShowPageHeader(); ?>
<?php
$vw_spp_ls_barang_jasa_detail_grid->ShowMessage();
?>
<?php if ($vw_spp_ls_barang_jasa_detail_grid->TotalRecs > 0 || $vw_spp_ls_barang_jasa_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_spp_ls_barang_jasa_detail">
<div id="fvw_spp_ls_barang_jasa_detailgrid" class="ewForm form-inline">
<div id="gmp_vw_spp_ls_barang_jasa_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_spp_ls_barang_jasa_detailgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spp_ls_barang_jasa_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_spp_ls_barang_jasa_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_spp_ls_barang_jasa_detail_grid->RenderListOptions();

// Render list options (header, left)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
	<?php if ($vw_spp_ls_barang_jasa_detail->SortUrl($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja) == "") { ?>
		<th data-name="kd_rekening_belanja"><div id="elh_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="vw_spp_ls_barang_jasa_detail_kd_rekening_belanja"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_rekening_belanja"><div><div id="elh_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_barang_jasa_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<?php if ($vw_spp_ls_barang_jasa_detail->SortUrl($vw_spp_ls_barang_jasa_detail->jumlah_belanja) == "") { ?>
		<th data-name="jumlah_belanja"><div id="elh_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="vw_spp_ls_barang_jasa_detail_jumlah_belanja"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_belanja"><div><div id="elh_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="vw_spp_ls_barang_jasa_detail_jumlah_belanja">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_barang_jasa_detail->jumlah_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_barang_jasa_detail->jumlah_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_spp_ls_barang_jasa_detail_grid->StartRec = 1;
$vw_spp_ls_barang_jasa_detail_grid->StopRec = $vw_spp_ls_barang_jasa_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName) && ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd" || $vw_spp_ls_barang_jasa_detail->CurrentAction == "gridedit" || $vw_spp_ls_barang_jasa_detail->CurrentAction == "F")) {
		$vw_spp_ls_barang_jasa_detail_grid->KeyCount = $objForm->GetValue($vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName);
		$vw_spp_ls_barang_jasa_detail_grid->StopRec = $vw_spp_ls_barang_jasa_detail_grid->StartRec + $vw_spp_ls_barang_jasa_detail_grid->KeyCount - 1;
	}
}
$vw_spp_ls_barang_jasa_detail_grid->RecCnt = $vw_spp_ls_barang_jasa_detail_grid->StartRec - 1;
if ($vw_spp_ls_barang_jasa_detail_grid->Recordset && !$vw_spp_ls_barang_jasa_detail_grid->Recordset->EOF) {
	$vw_spp_ls_barang_jasa_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_spp_ls_barang_jasa_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_spp_ls_barang_jasa_detail_grid->StartRec > 1)
		$vw_spp_ls_barang_jasa_detail_grid->Recordset->Move($vw_spp_ls_barang_jasa_detail_grid->StartRec - 1);
} elseif (!$vw_spp_ls_barang_jasa_detail->AllowAddDeleteRow && $vw_spp_ls_barang_jasa_detail_grid->StopRec == 0) {
	$vw_spp_ls_barang_jasa_detail_grid->StopRec = $vw_spp_ls_barang_jasa_detail->GridAddRowCount;
}

// Initialize aggregate
$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_spp_ls_barang_jasa_detail->ResetAttrs();
$vw_spp_ls_barang_jasa_detail_grid->RenderRow();
if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd")
	$vw_spp_ls_barang_jasa_detail_grid->RowIndex = 0;
if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridedit")
	$vw_spp_ls_barang_jasa_detail_grid->RowIndex = 0;
while ($vw_spp_ls_barang_jasa_detail_grid->RecCnt < $vw_spp_ls_barang_jasa_detail_grid->StopRec) {
	$vw_spp_ls_barang_jasa_detail_grid->RecCnt++;
	if (intval($vw_spp_ls_barang_jasa_detail_grid->RecCnt) >= intval($vw_spp_ls_barang_jasa_detail_grid->StartRec)) {
		$vw_spp_ls_barang_jasa_detail_grid->RowCnt++;
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd" || $vw_spp_ls_barang_jasa_detail->CurrentAction == "gridedit" || $vw_spp_ls_barang_jasa_detail->CurrentAction == "F") {
			$vw_spp_ls_barang_jasa_detail_grid->RowIndex++;
			$objForm->Index = $vw_spp_ls_barang_jasa_detail_grid->RowIndex;
			if ($objForm->HasValue($vw_spp_ls_barang_jasa_detail_grid->FormActionName))
				$vw_spp_ls_barang_jasa_detail_grid->RowAction = strval($objForm->GetValue($vw_spp_ls_barang_jasa_detail_grid->FormActionName));
			elseif ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd")
				$vw_spp_ls_barang_jasa_detail_grid->RowAction = "insert";
			else
				$vw_spp_ls_barang_jasa_detail_grid->RowAction = "";
		}

		// Set up key count
		$vw_spp_ls_barang_jasa_detail_grid->KeyCount = $vw_spp_ls_barang_jasa_detail_grid->RowIndex;

		// Init row class and style
		$vw_spp_ls_barang_jasa_detail->ResetAttrs();
		$vw_spp_ls_barang_jasa_detail->CssClass = "";
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd") {
			if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "copy") {
				$vw_spp_ls_barang_jasa_detail_grid->LoadRowValues($vw_spp_ls_barang_jasa_detail_grid->Recordset); // Load row values
				$vw_spp_ls_barang_jasa_detail_grid->SetRecordKey($vw_spp_ls_barang_jasa_detail_grid->RowOldKey, $vw_spp_ls_barang_jasa_detail_grid->Recordset); // Set old record key
			} else {
				$vw_spp_ls_barang_jasa_detail_grid->LoadDefaultValues(); // Load default values
				$vw_spp_ls_barang_jasa_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_spp_ls_barang_jasa_detail_grid->LoadRowValues($vw_spp_ls_barang_jasa_detail_grid->Recordset); // Load row values
		}
		$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd") // Grid add
			$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridadd" && $vw_spp_ls_barang_jasa_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_spp_ls_barang_jasa_detail_grid->RestoreCurrentRowFormValues($vw_spp_ls_barang_jasa_detail_grid->RowIndex); // Restore form values
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridedit") { // Grid edit
			if ($vw_spp_ls_barang_jasa_detail->EventCancelled) {
				$vw_spp_ls_barang_jasa_detail_grid->RestoreCurrentRowFormValues($vw_spp_ls_barang_jasa_detail_grid->RowIndex); // Restore form values
			}
			if ($vw_spp_ls_barang_jasa_detail_grid->RowAction == "insert")
				$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "gridedit" && ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT || $vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_ADD) && $vw_spp_ls_barang_jasa_detail->EventCancelled) // Update failed
			$vw_spp_ls_barang_jasa_detail_grid->RestoreCurrentRowFormValues($vw_spp_ls_barang_jasa_detail_grid->RowIndex); // Restore form values
		if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_spp_ls_barang_jasa_detail_grid->EditRowCnt++;
		if ($vw_spp_ls_barang_jasa_detail->CurrentAction == "F") // Confirm row
			$vw_spp_ls_barang_jasa_detail_grid->RestoreCurrentRowFormValues($vw_spp_ls_barang_jasa_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_spp_ls_barang_jasa_detail->RowAttrs = array_merge($vw_spp_ls_barang_jasa_detail->RowAttrs, array('data-rowindex'=>$vw_spp_ls_barang_jasa_detail_grid->RowCnt, 'id'=>'r' . $vw_spp_ls_barang_jasa_detail_grid->RowCnt . '_vw_spp_ls_barang_jasa_detail', 'data-rowtype'=>$vw_spp_ls_barang_jasa_detail->RowType));

		// Render row
		$vw_spp_ls_barang_jasa_detail_grid->RenderRow();

		// Render list options
		$vw_spp_ls_barang_jasa_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_spp_ls_barang_jasa_detail_grid->RowAction <> "delete" && $vw_spp_ls_barang_jasa_detail_grid->RowAction <> "insertdelete" && !($vw_spp_ls_barang_jasa_detail_grid->RowAction == "insert" && $vw_spp_ls_barang_jasa_detail->CurrentAction == "F" && $vw_spp_ls_barang_jasa_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_spp_ls_barang_jasa_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("body", "left", $vw_spp_ls_barang_jasa_detail_grid->RowCnt);
?>
	<?php if ($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja"<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->CellAttributes() ?>>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="form-group vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="form-group vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
<span<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->ViewAttributes() ?>>
<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="fvw_spp_ls_barang_jasa_detailgrid$x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="fvw_spp_ls_barang_jasa_detailgrid$x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="fvw_spp_ls_barang_jasa_detailgrid$o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="fvw_spp_ls_barang_jasa_detailgrid$o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_spp_ls_barang_jasa_detail_grid->PageObjName . "_row_" . $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_id" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_id" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT || $vw_spp_ls_barang_jasa_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_id" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_spp_ls_barang_jasa_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja"<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->CellAttributes() ?>>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="form-group vw_spp_ls_barang_jasa_detail_jumlah_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="form-group vw_spp_ls_barang_jasa_detail_jumlah_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowCnt ?>_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="vw_spp_ls_barang_jasa_detail_jumlah_belanja">
<span<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->ViewAttributes() ?>>
<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="fvw_spp_ls_barang_jasa_detailgrid$x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="fvw_spp_ls_barang_jasa_detailgrid$x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="fvw_spp_ls_barang_jasa_detailgrid$o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="fvw_spp_ls_barang_jasa_detailgrid$o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("body", "right", $vw_spp_ls_barang_jasa_detail_grid->RowCnt);
?>
	</tr>
<?php if ($vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_ADD || $vw_spp_ls_barang_jasa_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_spp_ls_barang_jasa_detailgrid.UpdateOpts(<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_spp_ls_barang_jasa_detail->CurrentAction <> "gridadd" || $vw_spp_ls_barang_jasa_detail->CurrentMode == "copy")
		if (!$vw_spp_ls_barang_jasa_detail_grid->Recordset->EOF) $vw_spp_ls_barang_jasa_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "add" || $vw_spp_ls_barang_jasa_detail->CurrentMode == "copy" || $vw_spp_ls_barang_jasa_detail->CurrentMode == "edit") {
		$vw_spp_ls_barang_jasa_detail_grid->RowIndex = '$rowindex$';
		$vw_spp_ls_barang_jasa_detail_grid->LoadDefaultValues();

		// Set row properties
		$vw_spp_ls_barang_jasa_detail->ResetAttrs();
		$vw_spp_ls_barang_jasa_detail->RowAttrs = array_merge($vw_spp_ls_barang_jasa_detail->RowAttrs, array('data-rowindex'=>$vw_spp_ls_barang_jasa_detail_grid->RowIndex, 'id'=>'r0_vw_spp_ls_barang_jasa_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_spp_ls_barang_jasa_detail->RowAttrs["class"], "ewTemplate");
		$vw_spp_ls_barang_jasa_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_spp_ls_barang_jasa_detail_grid->RenderRow();

		// Render list options
		$vw_spp_ls_barang_jasa_detail_grid->RenderListOptions();
		$vw_spp_ls_barang_jasa_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_spp_ls_barang_jasa_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("body", "left", $vw_spp_ls_barang_jasa_detail_grid->RowIndex);
?>
	<?php if ($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja">
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="form-group vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_barang_jasa_detail_kd_rekening_belanja" class="form-group vw_spp_ls_barang_jasa_detail_kd_rekening_belanja">
<span<?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->kd_rekening_belanja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_barang_jasa_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja">
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="form-group vw_spp_ls_barang_jasa_detail_jumlah_belanja">
<input type="text" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_ls_barang_jasa_detail_jumlah_belanja" class="form-group vw_spp_ls_barang_jasa_detail_jumlah_belanja">
<span<?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_barang_jasa_detail->jumlah_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_ls_barang_jasa_detail" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_ls_barang_jasa_detail->jumlah_belanja->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_ls_barang_jasa_detail_grid->ListOptions->Render("body", "right", $vw_spp_ls_barang_jasa_detail_grid->RowCnt);
?>
<script type="text/javascript">
fvw_spp_ls_barang_jasa_detailgrid.UpdateOpts(<?php echo $vw_spp_ls_barang_jasa_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "add" || $vw_spp_ls_barang_jasa_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail_grid->KeyCount ?>">
<?php echo $vw_spp_ls_barang_jasa_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_ls_barang_jasa_detail_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_ls_barang_jasa_detail_grid->KeyCount ?>">
<?php echo $vw_spp_ls_barang_jasa_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_spp_ls_barang_jasa_detailgrid">
</div>
<?php

// Close recordset
if ($vw_spp_ls_barang_jasa_detail_grid->Recordset)
	$vw_spp_ls_barang_jasa_detail_grid->Recordset->Close();
?>
<?php if ($vw_spp_ls_barang_jasa_detail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_spp_ls_barang_jasa_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail_grid->TotalRecs == 0 && $vw_spp_ls_barang_jasa_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_ls_barang_jasa_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_spp_ls_barang_jasa_detail->Export == "") { ?>
<script type="text/javascript">
fvw_spp_ls_barang_jasa_detailgrid.Init();
</script>
<?php } ?>
<?php
$vw_spp_ls_barang_jasa_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_spp_ls_barang_jasa_detail_grid->Page_Terminate();
?>
