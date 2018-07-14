<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($detail_spj_grid)) $detail_spj_grid = new cdetail_spj_grid();

// Page init
$detail_spj_grid->Page_Init();

// Page main
$detail_spj_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detail_spj_grid->Page_Render();
?>
<?php if ($detail_spj->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdetail_spjgrid = new ew_Form("fdetail_spjgrid", "grid");
fdetail_spjgrid.FormKeyCountName = '<?php echo $detail_spj_grid->FormKeyCountName ?>';

// Validate form
fdetail_spjgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_detail_sbp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->id_detail_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->jumlah_belanja->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pajak");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->pajak->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdetail_spjgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "id_detail_sbp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_sbp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sub_kegiatan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah_belanja", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pajak", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetail_spjgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetail_spjgrid.ValidateRequired = true;
<?php } else { ?>
fdetail_spjgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetail_spjgrid.Lists["x_id_detail_sbp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_no_sbp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_list_spj"};

// Form object for search
</script>
<?php } ?>
<?php
if ($detail_spj->CurrentAction == "gridadd") {
	if ($detail_spj->CurrentMode == "copy") {
		$bSelectLimit = $detail_spj_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$detail_spj_grid->TotalRecs = $detail_spj->SelectRecordCount();
			$detail_spj_grid->Recordset = $detail_spj_grid->LoadRecordset($detail_spj_grid->StartRec-1, $detail_spj_grid->DisplayRecs);
		} else {
			if ($detail_spj_grid->Recordset = $detail_spj_grid->LoadRecordset())
				$detail_spj_grid->TotalRecs = $detail_spj_grid->Recordset->RecordCount();
		}
		$detail_spj_grid->StartRec = 1;
		$detail_spj_grid->DisplayRecs = $detail_spj_grid->TotalRecs;
	} else {
		$detail_spj->CurrentFilter = "0=1";
		$detail_spj_grid->StartRec = 1;
		$detail_spj_grid->DisplayRecs = $detail_spj->GridAddRowCount;
	}
	$detail_spj_grid->TotalRecs = $detail_spj_grid->DisplayRecs;
	$detail_spj_grid->StopRec = $detail_spj_grid->DisplayRecs;
} else {
	$bSelectLimit = $detail_spj_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($detail_spj_grid->TotalRecs <= 0)
			$detail_spj_grid->TotalRecs = $detail_spj->SelectRecordCount();
	} else {
		if (!$detail_spj_grid->Recordset && ($detail_spj_grid->Recordset = $detail_spj_grid->LoadRecordset()))
			$detail_spj_grid->TotalRecs = $detail_spj_grid->Recordset->RecordCount();
	}
	$detail_spj_grid->StartRec = 1;
	$detail_spj_grid->DisplayRecs = $detail_spj_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detail_spj_grid->Recordset = $detail_spj_grid->LoadRecordset($detail_spj_grid->StartRec-1, $detail_spj_grid->DisplayRecs);

	// Set no record found message
	if ($detail_spj->CurrentAction == "" && $detail_spj_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$detail_spj_grid->setWarningMessage(ew_DeniedMsg());
		if ($detail_spj_grid->SearchWhere == "0=101")
			$detail_spj_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detail_spj_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detail_spj_grid->RenderOtherOptions();
?>
<?php $detail_spj_grid->ShowPageHeader(); ?>
<?php
$detail_spj_grid->ShowMessage();
?>
<?php if ($detail_spj_grid->TotalRecs > 0 || $detail_spj->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid detail_spj">
<div id="fdetail_spjgrid" class="ewForm form-inline">
<div id="gmp_detail_spj" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_detail_spjgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $detail_spj->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$detail_spj_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$detail_spj_grid->RenderListOptions();

// Render list options (header, left)
$detail_spj_grid->ListOptions->Render("header", "left");
?>
<?php if ($detail_spj->id_detail_sbp->Visible) { // id_detail_sbp ?>
	<?php if ($detail_spj->SortUrl($detail_spj->id_detail_sbp) == "") { ?>
		<th data-name="id_detail_sbp"><div id="elh_detail_spj_id_detail_sbp" class="detail_spj_id_detail_sbp"><div class="ewTableHeaderCaption"><?php echo $detail_spj->id_detail_sbp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_detail_sbp"><div><div id="elh_detail_spj_id_detail_sbp" class="detail_spj_id_detail_sbp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detail_spj->id_detail_sbp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detail_spj->id_detail_sbp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($detail_spj->id_detail_sbp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
	<?php if ($detail_spj->SortUrl($detail_spj->no_sbp) == "") { ?>
		<th data-name="no_sbp"><div id="elh_detail_spj_no_sbp" class="detail_spj_no_sbp"><div class="ewTableHeaderCaption"><?php echo $detail_spj->no_sbp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_sbp"><div><div id="elh_detail_spj_no_sbp" class="detail_spj_no_sbp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detail_spj->no_sbp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detail_spj->no_sbp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($detail_spj->no_sbp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detail_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<?php if ($detail_spj->SortUrl($detail_spj->sub_kegiatan) == "") { ?>
		<th data-name="sub_kegiatan"><div id="elh_detail_spj_sub_kegiatan" class="detail_spj_sub_kegiatan"><div class="ewTableHeaderCaption"><?php echo $detail_spj->sub_kegiatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sub_kegiatan"><div><div id="elh_detail_spj_sub_kegiatan" class="detail_spj_sub_kegiatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detail_spj->sub_kegiatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detail_spj->sub_kegiatan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($detail_spj->sub_kegiatan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detail_spj->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<?php if ($detail_spj->SortUrl($detail_spj->jumlah_belanja) == "") { ?>
		<th data-name="jumlah_belanja"><div id="elh_detail_spj_jumlah_belanja" class="detail_spj_jumlah_belanja"><div class="ewTableHeaderCaption"><?php echo $detail_spj->jumlah_belanja->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_belanja"><div><div id="elh_detail_spj_jumlah_belanja" class="detail_spj_jumlah_belanja">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detail_spj->jumlah_belanja->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detail_spj->jumlah_belanja->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($detail_spj->jumlah_belanja->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detail_spj->pajak->Visible) { // pajak ?>
	<?php if ($detail_spj->SortUrl($detail_spj->pajak) == "") { ?>
		<th data-name="pajak"><div id="elh_detail_spj_pajak" class="detail_spj_pajak"><div class="ewTableHeaderCaption"><?php echo $detail_spj->pajak->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pajak"><div><div id="elh_detail_spj_pajak" class="detail_spj_pajak">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detail_spj->pajak->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detail_spj->pajak->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($detail_spj->pajak->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detail_spj_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detail_spj_grid->StartRec = 1;
$detail_spj_grid->StopRec = $detail_spj_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detail_spj_grid->FormKeyCountName) && ($detail_spj->CurrentAction == "gridadd" || $detail_spj->CurrentAction == "gridedit" || $detail_spj->CurrentAction == "F")) {
		$detail_spj_grid->KeyCount = $objForm->GetValue($detail_spj_grid->FormKeyCountName);
		$detail_spj_grid->StopRec = $detail_spj_grid->StartRec + $detail_spj_grid->KeyCount - 1;
	}
}
$detail_spj_grid->RecCnt = $detail_spj_grid->StartRec - 1;
if ($detail_spj_grid->Recordset && !$detail_spj_grid->Recordset->EOF) {
	$detail_spj_grid->Recordset->MoveFirst();
	$bSelectLimit = $detail_spj_grid->UseSelectLimit;
	if (!$bSelectLimit && $detail_spj_grid->StartRec > 1)
		$detail_spj_grid->Recordset->Move($detail_spj_grid->StartRec - 1);
} elseif (!$detail_spj->AllowAddDeleteRow && $detail_spj_grid->StopRec == 0) {
	$detail_spj_grid->StopRec = $detail_spj->GridAddRowCount;
}

// Initialize aggregate
$detail_spj->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detail_spj->ResetAttrs();
$detail_spj_grid->RenderRow();
if ($detail_spj->CurrentAction == "gridadd")
	$detail_spj_grid->RowIndex = 0;
if ($detail_spj->CurrentAction == "gridedit")
	$detail_spj_grid->RowIndex = 0;
while ($detail_spj_grid->RecCnt < $detail_spj_grid->StopRec) {
	$detail_spj_grid->RecCnt++;
	if (intval($detail_spj_grid->RecCnt) >= intval($detail_spj_grid->StartRec)) {
		$detail_spj_grid->RowCnt++;
		if ($detail_spj->CurrentAction == "gridadd" || $detail_spj->CurrentAction == "gridedit" || $detail_spj->CurrentAction == "F") {
			$detail_spj_grid->RowIndex++;
			$objForm->Index = $detail_spj_grid->RowIndex;
			if ($objForm->HasValue($detail_spj_grid->FormActionName))
				$detail_spj_grid->RowAction = strval($objForm->GetValue($detail_spj_grid->FormActionName));
			elseif ($detail_spj->CurrentAction == "gridadd")
				$detail_spj_grid->RowAction = "insert";
			else
				$detail_spj_grid->RowAction = "";
		}

		// Set up key count
		$detail_spj_grid->KeyCount = $detail_spj_grid->RowIndex;

		// Init row class and style
		$detail_spj->ResetAttrs();
		$detail_spj->CssClass = "";
		if ($detail_spj->CurrentAction == "gridadd") {
			if ($detail_spj->CurrentMode == "copy") {
				$detail_spj_grid->LoadRowValues($detail_spj_grid->Recordset); // Load row values
				$detail_spj_grid->SetRecordKey($detail_spj_grid->RowOldKey, $detail_spj_grid->Recordset); // Set old record key
			} else {
				$detail_spj_grid->LoadDefaultValues(); // Load default values
				$detail_spj_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detail_spj_grid->LoadRowValues($detail_spj_grid->Recordset); // Load row values
		}
		$detail_spj->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detail_spj->CurrentAction == "gridadd") // Grid add
			$detail_spj->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detail_spj->CurrentAction == "gridadd" && $detail_spj->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detail_spj_grid->RestoreCurrentRowFormValues($detail_spj_grid->RowIndex); // Restore form values
		if ($detail_spj->CurrentAction == "gridedit") { // Grid edit
			if ($detail_spj->EventCancelled) {
				$detail_spj_grid->RestoreCurrentRowFormValues($detail_spj_grid->RowIndex); // Restore form values
			}
			if ($detail_spj_grid->RowAction == "insert")
				$detail_spj->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detail_spj->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detail_spj->CurrentAction == "gridedit" && ($detail_spj->RowType == EW_ROWTYPE_EDIT || $detail_spj->RowType == EW_ROWTYPE_ADD) && $detail_spj->EventCancelled) // Update failed
			$detail_spj_grid->RestoreCurrentRowFormValues($detail_spj_grid->RowIndex); // Restore form values
		if ($detail_spj->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detail_spj_grid->EditRowCnt++;
		if ($detail_spj->CurrentAction == "F") // Confirm row
			$detail_spj_grid->RestoreCurrentRowFormValues($detail_spj_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detail_spj->RowAttrs = array_merge($detail_spj->RowAttrs, array('data-rowindex'=>$detail_spj_grid->RowCnt, 'id'=>'r' . $detail_spj_grid->RowCnt . '_detail_spj', 'data-rowtype'=>$detail_spj->RowType));

		// Render row
		$detail_spj_grid->RenderRow();

		// Render list options
		$detail_spj_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detail_spj_grid->RowAction <> "delete" && $detail_spj_grid->RowAction <> "insertdelete" && !($detail_spj_grid->RowAction == "insert" && $detail_spj->CurrentAction == "F" && $detail_spj_grid->EmptyRow())) {
?>
	<tr<?php echo $detail_spj->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detail_spj_grid->ListOptions->Render("body", "left", $detail_spj_grid->RowCnt);
?>
	<?php if ($detail_spj->id_detail_sbp->Visible) { // id_detail_sbp ?>
		<td data-name="id_detail_sbp"<?php echo $detail_spj->id_detail_sbp->CellAttributes() ?>>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_id_detail_sbp" class="form-group detail_spj_id_detail_sbp">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$detail_spj->id_detail_sbp->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$detail_spj->id_detail_sbp->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" style="white-space: nowrap; z-index: <?php echo (9000 - $detail_spj_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>"<?php echo $detail_spj->id_detail_sbp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $detail_spj->id_detail_sbp->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fdetail_spjgrid.CreateAutoSuggest({"id":"x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($detail_spj->id_detail_sbp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(false) ?>">
<input type="hidden" name="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp">
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_id_detail_sbp" class="form-group detail_spj_id_detail_sbp">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$detail_spj->id_detail_sbp->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$detail_spj->id_detail_sbp->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" style="white-space: nowrap; z-index: <?php echo (9000 - $detail_spj_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>"<?php echo $detail_spj->id_detail_sbp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $detail_spj->id_detail_sbp->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fdetail_spjgrid.CreateAutoSuggest({"id":"x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($detail_spj->id_detail_sbp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(false) ?>">
<input type="hidden" name="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp">
</span>
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_id_detail_sbp" class="detail_spj_id_detail_sbp">
<span<?php echo $detail_spj->id_detail_sbp->ViewAttributes() ?>>
<?php echo $detail_spj->id_detail_sbp->ListViewValue() ?></span>
</span>
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $detail_spj_grid->PageObjName . "_row_" . $detail_spj_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="detail_spj" data-field="x_id" name="x<?php echo $detail_spj_grid->RowIndex ?>_id" id="x<?php echo $detail_spj_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($detail_spj->id->CurrentValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_id" name="o<?php echo $detail_spj_grid->RowIndex ?>_id" id="o<?php echo $detail_spj_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($detail_spj->id->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT || $detail_spj->CurrentMode == "edit") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_id" name="x<?php echo $detail_spj_grid->RowIndex ?>_id" id="x<?php echo $detail_spj_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($detail_spj->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
		<td data-name="no_sbp"<?php echo $detail_spj->no_sbp->CellAttributes() ?>>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_no_sbp" class="form-group detail_spj_no_sbp">
<input type="text" data-table="detail_spj" data-field="x_no_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_sbp->EditValue ?>"<?php echo $detail_spj->no_sbp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_no_sbp" class="form-group detail_spj_no_sbp">
<input type="text" data-table="detail_spj" data-field="x_no_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_sbp->EditValue ?>"<?php echo $detail_spj->no_sbp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_no_sbp" class="detail_spj_no_sbp">
<span<?php echo $detail_spj->no_sbp->ViewAttributes() ?>>
<?php echo $detail_spj->no_sbp->ListViewValue() ?></span>
</span>
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detail_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<td data-name="sub_kegiatan"<?php echo $detail_spj->sub_kegiatan->CellAttributes() ?>>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detail_spj->sub_kegiatan->getSessionValue() <> "") { ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<input type="text" data-table="detail_spj" data-field="x_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $detail_spj->sub_kegiatan->EditValue ?>"<?php echo $detail_spj->sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detail_spj->sub_kegiatan->getSessionValue() <> "") { ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<input type="text" data-table="detail_spj" data-field="x_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $detail_spj->sub_kegiatan->EditValue ?>"<?php echo $detail_spj->sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_sub_kegiatan" class="detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<?php echo $detail_spj->sub_kegiatan->ListViewValue() ?></span>
</span>
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detail_spj->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja"<?php echo $detail_spj->jumlah_belanja->CellAttributes() ?>>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_jumlah_belanja" class="form-group detail_spj_jumlah_belanja">
<input type="text" data-table="detail_spj" data-field="x_jumlah_belanja" name="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $detail_spj->jumlah_belanja->EditValue ?>"<?php echo $detail_spj->jumlah_belanja->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_jumlah_belanja" class="form-group detail_spj_jumlah_belanja">
<input type="text" data-table="detail_spj" data-field="x_jumlah_belanja" name="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $detail_spj->jumlah_belanja->EditValue ?>"<?php echo $detail_spj->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_jumlah_belanja" class="detail_spj_jumlah_belanja">
<span<?php echo $detail_spj->jumlah_belanja->ViewAttributes() ?>>
<?php echo $detail_spj->jumlah_belanja->ListViewValue() ?></span>
</span>
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detail_spj->pajak->Visible) { // pajak ?>
		<td data-name="pajak"<?php echo $detail_spj->pajak->CellAttributes() ?>>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_pajak" class="form-group detail_spj_pajak">
<input type="text" data-table="detail_spj" data-field="x_pajak" name="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->pajak->getPlaceHolder()) ?>" value="<?php echo $detail_spj->pajak->EditValue ?>"<?php echo $detail_spj->pajak->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->OldValue) ?>">
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_pajak" class="form-group detail_spj_pajak">
<input type="text" data-table="detail_spj" data-field="x_pajak" name="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->pajak->getPlaceHolder()) ?>" value="<?php echo $detail_spj->pajak->EditValue ?>"<?php echo $detail_spj->pajak->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detail_spj->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $detail_spj_grid->RowCnt ?>_detail_spj_pajak" class="detail_spj_pajak">
<span<?php echo $detail_spj->pajak->ViewAttributes() ?>>
<?php echo $detail_spj->pajak->ListViewValue() ?></span>
</span>
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="fdetail_spjgrid$x<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->FormValue) ?>">
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="fdetail_spjgrid$o<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detail_spj_grid->ListOptions->Render("body", "right", $detail_spj_grid->RowCnt);
?>
	</tr>
<?php if ($detail_spj->RowType == EW_ROWTYPE_ADD || $detail_spj->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetail_spjgrid.UpdateOpts(<?php echo $detail_spj_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detail_spj->CurrentAction <> "gridadd" || $detail_spj->CurrentMode == "copy")
		if (!$detail_spj_grid->Recordset->EOF) $detail_spj_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detail_spj->CurrentMode == "add" || $detail_spj->CurrentMode == "copy" || $detail_spj->CurrentMode == "edit") {
		$detail_spj_grid->RowIndex = '$rowindex$';
		$detail_spj_grid->LoadDefaultValues();

		// Set row properties
		$detail_spj->ResetAttrs();
		$detail_spj->RowAttrs = array_merge($detail_spj->RowAttrs, array('data-rowindex'=>$detail_spj_grid->RowIndex, 'id'=>'r0_detail_spj', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detail_spj->RowAttrs["class"], "ewTemplate");
		$detail_spj->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detail_spj_grid->RenderRow();

		// Render list options
		$detail_spj_grid->RenderListOptions();
		$detail_spj_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detail_spj->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detail_spj_grid->ListOptions->Render("body", "left", $detail_spj_grid->RowIndex);
?>
	<?php if ($detail_spj->id_detail_sbp->Visible) { // id_detail_sbp ?>
		<td data-name="id_detail_sbp">
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detail_spj_id_detail_sbp" class="form-group detail_spj_id_detail_sbp">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$detail_spj->id_detail_sbp->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$detail_spj->id_detail_sbp->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" style="white-space: nowrap; z-index: <?php echo (9000 - $detail_spj_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="sv_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>"<?php echo $detail_spj->id_detail_sbp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $detail_spj->id_detail_sbp->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="q_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fdetail_spjgrid.CreateAutoSuggest({"id":"x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($detail_spj->id_detail_sbp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="s_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(false) ?>">
<input type="hidden" name="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="ln_x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp">
</span>
<?php } else { ?>
<span id="el$rowindex$_detail_spj_id_detail_sbp" class="form-group detail_spj_id_detail_sbp">
<span<?php echo $detail_spj->id_detail_sbp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->id_detail_sbp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
		<td data-name="no_sbp">
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detail_spj_no_sbp" class="form-group detail_spj_no_sbp">
<input type="text" data-table="detail_spj" data-field="x_no_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_sbp->EditValue ?>"<?php echo $detail_spj->no_sbp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detail_spj_no_sbp" class="form-group detail_spj_no_sbp">
<span<?php echo $detail_spj->no_sbp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->no_sbp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="x<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" name="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" id="o<?php echo $detail_spj_grid->RowIndex ?>_no_sbp" value="<?php echo ew_HtmlEncode($detail_spj->no_sbp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detail_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<td data-name="sub_kegiatan">
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<?php if ($detail_spj->sub_kegiatan->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<input type="text" data-table="detail_spj" data-field="x_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $detail_spj->sub_kegiatan->EditValue ?>"<?php echo $detail_spj->sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detail_spj_sub_kegiatan" class="form-group detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="x<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_sub_kegiatan" name="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" id="o<?php echo $detail_spj_grid->RowIndex ?>_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detail_spj->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td data-name="jumlah_belanja">
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detail_spj_jumlah_belanja" class="form-group detail_spj_jumlah_belanja">
<input type="text" data-table="detail_spj" data-field="x_jumlah_belanja" name="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $detail_spj->jumlah_belanja->EditValue ?>"<?php echo $detail_spj->jumlah_belanja->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detail_spj_jumlah_belanja" class="form-group detail_spj_jumlah_belanja">
<span<?php echo $detail_spj->jumlah_belanja->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->jumlah_belanja->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="x<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_jumlah_belanja" name="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" id="o<?php echo $detail_spj_grid->RowIndex ?>_jumlah_belanja" value="<?php echo ew_HtmlEncode($detail_spj->jumlah_belanja->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detail_spj->pajak->Visible) { // pajak ?>
		<td data-name="pajak">
<?php if ($detail_spj->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detail_spj_pajak" class="form-group detail_spj_pajak">
<input type="text" data-table="detail_spj" data-field="x_pajak" name="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->pajak->getPlaceHolder()) ?>" value="<?php echo $detail_spj->pajak->EditValue ?>"<?php echo $detail_spj->pajak->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detail_spj_pajak" class="form-group detail_spj_pajak">
<span<?php echo $detail_spj->pajak->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->pajak->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="x<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="detail_spj" data-field="x_pajak" name="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" id="o<?php echo $detail_spj_grid->RowIndex ?>_pajak" value="<?php echo ew_HtmlEncode($detail_spj->pajak->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detail_spj_grid->ListOptions->Render("body", "right", $detail_spj_grid->RowCnt);
?>
<script type="text/javascript">
fdetail_spjgrid.UpdateOpts(<?php echo $detail_spj_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detail_spj->CurrentMode == "add" || $detail_spj->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detail_spj_grid->FormKeyCountName ?>" id="<?php echo $detail_spj_grid->FormKeyCountName ?>" value="<?php echo $detail_spj_grid->KeyCount ?>">
<?php echo $detail_spj_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detail_spj->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detail_spj_grid->FormKeyCountName ?>" id="<?php echo $detail_spj_grid->FormKeyCountName ?>" value="<?php echo $detail_spj_grid->KeyCount ?>">
<?php echo $detail_spj_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detail_spj->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetail_spjgrid">
</div>
<?php

// Close recordset
if ($detail_spj_grid->Recordset)
	$detail_spj_grid->Recordset->Close();
?>
<?php if ($detail_spj_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($detail_spj_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detail_spj_grid->TotalRecs == 0 && $detail_spj->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detail_spj_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detail_spj->Export == "") { ?>
<script type="text/javascript">
fdetail_spjgrid.Init();
</script>
<?php } ?>
<?php
$detail_spj_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detail_spj_grid->Page_Terminate();
?>
