 <?php
include "../phpcon/koneksi.php";
 
$sql = "SELECT * FROM simrs2012.m_provinsi";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $idprovinsi = $row['idprovinsi'];
    $namaprovinsi = $row['namaprovinsi'];

    $poly_arr[] = array(
						"idprovinsi" => $idprovinsi,
						"namaprovinsi" =>$namaprovinsi
						);
}

echo json_encode($poly_arr);
 
 
 ?>