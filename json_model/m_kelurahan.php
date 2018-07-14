 <?php
 include "../phpcon/koneksi.php";

$idkecamatan = $_POST['idkecamatan'];   
$sql = "SELECT * FROM simrs2012.m_kelurahan where idkecamatan = ".$idkecamatan ;

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $idkelurahan = $row['idkelurahan'];
    $idkecamatan = $row['idkecamatan'];
	$namakelurahan = $row['namakelurahan'];

    $poly_arr[] = array(
						"idkelurahan" => $idkelurahan,
						"idkecamatan" => $idkecamatan,
						"namakelurahan" =>$namakelurahan
						);
}

// encoding array to json format
echo json_encode($poly_arr);
 
 
 ?>