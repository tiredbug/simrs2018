<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_bill_ranap_detail_tindakan_penunjang_grid)) $vw_bill_ranap_detail_tindakan_penunjang_grid = new cvw_bill_ranap_detail_tindakan_penunjang_grid();

// Page init
$vw_bill_ranap_detail_tindakan_penunjang_grid->Page_Init();

// Page main
$vw_bill_ranap_detail_tindakan_penunjang_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_tindakan_penunjang_grid->Page_Render();
?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_bill_ranap_detail_tindakan_penunjanggrid = new ew_Form("fvw_bill_ranap_detail_tindakan_penunjanggrid", "grid");
fvw_bill_ranap_detail_tindakan_penunjanggrid.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName ?>';

// Validate form
fvw_bill_ranap_detail_tindakan_penunjanggrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_penunjang->tanggal->FldCaption(), $vw_bill_ranap_detail_tindakan_penunjang->tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_penunjang->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FldCaption(), $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_penunjang->tarif->FldCaption(), $vw_bill_ranap_detail_tindakan_penunjang->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_penunjang->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_penunjang->bhp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_penunjang->qty->FldCaption(), $vw_bill_ranap_detail_tindakan_penunjang->qty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_penunjang->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_penunjang->user->FldCaption(), $vw_bill_ranap_detail_tindakan_penunjang->user->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_bill_ranap_detail_tindakan_penunjanggrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_tindakan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tarif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bhp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "user", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_bill_ranap_detail_tindakan_penunjanggrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_tindakan_penunjanggrid.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_tindakan_penunjanggrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_tindakan_penunjanggrid.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
</script>
<?php } ?>
<?php
if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd") {
	if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "copy") {
		$bSelectLimit = $vw_bill_ranap_detail_tindakan_penunjang_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_penunjang->SelectRecordCount();
			$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset = $vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRecordset($vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec-1, $vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs);
		} else {
			if ($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset = $vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRecordset())
				$vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->RecordCount();
		}
		$vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec = 1;
		$vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs;
	} else {
		$vw_bill_ranap_detail_tindakan_penunjang->CurrentFilter = "0=1";
		$vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec = 1;
		$vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_penunjang->GridAddRowCount;
	}
	$vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs;
	$vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec = $vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_penunjang_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs <= 0)
			$vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_penunjang->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset && ($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset = $vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRecordset()))
			$vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec = 1;
	$vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset = $vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRecordset($vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec-1, $vw_bill_ranap_detail_tindakan_penunjang_grid->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "" && $vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_tindakan_penunjang_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_tindakan_penunjang_grid->SearchWhere == "0=101")
			$vw_bill_ranap_detail_tindakan_penunjang_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_tindakan_penunjang_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderOtherOptions();
