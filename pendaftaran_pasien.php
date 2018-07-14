<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pendaftaran_pasien_php = NULL; // Initialize page object first

class cpendaftaran_pasien_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pendaftaran_pasien.php';

	// Page object name
	var $PageObjName = 'pendaftaran_pasien_php';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pendaftaran_pasien.php', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// User table object (m_login)
		if (!isset($UserTable)) {
			$UserTable = new cm_login();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;
		if (@$_POST["customexport"] == "") {

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		 // Close connection

		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("custom", "pendaftaran_pasien_php", $url, "", "pendaftaran_pasien_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pendaftaran_pasien_php)) $pendaftaran_pasien_php = new cpendaftaran_pasien_php();

// Page init
$pendaftaran_pasien_php->Page_Init();

// Page main
$pendaftaran_pasien_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<?php if (!@$gbSkipHeaderFooter) { ?>
<div class="ewToolbar">
<?php
$pendaftaran_pasien_php->ShowMessage();
?>
</div>
<?php } ?>

<?php 

include 'phpcon/koneksi.php'; 
include 'phpcon/fungsi_col.php';


unset($_SESSION['register_nomr']);
unset($_SESSION['register_nama']);


$alert = epi_alert("ALERT EPI DEFAULT","cek alert menggunakan API EPI","success","full");
print  $alert;

$help = epi_helpBox("HELP BOX EPI DEFAULT", "cek HELP BOX menggunakan API EPI",false,6);
print $help;


$epi_sessionTimer = epi_sessionTimer();
print $epi_sessionTimer;
?>






<script type="text/javascript">
function startjam(){
	var d = new Date();
	var curr_hour = d.getHours();
	var curr_min = d.getMinutes();
	var curr_sec = d.getSeconds();
	document.getElementById('start_daftar').value=(curr_hour + ":" + curr_min+ ":" + curr_sec);
}




function stopjam(){
var d = new Date();
var curr_hour = d.getHours();
var curr_min = d.getMinutes();
var curr_sec = d.getSeconds();
document.getElementById('stop_daftar').value=(curr_hour + ":" + curr_min+ ":" + curr_sec);
}


$(document).ready(function() {
	
	//console.log("ok");
	//$('#form_pendaftaran').validate();
	$('.loader').hide();
	//jQuery('#KDCARABAYAR').hide();
	$('#grup_cara_bayar').hide();
	$('#div_ketrujuk').hide();
	
	
	
	$('#txt_nomr').attr('disabled','disabled').val('-automatic-');
	$("#div_cb_dokterjaga").hide();
	
	
	
	

	
	$('.statuspasien').change(function(){
	//$('input[type=radio][name=statuspasien]').change(function(){
		var status_val	= $(this).val();
		console.log(status_val);
		if(status_val == 1){
			$('#txt_nomr').attr('disabled','disabled').val('-automatic-');
			$('.loader').hide(); 
			$("#txt_no_kartu_jaminan").val('');
						$("#txt_nama_lengkap").val('');
						//$("#tx_TITLE").val('');			
						$("#txt_umur").val('');
						$("#cb_title").val('');
						$("#txt_tempat_lahir").val('');
						//$("#txt_tanggal_lahir").val'');
						$("#txt_alamat_lama").val('');
						$("#txt_alamat_ktp").val('');
						$("#txt_nama_ayah").val('');
						$("#txt_nama_ibu").val('');
						$("#txt_tlp_pasien").val('');
						$("#txt_nik").val('');
						$("#txt_nama_suami").val('');
						$("#txt_nama_istri").val('');
						$("#txt_nama_suami").val('');
						$("#txt_nama_istri").val('');
						$("#txt_pekerjaan_pasien").val('');
						$("#txt_penanggung_jawab").val('');
						$("#txt_hubungan_dengan_pasien").val('');
						$("#txt_alamat_penanggung_jawab").val('');
						$("#txt_tlp_penanggung_jawab").val('');
						$("#cb_etnis").val('');
						$("#cb_bahasa").val('');
						
						
						//$("input[name='jenis_pasien'][value='']").prop('checked', false);
						//$("input[name='pendidikan'][value='"+result.result.PENDIDIKAN+"']").prop('checked', true);
						//$("input[name='Status_perkawinan'][value='"+result.result.STATUS_PERKAWINAN+"']").prop('checked', true);
						//$("input[name='agama'][value='"+result.result.AGAMA+"']").prop('checked', true);
						//$("input[name='jenis_kelamin'][value='"+result.result.JENISKELAMIN+"']").prop('checked', true);
						
						
						//$("#KELURAHAN").val('');
						//$("#KDKECAMATAN").val('');
						//$("#KELURAHANHIDDEN").val('');
						//$("#KECAMATANHIDDEN").val('');
						//$("#KOTAHIDDEN").val('');
						//$("#KDPROVINSI").val('').change();
						//$("#KOTA").val('').change();
			
			
			
			
		}else{
			$('#txt_nomr').removeAttr('disabled').val('');
			//$('#PASIENBARU').val(0);	
		}
		
	});
	
	
	$('#cb_rujukan').change(function(){
		var status_val	= $(this).val();
		console.log(status_val);
		if(status_val == 1){
			$('#div_ketrujuk').hide();
		}else{
			$('#div_ketrujuk').show();
		}
		
	});
	
	
	
	$('#payplan').click(function(){
		var val	= jQuery(this).val();
		if(val >= 1){
			$('#grup_cara_bayar').show().addClass('required');
			$('#txt_no_kartu_jaminan').show().addClass('required');
			
			$('#div_tipe_jaminan').show();
			$('#div_no_kartu_jaminan').show();
			
			$('#txt_tipe_jaminan').show().addClass('required');
			
			}
	
	});
	
	
	
	$('#payplan1').click(function(){
		var val = jQuery(this).val();
		if(val == 1){
			$('#grup_cara_bayar').hide().removeClass('required');
			$('#txt_no_kartu_jaminan').hide().removeClass('required');
			$('#txt_tipe_jaminan').hide().removeClass('required');
			$('#div_tipe_jaminan').hide();
			$('#div_no_kartu_jaminan').hide();
			//$('#NOKARTU').hide().removeClass('required');

			
		}
		
	});
	
	
	
	
	$('#txt_nomr').blur(function(){
		var nomr	= $(this).val();
		if(nomr != ''){
			
			$('.loader').show();
			$.getJSON("ws/get_data_pasien_by_nomr.php", {noMR: $("#txt_nomr").val()},
				function(result){
					let status = result.result.code;
					if(status==200)
					{	
				
						$("#txt_no_kartu_jaminan").val(result.result.NO_KARTU);
						$("#txt_nama_lengkap").val(result.result.NAMA);
						$("#tx_TITLE").val(result.result.TITLE);			
						$("#txt_umur").val(result.result.UMUR);
						$("#cb_title").val(result.result.TITLE);
						
						
						$("#txt_tempat_lahir").val(result.result.TEMPAT);
						$("#txt_tanggal_lahir").val(result.result.TGLLAHIR);
						$("#txt_alamat_lama").val(result.result.ALAMAT);
						$("#txt_alamat_ktp").val(result.result.ALAMAT_KTP);
	
						$("#txt_nama_ayah").val(result.result.nama_ayah);
						$("#txt_nama_ibu").val(result.result.nama_ibu);
						
						$("#txt_tlp_pasien").val(result.result.NOTELP);
						$("#txt_nik").val(result.result.NOKTP);
						
						
						$("#txt_nama_suami").val(result.result.NAMA_SUAMI);
						$("#txt_nama_istri").val(result.result.nama_istri);
						$("#txt_nama_suami").val(result.result.NAMA_SUAMI);
						$("#txt_nama_istri").val(result.result.nama_istri);
						$("#txt_pekerjaan_pasien").val(result.result.PEKERJAAN);
						
						
						
						$("#txt_penanggung_jawab").val(result.result.PENANGGUNGJAWAB_NAMA);
						$("#txt_hubungan_dengan_pasien").val(result.result.PENANGGUNGJAWAB_HUBUNGAN);
						$("#txt_alamat_penanggung_jawab").val(result.result.PENANGGUNGJAWAB_ALAMAT);
						$("#txt_tlp_penanggung_jawab").val(result.result.PENANGGUNGJAWAB_PHONE);
						
						
						
						$("#cb_etnis").val(result.result.KD_ETNIS);
						$("#cb_bahasa").val(result.result.KD_BHS_HARIAN);
						
						alert(result.result.JNS_PASIEN);
						$("input[name='jenis_pasien'][value='"+result.result.JNS_PASIEN+"']").prop('checked', true);
						$("input[name='pendidikan'][value='"+result.result.PENDIDIKAN+"']").prop('checked', true);
						$("input[name='Status_perkawinan'][value='"+result.result.STATUS_PERKAWINAN+"']").prop('checked', true);
						$("input[name='agama'][value='"+result.result.AGAMA+"']").prop('checked', true);
						$("input[name='jenis_kelamin'][value='"+result.result.JENISKELAMIN+"']").prop('checked', true);
						
						
						$("#KELURAHAN").val(result.result.KELURAHAN);
						$("#KDKECAMATAN").val(result.result.KDKECAMATAN);
						$("#KELURAHANHIDDEN").val(result.result.KELURAHAN);
						$("#KECAMATANHIDDEN").val(result.result.KDKECAMATAN);
						$("#KOTAHIDDEN").val(result.result.KOTA);
						$("#KDPROVINSI").val(result.result.KDPROVINSI).change();
						$("#KOTA").val(result.result.KOTA).change();
						//alert('\n'+result.result.KDPROVINSI+'\n'+result.result.KOTA+'\n'+result.result.KDKECAMATAN+'\n'+result.result.KELURAHAN);
						alert(result.result.KDPROVINSI);
						
						
					}else{
						
						alert(result.result.message);
					}
				});         
			
			
			$('.loader').hide();
			
			
		}
	});
	
	
	$('#txt_tanggal_lahir').blur(function(){
		var tgl_lahir	= $(this).val();
		if(tgl_lahir != ''){
		
			console.log(tgl_lahir);
			$.getJSON("ws/get_umur_pasien.php", {tglLahir: tgl_lahir},
			function(result){
				$("#txt_umur").val(result.result[0]+" tahun "+result.result[1]+" bulan "+result.result[2]+" hari");	
			});
					
		}
	});
	
	
	$.ajax({
			url: 'json_model/m_rujukan.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_rujukan").empty();
				for( var i = 0; i<len; i++){
					var kode = response[i]['KODE'];
					var nama = response[i]['NAMA'];
					
					$("#cb_rujukan").append("<option value='"+kode+"'>"+nama+"</option>");
				}
			}
	});
	
	
	$.ajax({
			url: 'json_model/m_cara_bayar.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_cara_bayar").empty();
				$("#cb_cara_bayar").append("<option value ='1'  > - pilih cara bayar - </option>");
				for( var i = 0; i<len; i++){
					var KODE = response[i]['KODE'];
					var NAMA = response[i]['NAMA'];
					
					$("#cb_cara_bayar").append("<option value='"+KODE+"'>"+NAMA+"</option>");
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_agama.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['agama'];
				   $('#cb_agama').append('<input type="radio" name="agama"   value="'+KODE+'" required="required" /> '+NAMA+'</br>');
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/m_etnis.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_etnis").empty();
				$("#cb_etnis").append("<option value='0' > - pilih etnis - </option>");
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['nama_etnis'];
					
					$("#cb_etnis").append("<option value='"+KODE+"'>"+NAMA+"</option>");
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/m_bahasa_sehari_hari.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_bahasa").empty();
				$("#cb_bahasa").append("<option value='0' > - pilih bahasa - </option>");
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['bahasa_harian'];
					
					$("#cb_bahasa").append("<option value='"+KODE+"'>"+NAMA+"</option>");
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_titel.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_title").empty();
				$("#cb_title").append("<option value='0' > - pilih - </option>");
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['title'];
					
					$("#cb_title").append("<option value='"+KODE+"'>"+NAMA+"</option>");
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_status_perkawinan.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
			   // $("#cb_status_perkawinan").empty();
				
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['statusperkawinan'];
					//&nbsp;
						$('#cb_status_perkawinan').append('<input type="radio" name="Status_perkawinan"    value="'+KODE+'"  required="required" /> '+NAMA+'</br>');
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_pendididkan_terakhir.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
			   // $("#cb_status_perkawinan").empty();
				
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['pendidikan'];
					//&nbsp;
						$('#cb_pendidikan').append('<input type="radio" name="pendidikan"   value="'+KODE+'" required="required" /> '+NAMA+'</br>');
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_jenis_kelamin.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				var KODE = '';
				//$("#cb_jenis_kelamin").empty();
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					//var NAMA = response[i]['jeniskelamin'];
					//&nbsp;
						$('#cb_jenis_kelamin').append('<input type="radio" name="jenis_kelamin"    value="'+KODE+'" required="required" /> '+KODE+'&nbsp;&nbsp;');
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_jenis_pasien.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				//$("#cb_jenis_kelamin").empty();
				for( var i = 0; i<len; i++){
					var KODE = response[i]['jenis_pasien'];
					var NAMA = response[i]['jenis_pasien'];
					//&nbsp;
						$('#cb_jenis_pasien').append('<input type="radio" name="jenis_pasien"   value="'+KODE+'"  required="required"/> '+KODE+'&nbsp;&nbsp;');
				}
		   }
	});
	
	$.ajax({
			url: 'json_model/l_pasienbarulama.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				//$("#cb_jenis_kelamin").empty();
				for( var i = 0; i<len; i++){
					var KODE = response[i]['id'];
					var NAMA = response[i]['pasienbaru'];
					//&nbsp;
						$('#div_statuspasien').append('<input type="radio" class="rButton" name="statuspasien" id="statuspasien_'+KODE+'"   value="'+KODE+'"  /> '+NAMA+'&nbsp;&nbsp;');
				}
		   }
	});
	

	$.ajax({
			url: 'json_model/m_poly.php',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				$("#cb_poly").empty();
				$("#cb_poly").append("<option value = '' >"+'Pilih Poly'+"</option>");
				for( var i = 0; i<len; i++){
					var kode = response[i]['kode'];
					var nama = response[i]['nama'];
					
					$("#cb_poly").append("<option value='"+kode+"'>"+nama+"</option>");
				}
			}
	});
	

	$("#cb_poly").change(function(){
		var kdpoly = $(this).val();
		$("#cb_dokterjaga").removeAttr('disabled');
		$.ajax({url: 'json_model/m_dokter_jaga_rajal.php',type: 'post',data: {kdpoly:kdpoly},dataType: 'json', success:function(response){
				var len = response.length;
				$("#div_cb_dokterjaga").show();
			
				$("#cb_dokterjaga").empty();
				$("#cb_dokterjaga").append("<option value = '' >"+'-- Pilih Dokter Jaga --'+"</option>");
				for( var i = 0; i<len; i++){
					var id = response[i]['kddokter'];
					var name = response[i]['NAMADOKTER'];
					$("#cb_dokterjaga").append("<option value='"+id+"'>"+name+"</option>");
				}
			}
		});
	   
	});
	
	
	  $("#KDPROVINSI").change(function(){
			var selectValues = $("#KDPROVINSI").val();
			console.log(selectValues);
			var kotaHidden = $("#KOTAHIDDEN").val();
			var kecHidden = $("#KECAMATANHIDDEN").val();
    $.post('phpcon/ajxload.php',{kdprov:selectValues, kdkota:kotaHidden, kdkec:kecHidden, load_kota:'true'},function(data){
      $('#kotapilih').html(data);
      $('#KOTA').val(kotaHidden).change();
      $('#kecamatanpilih').html("<select class=\"form-control\" name=\"KDKECAMATAN\" class=\"text required\" title=\"*\" id=\"KDKECAMATAN\"><option value=\"0\"> --pilih from jquery-- </option>");
	  $('#kelurahanpilih').html("<select class=\"form-control\" name=\"KELURAHAN\" class=\"text required\" title=\"*\" id=\"KELURAHAN\"><option value=\"0\"> --pilih from jquery-- </option>");

	});
  });
	
}); 

