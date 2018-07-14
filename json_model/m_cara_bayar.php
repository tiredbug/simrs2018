 <?php
include "../phpcon/koneksi.php";
 
$sql = "select * from m_carabayar where KODE > 1 order by ORDERS asc";

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $KODE = $row['KODE'];
    $NAMA = $row['NAMA'];
	$ORDERS = $row['ORDERS'];
	
	$JMKS = $row['JMKS'];
	$payor_id = $row['payor_id'];
	$payor_cn = $row['payor_cn'];

    $poly_arr[] = array(
						"KODE" => $KODE,
						"NAMA" => $NAMA,
						"ORDERS" => $ORDERS,
						"JMKS" => $JMKS,
						"payor_id" => $payor_id,
						"payor_cn" =>$payor_cn
						);
}

echo json_encode($poly_arr);
 
 
 ?>