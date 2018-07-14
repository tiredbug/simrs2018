<?php

		include 'phpcon/koneksi.php'; 
		include 'phpcon/fungsi_col.php';
		
		
		$hasil = $_GET;
		
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		
		$message = null;
		$hasil = null;
		$detail_sep  = null;
		
		$message["error"]  = "";
		if(empty($_GET["noKartu"])) {
			$message["error"] = "nomer kartu kosong";    
		}elseif(empty($_GET["tglSep"])){  
			$message["error"] = "tanggal sep  kosong"; 
		}elseif(empty($_GET["ppkPelayanan"])){  
			$message["error"] = "ppk pelayanan  kosong"; 
		}elseif(empty($_GET["ppkPelayanan"])){  
			$message["error"] = "jenis pelayanan  kosong"; 
		}elseif(empty($_GET["klsRawat"])){  
			$message["error"] = "kelas rawat  kosong"; 
		}elseif(empty($_GET["noMR"])){  
			$message["error"] = "noMR  kosong"; 
		}elseif(empty($_GET["asalRujukan"])){  
			$message["error"] = "asalRujukan  kosong"; 
		}elseif(empty($_GET["tglRujukan"])){  
			$message["error"] = "tglRujukan  kosong"; 
		}elseif(empty($_GET["noRujukan"])){  
			$message["error"] = "noRujukan  kosong"; 
		}elseif(empty($_GET["noRujukan"])){  
			$message["error"] = "noRujukan  kosong"; 
		}elseif(empty($_GET["ppkRujukan"])){  
			$message["error"] = "ppkRujukan  kosong"; 
		}elseif(empty($_GET["catatan"])){  
			$message["error"] = "catatan  kosong"; 
		}elseif(empty($_GET["diagAwal"])){  
			$message["error"] = "diagAwal  kosong"; 
		}elseif(empty($_GET["tujuan"])){  
			$message["error"] = "tujuan  kosong"; 
		}/*elseif(empty($_GET["eksekutif"])){  
			$message["error"] = "poli eksekutif nfgn kosong"; 
		}elseif(empty($_GET["cob"])){  
			$message["error"] = "cob  kosong"; 
		}elseif(empty($_GET["lakaLantas"])){  
			$message["error"] = "lakaLantas  kosong"; 
		}elseif(empty($_GET["noTelp"])){  
			$message["error"] = "noTelp  kosong"; 
		}elseif(empty($_GET["user"])){  
			$message["error"] = "user  kosong"; 
		}*/else{
			
			$message["error"] = "sukses"; 
			
			$noKartu = $_GET["noKartu"] ;
			$tglSep = $_GET["tglSep"] ;
			$ppkPelayanan = $_GET["ppkPelayanan"] ;
			$jnsPelayanan = $_GET["jnsPelayanan"] ;
			$klsRawat = $_GET["klsRawat"] ;
			
			
			$noMR = $_GET["noMR"] ;
			$asalRujukan = $_GET["asalRujukan"] ;
			$tglRujukan = $_GET["tglRujukan"] ;
			$noRujukan = $_GET["noRujukan"] ;
			$ppkRujukan = $_GET["ppkRujukan"] ;
			
			
			
			$catatan = $_GET["catatan"] ;
			$diagAwal = $_GET["diagAwal"] ;
			$tujuan =  $_GET["tujuan"] ;
			$eksekutif =  $_GET["eksekutif"] ;
			$cob = $_GET["cob"] ;
			
			
			$lakaLantas = $_GET["lakaLantas"] ;
			$penjamin = $_GET["penjamin"] ;
			$lokasiLaka =  $_GET["lokasiLaka"] ;
			$noTelp = $_GET["noTelp"] ;
			$user = $_GET["user"] ;
			$idx = $_GET["idx"] ;
			$nik= $_GET["nik"] ;
			$status_kartu  = $_GET["status_kartu"] ;
			
			
			$detail_sep = insert_SEP($noKartu,$tglSep,$ppkPelayanan,$jnsPelayanan,$klsRawat,
										$noMR,$asalRujukan,$tglRujukan,$noRujukan,$ppkRujukan,
										$catatan,$diagAwal,$tujuan,$eksekutif,$cob,
										$lakaLantas,$penjamin,$lokasiLaka,$noTelp,$user,$idx,$nik,$status_kartu);
										
										
			
		 

		}
		
		$hasil["message"] = $message;
		$hasil["result"] = $detail_sep;
		
		
		
		echo json_encode($hasil);
		
?>
