<?php include_once "m_logininfo.php" ?>
<?php

// Create page object
if (!isset($t_sep_grid)) $t_sep_grid = new ct_sep_grid();

// Page init
$t_sep_grid->Page_Init();

// Page main
$t_sep_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sep_grid->Page_Render();
?>
<?php if ($t_sep->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft_sepgrid = new ew_Form("ft_sepgrid", "grid");
ft_sepgrid.FormKeyCountName = '<?php echo $t_sep_grid->FormKeyCountName ?>';

// Validate form
ft_sepgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_sep");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->tgl_sep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_poli_eksekutif");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->poli_eksekutif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cob");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->cob->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_penjamin_laka");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->penjamin_laka->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft_sepgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomer_sep", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nomr", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_kartubpjs", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jenis_layanan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tgl_sep", false)) return false;
	if (ew_ValueChanged(fobj, infix, "poli_eksekutif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cob", false)) return false;
	if (ew_ValueChanged(fobj, infix, "penjamin_laka", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_telp", false)) return false;
	return true;
}

// Form_CustomValidate event
ft_sepgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sepgrid.ValidateRequired = true;
<?php } else { ?>
ft_sepgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sepgrid.Lists["x_jenis_layanan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sepgrid.Lists["x_jenis_layanan"].Options = <?php echo json_encode($t_sep->jenis_layanan->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($t_sep->CurrentAction == "gridadd") {
	if ($t_sep->CurrentMode == "copy") {
		$bSelectLimit = $t_sep_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t_sep_grid->TotalRecs = $t_sep->SelectRecordCount();
			$t_sep_grid->Recordset = $t_sep_grid->LoadRecordset($t_sep_grid->StartRec-1, $t_sep_grid->DisplayRecs);
		} else {
			if ($t_sep_grid->Recordset = $t_sep_grid->LoadRecordset())
				$t_sep_grid->TotalRecs = $t_sep_grid->Recordset->RecordCount();
		}
		$t_sep_grid->StartRec = 1;
		$t_sep_grid->DisplayRecs = $t_sep_grid->TotalRecs;
	} else {
		$t_sep->CurrentFilter = "0=1";
		$t_sep_grid->StartRec = 1;
		$t_sep_grid->DisplayRecs = $t_sep->GridAddRowCount;
	}
	$t_sep_grid->TotalRecs = $t_sep_grid->DisplayRecs;
	$t_sep_grid->StopRec = $t_sep_grid->DisplayRecs;
} else {
	$bSelectLimit = $t_sep_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_sep_grid->TotalRecs <= 0)
			$t_sep_grid->TotalRecs = $t_sep->SelectRecordCount();
	} else {
		if (!$t_sep_grid->Recordset && ($t_sep_grid->Recordset = $t_sep_grid->LoadRecordset()))
			$t_sep_grid->TotalRecs = $t_sep_grid->Recordset->RecordCount();
	}
	$t_sep_grid->StartRec = 1;
	$t_sep_grid->DisplayRecs = $t_sep_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t_sep_grid->Recordset = $t_sep_grid->LoadRecordset($t_sep_grid->StartRec-1, $t_sep_grid->DisplayRecs);

	// Set no record found message
	if ($t_sep->CurrentAction == "" && $t_sep_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_sep_grid->setWarningMessage(ew_DeniedMsg());
		if ($t_sep_grid->SearchWhere == "0=101")
			$t_sep_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_sep_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t_sep_grid->RenderOtherOptions();
?>
<?php $t_sep_grid->ShowPageHeader(); ?>
<?php
$t_sep_grid->ShowMessage();
?>
<?php if ($t_sep_grid->TotalRecs > 0 || $t_sep->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_sep">
<div id="ft_sepgrid" class="ewForm form-inline">
<div id="gmp_t_sep" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<table id="tbl_t_sepgrid" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_sep->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_sep_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_sep_grid->RenderListOptions();

// Render list options (header, left)
$t_sep_grid->ListOptions->Render("header", "left");
?>
<?php if ($t_sep->id->Visible) { // id ?>
	<?php if ($t_sep->SortUrl($t_sep->id) == "") { ?>
		<th data-name="id"><div id="elh_t_sep_id" class="t_sep_id"><div class="ewTableHeaderCaption"><?php echo $t_sep->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_t_sep_id" class="t_sep_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
	<?php if ($t_sep->SortUrl($t_sep->nomer_sep) == "") { ?>
		<th data-name="nomer_sep"><div id="elh_t_sep_nomer_sep" class="t_sep_nomer_sep"><div class="ewTableHeaderCaption"><?php echo $t_sep->nomer_sep->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomer_sep"><div><div id="elh_t_sep_nomer_sep" class="t_sep_nomer_sep">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nomer_sep->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nomer_sep->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nomer_sep->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nomr->Visible) { // nomr ?>
	<?php if ($t_sep->SortUrl($t_sep->nomr) == "") { ?>
		<th data-name="nomr"><div id="elh_t_sep_nomr" class="t_sep_nomr"><div class="ewTableHeaderCaption"><?php echo $t_sep->nomr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomr"><div><div id="elh_t_sep_nomr" class="t_sep_nomr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nomr->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nomr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nomr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
	<?php if ($t_sep->SortUrl($t_sep->no_kartubpjs) == "") { ?>
		<th data-name="no_kartubpjs"><div id="elh_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs"><div class="ewTableHeaderCaption"><?php echo $t_sep->no_kartubpjs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_kartubpjs"><div><div id="elh_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->no_kartubpjs->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->no_kartubpjs->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->no_kartubpjs->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
	<?php if ($t_sep->SortUrl($t_sep->jenis_layanan) == "") { ?>
		<th data-name="jenis_layanan"><div id="elh_t_sep_jenis_layanan" class="t_sep_jenis_layanan"><div class="ewTableHeaderCaption"><?php echo $t_sep->jenis_layanan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_layanan"><div><div id="elh_t_sep_jenis_layanan" class="t_sep_jenis_layanan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->jenis_layanan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->jenis_layanan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->jenis_layanan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
	<?php if ($t_sep->SortUrl($t_sep->tgl_sep) == "") { ?>
		<th data-name="tgl_sep"><div id="elh_t_sep_tgl_sep" class="t_sep_tgl_sep"><div class="ewTableHeaderCaption"><?php echo $t_sep->tgl_sep->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_sep"><div><div id="elh_t_sep_tgl_sep" class="t_sep_tgl_sep">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->tgl_sep->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->tgl_sep->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->tgl_sep->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<?php if ($t_sep->SortUrl($t_sep->poli_eksekutif) == "") { ?>
		<th data-name="poli_eksekutif"><div id="elh_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif"><div class="ewTableHeaderCaption"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="poli_eksekutif"><div><div id="elh_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->poli_eksekutif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->poli_eksekutif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->cob->Visible) { // cob ?>
	<?php if ($t_sep->SortUrl($t_sep->cob) == "") { ?>
		<th data-name="cob"><div id="elh_t_sep_cob" class="t_sep_cob"><div class="ewTableHeaderCaption"><?php echo $t_sep->cob->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cob"><div><div id="elh_t_sep_cob" class="t_sep_cob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->cob->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->cob->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->cob->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
	<?php if ($t_sep->SortUrl($t_sep->penjamin_laka) == "") { ?>
		<th data-name="penjamin_laka"><div id="elh_t_sep_penjamin_laka" class="t_sep_penjamin_laka"><div class="ewTableHeaderCaption"><?php echo $t_sep->penjamin_laka->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="penjamin_laka"><div><div id="elh_t_sep_penjamin_laka" class="t_sep_penjamin_laka">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->penjamin_laka->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->penjamin_laka->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->penjamin_laka->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
	<?php if ($t_sep->SortUrl($t_sep->no_telp) == "") { ?>
		<th data-name="no_telp"><div id="elh_t_sep_no_telp" class="t_sep_no_telp"><div class="ewTableHeaderCaption"><?php echo $t_sep->no_telp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_telp"><div><div id="elh_t_sep_no_telp" class="t_sep_no_telp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->no_telp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->no_telp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->no_telp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_sep_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t_sep_grid->StartRec = 1;
$t_sep_grid->StopRec = $t_sep_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t_sep_grid->FormKeyCountName) && ($t_sep->CurrentAction == "gridadd" || $t_sep->CurrentAction == "gridedit" || $t_sep->CurrentAction == "F")) {
		$t_sep_grid->KeyCount = $objForm->GetValue($t_sep_grid->FormKeyCountName);
		$t_sep_grid->StopRec = $t_sep_grid->StartRec + $t_sep_grid->KeyCount - 1;
	}
}
$t_sep_grid->RecCnt = $t_sep_grid->StartRec - 1;
if ($t_sep_grid->Recordset && !$t_sep_grid->Recordset->EOF) {
	$t_sep_grid->Recordset->MoveFirst();
	$bSelectLimit = $t_sep_grid->UseSelectLimit;
	if (!$bSelectLimit && $t_sep_grid->StartRec > 1)
		$t_sep_grid->Recordset->Move($t_sep_grid->StartRec - 1);
} elseif (!$t_sep->AllowAddDeleteRow && $t_sep_grid->StopRec == 0) {
	$t_sep_grid->StopRec = $t_sep->GridAddRowCount;
}

// Initialize aggregate
$t_sep->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_sep->ResetAttrs();
$t_sep_grid->RenderRow();
if ($t_sep->CurrentAction == "gridadd")
	$t_sep_grid->RowIndex = 0;
if ($t_sep->CurrentAction == "gridedit")
	$t_sep_grid->RowIndex = 0;
while ($t_sep_grid->RecCnt < $t_sep_grid->StopRec) {
	$t_sep_grid->RecCnt++;
	if (intval($t_sep_grid->RecCnt) >= intval($t_sep_grid->StartRec)) {
		$t_sep_grid->RowCnt++;
		if ($t_sep->CurrentAction == "gridadd" || $t_sep->CurrentAction == "gridedit" || $t_sep->CurrentAction == "F") {
			$t_sep_grid->RowIndex++;
			$objForm->Index = $t_sep_grid->RowIndex;
			if ($objForm->HasValue($t_sep_grid->FormActionName))
				$t_sep_grid->RowAction = strval($objForm->GetValue($t_sep_grid->FormActionName));
			elseif ($t_sep->CurrentAction == "gridadd")
				$t_sep_grid->RowAction = "insert";
			else
				$t_sep_grid->RowAction = "";
		}

		// Set up key count
		$t_sep_grid->KeyCount = $t_sep_grid->RowIndex;

		// Init row class and style
		$t_sep->ResetAttrs();
		$t_sep->CssClass = "";
		if ($t_sep->CurrentAction == "gridadd") {
			if ($t_sep->CurrentMode == "copy") {
				$t_sep_grid->LoadRowValues($t_sep_grid->Recordset); // Load row values
				$t_sep_grid->SetRecordKey($t_sep_grid->RowOldKey, $t_sep_grid->Recordset); // Set old record key
			} else {
				$t_sep_grid->LoadDefaultValues(); // Load default values
				$t_sep_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t_sep_grid->LoadRowValues($t_sep_grid->Recordset); // Load row values
		}
		$t_sep->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t_sep->CurrentAction == "gridadd") // Grid add
			$t_sep->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t_sep->CurrentAction == "gridadd" && $t_sep->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t_sep_grid->RestoreCurrentRowFormValues($t_sep_grid->RowIndex); // Restore form values
		if ($t_sep->CurrentAction == "gridedit") { // Grid edit
			if ($t_sep->EventCancelled) {
				$t_sep_grid->RestoreCurrentRowFormValues($t_sep_grid->RowIndex); // Restore form values
			}
			if ($t_sep_grid->RowAction == "insert")
				$t_sep->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t_sep->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t_sep->CurrentAction == "gridedit" && ($t_sep->RowType == EW_ROWTYPE_EDIT || $t_sep->RowType == EW_ROWTYPE_ADD) && $t_sep->EventCancelled) // Update failed
			$t_sep_grid->RestoreCurrentRowFormValues($t_sep_grid->RowIndex); // Restore form values
		if ($t_sep->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t_sep_grid->EditRowCnt++;
		if ($t_sep->CurrentAction == "F") // Confirm row
			$t_sep_grid->RestoreCurrentRowFormValues($t_sep_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t_sep->RowAttrs = array_merge($t_sep->RowAttrs, array('data-rowindex'=>$t_sep_grid->RowCnt, 'id'=>'r' . $t_sep_grid->RowCnt . '_t_sep', 'data-rowtype'=>$t_sep->RowType));

		// Render row
		$t_sep_grid->RenderRow();

		// Render list options
		$t_sep_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t_sep_grid->RowAction <> "delete" && $t_sep_grid->RowAction <> "insertdelete" && !($t_sep_grid->RowAction == "insert" && $t_sep->CurrentAction == "F" && $t_sep_grid->EmptyRow())) {
?>
	<tr<?php echo $t_sep->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_sep_grid->ListOptions->Render("body", "left", $t_sep_grid->RowCnt);
?>
	<?php if ($t_sep->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t_sep->id->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t_sep" data-field="x_id" name="o<?php echo $t_sep_grid->RowIndex ?>_id" id="o<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="orig<?php echo $t_sep_grid->RowCnt ?>_t_sep_id" class="hide">
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_id" class="form-group t_sep_id">
<span<?php echo $t_sep->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->id->EditValue ?></p></span>
</span>
</div>
<a class="btn btn-success btn-xs"
target="_blank"
href="cetak_form_klaim_52.php?kdspp=<?php echo urlencode(CurrentPage()->idx->CurrentValue)?>">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>Cetak </b> FORM EKLAIM</a>
<input type="hidden" data-table="t_sep" data-field="x_id" name="x<?php echo $t_sep_grid->RowIndex ?>_id" id="x<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->CurrentValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div id="orig<?php echo $t_sep_grid->RowCnt ?>_t_sep_id" class="hide">
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_id" class="t_sep_id">
<span<?php echo $t_sep->id->ViewAttributes() ?>>
<?php echo $t_sep->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"
target="_blank"
href="cetak_form_klaim_52.php?kdspp=<?php echo urlencode(CurrentPage()->idx->CurrentValue)?>">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>Cetak </b> FORM EKLAIM</a>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_id" name="x<?php echo $t_sep_grid->RowIndex ?>_id" id="x<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_id" name="o<?php echo $t_sep_grid->RowIndex ?>_id" id="o<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_id" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_id" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_id" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_id" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t_sep_grid->PageObjName . "_row_" . $t_sep_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
		<td data-name="nomer_sep"<?php echo $t_sep->nomer_sep->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomer_sep" class="form-group t_sep_nomer_sep">
<input type="text" data-table="t_sep" data-field="x_nomer_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomer_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomer_sep->EditValue ?>"<?php echo $t_sep->nomer_sep->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomer_sep" class="form-group t_sep_nomer_sep">
<input type="text" data-table="t_sep" data-field="x_nomer_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomer_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomer_sep->EditValue ?>"<?php echo $t_sep->nomer_sep->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomer_sep" class="t_sep_nomer_sep">
<span<?php echo $t_sep->nomer_sep->ViewAttributes() ?>>
<?php echo $t_sep->nomer_sep->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->nomr->Visible) { // nomr ?>
		<td data-name="nomr"<?php echo $t_sep->nomr->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_sep->nomr->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomr" class="form-group t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->nomr->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomr" class="form-group t_sep_nomr">
<input type="text" data-table="t_sep" data-field="x_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomr->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomr->EditValue ?>"<?php echo $t_sep->nomr->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="o<?php echo $t_sep_grid->RowIndex ?>_nomr" id="o<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_sep->nomr->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomr" class="form-group t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->nomr->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomr" class="form-group t_sep_nomr">
<input type="text" data-table="t_sep" data-field="x_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomr->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomr->EditValue ?>"<?php echo $t_sep->nomr->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_nomr" class="t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<?php echo $t_sep->nomr->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="o<?php echo $t_sep_grid->RowIndex ?>_nomr" id="o<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_nomr" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
		<td data-name="no_kartubpjs"<?php echo $t_sep->no_kartubpjs->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_kartubpjs" class="form-group t_sep_no_kartubpjs">
<input type="text" data-table="t_sep" data-field="x_no_kartubpjs" name="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_kartubpjs->EditValue ?>"<?php echo $t_sep->no_kartubpjs->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_kartubpjs" class="form-group t_sep_no_kartubpjs">
<input type="text" data-table="t_sep" data-field="x_no_kartubpjs" name="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_kartubpjs->EditValue ?>"<?php echo $t_sep->no_kartubpjs->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs">
<span<?php echo $t_sep->no_kartubpjs->ViewAttributes() ?>>
<?php echo $t_sep->no_kartubpjs->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
		<td data-name="jenis_layanan"<?php echo $t_sep->jenis_layanan->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_jenis_layanan" class="form-group t_sep_jenis_layanan">
<div id="tp_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" class="ewTemplate"><input type="radio" data-table="t_sep" data-field="x_jenis_layanan" data-value-separator="<?php echo $t_sep->jenis_layanan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="{value}"<?php echo $t_sep->jenis_layanan->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_sep->jenis_layanan->RadioButtonListHtml(FALSE, "x{$t_sep_grid->RowIndex}_jenis_layanan") ?>
</div></div>
</span>
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_jenis_layanan" class="form-group t_sep_jenis_layanan">
<div id="tp_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" class="ewTemplate"><input type="radio" data-table="t_sep" data-field="x_jenis_layanan" data-value-separator="<?php echo $t_sep->jenis_layanan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="{value}"<?php echo $t_sep->jenis_layanan->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_sep->jenis_layanan->RadioButtonListHtml(FALSE, "x{$t_sep_grid->RowIndex}_jenis_layanan") ?>
</div></div>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_jenis_layanan" class="t_sep_jenis_layanan">
<span<?php echo $t_sep->jenis_layanan->ViewAttributes() ?>>
<?php echo $t_sep->jenis_layanan->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
		<td data-name="tgl_sep"<?php echo $t_sep->tgl_sep->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t_sep->tgl_sep->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->tgl_sep->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($t_sep->tgl_sep->CurrentValue, 0)) ?>">
<?php } else { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<input type="text" data-table="t_sep" data-field="x_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" placeholder="<?php echo ew_HtmlEncode($t_sep->tgl_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->tgl_sep->EditValue ?>"<?php echo $t_sep->tgl_sep->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t_sep->tgl_sep->getSessionValue() <> "") { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->tgl_sep->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($t_sep->tgl_sep->CurrentValue, 0)) ?>">
<?php } else { ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<input type="text" data-table="t_sep" data-field="x_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" placeholder="<?php echo ew_HtmlEncode($t_sep->tgl_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->tgl_sep->EditValue ?>"<?php echo $t_sep->tgl_sep->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_tgl_sep" class="t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<?php echo $t_sep->tgl_sep->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<td data-name="poli_eksekutif"<?php echo $t_sep->poli_eksekutif->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_poli_eksekutif" class="form-group t_sep_poli_eksekutif">
<input type="text" data-table="t_sep" data-field="x_poli_eksekutif" name="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_sep->poli_eksekutif->EditValue ?>"<?php echo $t_sep->poli_eksekutif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_poli_eksekutif" class="form-group t_sep_poli_eksekutif">
<input type="text" data-table="t_sep" data-field="x_poli_eksekutif" name="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_sep->poli_eksekutif->EditValue ?>"<?php echo $t_sep->poli_eksekutif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif">
<span<?php echo $t_sep->poli_eksekutif->ViewAttributes() ?>>
<?php echo $t_sep->poli_eksekutif->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->cob->Visible) { // cob ?>
		<td data-name="cob"<?php echo $t_sep->cob->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_cob" class="form-group t_sep_cob">
<input type="text" data-table="t_sep" data-field="x_cob" name="x<?php echo $t_sep_grid->RowIndex ?>_cob" id="x<?php echo $t_sep_grid->RowIndex ?>_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cob->getPlaceHolder()) ?>" value="<?php echo $t_sep->cob->EditValue ?>"<?php echo $t_sep->cob->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_cob" name="o<?php echo $t_sep_grid->RowIndex ?>_cob" id="o<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_cob" class="form-group t_sep_cob">
<input type="text" data-table="t_sep" data-field="x_cob" name="x<?php echo $t_sep_grid->RowIndex ?>_cob" id="x<?php echo $t_sep_grid->RowIndex ?>_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cob->getPlaceHolder()) ?>" value="<?php echo $t_sep->cob->EditValue ?>"<?php echo $t_sep->cob->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_cob" class="t_sep_cob">
<span<?php echo $t_sep->cob->ViewAttributes() ?>>
<?php echo $t_sep->cob->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_cob" name="x<?php echo $t_sep_grid->RowIndex ?>_cob" id="x<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_cob" name="o<?php echo $t_sep_grid->RowIndex ?>_cob" id="o<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_cob" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_cob" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_cob" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_cob" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
		<td data-name="penjamin_laka"<?php echo $t_sep->penjamin_laka->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_penjamin_laka" class="form-group t_sep_penjamin_laka">
<input type="text" data-table="t_sep" data-field="x_penjamin_laka" name="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->penjamin_laka->EditValue ?>"<?php echo $t_sep->penjamin_laka->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_penjamin_laka" class="form-group t_sep_penjamin_laka">
<input type="text" data-table="t_sep" data-field="x_penjamin_laka" name="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->penjamin_laka->EditValue ?>"<?php echo $t_sep->penjamin_laka->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_penjamin_laka" class="t_sep_penjamin_laka">
<span<?php echo $t_sep->penjamin_laka->ViewAttributes() ?>>
<?php echo $t_sep->penjamin_laka->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
		<td data-name="no_telp"<?php echo $t_sep->no_telp->CellAttributes() ?>>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_telp" class="form-group t_sep_no_telp">
<input type="text" data-table="t_sep" data-field="x_no_telp" name="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_telp->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_telp->EditValue ?>"<?php echo $t_sep->no_telp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->OldValue) ?>">
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_telp" class="form-group t_sep_no_telp">
<input type="text" data-table="t_sep" data-field="x_no_telp" name="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_telp->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_telp->EditValue ?>"<?php echo $t_sep->no_telp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t_sep->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t_sep_grid->RowCnt ?>_t_sep_no_telp" class="t_sep_no_telp">
<span<?php echo $t_sep->no_telp->ViewAttributes() ?>>
<?php echo $t_sep->no_telp->ListViewValue() ?></span>
</span>
<?php if ($t_sep->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="ft_sepgrid$x<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->FormValue) ?>">
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="ft_sepgrid$o<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_sep_grid->ListOptions->Render("body", "right", $t_sep_grid->RowCnt);
?>
	</tr>
<?php if ($t_sep->RowType == EW_ROWTYPE_ADD || $t_sep->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft_sepgrid.UpdateOpts(<?php echo $t_sep_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t_sep->CurrentAction <> "gridadd" || $t_sep->CurrentMode == "copy")
		if (!$t_sep_grid->Recordset->EOF) $t_sep_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t_sep->CurrentMode == "add" || $t_sep->CurrentMode == "copy" || $t_sep->CurrentMode == "edit") {
		$t_sep_grid->RowIndex = '$rowindex$';
		$t_sep_grid->LoadDefaultValues();

		// Set row properties
		$t_sep->ResetAttrs();
		$t_sep->RowAttrs = array_merge($t_sep->RowAttrs, array('data-rowindex'=>$t_sep_grid->RowIndex, 'id'=>'r0_t_sep', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t_sep->RowAttrs["class"], "ewTemplate");
		$t_sep->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t_sep_grid->RenderRow();

		// Render list options
		$t_sep_grid->RenderListOptions();
		$t_sep_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t_sep->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_sep_grid->ListOptions->Render("body", "left", $t_sep_grid->RowIndex);
?>
	<?php if ($t_sep->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<?php } else { ?>
<div id="orig<?php echo $t_sep_grid->RowCnt ?>_t_sep_id" class="hide">
<span id="el$rowindex$_t_sep_id" class="form-group t_sep_id">
<span<?php echo $t_sep->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->id->ViewValue ?></p></span>
</span>
</div>
<a class="btn btn-success btn-xs"
target="_blank"
href="cetak_form_klaim_52.php?kdspp=<?php echo urlencode(CurrentPage()->idx->CurrentValue)?>">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>Cetak </b> FORM EKLAIM</a>
<input type="hidden" data-table="t_sep" data-field="x_id" name="x<?php echo $t_sep_grid->RowIndex ?>_id" id="x<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_id" name="o<?php echo $t_sep_grid->RowIndex ?>_id" id="o<?php echo $t_sep_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t_sep->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
		<td data-name="nomer_sep">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_nomer_sep" class="form-group t_sep_nomer_sep">
<input type="text" data-table="t_sep" data-field="x_nomer_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomer_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomer_sep->EditValue ?>"<?php echo $t_sep->nomer_sep->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_nomer_sep" class="form-group t_sep_nomer_sep">
<span<?php echo $t_sep->nomer_sep->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->nomer_sep->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_nomer_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_nomer_sep" value="<?php echo ew_HtmlEncode($t_sep->nomer_sep->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->nomr->Visible) { // nomr ?>
		<td data-name="nomr">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<?php if ($t_sep->nomr->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_sep_nomr" class="form-group t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->nomr->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_sep_nomr" class="form-group t_sep_nomr">
<input type="text" data-table="t_sep" data-field="x_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomr->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomr->EditValue ?>"<?php echo $t_sep->nomr->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_sep_nomr" class="form-group t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->nomr->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="x<?php echo $t_sep_grid->RowIndex ?>_nomr" id="x<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_nomr" name="o<?php echo $t_sep_grid->RowIndex ?>_nomr" id="o<?php echo $t_sep_grid->RowIndex ?>_nomr" value="<?php echo ew_HtmlEncode($t_sep->nomr->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
		<td data-name="no_kartubpjs">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_no_kartubpjs" class="form-group t_sep_no_kartubpjs">
<input type="text" data-table="t_sep" data-field="x_no_kartubpjs" name="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_kartubpjs->EditValue ?>"<?php echo $t_sep->no_kartubpjs->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_no_kartubpjs" class="form-group t_sep_no_kartubpjs">
<span<?php echo $t_sep->no_kartubpjs->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->no_kartubpjs->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="x<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_no_kartubpjs" name="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" id="o<?php echo $t_sep_grid->RowIndex ?>_no_kartubpjs" value="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
		<td data-name="jenis_layanan">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_jenis_layanan" class="form-group t_sep_jenis_layanan">
<div id="tp_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" class="ewTemplate"><input type="radio" data-table="t_sep" data-field="x_jenis_layanan" data-value-separator="<?php echo $t_sep->jenis_layanan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="{value}"<?php echo $t_sep->jenis_layanan->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_sep->jenis_layanan->RadioButtonListHtml(FALSE, "x{$t_sep_grid->RowIndex}_jenis_layanan") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_jenis_layanan" class="form-group t_sep_jenis_layanan">
<span<?php echo $t_sep->jenis_layanan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->jenis_layanan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="x<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_jenis_layanan" name="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" id="o<?php echo $t_sep_grid->RowIndex ?>_jenis_layanan" value="<?php echo ew_HtmlEncode($t_sep->jenis_layanan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
		<td data-name="tgl_sep">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<?php if ($t_sep->tgl_sep->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->tgl_sep->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($t_sep->tgl_sep->CurrentValue, 0)) ?>">
<?php } else { ?>
<span id="el$rowindex$_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<input type="text" data-table="t_sep" data-field="x_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" placeholder="<?php echo ew_HtmlEncode($t_sep->tgl_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->tgl_sep->EditValue ?>"<?php echo $t_sep->tgl_sep->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t_sep_tgl_sep" class="form-group t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->tgl_sep->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="x<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_tgl_sep" name="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" id="o<?php echo $t_sep_grid->RowIndex ?>_tgl_sep" value="<?php echo ew_HtmlEncode($t_sep->tgl_sep->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<td data-name="poli_eksekutif">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_poli_eksekutif" class="form-group t_sep_poli_eksekutif">
<input type="text" data-table="t_sep" data-field="x_poli_eksekutif" name="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_sep->poli_eksekutif->EditValue ?>"<?php echo $t_sep->poli_eksekutif->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_poli_eksekutif" class="form-group t_sep_poli_eksekutif">
<span<?php echo $t_sep->poli_eksekutif->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->poli_eksekutif->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="x<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_poli_eksekutif" name="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" id="o<?php echo $t_sep_grid->RowIndex ?>_poli_eksekutif" value="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->cob->Visible) { // cob ?>
		<td data-name="cob">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_cob" class="form-group t_sep_cob">
<input type="text" data-table="t_sep" data-field="x_cob" name="x<?php echo $t_sep_grid->RowIndex ?>_cob" id="x<?php echo $t_sep_grid->RowIndex ?>_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cob->getPlaceHolder()) ?>" value="<?php echo $t_sep->cob->EditValue ?>"<?php echo $t_sep->cob->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_cob" class="form-group t_sep_cob">
<span<?php echo $t_sep->cob->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->cob->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_cob" name="x<?php echo $t_sep_grid->RowIndex ?>_cob" id="x<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_cob" name="o<?php echo $t_sep_grid->RowIndex ?>_cob" id="o<?php echo $t_sep_grid->RowIndex ?>_cob" value="<?php echo ew_HtmlEncode($t_sep->cob->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
		<td data-name="penjamin_laka">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_penjamin_laka" class="form-group t_sep_penjamin_laka">
<input type="text" data-table="t_sep" data-field="x_penjamin_laka" name="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->penjamin_laka->EditValue ?>"<?php echo $t_sep->penjamin_laka->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_penjamin_laka" class="form-group t_sep_penjamin_laka">
<span<?php echo $t_sep->penjamin_laka->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->penjamin_laka->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="x<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_penjamin_laka" name="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" id="o<?php echo $t_sep_grid->RowIndex ?>_penjamin_laka" value="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
		<td data-name="no_telp">
<?php if ($t_sep->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t_sep_no_telp" class="form-group t_sep_no_telp">
<input type="text" data-table="t_sep" data-field="x_no_telp" name="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_telp->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_telp->EditValue ?>"<?php echo $t_sep->no_telp->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t_sep_no_telp" class="form-group t_sep_no_telp">
<span<?php echo $t_sep->no_telp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sep->no_telp->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="x<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t_sep" data-field="x_no_telp" name="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" id="o<?php echo $t_sep_grid->RowIndex ?>_no_telp" value="<?php echo ew_HtmlEncode($t_sep->no_telp->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_sep_grid->ListOptions->Render("body", "right", $t_sep_grid->RowCnt);
?>
<script type="text/javascript">
ft_sepgrid.UpdateOpts(<?php echo $t_sep_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t_sep->CurrentMode == "add" || $t_sep->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t_sep_grid->FormKeyCountName ?>" id="<?php echo $t_sep_grid->FormKeyCountName ?>" value="<?php echo $t_sep_grid->KeyCount ?>">
<?php echo $t_sep_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_sep->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t_sep_grid->FormKeyCountName ?>" id="<?php echo $t_sep_grid->FormKeyCountName ?>" value="<?php echo $t_sep_grid->KeyCount ?>">
<?php echo $t_sep_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t_sep->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft_sepgrid">
</div>
<?php

// Close recordset
if ($t_sep_grid->Recordset)
	$t_sep_grid->Recordset->Close();
?>
<?php if ($t_sep_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t_sep_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t_sep_grid->TotalRecs == 0 && $t_sep->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_sep_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t_sep->Export == "") { ?>
<script type="text/javascript">
ft_sepgrid.Init();
</script>
<?php } ?>
<?php
$t_sep_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t_sep_grid->Page_Terminate();
?>
