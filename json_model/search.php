 <?php
 include "../phpcon/koneksi.php";

$keyword = $_POST['key'];   
$sql = "SELECT CODE,CODE2,STR FROM simrs2012.icd_eklaim WHERE CBG_USE_IND = 1 AND SAB = 'ICD10_1998'
AND (CODE LIKE'A0%' OR CODE2 LIKE 'A0%' OR STR LIKE 'A0%' )" ;

$result = mysqli_query($conn,$sql);
$poly_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $CODE = $row['CODE'];
    $CODE2 = $row['CODE2'];
	$STR = $row['STR'];
	/*,
						"CODE2" => $CODE2,
						"STR" =>$STR*/

    $poly_arr[] = array(
						"CODE" => $CODE
						);
}

// encoding array to json format
echo json_encode($poly_arr);


 
 
 ?>