 <?php
 include "../phpcon/koneksi.php";

$idprovinsi = $_POST['idprovinsi'];   
$sql = "SELECT a.*,b.namaprovinsi FROM simrs2012.m_kota a
LEFT OUTER JOIN m_provinsi b ON (a.idprovinsi=b.idprovinsi) where a.idprovinsi = ".$idprovinsi ;

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $idkota = $row['idkota'];
    $idprovinsi = $row['idprovinsi'];
	$namakota = $row['namakota'];
	$namaprovinsi = $row['namaprovinsi'];

    $poly_arr[] = array(
						"idkota" => $idkota,
						"idprovinsi" => $idprovinsi,
						"namakota" => $namakota,
						"namaprovinsi" =>$namaprovinsi
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>