<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_spp_pengembalian_penerimaan_detail_belanja_grid)) $vw_spp_pengembalian_penerimaan_detail_belanja_grid = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid();

// Page init
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Page_Init();

// Page main
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Page_Render();
?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_spp_pengembalian_penerimaan_detail_belanjagrid = new ew_Form("fvw_spp_pengembalian_penerimaan_detail_belanjagrid", "grid");
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.FormKeyCountName = '<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName ?>';

// Validate form
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FldCaption(), $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FldCaption(), $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kd_rekening_belanja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah_belanja", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.ValidateRequired = true;
<?php } else { ?>
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd") {
	if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "copy") {
		$bSelectLimit = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs = $vw_spp_pengembalian_penerimaan_detail_belanja->SelectRecordCount();
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRecordset($vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec-1, $vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs);
		} else {
			if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRecordset())
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->RecordCount();
		}
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec = 1;
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs;
	} else {
		$vw_spp_pengembalian_penerimaan_detail_belanja->CurrentFilter = "0=1";
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec = 1;
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs = $vw_spp_pengembalian_penerimaan_detail_belanja->GridAddRowCount;
	}
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs;
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs <= 0)
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs = $vw_spp_pengembalian_penerimaan_detail_belanja->SelectRecordCount();
	} else {
		if (!$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset && ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRecordset()))
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->RecordCount();
	}
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec = 1;
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRecordset($vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec-1, $vw_spp_pengembalian_penerimaan_detail_belanja_grid->DisplayRecs);

	// Set no record found message
	if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "" && $vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->SearchWhere == "0=101")
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderOtherOptions();
?>
<?php $vw_spp_pengembalian_penerimaan_detail_belanja_grid->ShowPageHeader(); ?>
<?php
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ShowMessage();
?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs > 0 || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_spp_pengembalian_penerimaan_detail_belanja">
<div id="fvw_spp_pengembalian_penerimaan_detail_belanjagrid" class="ewForm form-inline">
<div id="gmp_vw_spp_pengembalian_penerimaan_detail_belanja" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_spp_pengembalian_penerimaan_detail_belanjagrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderListOptions();

// Render list options (header, left)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->SortUrl($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja) == "") { ?>
		<th data-name="kd_rekening_belanja"><div id="elh_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_rekening_belanja"><div><div id="elh_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->SortUrl($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja) == "") { ?>
		<th data-name="jumlah_belanja"><div id="elh_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_belanja"><div><div id="elh_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec = 1;
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName) && ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridedit" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "F")) {
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->KeyCount = $objForm->GetValue($vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName);
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec + $vw_spp_pengembalian_penerimaan_detail_belanja_grid->KeyCount - 1;
	}
}
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RecCnt = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec - 1;
if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset && !$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->EOF) {
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec > 1)
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->Move($vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec - 1);
} elseif (!$vw_spp_pengembalian_penerimaan_detail_belanja->AllowAddDeleteRow && $vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec == 0) {
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec = $vw_spp_pengembalian_penerimaan_detail_belanja->GridAddRowCount;
}

