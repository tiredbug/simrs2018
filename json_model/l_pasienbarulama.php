 <?php
include "../phpcon/koneksi.php";
 

$sql = "SELECT * FROM l_pasienbaru";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
	$pasienbaru = $row['pasienbaru'];

    $poly_arr[] = array(
						"id" => $id,
						"pasienbaru" =>$pasienbaru
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>