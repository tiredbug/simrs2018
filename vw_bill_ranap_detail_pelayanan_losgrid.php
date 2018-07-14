<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_bill_ranap_detail_pelayanan_los_grid)) $vw_bill_ranap_detail_pelayanan_los_grid = new cvw_bill_ranap_detail_pelayanan_los_grid();

// Page init
$vw_bill_ranap_detail_pelayanan_los_grid->Page_Init();

// Page main
$vw_bill_ranap_detail_pelayanan_los_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_pelayanan_los_grid->Page_Render();
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_bill_ranap_detail_pelayanan_losgrid = new ew_Form("fvw_bill_ranap_detail_pelayanan_losgrid", "grid");
fvw_bill_ranap_detail_pelayanan_losgrid.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName ?>';

// Validate form
fvw_bill_ranap_detail_pelayanan_losgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldCaption(), $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_pelayanan_los->tarif->FldCaption(), $vw_bill_ranap_detail_pelayanan_los->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_pelayanan_los->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_pelayanan_los->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_pelayanan_los->user->FldCaption(), $vw_bill_ranap_detail_pelayanan_los->user->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_ruang");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_pelayanan_los->no_ruang->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_bill_ranap_detail_pelayanan_losgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kode_tindakan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tarif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "user", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_ruang", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_bill_ranap_detail_pelayanan_losgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_pelayanan_losgrid.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_pelayanan_losgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_pelayanan_losgrid.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
</script>
<?php } ?>
<?php
if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd") {
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "copy") {
		$bSelectLimit = $vw_bill_ranap_detail_pelayanan_los_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs = $vw_bill_ranap_detail_pelayanan_los->SelectRecordCount();
			$vw_bill_ranap_detail_pelayanan_los_grid->Recordset = $vw_bill_ranap_detail_pelayanan_los_grid->LoadRecordset($vw_bill_ranap_detail_pelayanan_los_grid->StartRec-1, $vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs);
		} else {
			if ($vw_bill_ranap_detail_pelayanan_los_grid->Recordset = $vw_bill_ranap_detail_pelayanan_los_grid->LoadRecordset())
				$vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs = $vw_bill_ranap_detail_pelayanan_los_grid->Recordset->RecordCount();
		}
		$vw_bill_ranap_detail_pelayanan_los_grid->StartRec = 1;
		$vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs = $vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs;
	} else {
		$vw_bill_ranap_detail_pelayanan_los->CurrentFilter = "0=1";
		$vw_bill_ranap_detail_pelayanan_los_grid->StartRec = 1;
		$vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs = $vw_bill_ranap_detail_pelayanan_los->GridAddRowCount;
	}
	$vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs = $vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs;
	$vw_bill_ranap_detail_pelayanan_los_grid->StopRec = $vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_bill_ranap_detail_pelayanan_los_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs <= 0)
			$vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs = $vw_bill_ranap_detail_pelayanan_los->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_pelayanan_los_grid->Recordset && ($vw_bill_ranap_detail_pelayanan_los_grid->Recordset = $vw_bill_ranap_detail_pelayanan_los_grid->LoadRecordset()))
			$vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs = $vw_bill_ranap_detail_pelayanan_los_grid->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_pelayanan_los_grid->StartRec = 1;
	$vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs = $vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_bill_ranap_detail_pelayanan_los_grid->Recordset = $vw_bill_ranap_detail_pelayanan_los_grid->LoadRecordset($vw_bill_ranap_detail_pelayanan_los_grid->StartRec-1, $vw_bill_ranap_detail_pelayanan_los_grid->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "" && $vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_pelayanan_los_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_pelayanan_los_grid->SearchWhere == "0=101")
			$vw_bill_ranap_detail_pelayanan_los_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_pelayanan_los_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_bill_ranap_detail_pelayanan_los_grid->RenderOtherOptions();
