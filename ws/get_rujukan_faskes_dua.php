<?php

		include '../phpcon/koneksi.php'; 
		include '../phpcon/fungsi_col.php';
		
		//$kode_rujukan = '111102011216Y000076';
		//$nomr = '180986';
		//$rujukan = getdetail_rujukan_faskes($kode_rujukan,$nomr );
		
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		
		$message = "";
		$hasil = "";
		$detail_sep  = "";
		
		$message["error"]  = "";
		if(empty($_GET["kode_rujukan"])) {
			$message["error"] = "kode_rujukan kosong";    
		}elseif(empty($_GET["noMR"])){  
			$message["error"] = "nomr  kosong"; 
		}else{
			
			$message["error"] = "sukses"; 
			
			$kode_rujukan = $_GET["kode_rujukan"] ;
			$nomr = $_GET["noMR"] ;
		
			$rujukan = getdetail_rujukan_faskes2($kode_rujukan,$nomr );
										

		}
		
		$hasil["message"] = $message;
		$hasil["result"] = $rujukan;
		
		echo json_encode($hasil);

		
?>