?>
<?php $vw_bill_ranap_detail_tindakan_penunjang_grid->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_tindakan_penunjang_grid->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs > 0 || $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_tindakan_penunjang">
<div id="fvw_bill_ranap_detail_tindakan_penunjanggrid" class="ewForm form-inline">
<div id="gmp_vw_bill_ranap_detail_tindakan_penunjang" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_bill_ranap_detail_tindakan_penunjanggrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_tindakan_penunjang_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tanggal->Visible) { // tanggal ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->tanggal) == "") { ?>
		<th data-name="tanggal"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="vw_bill_ranap_detail_tindakan_penunjang_tanggal"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="vw_bill_ranap_detail_tindakan_penunjang_tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->tanggal->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->tanggal->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="vw_bill_ranap_detail_tindakan_penunjang_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="vw_bill_ranap_detail_tindakan_penunjang_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->bhp->Visible) { // bhp ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->bhp) == "") { ?>
		<th data-name="bhp"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="vw_bill_ranap_detail_tindakan_penunjang_bhp"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bhp"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="vw_bill_ranap_detail_tindakan_penunjang_bhp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->bhp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->bhp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_qty" class="vw_bill_ranap_detail_tindakan_penunjang_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_qty" class="vw_bill_ranap_detail_tindakan_penunjang_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->SortUrl($vw_bill_ranap_detail_tindakan_penunjang->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_user" class="vw_bill_ranap_detail_tindakan_penunjang_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div><div id="elh_vw_bill_ranap_detail_tindakan_penunjang_user" class="vw_bill_ranap_detail_tindakan_penunjang_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_penunjang->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_penunjang->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec = 1;
$vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec = $vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName) && ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "F")) {
		$vw_bill_ranap_detail_tindakan_penunjang_grid->KeyCount = $objForm->GetValue($vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName);
		$vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec = $vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec + $vw_bill_ranap_detail_tindakan_penunjang_grid->KeyCount - 1;
	}
}
$vw_bill_ranap_detail_tindakan_penunjang_grid->RecCnt = $vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec - 1;
if ($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset && !$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->EOF) {
	$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_penunjang_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec > 1)
		$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->Move($vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_tindakan_penunjang->AllowAddDeleteRow && $vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec == 0) {
	$vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec = $vw_bill_ranap_detail_tindakan_penunjang->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_tindakan_penunjang->ResetAttrs();
$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderRow();
if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd")
	$vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex = 0;
if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridedit")
	$vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex = 0;
while ($vw_bill_ranap_detail_tindakan_penunjang_grid->RecCnt < $vw_bill_ranap_detail_tindakan_penunjang_grid->StopRec) {
	$vw_bill_ranap_detail_tindakan_penunjang_grid->RecCnt++;
	if (intval($vw_bill_ranap_detail_tindakan_penunjang_grid->RecCnt) >= intval($vw_bill_ranap_detail_tindakan_penunjang_grid->StartRec)) {
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt++;
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "F") {
			$vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex++;
			$objForm->Index = $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex;
			if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_penunjang_grid->FormActionName))
				$vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction = strval($objForm->GetValue($vw_bill_ranap_detail_tindakan_penunjang_grid->FormActionName));
			elseif ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd")
				$vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction = "insert";
			else
				$vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction = "";
		}

		// Set up key count
		$vw_bill_ranap_detail_tindakan_penunjang_grid->KeyCount = $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_tindakan_penunjang->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_penunjang->CssClass = "";
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd") {
			if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "copy") {
				$vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRowValues($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset); // Load row values
				$vw_bill_ranap_detail_tindakan_penunjang_grid->SetRecordKey($vw_bill_ranap_detail_tindakan_penunjang_grid->RowOldKey, $vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset); // Set old record key
			} else {
				$vw_bill_ranap_detail_tindakan_penunjang_grid->LoadDefaultValues(); // Load default values
				$vw_bill_ranap_detail_tindakan_penunjang_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_bill_ranap_detail_tindakan_penunjang_grid->LoadRowValues($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd") // Grid add
			$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridadd" && $vw_bill_ranap_detail_tindakan_penunjang->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_bill_ranap_detail_tindakan_penunjang_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridedit") { // Grid edit
			if ($vw_bill_ranap_detail_tindakan_penunjang->EventCancelled) {
				$vw_bill_ranap_detail_tindakan_penunjang_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex); // Restore form values
			}
			if ($vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction == "insert")
				$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "gridedit" && ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) && $vw_bill_ranap_detail_tindakan_penunjang->EventCancelled) // Update failed
			$vw_bill_ranap_detail_tindakan_penunjang_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_bill_ranap_detail_tindakan_penunjang_grid->EditRowCnt++;
		if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "F") // Confirm row
			$vw_bill_ranap_detail_tindakan_penunjang_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_tindakan_penunjang->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_penunjang->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt . '_vw_bill_ranap_detail_tindakan_penunjang', 'data-rowtype'=>$vw_bill_ranap_detail_tindakan_penunjang->RowType));

		// Render row
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction <> "delete" && $vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction <> "insertdelete" && !($vw_bill_ranap_detail_tindakan_penunjang_grid->RowAction == "insert" && $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "F" && $vw_bill_ranap_detail_tindakan_penunjang_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_penunjang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_penunjang->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_penunjang->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_penunjanggrid", "x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_penunjang->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_penunjang->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_penunjanggrid", "x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="vw_bill_ranap_detail_tindakan_penunjang_tanggal">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->PageObjName . "_row_" . $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_id" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="vw_bill_ranap_detail_tindakan_penunjang_tarif">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->bhp->Visible) { // bhp ?>
		<td data-name="bhp"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="form-group vw_bill_ranap_detail_tindakan_penunjang_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="form-group vw_bill_ranap_detail_tindakan_penunjang_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="vw_bill_ranap_detail_tindakan_penunjang_bhp">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_qty" class="form-group vw_bill_ranap_detail_tindakan_penunjang_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_qty" class="form-group vw_bill_ranap_detail_tindakan_penunjang_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_qty" class="vw_bill_ranap_detail_tindakan_penunjang_qty">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_user" class="form-group vw_bill_ranap_detail_tindakan_penunjang_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_user" class="form-group vw_bill_ranap_detail_tindakan_penunjang_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_penunjang_user" class="vw_bill_ranap_detail_tindakan_penunjang_user">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_tindakan_penunjanggrid$o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt);
