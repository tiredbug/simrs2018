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

$pendaftaran_pasien_proses_php = NULL; // Initialize page object first

class cpendaftaran_pasien_proses_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pendaftaran_pasien_proses.php';

	// Page object name
	var $PageObjName = 'pendaftaran_pasien_proses_php';

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
			define("EW_TABLE_NAME", 'pendaftaran_pasien_proses.php', TRUE);

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
		$Breadcrumb->Add("custom", "pendaftaran_pasien_proses_php", $url, "", "pendaftaran_pasien_proses_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pendaftaran_pasien_proses_php)) $pendaftaran_pasien_proses_php = new cpendaftaran_pasien_proses_php();

// Page init
$pendaftaran_pasien_proses_php->Page_Init();

// Page main
$pendaftaran_pasien_proses_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<?php if (!@$gbSkipHeaderFooter) { ?>
<div class="ewToolbar">
<?php
$pendaftaran_pasien_proses_php->ShowMessage();
?>
</div>
<?php } ?>
<?php
//session_start();


include 'phpcon/koneksi.php'; 
include 'phpcon/fungsi_col.php';


//tangkap data dari form


if((empty($_SESSION['register_nomr'])) && (empty($_SESSION['register_nama'])) ){ 


$_error_msg = "";

$nomr = "";
$ketemu = "0";
$minta_rujukan;
$ket_rujuk='';
$NAMADATA;


echo '<pre>';
print_r($_POST);
echo '</pre>';


if ($_POST['cb_rujukan'] == 1)
{
	$ket_rujuk =  'DIRI SENDIRI';
	//echo '</br>'
	//print "$_POST[cb_rujukan] : ".$_POST['cb_rujukan'];
	//echo '</br>'
}else {
	
	$ket_rujuk = $_POST['txt_ketrujuk'];
}

/*echo '<pre>';
print_r($_SESSION);
echo '</pre>'; */






	if(trim(isset($_POST['txt_nomr'])) != ''){
		if($_POST['STATUSPASIEN']=="1"){
			$sqlsearchpasien = "select NAMA from m_pasien WHERE NOMR = '".trim($_POST['txt_nomr'])."'";
			print $sqlsearchpasien;
			$sql = mysqli_query($conn,$sqlsearchpasien);
			if(mysqli_num_rows($sql) > 0){
				$nomr 	= get_nomr_baru();
			}else{
				$nomr	= trim($_POST['txt_nomr']);
			}
		
		}else{
			
			$sqlsearchpasien = "select NAMA from m_pasien WHERE NOMR = '".trim($_POST['txt_nomr'])."'";
			print $sqlsearchpasien;
			$sql = mysqli_query($conn,$sqlsearchpasien);
			if(mysqli_num_rows($sql) > 0){
				$ketemu = "1";
				$nomr	= trim($_POST['txt_nomr']);
			}else{
				$nomr 	= get_nomr_baru();
			}
			
		}
		
		
	}else{
		$nomr 	= get_nomr_baru();
		print $nomr ;
		$ketemu	= 0;
	}
	

	
	
	if($_POST['jenis_kelamin']=="") $_error_msg = $_error_msg."Jenis Kelamin Belum Dipilih, ";
	if($_POST['jenis_pasien']=="") $_error_msg = $_error_msg."jenis_pasien Belum Dipilih, ";
	if($_POST['cb_cara_bayar']=="") $_error_msg = $_error_msg."cb_cara_bayar Belum Dipilih, ";
	if($_POST['cb_poly']=="") $_error_msg = $_error_msg."cb_poly Belum Dipilih, ";
	
	
	if(strlen($_error_msg)>0) {
		$_error_msg = substr($_error_msg,0,strlen($_error_msg)-2).".";
		?>
		<SCRIPT language="JavaScript">
			alert("<?=$_error_msg?>");
			window.location="pendaftaran_pasien.php";
		</SCRIPT>
		<?php
	}else{ 
		
		
		
		   if(empty($_POST['minta_rujukan'])) {
				$minta_rujukan = "0";
			}else {
				$minta_rujukan = "1";
			}
			
			
			if(!empty($_POST['cb_title'])) {
				$NAMADATA=str_replace(',',' ',$_POST['txt_nama_lengkap']).', '.$_POST['cb_title'];
			}else {
				$NAMADATA=str_replace(',',' ',$_POST['txt_nama_lengkap']);
			}
	
			$tmpTGLLAHIR = date('Y-m-d', strtotime(str_replace('/','-',$_POST['txt_tanggal_lahir'])));
			
			if($ketemu == "1") {
				$update_sql= "UPDATE m_pasien SET
				  NAMA  = '".addslashes($NAMADATA)."', 
				  TEMPAT  = '".addslashes($_POST['txt_tempat_lahir'])."',  
				  TGLLAHIR  = '".trim($tmpTGLLAHIR)."', 
				  JENISKELAMIN  = '".$_POST['jenis_kelamin']."', 
				  ALAMAT  = '".trim($_POST['txt_alamat_ktp'])."', 
				  KELURAHAN  = '".addslashes($_POST['KELURAHAN'])."', 
				  KDKECAMATAN  = ".addslashes($_POST['KDKECAMATAN']).", 
				  KOTA  = '".addslashes($_POST['KOTA'])."', 
				  KDPROVINSI  = ".addslashes($_POST['KDPROVINSI']).", 
				  NOTELP  = '".trim($_POST['txt_tlp_pasien'])."', 
				  NOKTP  = '".trim($_POST['txt_nik'])."',  
				  SUAMI_ORTU  = '".str_replace("'","",$_POST['txt_nama_suami'])."', 
				  PEKERJAAN  = '".addslashes($_POST['txt_pekerjaan_pasien'])."',  
				  STATUS  = ".trim($_POST['Status_perkawinan']).", 
				  AGAMA  = ".trim($_POST['agama']).",  
				  PENDIDIKAN  = ".trim($_POST['pendidikan']).", 
				  KDCARABAYAR  = ".trim($_POST['cb_cara_bayar']).",  
				  NIP  = '".trim(CurrentUserName())."',
				  ALAMAT_KTP = '".addslashes($_POST['txt_alamat_ktp'])."',
				  TITLE = '".$_REQUEST['cb_title']."',
				  PENANGGUNGJAWAB_NAMA = '".trim($_POST['txt_penanggung_jawab'])."',
				  PENANGGUNGJAWAB_HUBUNGAN = '".trim($_POST['txt_hubungan_dengan_pasien'])."',
				  PENANGGUNGJAWAB_ALAMAT = '".trim($_POST['txt_alamat_penanggung_jawab'])."',
				  PENANGGUNGJAWAB_PHONE = '".trim($_POST['txt_tlp_penanggung_jawab'])."',
				  
				  NO_KARTU = '".trim($_POST['txt_no_kartu_jaminan'])."',
				  JNS_PASIEN = '".$_POST['jenis_pasien']."',
				  
				  nama_ayah = '".trim($_POST['txt_nama_ayah'])."',
				  nama_ibu = '".trim($_POST['txt_nama_ibu'])."',
				  nama_istri = '".trim($_POST['txt_nama_istri'])."',
				  
				  
				  KD_ETNIS = '".trim($_POST['cb_etnis'])."',
				  KD_BHS_HARIAN = '".trim($_POST['cb_bahasa'])."'
			WHERE NOMR =  '".$nomr."' ";
			
				print $update_sql ;
				$eeeeee = $conn->query($update_sql); // NOMR_LAMA = '".trim($_POST['NOMR2'])."',

			}else{
				 $sqlinsert_pasien = "INSERT INTO m_pasien (NOMR, NAMA, TEMPAT, TGLLAHIR, JENISKELAMIN, ALAMAT, KELURAHAN, KDKECAMATAN, KOTA, 
				KDPROVINSI, NOTELP, NOKTP, SUAMI_ORTU, PEKERJAAN, STATUS, AGAMA, PENDIDIKAN, KDCARABAYAR, NIP,TGLDAFTAR, ALAMAT_KTP,
				TITLE,PENANGGUNGJAWAB_NAMA, PENANGGUNGJAWAB_HUBUNGAN, PENANGGUNGJAWAB_ALAMAT, PENANGGUNGJAWAB_PHONE, NOMR_LAMA,
				NO_KARTU, JNS_PASIEN, nama_ayah, nama_ibu, nama_istri,KD_ETNIS,KD_BHS_HARIAN,IBUKANDUNG) VALUES('".$nomr."',
				'".addslashes($NAMADATA)."',
				'".addslashes($_POST['txt_tempat_lahir'])."',
				'".trim($tmpTGLLAHIR)."',
				'".$_POST['jenis_kelamin']."',
				'".addslashes($_POST['txt_alamat_ktp'])."',
				'".addslashes($_POST['KELURAHAN'])."',
				'".trim($_POST['KDKECAMATAN'])."',
				'".addslashes($_POST['KOTA'])."',
				'".trim($_POST['KDPROVINSI'])."',
				'".addslashes($_POST['txt_tlp_pasien'])."',
				'".addslashes($_POST['txt_nik'])."',
				'".addslashes($_POST['txt_nama_suami'])."',
				'".addslashes($_POST['txt_pekerjaan_pasien'])."',
				'".trim($_POST['Status_perkawinan'])."',
				'".trim($_POST['agama'])."',
				'".trim($_POST['pendidikan'])."',
				'".trim($_POST['cb_cara_bayar'])."',
				'".trim(CurrentUserName())."',
				'".$_POST['txt_tgl_daftar']."', 
				'".trim($_POST['txt_alamat_ktp'])."',
				'".$_POST['cb_title']."',
				'".trim($_POST['txt_penanggung_jawab'])."', 
				'".trim($_POST['txt_hubungan_dengan_pasien'])."',
				'".trim($_POST['txt_alamat_penanggung_jawab'])."', 
				'".trim($_POST['txt_tlp_penanggung_jawab'])."', 
				'".trim(isset($_POST['NOMR2']))."', 
				'".trim($_POST['txt_no_kartu_jaminan'])."',
				'".$_POST['jenis_pasien']."', 
				
				'".trim($_POST['txt_nama_ayah'])."', 
				'".trim($_POST['txt_nama_ibu'])."', 
				'".trim($_POST['txt_nama_istri'])."', 
				'".trim($_POST['cb_etnis'])."',
				'".trim($_POST['cb_bahasa'])."', 
				'".trim($_POST['txt_nama_ibu'])."')";
				
				
				print '</br>';print $sqlinsert_pasien ;
				
				$insert_pasien = $conn->query($sqlinsert_pasien);
				
				
				
				$sql_update_max_mr = "update m_maxnomr set nomor=".$nomr." ";
				$update_max_mr = $conn->query($sql_update_max_mr);
			}
			
			
			
			
			if($_POST['cb_poly']=="9" || $_POST['cb_poly']=="10") {
	
				$sqlinsert_pendaftaran = "INSERT INTO t_pendaftaran (NOMR,
														TGLREG,KDDOKTER,KDPOLY,
														KDRUJUK,KDCARABAYAR,NOJAMINAN,
														JAMREG, MASUKPOLY,MINTA_RUJUKAN,
														SHIFT,PASIENBARU,NIP,
														KETRUJUK,PENANGGUNGJAWAB_NAMA, PENANGGUNGJAWAB_HUBUNGAN, 
														PENANGGUNGJAWAB_ALAMAT, PENANGGUNGJAWAB_PHONE,
														status,KETBAYAR,NOKARTU) 
														VALUES('".$nomr."',
														'".trim($_POST['txt_tgl_daftar'])."',".trim($_POST['cb_dokterjaga']).",'".trim($_POST['cb_poly'])."',
														'".trim($_POST['cb_rujukan'])."','".trim($_POST['cb_cara_bayar'])."','".trim(isset($_POST['NOJAMINAN']))."',
														now(), current_time(), '".$minta_rujukan."',
														'".trim($_POST['SHIFT'])."','".trim($_POST['STATUSPASIEN'])."','".CurrentUserName()."',
														'".$ket_rujuk."','".trim($_POST['txt_penanggung_jawab'])."', '".trim($_POST['txt_hubungan_dengan_pasien'])."',
														'".trim($_POST['txt_alamat_penanggung_jawab'])."', '".trim($_POST['txt_tlp_penanggung_jawab'])."',
														0,'".isset($_POST['KETBAYAR'])."','".trim($_POST['txt_no_kartu_jaminan'])."')";
    
			}else{
				 $sqlinsert_pendaftaran = "INSERT INTO t_pendaftaran (NOMR, 
															TGLREG, KDDOKTER, KDPOLY,
															KDRUJUK, KDCARABAYAR, NOJAMINAN,
															SHIFT, STATUS, PASIENBARU,
															NIP, KETRUJUK, PENANGGUNGJAWAB_NAMA,
															PENANGGUNGJAWAB_HUBUNGAN, PENANGGUNGJAWAB_ALAMAT,
															PENANGGUNGJAWAB_PHONE, JAMREG, MINTA_RUJUKAN,KETBAYAR,
															NOKARTU)
								VALUES('".$nomr."',
								'".trim($_POST['txt_tgl_daftar'])."','".trim($_POST['cb_dokterjaga'])."','".trim($_POST['cb_poly'])."',
								'".trim($_POST['cb_rujukan'])."','".trim($_POST['cb_cara_bayar'])."','".trim(isset($_POST['NOJAMINAN']))."',
								'".trim($_POST['SHIFT'])."','0','".trim($_POST['STATUSPASIEN'])."',
								'".CurrentUserName()."','".$ket_rujuk."', '".trim($_POST['txt_penanggung_jawab'])."',
								'".trim($_POST['txt_hubungan_dengan_pasien'])."', '".trim($_POST['txt_alamat_penanggung_jawab'])."', '".trim($_POST['txt_tlp_penanggung_jawab'])."',
								now(), '".$minta_rujukan."','".isset($_POST['KETBAYAR'])."','".trim($_POST['txt_no_kartu_jaminan'])."')";						
    
			}
			
			print '</br>';
			print  $sqlinsert_pendaftaran;
			$insert_pasien_pendaftaran = $conn->query($sqlinsert_pendaftaran);
			
			
			if($_POST['cb_poly']=="51") {
				 print '3';
				 /*  $sql_idx_daftar = "select IDXDAFTAR FROM t_pendaftaran WHERE NOMR = '".$nomr."' ORDER BY IDXDAFTAR DESC LIMIT 1";
        $query_idx_daftar=mysql_query($sql_idx_daftar);
        $data_idx_daftar=mysql_fetch_assoc($query_idx_daftar);
        $idx_daftar = $data_idx_daftar['IDXDAFTAR'];

        $ins_operasi="INSERT INTO t_operasi(nomr, KDUNIT, IDXDAFTAR, RAJAL, NIP, TGLORDER) VALUES('".$nomr."', ".$_SESSION['KDUNIT'].", ".$idx_daftar.", 2, '".$_SESSION['NIP']."', CURDATE())";
        mysql_query($ins_operasi);*/
			}
			 
			if(!empty($_POST['start_daftar']) && !empty($_POST['stop_daftar'])){
				  print '4';
				  
				  /* $sql_last_daftar = "select IDXDAFTAR, NOMR FROM t_pendaftaran ORDER BY IDXDAFTAR DESC LIMIT 1";
        $query_last_daftar=mysql_query($sql_last_daftar);
        $data_last_daftar=mysql_fetch_assoc($query_last_daftar);
        $idx_daftar = $data_last_daftar['IDXDAFTAR'];
        $nomr_last = $data_last_daftar['NOMR'];
        $start_daftar = $_POST['start_daftar'];
        $stop_daftar = $_POST['stop_daftar'];

        $sql_insert_time_daftar = "INSERT INTO t_pendaftaran_iso  (idxdaftar, NOMR, start_daftar, stop_daftar) VALUES ($idx_daftar, '$nomr_last', '$start_daftar', '$stop_daftar')";
        mysql_query($sql_insert_time_daftar) or die();*/
			}
			
			
			
			$jenispoly		= isset($_POST['cb_poly']);
			print $jenispoly;
			print '</br>';
			
			
			$kdprofesi		= getProfesiDoktor($_POST['cb_dokterjaga']);
			print $kdprofesi;
			print '</br>';
			$kodetarif		= getKodePendaftaran($jenispoly,$kdprofesi);
			print $kodetarif;
			print '</br>';
			$tarif_daftar	= getTarifPendaftaran($kodetarif);
			print_r($tarif_daftar);
			print '</br>';
			$last_bill		= getLastNoBILL(1);
			print $last_bill;
			print '</br>';
			$last_idxdaftar	= getLastIDXDAFTAR();
			print "$last_idxdaftar;: ".$last_idxdaftar;
			print '</br>';
			$qty			= 1;
			
			$_SESSION['cb_poly'] = $_POST['cb_poly'];
			print $_SESSION['cb_poly'];
			print '</br>';
			$_SESSION['idx']  = $last_idxdaftar;
			print $_SESSION['idx'];
			print '</br>';
			$_SESSION['status']	= isset($_POST['cb_cara_bayar']);
			print $_SESSION['status'];
			print '</br>';
			
			$ip 	= getRealIpAddr();
			print $ip;
			print '</br>';
			$tarif 	= getTarif($kodetarif);
			print_r($tarif);
			print '</br>';		

			$sql_tarif = "insert into tmp_cartbayar set 
			KODETARIF = ' ".$kodetarif." ',
			QTY = 1,
			IP = '".$ip ."', 
			ID = '".$kodetarif."',
			POLY = ".isset($_POST['cb_poly']).",
			KDDOKTER=".trim($_POST['cb_dokterjaga']).",
			TARIF = ".$tarif['tarif'].",
			TOTTARIF = ".$tarif['tarif'].",
			JASA_PELAYANAN = ".$tarif['jasa_pelayanan'].",
			JASA_SARANA = ".$tarif['jasa_sarana'].",
			UNIT = ".$_POST['cb_poly']." ";
			
	
			print  $sql_tarif;
			$insert_sql_tarif = $conn->query($sql_tarif);
			
			
			
			
			if($_POST['cb_cara_bayar'] > 1){
				print '5';
				$sql_bill = 'insert into t_billrajal set KODETARIF = "'.$kodetarif.'",
									NOMR = "'.$nomr.'", KDPOLY = "'.isset($_POST['cb_poly']).'",
									TANGGAL = CURDATE(), SHIFT = '.$_POST['SHIFT'].', 
									NIP = "'.CurrentUserName().'", QTY = '.$qty.',
									IDXDAFTAR = '.$last_idxdaftar.',
									NOBILL = '.$last_bill.', ASKES = 0, COSTSHARING = 0,
									KETERANGAN = "-", KDDOKTER = '.$_POST['cb_dokterjaga'].', 
									STATUS = "SELESAI", CARABAYAR = '.isset($_POST['cb_cara_bayar']).',
									APS = 0, JASA_SARANA = '.$tarif_daftar['jasa_sarana'].',
									JASA_PELAYANAN = '.$tarif_daftar['jasa_pelayanan'].', 
									UNIT='.isset($_POST['cb_poly']).', TARIFRS = "'.$tarif_daftar['tarif'] .'" ';
									
				print $sql_bill;
				print '</br>';
				
				$insert_sql_bill = $conn->query($sql_bill);
				
				
				
				$sql_bayar = 'insert into t_bayarrajal set 
				NOMR = "'.$nomr.'",
				IDXDAFTAR = '.$last_idxdaftar.',
				NOBILL = '.$last_bill.',
				TOTTARIFRS = '.$tarif_daftar['tarif']*$qty.',
				TOTJASA_SARANA = '.$tarif_daftar['tarif'] * $qty.',
				TOTJASA_PELAYANAN = '.$tarif_daftar['jasa_sarana'] * $qty.',
				APS = 0, 
				CARABAYAR = '.isset($_POST['cb_cara_bayar']).',
				TGLBAYAR=CURDATE(), JAMBAYAR=CURTIME(),
				JMBAYAR="'.$tarif_daftar['tarif']*$qty.'", 
				NIP = "'.CurrentUserName().'",
				SHIFT="'.$_POST['SHIFT'].'",
				TBP="0", UNIT='.isset($_POST['cb_poly']).', LUNAS = 1, STATUS = "LUNAS"';
				
				print $sql_bayar;
				print '</br>';
				
				
				$insert_sql_bayar = $conn->query($sql_bayar);
				
			}else{
			
			print '6';
			
				$sql_bill = 'insert into t_billrajal set KODETARIF = "'.$kodetarif.'",
				NOMR = "'.$nomr.'", KDPOLY = "'.isset($_POST['cb_poly']).'", 
				TANGGAL = CURDATE(), SHIFT = '.$_POST['SHIFT'].',
				NIP = "'.CurrentUserName().'",
				QTY = '.$qty.',
				IDXDAFTAR = '.$last_idxdaftar.',
				NOBILL = '.$last_bill.',
				ASKES = 0, COSTSHARING = 0, KETERANGAN = "-",
				KDDOKTER = '.$_POST['cb_dokterjaga'].', STATUS = "SELESAI",
				CARABAYAR = '.isset($_POST['cb_cara_bayar']).',
				APS = 0, JASA_SARANA = '.$tarif_daftar['jasa_sarana'].',
				JASA_PELAYANAN = '.$tarif_daftar['jasa_pelayanan'].',
				UNIT='.isset($_POST['cb_poly']).',
				TARIFRS = "'.$tarif_daftar['tarif']. '" ';
									
				print $sql_bill;
				print '</br>';
				
				$insert_sql_bill = $conn->query($sql_bill);
				
				
				
				$sql_bayar = 'insert into t_bayarrajal set NOMR = "'.$nomr.'",
				IDXDAFTAR = '.$last_idxdaftar.',
		NOBILL = '.$last_bill.',
		TOTTARIFRS = '.$tarif_daftar['tarif']*$qty.', UNIT='.isset($_POST['cb_poly']).', 
		TOTJASA_SARANA = '.$tarif_daftar['jasa_sarana'] * $qty.',
		TOTJASA_PELAYANAN = '.$tarif_daftar['jasa_pelayanan'] * $qty.', APS = 0,
		CARABAYAR = '.isset($_POST['cb_cara_bayar']);
				
				print $sql_bayar;
				print '</br>';
				
				
				$insert_sql_bayar = $conn->query($sql_bayar);
			
			} 
			
			
			
			//mysql_query('update m_maxnobill set nomor = '.$last_bill);
			$sql_update_max_bill = 'update m_maxnobill set nomor = '.$last_bill;
			$update_max_bill = $conn->query($sql_update_max_bill);
			
			
			
			$_SESSION['register_nomr'] = $nomr;
			$_SESSION['register_nama'] = $NAMADATA;
			
		
			
	
	} 

