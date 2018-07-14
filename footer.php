<?php if (@!$gbSkipHeaderFooter) { ?>
<!-- right column (end) -->
<!-- end SA main -->
</section>
<?php if (isset($gTimer)) $gTimer->Stop() ?>
<?php if ($EPI_CleanLoginPages && !$EPI_ExtraPage) { ?> </div> <?php } ?>
<!-- content (end) -->
<!-- footer (begin) --><!-- ** Note: Only licensed users are allowed to remove or change the following copyright statement. ** -->
<!-- footer SA begin -->
<div class="main-footer" <?php if ($EPI_CleanLoginPages && $EPI_ExtraPage) echo 'style = "display:none;"'; ?>>
<div class="row">
    <div class="col-xs-12 col-sm-6">
    <span class="text-muted"><?php echo "Copyright &copy; " . date("Y") . " " . $Language->ProjectPhrase("FooterText") ?></span>
    </div>
    <?php if (IsSysAdmin() && file_exists("epi/epi_serverstatus.php")) include("epi/epi_serverstatus.php"); ?>
    </div>
<!-- end col -->
</div>
<!-- end row -->
</div>
<!-- footer SA end -->
<!-- footer (end) -->	
<?php } ?>
<!-- modal dialog -->
<div id="ewModalDialog" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title pull-left"></h4>
                <div class="modal-date pull-right"></div>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- modal lookup dialog -->
<div id="ewModalLookupDialog" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- add option dialog -->
<div id="ewAddOptDialog" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary ewButton">
            <?php echo $Language->Phrase("AddBtn") ?>
            </button>
            <button type="button" class="btn btn-default ewButton" data-dismiss="modal">
            <?php echo $Language->Phrase("CancelBtn") ?>
            </button>
            </div>
        </div>
    </div>
</div>
<!-- message box -->
<div id="ewMsgBox" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ewPrompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton"><?php echo $Language->Phrase("MessageOK") ?></button><button type="button" class="btn btn-default ewButton" data-dismiss="modal"><?php echo $Language->Phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ewTimer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ewTooltip"></div>
<script type="text/javascript">
jQuery.get("<?php echo $EW_RELATIVE_PATH ?>phpjs/userevt13.js");
</script>
<script type="text/javascript">

// Write your global startup script here
// document.write("page loaded");

$(document).ready(function(){
	$("#btn_print_form_pendaftaran").click(function(){
		var v_idx = $("#hd_id_daftar").val();
		var v_nomr = $("#hd_nomr").val();
		var v_poly = $("#hd_kdpoly").val();
		$.post("cetak_formulir_pendaftaran_pasien.php?IDXDAFTAR="+v_idx+"&KDPOLY="+v_poly+"&NOMR="+v_nomr+"", function(data) {
			var w;
		 	$("#show_print").empty().html(data);
		 	w = window.open();
			w.document.write($("#show_print").html());
			w.print();
			w.close();
			$("#show_print").empty();
			});
	});
	$("#btn_pendaftaran").click(function(){

			//$url = "t_pendaftaranadd.php?flag=".$this->NOMR->CurrentValue;;
			var v_nomr = $("#hd_nomr").val();

			//alert(v_idx);
			//alert(v_nomr);

			window.open("t_pendaftaranadd.php?flag="+v_nomr+"");
	});
	$("#btn_buat_sep_rajal").click(function(){
			var v_idx = $("#hd_id_daftar").val();
			window.open("vw_bridging_sep_by_no_kartuedit.php?IDXDAFTAR="+v_idx +"");
	});
	$("#btn_buat_sep_rajal_by_noRujukan").click(function(){
			var v_idx = $("#hd_id_daftar").val();
			window.open("vw_bridging_sep_by_no_rujukanedit.php?IDXDAFTAR="+v_idx +"");
	});
	$("#btn_buat_sep_ranap").click(function(){
			var v_idx = $("#hd_id_daftar").val();
			window.open("vw_sep_rawat_inap_by_nokaedit.php?id_admission="+v_idx +"");
	});
	$("#btn_cetak_label").click(function(){
		var cd = $("#hd_id_daftar").val();
		var aa = $("#hd_nomr").val();
			$.post("cetak_label_pasien_rajal.php?idx="+cd+"&nomr="+aa+"", function(data) {
				var w;
				$("#show_label_identitas").empty().html(data);
				w = window.open();
				w.document.write($("#show_label_identitas").html());
				w.print();
				w.close();
				$("#show_label_identitas").empty();
			});
	});

	//
	$("#btn_cetak_gelang").click(function(){
		var cd = $("#hd_id_daftar").val();
		var aa = $("#hd_nomr").val();
			$.post("cetak_gelang_pasien_ranap.php?idx="+cd+"&nomr="+aa+"", function(data) {
				var w;
				$("#show_label_identitas").empty().html(data);
				w = window.open();
				w.document.write($("#show_label_identitas").html());
				w.print();
				w.close();
				$("#show_label_identitas").empty();
			});
	});
});
</script>
<?php if ($EPI_FixedMenu === 'Fixed') { ?>
<script src="adminlte/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<?php } ?>
<script src='epi/js/bootstrap-tagsinput.min.js'></script>
<script src="adminlte/dist/js/app.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$('#RootMenu li.active') .closest('li.treeview')  .addClass('active');
});
if ('<?php echo CurrentPageID(); ?>' == 'userpriv') {
	$('#tbl_userpriv').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"order": [], // remove to auto sort by name
		"info": true,
		"autoWidth": true,
		"columns": [
			{"orderable": true},
			{"orderable": false},
			{"orderable": false},
			{"orderable": false},
			{"orderable": false},
			{"orderable": false},
			{"orderable": false}
			]
  	});
}
</script>
</body>
</html>
