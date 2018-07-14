 <?php
 include "../phpcon/koneksi.php";

//$departid = $_POST['depart'];   

$sql = "SELECT * FROM simrs2012.m_rujukan";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $KODE = $row['KODE'];
    $NAMA = $row['NAMA'];
	$ORDERS = $row['ORDERS'];

    $poly_arr[] = array(
						"KODE" => $KODE,
						"NAMA" => $NAMA,
						"ORDERS" =>$ORDERS
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>