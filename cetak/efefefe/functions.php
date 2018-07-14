<?php 


function getNamaBulan($kdBulan){
	include("koneksi.php");
	$sql = "SELECT l_bulan FROM l_bulan where bulan_id  = ".$kdBulan;
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$val = $row["l_bulan"];
	}else{
		$val = '';
	}
	return $val;
}





function getDataClient($KodeClient){
	include("koneksi.php");
	$sql = "select ALAMAT from m_pasien where NOMR =".$KodeClient;
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		//$val[] = $row['NOMR'];
		//$val[] = $row['NAMA'];
		$val[] = $row['ALAMAT'];
		//$val = $row['TGLLAHIR'];
	}else{
		$val = '';
	}
	return $val;
}



function Nama_Hari($val) { 
    $arrWeek = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    return $arrWeek[$val];
}



?>