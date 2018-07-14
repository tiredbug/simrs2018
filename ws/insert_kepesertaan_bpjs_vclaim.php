<?php

		include '../phpcon/koneksi.php'; 
		include '../phpcon/fungsi_col.php';
		
		
		//$hasil = $_GET;
		

		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		
		$message = null;
		$hasil = null;
		$detail_sep  = null;
		
		$message["error"]  = "";
		if(empty($_GET["noMR"])) {
			$message["error"] = "noMR kosong";    
		}elseif(empty($_GET["tglSEP"])){  
			$message["error"] = "tglSep  kosong"; 
		}elseif(empty($_GET["nomor_kartu"])){  
			$message["error"] = "nomor_kartu  kosong"; 
		}else{
			
			$message["error"] = "sukses"; 
			
			$noMR = $_GET["noMR"] ;
			$tglSep = $_GET["tglSep"] ;
			$nomor_kartu = $_GET["nomor_kartu"] ;
			
			
			$detail_keanggotaanBPJS = get_detail_keanggotaanBPJS_by_kartu($nomor_kartu,$noMR);
										

		}
		
		$hasil["message"] = $message;
		$hasil["result"] = $detail_keanggotaanBPJS;
		//$hasil["result"] = $_GET;
		
		
		
		//echo '<pre>';
		echo json_encode($hasil);
		//echo '</pre>';
		
?>
