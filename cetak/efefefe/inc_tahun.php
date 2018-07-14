<label for="tahun">TAHUN : </label>
      <select id="tahun" name="tahun">
        <!--<option >PILIH TAHUN</option>
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
		<option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
		<option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
		<option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
		<option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>-->
		
		<?php
				
				$query_ltahun=mysql_query("select * from l_tahun ORDER BY tahun_nama DESC");
				while($data_query_ltahun=mysql_fetch_array($query_ltahun))
				{
					$tahun_id=$data_query_ltahun['tahun_id'];
					$tahun_nama=$data_query_ltahun['tahun_nama'];
					echo '<option value="'.$tahun_id.'">'.$tahun_nama.'</option>';
				}
			?>
      </select>
