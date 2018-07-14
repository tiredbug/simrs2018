<label for="tahun">RUANG : </label>
      <select id="ruang_id" name="ruang_nama">
 
		<?php
				
				$query_mruang=mysql_query("select * from m_ruang");
				while($data_query_mruang=mysql_fetch_array($query_mruang))
				{
					$no=$data_query_mruang['no'];
					$nama=$data_query_mruang['nama'];
					echo '<option value="'.$no.'">'.$nama.'</option>';
				}
			?>
      </select>