</script>



<style type="text/css">
.loader{background:url(js/loading.gif) no-repeat; width:16px; height:16px; float:right; margin-right:30px;}
.loader2{background:url(js/loading.gif) no-repeat; width:16px; height:16px; float:right; margin-right:30px;}
input.error{ border:1px solid #F00;}
label.error{ color:#F00; font-weight:bold;}
</style>
	  <!-- Content Wrapper. Contains page content -->
	

		<!-- Main content -->
	  
				
				<div class="row" >
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form name="form_pendaftaran" id="form_pendaftaran"
										enctype="multipart/form-data" onsubmit="return validate(this)" 
										 data-parsley-validate
										class="form-horizontal form-label-left" action="pendaftaran_pasien_proses.php" method="post">
										
									
							<div class="box box-success">
								<div class="box-header with-border">
									<h3 class="box-title">Pendaftaran</h3>
								</div>					
								<div class="box-body">
								
								 <div class="col-lg-6 col-md-6 col-sm-6">
								
								
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Status Pasien<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<!-- <input type="text" name="txt_status_pasien"  class="form-control col-md-7 col-xs-12" > -->
												<!-- <div id="div_statuspasien" name="div_statuspasien">
												
							
												</div> -->
												
													<input type="radio"  name="STATUSPASIEN" id="STATUSPASIEN_1" class="statuspasien" value="1" checked="checked" >  Baru
													<input type="radio"  name="STATUSPASIEN" id="STATUSPASIEN_0" class="statuspasien" value="0" >  Lama
												
												
													
		
											</div>
										 </div>
										 
										 
										 <div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">NOMR<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<input type="text" name="txt_nomr" id="txt_nomr"   class="form-control col-md-7 col-xs-12" >
											</div>
										 </div>
										 
										 
										 
								
										 
										 <div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Poli<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<select required class="form-control" id ="cb_poly"  name="cb_poly">
												
													</select>
											</div>
										 </div>
										 
										  <div class="form-group" id= "div_cb_dokterjaga">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Dokter Jaga<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<select required class="form-control" id ="cb_dokterjaga"  name="cb_dokterjaga">
													 
													</select>
											</div>
										 </div>
										 
										 
									
										 
										 
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Minta Rujukan<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												
												<input type="checkbox" name="minta_rujukan"  id="minta_rujukan" value="1" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Tgl Daftar<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<input type="date" value="<?php echo date("Y-m-d");?>" 
												name="txt_tgl_daftar" id="txt_tgl_daftar"   
												required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
												min = "<?php echo date('Y-m-d', strtotime(' - 1 days')); ?>"
												max = "<?php echo date('Y-m-d', strtotime(' + 0 days')); ?>"
												class="form-control col-md-7 col-xs-12"  >
											</div>
										</div>
										
										
										<div class="form-group"  >
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Cara Bayar<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
											<input type="radio" name="payplan" id="payplan1" class="required" title="*" value="1"  <?php echo "Checked";?> required="required" />
											  Umum
											<input type="radio" name="payplan" id="payplan" class="required" title="*" value="2" required="required"  />
												Asuransi/ Jaminan	
											</div>
										</div>
										
										<div class="form-group" id="grup_cara_bayar" >
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Jenis Jaminan<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<select required class="form-control" id="cb_cara_bayar" name="cb_cara_bayar" >
												
							
												</select>
												
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Rujukan<span class="required">:</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-9">
												<select class="form-control" id="cb_rujukan" name="cb_rujukan" >
							
												</select>
											</div>
										</div>
										
						
										<div class="form-group" id = "div_ketrujuk">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Asal Faskes<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_ketrujuk"  id="txt_ketrujuk"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
								
										
										

									</div>
									
									
								<div class="col-lg-6 col-md-6 col-sm-6">
								 
									<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Shift <span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<!-- <input type="text" name="txt_shift"  class="form-control col-md-7 col-xs-12" > -->
												<input type="radio" name="SHIFT" class="required" title="*" value="1" checked  />
												1
												<input type="radio" name="SHIFT" class="required" title="*" value="2"  />
												2
												<input type="radio" name="SHIFT" class="required" title="*" value="3" />
												3
											</div>
										</div>
								 
								 </div>
									
									
									
								</div>
								
							</div>
			   
			   
			   
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Identitas Pasien</h3>
					</div>
					
					
					<div class="box-body">
					
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6">

										<div class="form-group" id = "div_no_kartu_jaminan" >
											<label class="control-label col-md-3 col-sm-3  col-xs-12">NoKartu Jaminan<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_no_kartu_jaminan"  id="txt_no_kartu_jaminan" class="form-control col-md-7 col-xs-12" >
											</div>
										 </div>
										 
										 
										 <div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama Lengkap<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nama_lengkap" required="required" id="txt_nama_lengkap"  class="form-control col-md-7 col-xs-12" >
											</div>
										 </div>
										 
										 
										 
										 <div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Alias<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">	
												<select class="form-control" id ="cb_title" name="cb_title" >
												
													</select>
											</div>
										 </div>
										 
										 
										 
										 
										 <div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Tempat Lahir<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_tempat_lahir"  required="required"  id="txt_tempat_lahir"    class="form-control col-md-7 col-xs-12" >
											</div>
										 </div>
										 
										 
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Tanggal Lahir<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="date" 
												value="<?php echo date("Y-m-d");?>"  
												name="txt_tanggal_lahir" id="txt_tanggal_lahir"
												max = "<?php echo date('Y-m-d', strtotime(' + 0 days')); ?>"

												class="form-control col-md-7 col-xs-12" required  >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Umur<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_umur"  id="txt_umur"  required="required"  readonly class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Alamat KTP<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_alamat_ktp" id="txt_alamat_ktp"   class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Alamat Lama<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_alamat_lama" id="txt_alamat_lama"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Provinsi<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											
												 <select class="form-control" name="KDPROVINSI" class="text required"  title="*" id="KDPROVINSI">
															<option value="0"> --pilih from html-- </option>
													  <?php
														$sql_provinsi = "select * from m_provinsi order by idprovinsi ASC";
														//print $sql_provinsi;
														$query_provinsi = mysqli_query($conn,$sql_provinsi);
																$sel;
																while($data = mysqli_fetch_array($query_provinsi,MYSQLI_ASSOC)){
																	
																	if($_GET['KDPROVINSI'] == $data['idprovinsi']){ 
																		$sel = "selected=Selected"; 
																	}else{
																		$sel = "";
																	}
																	echo '<option value="'.$data['idprovinsi'].'" '.$sel.' > '.$data['namaprovinsi'].'</option>';
																}
												
													  ?>
														  </select>
														  
													<input class="text"  value="<?php echo isset($_GET['KOTA']);?>" type="hidden" name="KOTAHIDDEN" id="KOTAHIDDEN" >
													<input  class="text" value="<?php echo isset($_GET['KECAMATAN']);?>" type="hidden" name="KECAMATANHIDDEN" id="KECAMATANHIDDEN" >
													<input  class="text" value="<?php echo isset($_GET['KELURAHAN']);?>" type="hidden" name="KELURAHANHIDDEN" id="KELURAHANHIDDEN" ></td>
												
												
												
												
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Kabupaten/Kota<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12" id="kotapilih">
													 <select class="form-control" name="KOTA" class="text required"  title="*" id="KOTA">
														<option value="0"> --pilih from html-- </option>
													  <?php
														$sql_kabupaten = "select * from m_kota where idprovinsi = ".$_GET['KDPROVINSI']." order by idkota ASC";
														//print $sql_provinsi;
														$query_kabupaten = mysqli_query($conn,$sql_kabupaten);
																$sel;
																while($data = mysqli_fetch_array($query_kabupaten,MYSQLI_ASSOC)){
																	
																	if($_GET['KOTA'] == $data['idkota']){ 
																		$sel = "selected=Selected"; 
																	}else{
																		$sel = "";
																	}
																	echo '<option value="'.$data['idkota'].'" '.$sel.' > '.$data['namakota'].'</option>';
																}
												
													  ?>
														  </select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Kecamatan<span class="required">:</span>
											</label>
											<div id="kecamatanpilih" class="col-md-6 col-sm-6 col-xs-12">
													 <select class="form-control" name="KDKECAMATAN" class="text required" title="*"   id="KDKECAMATAN">
															<option value="0"> --pilih from html-- </option>
													  <?php
														$sql_kecamatan = "select * from m_kecamatan where idkota = ".$_GET['KOTA']." order by idkecamatan ASC";
														//print $sql_provinsi;
														$query_kecamatan = mysqli_query($conn,$sql_kecamatan);
																$sel;
																while($data = mysqli_fetch_array($query_kecamatan,MYSQLI_ASSOC)){
																	
																	if($_GET['KDKECAMATAN'] == $data['idkecamatan']){ 
																		$sel = "selected=Selected"; 
																	}else{
																		$sel = "";
																	}
																	echo '<option value="'.$data['idkecamatan'].'" '.$sel.' > '.$data['namakecamatan'].'</option>';
																}
												
													  ?>
														  </select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Kelurahan<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12" id="kelurahanpilih" >
												 <select class="form-control" name="KELURAHAN" class="text required" title="*" id="KELURAHAN" >
															<option value="0"> --pilih from html-- </option>
													  <?php
														$sql_keluarahan = "select * from m_kelurahan where idkecamatan = ".$_GET['KDKECAMATAN']." order by idkelurahan ASC";
														//print $sql_provinsi;
														$query_kelurahan = mysqli_query($conn,$sql_keluarahan);
																$sel;
																while($data = mysqli_fetch_array($query_kelurahan,MYSQLI_ASSOC)){
																	
																	if($_GET['KELURAHAN'] == $data['idkelurahan']){ 
																		$sel = "selected=Selected"; 
																	}else{
																		$sel = "";
																	}
																	echo '<option value="'.$data['idkelurahan'].'" '.$sel.' > '.$data['namakelurahan'].'</option>';
																}
												
													  ?>
														  </select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama Ayah<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nama_ayah"  required="required" id="txt_nama_ayah"   class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama Ibu<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nama_ibu" required="required"  id="txt_nama_ibu"   class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">No TLP<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_tlp_pasien"  required="required" id="txt_tlp_pasien"   class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">NIK<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nik"  id="txt_nik" required="required"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama Suami<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nama_suami"  required="required" id="txt_nama_suami"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama Istri<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_nama_istri"  required="required"  id="txt_nama_istri" class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Pekerjaan Pasien<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_pekerjaan_pasien" required="required"   id="txt_pekerjaan_pasien" class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
						
										
							
										
										
							
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Etnis/Suku<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">

												<select class="form-control" id ="cb_etnis" name="cb_etnis" >
												
													</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Bahasa Harian<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">												
												<select class="form-control" id ="cb_bahasa" name="cb_bahasa" >
												
													</select>
											</div>
										</div> 
										
										

							</div>
									
									
							<div class="col-lg-6 col-md-6 col-sm-6">
									 
										<div class="form-group" id = "div_tipe_jaminan">
												<label class="control-label col-md-3 col-sm-3  col-xs-12">Jenis Pasien <span class="required">:</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div id="cb_jenis_pasien" name="cb_jenis_pasien" >
												
							
													</div>
												</div>
										</div>
										
										
										<div class="form-group">
												<label class="control-label col-md-3 col-sm-3  col-xs-12">Jenis Kelamin <span class="required">:</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div id="cb_jenis_kelamin" name="cb_jenis_kelamin" >
												
							
													</div>
												</div>
										</div>
										
										
										<div class="form-group">
												<label class="control-label col-md-3 col-sm-3  col-xs-12">Status Perkawinan<span class="required">:</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
													
													<div id="cb_status_perkawinan" name="cb_status_perkawinan" >
												
							
													</div>
												
												</div>
										</div>
										
										
										
										<div class="form-group">
												<label class="control-label col-md-3 col-sm-3  col-xs-12">Pendidikan<span class="required">:</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div id="cb_pendidikan" name="cb_pendidikan" >
												
							
													</div>
												</div>
										</div>
										
										
										<div class="form-group">
												<label class="control-label col-md-3 col-sm-3  col-xs-12">Agama <span class="required">:</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div  id ="cb_agama" name="cb_agama" >
												
													</div>
												</div>
										</div> 
									 
									 
									 
							</div>		
						</div>
					
						
					</div>
								
									 
				</div>
				
				
				
						<div class="box box-success">
								<div class="box-header with-border">
									<h3 class="box-title">Data Penanggung Jawab Pasien</h3>
								</div>					
								<div class="box-body">
								<div class="row">
								
								 <div class="col-lg-6 col-md-6 col-sm-6">
								 
								 			<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Nama<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_penanggung_jawab" id="txt_penanggung_jawab"  required="required"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Hubungan<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_hubungan_dengan_pasien"  required="required"  id="txt_hubungan_dengan_pasien"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
										
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">Alamat<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_alamat_penanggung_jawab"  required="required" id="txt_alamat_penanggung_jawab"  class="form-control col-md-7 col-xs-12" >
											</div>
										</div>
										
													<div class="form-group">
											<label class="control-label col-md-3 col-sm-3  col-xs-12">No.TLP<span class="required">:</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="txt_tlp_penanggung_jawab" required="required" 
												id="txt_tlp_penanggung_jawab" class="form-control col-md-7 col-xs-12"  >
											</div>
										</div>
								
							
					

								</div>
									
									
								<div class="col-lg-6 col-md-6 col-sm-6">
								 
						
								 
								 </div>
								 </div>
								 
								 <div class="ln_solid"></div>
									
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
												<a href="home.php" class="btn btn-warning">Batal </a>
												<input class="btn btn-success"  id= "btn_simpan_anggota" name="simpan" type="submit" value="Simpan">
											</div>
										</div>
									
									
									
								</div>
								
							</div>
			
			 </form>
		</div>
		</div>
		
		
<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$pendaftaran_pasien_php->Page_Terminate();
?>
