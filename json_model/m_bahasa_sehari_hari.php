 <?php
include "../phpcon/koneksi.php";
 
$sql = "SELECT * FROM simrs2012.m_bahasa_harian";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    $bahasa_harian = $row['bahasa_harian'];

    $poly_arr[] = array(
						"id" => $id,
						"bahasa_harian" =>$bahasa_harian
						);
}

echo json_encode($poly_arr);
 
 
 ?>