 <?php
 include "../phpcon/koneksi.php";

$idkota = $_POST['idkota'];   
$sql = "SELECT * FROM simrs2012.m_kecamatan where idkota = ".$idkota ;

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $idkecamatan = $row['idkecamatan'];
    $idkota = $row['idkota'];
	$namakecamatan = $row['namakecamatan'];

    $poly_arr[] = array(
						"idkecamatan" => $idkecamatan,
						"idkota" => $idkota,
						"namakecamatan" =>$namakecamatan
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>