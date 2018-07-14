<?php

		include '../phpcon/koneksi.php'; 
		include '../phpcon/fungsi_col.php';
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		
		$message = "";
		$hasil = "";
		
		$message["error"]  = "";
		if(empty($_GET["noMR"])){  
			$message["error"] = "nomr  kosong"; 
		}else{
			
			$message["error"] = "sukses"; 
			$nomr = $_GET["noMR"] ;
		
			$data_pasien = getDataPasienPendaftaranbyNomr($nomr);
										

		}
		
		$hasil["message"] = $message;
		$hasil["result"] = $data_pasien;
		
		echo json_encode($hasil);

		
?>