?>
<?php $vw_bill_ranap_detail_pelayanan_los_grid->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_pelayanan_los_grid->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs > 0 || $vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_pelayanan_los">
<div id="fvw_bill_ranap_detail_pelayanan_losgrid" class="ewForm form-inline">
<div id="gmp_vw_bill_ranap_detail_pelayanan_los" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_bill_ranap_detail_pelayanan_losgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_pelayanan_los->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_pelayanan_los_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_pelayanan_los_grid->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div><div id="elh_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div><div id="elh_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div><div id="elh_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div><div id="elh_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->user->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->Visible) { // no_ruang ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->no_ruang) == "") { ?>
		<th data-name="no_ruang"><div id="elh_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ruang"><div><div id="elh_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->no_ruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_bill_ranap_detail_pelayanan_los_grid->StartRec = 1;
$vw_bill_ranap_detail_pelayanan_los_grid->StopRec = $vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName) && ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd" || $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit" || $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "F")) {
		$vw_bill_ranap_detail_pelayanan_los_grid->KeyCount = $objForm->GetValue($vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName);
		$vw_bill_ranap_detail_pelayanan_los_grid->StopRec = $vw_bill_ranap_detail_pelayanan_los_grid->StartRec + $vw_bill_ranap_detail_pelayanan_los_grid->KeyCount - 1;
	}
}
$vw_bill_ranap_detail_pelayanan_los_grid->RecCnt = $vw_bill_ranap_detail_pelayanan_los_grid->StartRec - 1;
if ($vw_bill_ranap_detail_pelayanan_los_grid->Recordset && !$vw_bill_ranap_detail_pelayanan_los_grid->Recordset->EOF) {
	$vw_bill_ranap_detail_pelayanan_los_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_pelayanan_los_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_pelayanan_los_grid->StartRec > 1)
		$vw_bill_ranap_detail_pelayanan_los_grid->Recordset->Move($vw_bill_ranap_detail_pelayanan_los_grid->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_pelayanan_los->AllowAddDeleteRow && $vw_bill_ranap_detail_pelayanan_los_grid->StopRec == 0) {
	$vw_bill_ranap_detail_pelayanan_los_grid->StopRec = $vw_bill_ranap_detail_pelayanan_los->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_pelayanan_los->ResetAttrs();
$vw_bill_ranap_detail_pelayanan_los_grid->RenderRow();
if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd")
	$vw_bill_ranap_detail_pelayanan_los_grid->RowIndex = 0;
if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit")
	$vw_bill_ranap_detail_pelayanan_los_grid->RowIndex = 0;
while ($vw_bill_ranap_detail_pelayanan_los_grid->RecCnt < $vw_bill_ranap_detail_pelayanan_los_grid->StopRec) {
	$vw_bill_ranap_detail_pelayanan_los_grid->RecCnt++;
	if (intval($vw_bill_ranap_detail_pelayanan_los_grid->RecCnt) >= intval($vw_bill_ranap_detail_pelayanan_los_grid->StartRec)) {
		$vw_bill_ranap_detail_pelayanan_los_grid->RowCnt++;
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd" || $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit" || $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "F") {
			$vw_bill_ranap_detail_pelayanan_los_grid->RowIndex++;
			$objForm->Index = $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex;
			if ($objForm->HasValue($vw_bill_ranap_detail_pelayanan_los_grid->FormActionName))
				$vw_bill_ranap_detail_pelayanan_los_grid->RowAction = strval($objForm->GetValue($vw_bill_ranap_detail_pelayanan_los_grid->FormActionName));
			elseif ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd")
				$vw_bill_ranap_detail_pelayanan_los_grid->RowAction = "insert";
			else
				$vw_bill_ranap_detail_pelayanan_los_grid->RowAction = "";
		}

		// Set up key count
		$vw_bill_ranap_detail_pelayanan_los_grid->KeyCount = $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_pelayanan_los->ResetAttrs();
		$vw_bill_ranap_detail_pelayanan_los->CssClass = "";
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd") {
			if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "copy") {
				$vw_bill_ranap_detail_pelayanan_los_grid->LoadRowValues($vw_bill_ranap_detail_pelayanan_los_grid->Recordset); // Load row values
				$vw_bill_ranap_detail_pelayanan_los_grid->SetRecordKey($vw_bill_ranap_detail_pelayanan_los_grid->RowOldKey, $vw_bill_ranap_detail_pelayanan_los_grid->Recordset); // Set old record key
			} else {
				$vw_bill_ranap_detail_pelayanan_los_grid->LoadDefaultValues(); // Load default values
				$vw_bill_ranap_detail_pelayanan_los_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_bill_ranap_detail_pelayanan_los_grid->LoadRowValues($vw_bill_ranap_detail_pelayanan_los_grid->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd") // Grid add
			$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd" && $vw_bill_ranap_detail_pelayanan_los->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_bill_ranap_detail_pelayanan_los_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_pelayanan_los_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit") { // Grid edit
			if ($vw_bill_ranap_detail_pelayanan_los->EventCancelled) {
				$vw_bill_ranap_detail_pelayanan_los_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_pelayanan_los_grid->RowIndex); // Restore form values
			}
			if ($vw_bill_ranap_detail_pelayanan_los_grid->RowAction == "insert")
				$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit" && ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) && $vw_bill_ranap_detail_pelayanan_los->EventCancelled) // Update failed
			$vw_bill_ranap_detail_pelayanan_los_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_pelayanan_los_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_bill_ranap_detail_pelayanan_los_grid->EditRowCnt++;
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "F") // Confirm row
			$vw_bill_ranap_detail_pelayanan_los_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_pelayanan_los_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_pelayanan_los->RowAttrs = array_merge($vw_bill_ranap_detail_pelayanan_los->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_pelayanan_los_grid->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt . '_vw_bill_ranap_detail_pelayanan_los', 'data-rowtype'=>$vw_bill_ranap_detail_pelayanan_los->RowType));

		// Render row
		$vw_bill_ranap_detail_pelayanan_los_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_pelayanan_los_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_bill_ranap_detail_pelayanan_los_grid->RowAction <> "delete" && $vw_bill_ranap_detail_pelayanan_los_grid->RowAction <> "insertdelete" && !($vw_bill_ranap_detail_pelayanan_los_grid->RowAction == "insert" && $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "F" && $vw_bill_ranap_detail_pelayanan_los_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_bill_ranap_detail_pelayanan_los->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="form-group vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" style="white-space: nowrap; z-index: <?php echo (9000 - $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditValue ?>" size="55" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.CreateAutoSuggest({"id":"x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan","forceSelect":true});
</script>
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="form-group vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" style="white-space: nowrap; z-index: <?php echo (9000 - $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditValue ?>" size="55" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.CreateAutoSuggest({"id":"x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan","forceSelect":true});
</script>
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->PageObjName . "_row_" . $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_id" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_pelayanan_los->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_tarif" class="form-group vw_bill_ranap_detail_pelayanan_los_tarif">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_tarif" class="form-group vw_bill_ranap_detail_pelayanan_los_tarif">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_qty" class="form-group vw_bill_ranap_detail_pelayanan_los_qty">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_qty" class="form-group vw_bill_ranap_detail_pelayanan_los_qty">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_pelayanan_los->user->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_user" class="form-group vw_bill_ranap_detail_pelayanan_los_user">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_user" class="form-group vw_bill_ranap_detail_pelayanan_los_user">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->user->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang"<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="form-group vw_bill_ranap_detail_pelayanan_los_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="form-group vw_bill_ranap_detail_pelayanan_los_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="fvw_bill_ranap_detail_pelayanan_losgrid$x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="fvw_bill_ranap_detail_pelayanan_losgrid$o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt);
?>
	</tr>
