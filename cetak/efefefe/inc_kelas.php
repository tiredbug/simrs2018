<label for="tahun">KELAS : </label>
      <select id="kelas_id" name="kelas">
		<?php
				$sql = "SELECT * FROM l_kelas_perawatan";
				$query_kelas=mysql_query($sql);
				while($data_query_kelas=mysql_fetch_array($query_kelas))
				{
					$kelasperawatan_id= $data_query_kelas['kelasperawatan_id'];
					$kelasperawatan= $data_query_kelas['kelasperawatan'];
					echo '<option value="'.$kelasperawatan_id.'">'.$kelasperawatan.'</option>';
				}
			?>
      </select>
