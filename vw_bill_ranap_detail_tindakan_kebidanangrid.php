<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($vw_bill_ranap_detail_tindakan_kebidanan_grid)) $vw_bill_ranap_detail_tindakan_kebidanan_grid = new cvw_bill_ranap_detail_tindakan_kebidanan_grid();

// Page init
$vw_bill_ranap_detail_tindakan_kebidanan_grid->Page_Init();

// Page main
$vw_bill_ranap_detail_tindakan_kebidanan_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_tindakan_kebidanan_grid->Page_Render();
?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->Export == "") { ?>
<script type="text/javascript">

// Form object
var fvw_bill_ranap_detail_tindakan_kebidanangrid = new ew_Form("fvw_bill_ranap_detail_tindakan_kebidanangrid", "grid");
fvw_bill_ranap_detail_tindakan_kebidanangrid.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName ?>';

// Validate form
fvw_bill_ranap_detail_tindakan_kebidanangrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FldCaption(), $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_kebidanan->qty->FldCaption(), $vw_bill_ranap_detail_tindakan_kebidanan->qty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_kebidanan->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_kebidanan->tarif->FldCaption(), $vw_bill_ranap_detail_tindakan_kebidanan->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_kebidanan->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_kebidanan->bhp->FldCaption(), $vw_bill_ranap_detail_tindakan_kebidanan->bhp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_kebidanan->bhp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_kebidanan->user->FldCaption(), $vw_bill_ranap_detail_tindakan_kebidanan->user->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fvw_bill_ranap_detail_tindakan_kebidanangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_tindakan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tarif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bhp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "user", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_bill_ranap_detail_tindakan_kebidanangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_tindakan_kebidanangrid.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_tindakan_kebidanangrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_tindakan_kebidanangrid.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
</script>
<?php } ?>
<?php
if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd") {
	if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "copy") {
		$bSelectLimit = $vw_bill_ranap_detail_tindakan_kebidanan_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_kebidanan->SelectRecordCount();
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset = $vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRecordset($vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec-1, $vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs);
		} else {
			if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset = $vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRecordset())
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->RecordCount();
		}
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec = 1;
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs;
	} else {
		$vw_bill_ranap_detail_tindakan_kebidanan->CurrentFilter = "0=1";
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec = 1;
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_kebidanan->GridAddRowCount;
	}
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs;
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec = $vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs;
} else {
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_kebidanan_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs <= 0)
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_kebidanan->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset && ($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset = $vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRecordset()))
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs = $vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec = 1;
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs = $vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset = $vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRecordset($vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec-1, $vw_bill_ranap_detail_tindakan_kebidanan_grid->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "" && $vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->SearchWhere == "0=101")
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderOtherOptions();
?>
<?php $vw_bill_ranap_detail_tindakan_kebidanan_grid->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs > 0 || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_tindakan_kebidanan">
<div id="fvw_bill_ranap_detail_tindakan_kebidanangrid" class="ewForm form-inline">
<div id="gmp_vw_bill_ranap_detail_tindakan_kebidanan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_vw_bill_ranap_detail_tindakan_kebidanangrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Visible) { // tanggal ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->tanggal) == "") { ?>
		<th data-name="tanggal"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="vw_bill_ranap_detail_tindakan_kebidanan_tanggal"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="vw_bill_ranap_detail_tindakan_kebidanan_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="vw_bill_ranap_detail_tindakan_kebidanan_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="vw_bill_ranap_detail_tindakan_kebidanan_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="vw_bill_ranap_detail_tindakan_kebidanan_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->bhp->Visible) { // bhp ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->bhp) == "") { ?>
		<th data-name="bhp"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="vw_bill_ranap_detail_tindakan_kebidanan_bhp"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bhp"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="vw_bill_ranap_detail_tindakan_kebidanan_bhp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->bhp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->bhp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->SortUrl($vw_bill_ranap_detail_tindakan_kebidanan->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_user" class="vw_bill_ranap_detail_tindakan_kebidanan_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div><div id="elh_vw_bill_ranap_detail_tindakan_kebidanan_user" class="vw_bill_ranap_detail_tindakan_kebidanan_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_kebidanan->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_kebidanan->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec = 1;
$vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec = $vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName) && ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "F")) {
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->KeyCount = $objForm->GetValue($vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName);
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec = $vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec + $vw_bill_ranap_detail_tindakan_kebidanan_grid->KeyCount - 1;
	}
}
$vw_bill_ranap_detail_tindakan_kebidanan_grid->RecCnt = $vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec - 1;
if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset && !$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->EOF) {
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_kebidanan_grid->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec > 1)
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->Move($vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_tindakan_kebidanan->AllowAddDeleteRow && $vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec == 0) {
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec = $vw_bill_ranap_detail_tindakan_kebidanan->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_tindakan_kebidanan->ResetAttrs();
$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderRow();
if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd")
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex = 0;
if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridedit")
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex = 0;
while ($vw_bill_ranap_detail_tindakan_kebidanan_grid->RecCnt < $vw_bill_ranap_detail_tindakan_kebidanan_grid->StopRec) {
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->RecCnt++;
	if (intval($vw_bill_ranap_detail_tindakan_kebidanan_grid->RecCnt) >= intval($vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRec)) {
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt++;
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "F") {
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex++;
			$objForm->Index = $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex;
			if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_kebidanan_grid->FormActionName))
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction = strval($objForm->GetValue($vw_bill_ranap_detail_tindakan_kebidanan_grid->FormActionName));
			elseif ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd")
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction = "insert";
			else
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction = "";
		}

		// Set up key count
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->KeyCount = $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_tindakan_kebidanan->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_kebidanan->CssClass = "";
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd") {
			if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "copy") {
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRowValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset); // Load row values
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->SetRecordKey($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowOldKey, $vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset); // Set old record key
			} else {
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadDefaultValues(); // Load default values
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadRowValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd") // Grid add
			$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridadd" && $vw_bill_ranap_detail_tindakan_kebidanan->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridedit") { // Grid edit
			if ($vw_bill_ranap_detail_tindakan_kebidanan->EventCancelled) {
				$vw_bill_ranap_detail_tindakan_kebidanan_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex); // Restore form values
			}
			if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction == "insert")
				$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "gridedit" && ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) && $vw_bill_ranap_detail_tindakan_kebidanan->EventCancelled) // Update failed
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->EditRowCnt++;
		if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "F") // Confirm row
			$vw_bill_ranap_detail_tindakan_kebidanan_grid->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_tindakan_kebidanan->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_kebidanan->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt . '_vw_bill_ranap_detail_tindakan_kebidanan', 'data-rowtype'=>$vw_bill_ranap_detail_tindakan_kebidanan->RowType));

		// Render row
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction <> "delete" && $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction <> "insertdelete" && !($vw_bill_ranap_detail_tindakan_kebidanan_grid->RowAction == "insert" && $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "F" && $vw_bill_ranap_detail_tindakan_kebidanan_grid->EmptyRow())) {
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_kebidanangrid", "x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_kebidanangrid", "x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->PageObjName . "_row_" . $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_id" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="vw_bill_ranap_detail_tindakan_kebidanan_qty">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="vw_bill_ranap_detail_tindakan_kebidanan_tarif">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->bhp->Visible) { // bhp ?>
		<td data-name="bhp"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="vw_bill_ranap_detail_tindakan_kebidanan_bhp">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_user" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_user" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt ?>_vw_bill_ranap_detail_tindakan_kebidanan_user" class="vw_bill_ranap_detail_tindakan_kebidanan_user">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->ListViewValue() ?></span>
</span>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->FormValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="fvw_bill_ranap_detail_tindakan_kebidanangrid$o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt);
?>
	</tr>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_ADD || $vw_bill_ranap_detail_tindakan_kebidanan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_kebidanangrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "gridadd" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "copy")
		if (!$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->EOF) $vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->MoveNext();
}
?>
<?php
	if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "add" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "copy" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "edit") {
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex = '$rowindex$';
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->LoadDefaultValues();

		// Set row properties
		$vw_bill_ranap_detail_tindakan_kebidanan->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_kebidanan->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_kebidanan->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex, 'id'=>'r0_vw_bill_ranap_detail_tindakan_kebidanan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_bill_ranap_detail_tindakan_kebidanan->RowAttrs["class"], "ewTemplate");
		$vw_bill_ranap_detail_tindakan_kebidanan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->RenderListOptions();
		$vw_bill_ranap_detail_tindakan_kebidanan_grid->StartRowCnt = 0;
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_kebidanan->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_kebidanangrid", "x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_tanggal" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tanggal">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tanggal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp">
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->kode_tindakan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->qty->Visible) { // qty ?>
		<td data-name="qty">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_qty" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_qty">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->qty->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->tarif->Visible) { // tarif ?>
		<td data-name="tarif">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_tarif" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_tarif">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->tarif->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->tarif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->bhp->Visible) { // bhp ?>
		<td data-name="bhp">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_bhp" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_bhp">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->bhp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->bhp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->user->Visible) { // user ?>
		<td data-name="user">
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction <> "F") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_user" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_kebidanan_user" class="form-group vw_bill_ranap_detail_tindakan_kebidanan_user">
<span<?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_kebidanan->user->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_kebidanan" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_kebidanan->user->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowCnt);
?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_kebidanangrid.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "add" || $vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_kebidanan_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvw_bill_ranap_detail_tindakan_kebidanangrid">
</div>
<?php

// Close recordset
if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset)
	$vw_bill_ranap_detail_tindakan_kebidanan_grid->Recordset->Close();
?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_kebidanan_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan_grid->TotalRecs == 0 && $vw_bill_ranap_detail_tindakan_kebidanan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_kebidanan_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_kebidanan->Export == "") { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_kebidanangrid.Init();
</script>
<?php } ?>
<?php
$vw_bill_ranap_detail_tindakan_kebidanan_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$vw_bill_ranap_detail_tindakan_kebidanan_grid->Page_Terminate();
?>
