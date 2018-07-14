 <?php
 include "../phpcon/koneksi.php";

$kd_poly = $_POST['kdpoly'];   

$sql = "SELECT a.id, a.kdpoly,a.kddokter ,b.NAMADOKTER ,c.nama as 'nama_poly' FROM simrs2012.m_dokter_jaga a
		INNER JOIN m_dokter b ON (a.kddokter=b.KDDOKTER)
		LEFT OUTER JOIN m_poly c ON (a.kdpoly=c.kode) where a.kdpoly =  ".$kd_poly;

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    $kdpoly = $row['kdpoly'];
	$nama_poly = $row['nama_poly'];
	$kddokter = $row['kddokter'];
	$NAMADOKTER = $row['NAMADOKTER'];

    $poly_arr[] = array(
						"id" => $id,
						"kdpoly" => $kdpoly,
						"nama_poly" =>$nama_poly,
						"kddokter" =>$kddokter,
						"NAMADOKTER" =>$NAMADOKTER
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>