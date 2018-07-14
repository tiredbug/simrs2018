 <SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	
	$("#KOTA").change(function(){
		var selectValues = $("#KOTA").val();
		var kecHidden = $("#KECAMATANHIDDEN").val();
		$.post('./phpcon/ajxload.php',{kdkota:selectValues,load_kecamatan:'true'},function(data){
			//alert(data);
			$('#kecamatanpilih').html(data);
			$('#KDKECAMATAN').val(kecHidden).change();
			$('#kelurahanpilih').html("<select class=\"form-control\" name=\"KELURAHAN\" class=\"text required\" title=\"*\" id=\"KELURAHAN\"><option value=\"0\"> --pilih from jquery aak load-- </option>")
		});
	});
	
	$("#KDKECAMATAN").change(function(){
		var selectValues = $("#KDKECAMATAN").val();
		var kelHidden = $("#KELURAHANHIDDEN").val();
		$.post('./phpcon/ajxload.php',{kdkecamatan:selectValues,load_kelurahan:'true'},function(data){
			//alert(data);
			$('#kelurahanpilih').html(data);
			$('#KELURAHAN').val(kelHidden);
		});
	});
	

});
</SCRIPT>
 
 <?php
session_start();
include 'koneksi.php'; 
include 'fungsi_col.php';

if(isset($_REQUEST['load_kota']) != ''){
	$kdprov	= $_REQUEST['kdprov'];
	$sql_kabupaten = "select * from m_kota where idprovinsi = ".$kdprov." order by idkota ASC";
	$result = $conn->query($sql_kabupaten);
	if (isset($result->num_rows) > 0) {
		echo '<select class="form-control" name="KOTA" class="text required" title="*" id="KOTA"> ';
		while($data = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
			if(isset($_GET['kdkota']) == $data['idkota']){
					$sel = "selected=Selected"; 
					}else{
						$sel = "";
						}
			echo '<option value="'.$data['idkota'].'" '.$sel.' > '.$data['namakota'].'</option>';
		}
		echo '</select>';
	} else {
		echo "Tidak ada kota di provinsi tersebut";
	}
}


if(isset($_REQUEST['load_kecamatan']) != ''){
	$kdkota	= $_REQUEST['kdkota'];
	$sql_kecamatan = "select * from m_kecamatan where idkota = ".$kdkota." order by idkecamatan ASC";
	$result = $conn->query($sql_kecamatan);
	if (isset($result->num_rows) > 0) {
		echo '<select class="form-control" name="KDKECAMATAN" class="text required" title="*" id="KDKECAMATAN"><option value="0"> --pilih from ajaxload-- </option>';
		while($data = $result->fetch_assoc()) {
			echo '<option value="'.$data['idkecamatan'].'" '.$sel.' > '.$data['namakecamatan'].'</option>';
		}
		echo '</select>';
	} else {
		echo 'Tidak ada kecamatan di kota tersebut';
	}
}





$load_kelurahan = isset($_REQUEST['load_kelurahan']);
if($load_kelurahan != ''){
	$kdkecamatan	= $_REQUEST['kdkecamatan'];
	$sql_kelurahan = "select * from m_kelurahan where idkecamatan = ".$kdkecamatan." order by idkelurahan ASC";
	$result = $conn->query($sql_kelurahan);
	if (isset($result->num_rows) > 0) {
			echo '<select class="form-control" name="KELURAHAN" class="text required" title="*" id="KELURAHAN"><option value="0"> --pilih from ajaxload-- </option>';while($data = $result->fetch_assoc()) {
			echo '<option value="'.$data['idkelurahan'].'" '.$sel.' > '.$data['namakelurahan'].'</option>';
		}
		echo '</select>';
	} else {
		echo 'Tidak ada kelurahan di kecamatan tersebut';
	}
	/*$query_keluarahan = mysqli_query($conn,$sql_kelurahan);
	if(mysqli_num_rows($query_keluarahan) > 0){
		echo '<select class="form-control" name="KELURAHAN" class="text required" title="*" id="KELURAHAN"><option value="0"> --pilih from ajaxload-- </option>';
			while($data = mysqli_fetch_array($query_keluarahan,MYSQLI_ASSOC)){

				echo '<option value="'.$data['idkelurahan'].'" '.$sel.' > '.$data['namakelurahan'].'</option>';
			}
		echo '</select>';
	}else{
		echo 'Tidak ada kelurahan di kecamatan tersebut';
	}*/
}


?> 