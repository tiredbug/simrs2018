<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
include_once "../../ewcfg13.php";
include_once ((EW_USE_ADODB) ? "../../adodb5/adodb.inc.php" : "../../ewmysql13.php");
include_once "../../phpinc/PHPThumb.php";
include_once "../../phpfn13.php";
include_once "../../pd_usersinfo.php";
include_once "../../userfn13.php";
header('Content-Type: application/json');
epi_processGet($_GET);
epi_processPost($_POST);
?>