?>
	</tr>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_ADD || $vw_bill_ranap_detail_tindakan_penunjang->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_penunjanggrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "gridadd" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "copy")
		if (!$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->EOF) $vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "add" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "copy" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "edit") {
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex = '$rowindex$';
		$vw_bill_ranap_detail_tindakan_penunjang_grid->LoadDefaultValues();

		// Set row properties
		$vw_bill_ranap_detail_tindakan_penunjang->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_penunjang->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_penunjang->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex, 'id'=>'r0_vw_bill_ranap_detail_tindakan_penunjang', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_bill_ranap_detail_tindakan_penunjang->RowAttrs["class"], "ewTemplate");
		$vw_bill_ranap_detail_tindakan_penunjang->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_penunjang_grid->RenderListOptions();
		$vw_bill_ranap_detail_tindakan_penunjang_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_penunjang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_penunjang->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_penunjang->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_penunjang->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_penunjanggrid", "x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_tanggal" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tanggal">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tanggal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp">
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_penunjang_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->kode_tindakan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->tarif->Visible) { // tarif ?>
		<td data-name="tarif">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_tarif" class="form-group vw_bill_ranap_detail_tindakan_penunjang_tarif">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->tarif->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->tarif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->bhp->Visible) { // bhp ?>
		<td data-name="bhp">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="form-group vw_bill_ranap_detail_tindakan_penunjang_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_bhp" class="form-group vw_bill_ranap_detail_tindakan_penunjang_bhp">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->bhp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->bhp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->qty->Visible) { // qty ?>
		<td data-name="qty">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_qty" class="form-group vw_bill_ranap_detail_tindakan_penunjang_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_qty" class="form-group vw_bill_ranap_detail_tindakan_penunjang_qty">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->qty->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_penunjang->user->Visible) { // user ?>
		<td data-name="user">
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_user" class="form-group vw_bill_ranap_detail_tindakan_penunjang_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_penunjang_user" class="form-group vw_bill_ranap_detail_tindakan_penunjang_user">
<span<?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_penunjang->user->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_penunjang" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_penunjang->user->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_penunjang_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_penunjang_grid->RowCnt);
?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_penunjanggrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "add" || $vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_penunjang_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_bill_ranap_detail_tindakan_penunjanggrid">
</div>
<?php

// Close recordset
if ($vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset)
	$vw_bill_ranap_detail_tindakan_penunjang_grid->Recordset->Close();
?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_penunjang_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang_grid->TotalRecs == 0 && $vw_bill_ranap_detail_tindakan_penunjang->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_penunjang_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_penunjang->Export == "") { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_penunjanggrid.Init();
</script>
<?php } ?>
<?php
$vw_bill_ranap_detail_tindakan_penunjang_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_bill_ranap_detail_tindakan_penunjang_grid->Page_Terminate();
?>
