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

$chart1_php = NULL; // Initialize page object first

class cchart1_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'chart1.php';

	// Page object name
	var $PageObjName = 'chart1_php';

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
			define("EW_TABLE_NAME", 'chart1.php', TRUE);

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

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

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
		$Breadcrumb->Add("custom", "chart1_php", $url, "", "chart1_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($chart1_php)) $chart1_php = new cchart1_php();

// Page init
$chart1_php->Page_Init();

// Page main
$chart1_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<?php if (!@$gbSkipHeaderFooter) { ?>
<div class="ewToolbar">
<?php
$chart1_php->ShowMessage();
?>
</div>
<?php } ?>
<?php
require_once("epi/epi_chartjs.php");
ew_AddClientScript("epi/js/Chart.min.js"); 
?>
<h4>Grafik Pantau</h4>
<div class = "row">
<div class = "col-md-4">
<?php
// Start vars
// Area charts use category, value, and period for each chart
//$chart_table = "fake_sales";
//$category_field = "sales_category";
//$value_field = "sales_total";
//$period_field = "sales_month";
$dataset_sql = "SELECT x.NIP,GROUP_CONCAT(x.bulan) AS gc_labels, GROUP_CONCAT(x.jumlah) AS gc_values FROM 
(
SELECT y.NIP,y.bulan, count(y.IDXDAFTAR) as 'jumlah'
FROM 
(
SELECT a.NIP, c.bulan_id as 'bulan', YEAR(a.TGLREG) as 'tahun', IDXDAFTAR
FROM t_pendaftaran a
LEFT OUTER JOIN m_login b ON (a.NIP=b.NIP)
RIGHT OUTER JOIN l_bulan c ON  MONTH(a.TGLREG) = c.bulan_id
WHERE YEAR(a.TGLREG) = YEAR(CURDATE()) 
and b.role_id = 4
)
as y
GROUP BY y.NIP,y.bulan
ORDER BY y.bulan
)
as x

group by x.NIP
ORDER BY x.bulan DESC
";
// End vars


$area2_input_array = $GLOBALS['conn']->GetAll($dataset_sql); // using global connection, will work with non-MySQL DBs
if ($area2_input_array) echo epi_chartjs_two("NIP", "gc_labels", "gc_values", $area2_input_array, "Area", 'area_one', 400, "Area Chart 1 (0.5 Opacity)", 0.5);


?>
</div>
<div class = "col-md-4">
<?php
// Start vars
// Area charts use category, value, and period for each chart
//$chart_table = "fake_sales";
//$category_field = "sales_category";
//$value_field = "sales_total";
//$period_field = "sales_month";
$dataset_sql = "SELECT x.NIP,GROUP_CONCAT(x.bulan) AS gc_labels, GROUP_CONCAT(x.jumlah) AS gc_values FROM 
(
SELECT y.NIP,y.bulan, count(y.IDXDAFTAR) as 'jumlah'
FROM 
(
SELECT a.NIP, c.bulan_id as 'bulan', YEAR(a.TGLREG) as 'tahun', IDXDAFTAR
FROM t_pendaftaran a
LEFT OUTER JOIN m_login b ON (a.NIP=b.NIP)
RIGHT OUTER JOIN l_bulan c ON  MONTH(a.TGLREG) = c.bulan_id
WHERE YEAR(a.TGLREG) = YEAR(CURDATE()) 
and b.role_id = 4
and MONTH(a.TGLREG) = MONTH(CURDATE()) 
)
as y
GROUP BY y.NIP,y.bulan
ORDER BY y.bulan
)
as x

group by x.NIP
ORDER BY x.bulan DESC
LIMIT 4
";
// End vars

$area2_input_array = $GLOBALS['conn']->GetAll($dataset_sql); // using global connection, will work with non-MySQL DBs
if ($area2_input_array) echo epi_chartjs_two("NIP", "gc_labels", "gc_values", $area2_input_array, "horizontalBar", 'area_two', 400, "Horizontal Bar (Opacity 0.85)", 0.85);


?>
</div>
<div class = "col-md-4">
<?php
// Start vars
// Area charts use category, value, and period for each chart
//$chart_table = "fake_sales";
//$category_field = "sales_category";
//$value_field = "sales_total";
//$period_field = "sales_month";
$dataset_sql = "SELECT x.NIP,GROUP_CONCAT(x.bulan) AS gc_labels, GROUP_CONCAT(x.jumlah) AS gc_values FROM 
(
SELECT y.NIP,y.bulan, count(y.IDXDAFTAR) as 'jumlah'
FROM 
(
SELECT a.NIP, c.bulan_id as 'bulan', YEAR(a.TGLREG) as 'tahun', IDXDAFTAR
FROM t_pendaftaran a
LEFT OUTER JOIN m_login b ON (a.NIP=b.NIP)
RIGHT OUTER JOIN l_bulan c ON  MONTH(a.TGLREG) = c.bulan_id
WHERE YEAR(a.TGLREG) = YEAR(CURDATE()) 
and b.role_id = 4
and MONTH(a.TGLREG) = MONTH(CURDATE()) 
)
as y
GROUP BY y.NIP,y.bulan
ORDER BY y.bulan
)
as x

group by x.NIP
ORDER BY x.bulan DESC
LIMIT 4
";
// End vars

//$area2_input_array = $GLOBALS['conn']->GetAll($dataset_sql); // using global connection, will work with non-MySQL DBs
//if ($area2_input_array) echo epi_chartjs_two("NIP", "gc_labels", "gc_values", $area2_input_array, "horizontalBar", 'area_two', 1000, "Horizontal Bar (Opacity 0.85)", 0.85);

$area2_input_array = $GLOBALS['conn']->GetAll($dataset_sql); // using global connection, will work with non-MySQL DBs
if ($area2_input_array) echo epi_chartjs_two("NIP", "gc_labels", "gc_values", $area2_input_array, "horizontalBar", 'area_two', 400, "Horizontal Bar (Opacity 0.85)", 0.85);


?>
</div>
</div>

<div class="row">

<div class = "col-md-4">
<?php
// Start vars
// Area charts use category, value, and period for each chart
//$chart_table = "fake_sales";
//$category_field = "sales_category";
//$value_field = "sales_total";
//$period_field = "sales_month";
$dataset_sql2 = "SELECT x.NIP,GROUP_CONCAT(x.bulan) AS gc_labels, GROUP_CONCAT(x.jumlah) AS gc_values FROM 
(
SELECT y.NIP,y.bulan, count(y.IDXDAFTAR) as 'jumlah'
FROM 
(
SELECT a.NIP, c.bulan_id as 'bulan', YEAR(a.TGLREG) as 'tahun', IDXDAFTAR
FROM t_pendaftaran a
LEFT OUTER JOIN m_login b ON (a.NIP=b.NIP)
RIGHT OUTER JOIN l_bulan c ON  MONTH(a.TGLREG) = c.bulan_id
WHERE YEAR(a.TGLREG) = YEAR(CURDATE()) 
and b.role_id = 4
and MONTH(a.TGLREG) = MONTH(CURDATE()) 
)
as y
GROUP BY y.NIP,y.bulan
ORDER BY y.bulan
)
as x

group by x.NIP
ORDER BY x.bulan DESC LIMIT 4
";
// End vars

$area2_input_array2 = $GLOBALS['conn']->GetAll($dataset_sql2); // using global connection, will work with non-MySQL DBs
if ($area2_input_array2) echo epi_chartjs_two('NIP', 'gc_labels', 'gc_values', $area2_input_array2,'Bar', 'bar_one', 400, 'Jumlah Entri Pendaftaran RaJal');


?>
</div>
</div>



<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$chart1_php->Page_Terminate();
?>
