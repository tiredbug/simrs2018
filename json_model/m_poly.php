 <?php
include "../phpcon/koneksi.php";
//$departid = $_POST['depart'];   

$sql = "SELECT * FROM m_poly";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $userid = $row['kode'];
    $name = $row['nama'];
	$jenispoly = $row['jenispoly'];

    $poly_arr[] = array(
						"kode" => $userid,
						"nama" => $name,
						"jenispoly" =>$jenispoly
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>