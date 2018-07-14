<label for="bulan">BULAN : </label>
   <select id="bulan" name="bulan">
        <!--<option >PILIH BULAN</option>
        <option value="1">JANUARI</option>
        <option value="2">FEBRUARI</option>
        <option value="3">MARET</option>
		<option value="4">APRIL</option>
        <option value="5">MEI</option>
        <option value="6">JUNI</option>
		<option value="7">JULI</option>
        <option value="8">AGUSTUS</option>
        <option value="9">SEPTEMBER</option>
		<option value="10">OKTOBER</option>
        <option value="11">NOVEMBER</option>
        <option value="12">DESEMBER</option>
-->
		<?php
				// include "koneksi.php"; 
				$query_lbulan=mysql_query("select * from l_bulan");
				while($data_query_lbulan=mysql_fetch_array($query_lbulan))
				{
					$bulan_id=$data_query_lbulan['bulan_id'];
					$bulan_nama=$data_query_lbulan['bulan_nama'];
					echo '<option value="'.$bulan_id.'">'.$bulan_nama.'</option>';
				}
			?>
</select>