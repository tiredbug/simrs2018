<label for="layanan">LAYANAN : </label>

<?php echo "<select name='layanan_id'>
<option value=0 selected> PILIH LAYANAN </option>";
$tampil=mysql_query("SELECT layanan_id,layanan_nama FROM l_layanan ORDER BY layanan_id");
while($r=mysql_fetch_array($tampil)){
echo "<option value=$r[layanan_id]>$r[layanan_nama]</option>";
}
echo "</select>"; ?> 