<?php

		include '../phpcon/koneksi.php'; 
		include '../phpcon/fungsi_col.php';
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		
		$message = "";
		$hasil = "";
		
		$message["error"]  = "";
		
		
		if(empty($_GET["tglLahir"])){  
			$message["error"] = "tglLahir  kosong"; 
		}else{
			
			$message["error"] = "sukses"; 
			$tglLahir = $_GET["tglLahir"] ;
			$data_umur = datediff($tglLahir,date("Y-m-d"));
			
										

		}
		
		$hasil["message"] = $message;
		$hasil["result"] = $data_umur;
		
		echo json_encode($hasil);

		
?>
