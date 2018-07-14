 <?php
include "../phpcon/koneksi.php";
 
$sql = "SELECT * FROM simrs2012.m_etnis";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    $nama_etnis = $row['nama_etnis'];

    $poly_arr[] = array(
						"id" => $id,
						"nama_etnis" =>$nama_etnis
						);
}

echo json_encode($poly_arr);
 
 
 ?>