<label for="cara_bayar">CARA BAYAR : </label>
      <select id="carabayar_id" name="carabayar_nama">
		<?php
				$query_mcarabayar=mysql_query("select * from m_carabayar");
				while($data_query_mcarabayar=mysql_fetch_array($query_mcarabayar))
				{
					$KODE_=$data_query_mcarabayar['KODE'];
					$NAMA_=$data_query_mcarabayar['NAMA'];
					echo '<option value="'.$KODE_.'">'.$NAMA_.'</option>';
				}
			?>
      </select>
