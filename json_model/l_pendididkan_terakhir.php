 <?php
include "../phpcon/koneksi.php";
 

$sql = "SELECT * FROM simrs2012.l_pendidikanterakhir";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
	$pendidikan = $row['pendidikan'];

    $poly_arr[] = array(
						"id" => $id,
						"pendidikan" =>$pendidikan
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>