?>

<script type="text/javascript">
$(document).ready(function(){
	$("#btn_print_form_pendaftaran").click(function(){
			
		var v_idx = $("#hd_id_daftar").val();
		alert(v_idx);
		var v_nomr = $("#hd_nomr").val();
		alert(v_nomr);
		var v_poly = $("#hd_kdpoly").val();
		alert(v_poly);
		
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
	
});

</script>


<div id="show_print"></div>
<div id="show_label_identitas"></div>
<div class="row">
	<div class="col-md-12">
	  <div class="box">
	  <div class="box-header with-border">
		<div class="box-tools pull-right">
		</div>
	  </div>
	  <!— /.box-header —>
	  <div class="box-body">
		<div class="row">
		<div style="width:900px; margin-left:auto; margin-right:auto; text-align:center; margin-top:1px;">
		<div class="small-box bg-aqua">
			<div class="inner">
			  <h4>Data Telah di Simpan</h4>
			  <div style="font-size:26px;">NOMR</div>
			  <div style="font-size:50px;"><?php echo $nomr; ?></div>
			  <div style="font-size:26px;">NAMA PASIEN</div>
			  <div style="font-size:50px;"><?php echo $NAMADATA; ?></div>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div><a onclick="javascript:window.location='pendaftaran_pasien.php'" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		</div>
		  &nbsp;&nbsp;
		  <input type="hidden" name="back"  class="printpasien"  value="Print Formulir Pendaftaran" />
		   &nbsp;&nbsp;
		  <input type="button" name="coba"  class="coba" id="btn_print_form_pendaftaran" value="Print Formulir Pendaftaran" />
		  <?php
		  if($_POST['cb_cara_bayar']!=1){
		  ?>
		  	&nbsp;&nbsp;
		  	<input  type="button"   name="coba"  id="btn_buat_sep_rajal" value="Lanjut Proses Pembuatan SEP Rawat Jalan Menggunakan Kartu BPJS" />
		  	&nbsp;&nbsp;
		  	&nbsp;&nbsp;
		  	<input  type="button"   name="coba"  id="btn_buat_sep_rajal_by_noRujukan" value="Lanjut Proses Pembuatan SEP Rawat Jalan Menggunakan Rujukan Online" />
		  	&nbsp;&nbsp;
		  <?php
		  }
		  ?>
		  <input  type="button"   name="btn_cetak_label"  id="btn_cetak_label" value="Cetak Label Pasien" />

		  &nbsp;&nbsp;
		  <input type="hidden" name="kartu"  class="kartu" value="kartu" />
		  &nbsp;&nbsp;
		  <input type="hidden" name="back22"  id="hd_id_daftar"  value="<?php echo $last_idxdaftar; ?>" />
		  &nbsp;&nbsp;
		  <input type="hidden" name="back2233"  id="hd_nomr"  value="<?php echo $nomr; ?>" />
		  &nbsp;&nbsp;
		  <input type="hidden" name="htththt"  id="hd_tanggal "  value="print ''.$tanggal.'';" />
		  &nbsp;&nbsp;
		  <input type="hidden" name="back2233"  id="hd_kdpoly"  value="<?php echo $_POST['cb_poly']; ?>" />
		</div>
		
		</div>

		</div>

	  </div>

	 
	  </div>
	 
	</div>
	
	</div>




<?php
}else{
	?>
	
	
	<div id="show_print"></div>
<div id="show_label_identitas"></div>
<div class="row">
	<div class="col-md-12">
	  <div class="box">
	  <div class="box-header with-border">
		<div class="box-tools pull-right">
		</div>
	  </div>

	  <div class="box-body">
		<div class="row">
		<div style="width:900px; margin-left:auto; margin-right:auto; text-align:center; margin-top:1px;">
		<div class="small-box bg-aqua">
			<div class="inner">
			  <h4>Muat Ulang Proses</h4>
			  <div style="font-size:26px;"></div>
			  <div style="font-size:50px;"></div>
			  <div style="font-size:26px;">Klik Tombol Lanjutkan</div>
			  <div style="font-size:50px;"></div>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div><a onclick="javascript:window.location='pendaftaran_pasien.php'" class="small-box-footer">Lanjutkan <i class="fa fa-arrow-circle-right"></i></a>
		</div>
		 
		</div>
		
		</div>

		</div>

	  </div>

	 
	  </div>
	 
	</div>
	
	</div>
	
	
	
	
	
	<?php
	//print 'OK';
}


?>





<!-- 
<style type="text/css" media="print">
#show_print{display:block;}
</style>
<style type="text/css" media="screen">
#show_print{display:none;}
</style>
<div id="show_print"></div>
<div style="width:900px; margin-left:auto; margin-right:auto; text-align:center; margin-top:50px;">
	<div style="font-size:14px;">Data Telah di Simpan.</div>
	<div style="font-size:26px;">NOMR</div>
	<div style="font-size:74px;"><?php // echo $_SESSION['register_nomr']; ?></div>
	<div style="font-size:26px;">NAMA PASIEN</div>
	<div style="font-size:74px;"><?php //echo $_SESSION['register_nama']; ?></div>
	<input type="button" name="back" onclick="javascript:window.location='pendaftaran_pasien.php'" value="OK" />
	&nbsp;&nbsp;
	<input type="button" name="back"  class="printpasien" value="Print Formulir Pendaftaran" />
	&nbsp;&nbsp;
	<input type="button" name="back" onclick="javascript:cetakkartu()" value="Cetak Kartu" />
	&nbsp;&nbsp;
	<input type="button" name="back"  class="printrm" value="Print Tracer" />
</div> -->






<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$pendaftaran_pasien_proses_php->Page_Terminate();
?>
