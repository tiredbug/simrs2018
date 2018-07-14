 <?php
include "../phpcon/koneksi.php";
 

$sql = "SELECT * FROM simrs2012.l_agama";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
	$agama = $row['agama'];

    $poly_arr[] = array(
						"id" => $id,
						"agama" =>$agama
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>