<?php if ($vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_ADD || $vw_bill_ranap_detail_pelayanan_los->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "gridadd" || $vw_bill_ranap_detail_pelayanan_los->CurrentMode == "copy")
		if (!$vw_bill_ranap_detail_pelayanan_los_grid->Recordset->EOF) $vw_bill_ranap_detail_pelayanan_los_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "add" || $vw_bill_ranap_detail_pelayanan_los->CurrentMode == "copy" || $vw_bill_ranap_detail_pelayanan_los->CurrentMode == "edit") {
		$vw_bill_ranap_detail_pelayanan_los_grid->RowIndex = '$rowindex$';
		$vw_bill_ranap_detail_pelayanan_los_grid->LoadDefaultValues();

		// Set row properties
		$vw_bill_ranap_detail_pelayanan_los->ResetAttrs();
		$vw_bill_ranap_detail_pelayanan_los->RowAttrs = array_merge($vw_bill_ranap_detail_pelayanan_los->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_pelayanan_los_grid->RowIndex, 'id'=>'r0_vw_bill_ranap_detail_pelayanan_los', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_bill_ranap_detail_pelayanan_los->RowAttrs["class"], "ewTemplate");
		$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_bill_ranap_detail_pelayanan_los_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_pelayanan_los_grid->RenderListOptions();
		$vw_bill_ranap_detail_pelayanan_los_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_bill_ranap_detail_pelayanan_los->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex);
?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="form-group vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" style="white-space: nowrap; z-index: <?php echo (9000 - $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="sv_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditValue ?>" size="55" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getPlaceHolder()) ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="q_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.CreateAutoSuggest({"id":"x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan","forceSelect":true});
</script>
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif">
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="form-group vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->Visible) { // tarif ?>
		<td data-name="tarif">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_tarif" class="form-group vw_bill_ranap_detail_pelayanan_los_tarif">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_tarif" class="form-group vw_bill_ranap_detail_pelayanan_los_tarif">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->tarif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->qty->Visible) { // qty ?>
		<td data-name="qty">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_qty" class="form-group vw_bill_ranap_detail_pelayanan_los_qty">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_qty" class="form-group vw_bill_ranap_detail_pelayanan_los_qty">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->user->Visible) { // user ?>
		<td data-name="user">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_user" class="form-group vw_bill_ranap_detail_pelayanan_los_user">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->user->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_user" class="form-group vw_bill_ranap_detail_pelayanan_los_user">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->user->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_pelayanan_los->user->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->user->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="form-group vw_bill_ranap_detail_pelayanan_los_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="form-group vw_bill_ranap_detail_pelayanan_los_no_ruang">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_pelayanan_los" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los->no_ruang->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_pelayanan_los_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_pelayanan_los_grid->RowCnt);
?>
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "add" || $vw_bill_ranap_detail_pelayanan_los->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_pelayanan_los_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_bill_ranap_detail_pelayanan_losgrid">
</div>
<?php

// Close recordset
if ($vw_bill_ranap_detail_pelayanan_los_grid->Recordset)
	$vw_bill_ranap_detail_pelayanan_los_grid->Recordset->Close();
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_bill_ranap_detail_pelayanan_los_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_grid->TotalRecs == 0 && $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_pelayanan_los_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->Export == "") { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_losgrid.Init();
</script>
<?php } ?>
<?php
$vw_bill_ranap_detail_pelayanan_los_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_bill_ranap_detail_pelayanan_los_grid->Page_Terminate();
?>