// Initialize aggregate
$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_spp_pengembalian_penerimaan_detail_belanja->ResetAttrs();
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderRow();
if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd")
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex = 0;
if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridedit")
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex = 0;
while ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RecCnt < $vw_spp_pengembalian_penerimaan_detail_belanja_grid->StopRec) {
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RecCnt++;
	if (intval($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RecCnt) >= intval($vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRec)) {
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt++;
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridedit" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "F") {
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex++;
			$objForm->Index = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex;
			if ($objForm->HasValue($vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormActionName))
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction = strval($objForm->GetValue($vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormActionName));
			elseif ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd")
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction = "insert";
			else
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction = "";
		}

		// Set up key count
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->KeyCount = $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex;

		// Init row class and style
		$vw_spp_pengembalian_penerimaan_detail_belanja->ResetAttrs();
		$vw_spp_pengembalian_penerimaan_detail_belanja->CssClass = "";
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd") {
			if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "copy") {
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRowValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset); // Load row values
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->SetRecordKey($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowOldKey, $vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset); // Set old record key
			} else {
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadDefaultValues(); // Load default values
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadRowValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset); // Load row values
		}
		$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd") // Grid add
			$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridadd" && $vw_spp_pengembalian_penerimaan_detail_belanja->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RestoreCurrentRowFormValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex); // Restore form values
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridedit") { // Grid edit
			if ($vw_spp_pengembalian_penerimaan_detail_belanja->EventCancelled) {
				$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RestoreCurrentRowFormValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex); // Restore form values
			}
			if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction == "insert")
				$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "gridedit" && ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT || $vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_ADD) && $vw_spp_pengembalian_penerimaan_detail_belanja->EventCancelled) // Update failed
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RestoreCurrentRowFormValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex); // Restore form values
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->EditRowCnt++;
		if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "F") // Confirm row
			$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RestoreCurrentRowFormValues($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_spp_pengembalian_penerimaan_detail_belanja->RowAttrs = array_merge($vw_spp_pengembalian_penerimaan_detail_belanja->RowAttrs, array('data-rowindex'=>$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt, 'id'=>'r' . $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt . '_vw_spp_pengembalian_penerimaan_detail_belanja', 'data-rowtype'=>$vw_spp_pengembalian_penerimaan_detail_belanja->RowType));

		// Render row
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderRow();

		// Render list options
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction <> "delete" && $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction <> "insertdelete" && !($vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowAction == "insert" && $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "F" && $vw_spp_pengembalian_penerimaan_detail_belanja_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("body", "left", $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt);
?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->CellAttributes() ?>>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
<span<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->PageObjName . "_row_" . $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_id" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_id" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_id" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->CellAttributes() ?>>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt ?>_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
<span<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->ListViewValue() ?></span>
</span>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="fvw_spp_pengembalian_penerimaan_detail_belanjagrid$o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("body", "right", $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt);
?>
	</tr>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_ADD || $vw_spp_pengembalian_penerimaan_detail_belanja->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.UpdateOpts(<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "gridadd" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "copy")
		if (!$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->EOF) $vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "add" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "copy" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "edit") {
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex = '$rowindex$';
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->LoadDefaultValues();

		// Set row properties
		$vw_spp_pengembalian_penerimaan_detail_belanja->ResetAttrs();
		$vw_spp_pengembalian_penerimaan_detail_belanja->RowAttrs = array_merge($vw_spp_pengembalian_penerimaan_detail_belanja->RowAttrs, array('data-rowindex'=>$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex, 'id'=>'r0_vw_spp_pengembalian_penerimaan_detail_belanja', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_spp_pengembalian_penerimaan_detail_belanja->RowAttrs["class"], "ewTemplate");
		$vw_spp_pengembalian_penerimaan_detail_belanja->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderRow();

		// Render list options
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->RenderListOptions();
		$vw_spp_pengembalian_penerimaan_detail_belanja_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("body", "left", $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex);
?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
		<td data-name="kd_rekening_belanja">
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_kd_rekening_belanja">
<span<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_kd_rekening_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_kd_rekening_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->kd_rekening_belanja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja">
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
<input type="text" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja" class="form-group vw_spp_pengembalian_penerimaan_detail_belanja_jumlah_belanja">
<span<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_spp_pengembalian_penerimaan_detail_belanja" data-field="x_jumlah_belanja" name="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_detail_belanja->jumlah_belanja->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ListOptions->Render("body", "right", $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowCnt);
?>
<script type="text/javascript">
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.UpdateOpts(<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "add" || $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->KeyCount ?>">
<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName ?>" id="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->FormKeyCountName ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->KeyCount ?>">
<?php echo $vw_spp_pengembalian_penerimaan_detail_belanja_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_spp_pengembalian_penerimaan_detail_belanjagrid">
</div>
<?php

// Close recordset
if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset)
	$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Recordset->Close();
?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->TotalRecs == 0 && $vw_spp_pengembalian_penerimaan_detail_belanja->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_pengembalian_penerimaan_detail_belanja_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_detail_belanja->Export == "") { ?>
<script type="text/javascript">
fvw_spp_pengembalian_penerimaan_detail_belanjagrid.Init();
</script>
<?php } ?>
<?php
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_spp_pengembalian_penerimaan_detail_belanja_grid->Page_Terminate();
?>
