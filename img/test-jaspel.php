    <form name="formsearch" method="get" >
     <table class="tb">
       <tr>
          <td align="right">Tanggal &nbsp;<input type="text" name="tgl" id="tgl_pesan" readonly="readonly" class="text" 
              value="<? if($tgl!=""){
			  echo $tgl;}?>"/><a href="javascript:showCal('Calendar3')"><img align="top" src="../img/date.png" border="0" /></a>
              <input type="hidden" name="link" value="54" />
              <input type="submit" value="Cari" class="text"/></td>
          </tr>
     </table>
    </form> 

<?php 
include("../include/connect.php");
$qry = mysql_query("select a.kdpoly,c.nama as poly, a.kddokter,b.namadokter,sum(d.tarifrs) as tarif , 0.7*sum(d.tarifrs) as jsdr, 0.1*sum(d.tarifrs) as manajemen,  0.2*sum(d.tarifrs) as pendukung
					from t_pendaftaran a, m_dokter b, m_poly c, t_billrajal d
					where a.kddokter=b.kddokter and a.kdpoly=c.kode and a.idxdaftar=d.idxdaftar and tglreg=curdate() 
						aND a.kdpoly=d.kdpoly and a.kdpoly in(1,2,3,4,5,6,7,8) and d.kodetarif in(
'010401','010402','010403','010404','010405','010406','010407','010408','010409','010410','010411','010412','010413','010414')
					group by a.kdpoly,c.nama, a.kddokter,b.namadokter order by a.kdpoly") or die (mysql_error());
?>
<table width="554" border="1" class="tb">
  <tr>
    <th colspan="6">Pemeriksaan Dokter Spesialis/Gigi/Umum</th>
  </tr>
  <tr>
    <td width="105">Poly</td>
    <td width="94">Nama Dokter</td>    
    <td width="71">Pendapatan</td>


    <td width="82">Jasa Dokter</td>    
    <td width="75">Manajemen</td>
    <td width="87">Pendukung</td>
  </tr>
<? while ($list = mysql_fetch_array($qry)){  ?>
  <tr>
    <td><?=$list['poly'];?></td>
   <td><?=$list['namadokter'];?></td>    
    <td><?= number_format($list['tarif'],0);?></td>
 
    <td><?= number_format($list['jsdr'],0);?></td>
    <td><?= number_format($list['manajemen'],0);?></td>
    <td><?= number_format($list['pendukung'],0);?></td>
  </tr>
 <? } ?> 
</table>
<p>
<?php
$qry = mysql_query("select a.kdpoly,c.nama as poly, a.kddokter,b.namadokter,sum(d.tarifrs) as tarif ,
					   e.nama_jasa, 0.7*sum(d.tarifrs) as jsdr, 0.1*sum(d.tarifrs) as manajemen,  
					   0.125*sum(d.tarifrs) as 	pendukung,0.075*sum(d.tarifrs) as asisten 
					from t_pendaftaran a, m_dokter b, m_poly c, t_billrajal d, m_tarif e
					where a.kddokter=b.kddokter and a.kdpoly=c.kode and a.idxdaftar=d.idxdaftar and tglreg=curdate() 
						 and a.kdpoly in(1,2,3,4,5,6,7,8) and kodetarif like '0108%' and d.kodetarif=e.kode
					group by a.kdpoly,c.nama, a.kddokter,b.namadokter,e.nama_jasa 
					order by a.kdpoly") or die (mysql_error());
?>                    
<table width="728" border="1" class="tb">
  <tr>
    <th colspan="8">Tindakan  paket medis IIIA/ IIIB/ IIIC</th>
  </tr>
  <tr>
    <td width="103">Poly</td>
    <td width="105">Nama Dokter</td>
    <td width="82">Paket</td>

    <td width="80">Pendapatan</td>
    <td width="71">Jasa Dr.</td>
    <td width="71">Manajemen</td>
    <td width="82">Pendukung</td>
    <td width="82">Asisten</td>
  </tr>
<? while ($list = mysql_fetch_array($qry)){  ?>  
  <tr>
    <td><?= $list['poly'];?></td>
    <td><?= $list['namadokter'];?></td>
    <td><?= $list['nama_jasa'];?></td>
    <td><?= number_format($list['tarif'],0);?></td>
    <td><?= number_format($list['jsdr'],0);?></td>
    <td><?= number_format($list['manajemen'],0);?></td>
    <td><?= number_format($list['pendukung'],0);?></td>
    <td><?= number_format($list['asisten'],0);?></td>
  </tr>
 <? } ?>  
</table>
<p><?php 
$qry = mysql_query("
select a.kdpoly,c.nama as poly, a.kddokter,b.namadokter,sum(d.tarifrs) as tarif ,
e.nama_jasa, 0.7*sum(d.tarifrs) as jsdr, 0.1*sum(d.tarifrs) as manajemen,  0.20*sum(d.tarifrs) as pendukung
from t_pendaftaran a, m_dokter b, m_poly c, t_billrajal d, m_tarif e
 where a.kddokter=b.kddokter and a.kdpoly=c.kode and a.idxdaftar=d.idxdaftar and tglreg=curdate() 
 and a.kdpoly in(1,2,3,4,5,6,7,8) 
and kodetarif in('01050201','01050202','01050203','01050204','01050205') and d.kodetarif=e.kode
 group by a.kdpoly,c.nama, a.kddokter,b.namadokter,e.nama_jasa 
order by a.kdpoly") or die (mysql_error());
?>                    
<table width="575" border="1" class="tb">
  <tr>
    <th colspan="8">Elektromedik</th>
  </tr>
  <tr>
    <td width="58">Poly</td>
    <td width="102">Nama Dokter</td>    
    <td width="82"> Tindakan</td>

    <td width="80">Pendapatan</td>
    <td width="53">Jasa Dr</td>
    <td width="79">Manajemen</td>
    <td width="75">Pendukung</td>

  </tr>
<? while ($list = mysql_fetch_array($qry)){  ?>  
  
  <tr>
    <td><?= $list['poly'];?></td>
    <td><?= $list['namadokter'];?></td>
    <td><?= $list['nama_jasa'];?></td>
    <td><?= number_format($list['tarif'],0);?></td>
    <td><?= number_format($list['jsdr'],0);?></td>
    <td><?= number_format($list['manajemen'],0);?></td>
    <td><?= number_format($list['pendukung'],0);?></td>
  </tr>
 <? } ?>    
</table>
<p>
<p> <?php 
$qry = mysql_query("select a.kdpoly,c.nama as poly, a.kddokter,b.namadokter,sum(d.tarifrs) as tarif ,
e.nama_jasa, 0.7*sum(d.tarifrs) as jsdr, 0.1*sum(d.tarifrs) as manajemen,  0.20*sum(d.tarifrs) as pendukung
from t_pendaftaran a, m_dokter b, m_poly c, t_billrajal d, m_tarif e
 where a.kddokter=b.kddokter and a.kdpoly=c.kode and a.idxdaftar=d.idxdaftar and tglreg=curdate() 
 and a.kdpoly in(1,2,3,4,5,6,7,8) 
and kodetarif like '010903%' and d.kodetarif=e.kode
 group by a.kdpoly,c.nama, a.kddokter,b.namadokter,e.nama_jasa 
order by a.kdpoly") or die (mysql_error());?>  
<table width="578" border="1" class="tb">
  <tr>
    <th colspan="8">Visum </th>
  </tr>
  <tr>
    <td width="56">Poly</td>
    <td width="68">Dokter</td>
    <td width="58">Tindakan</td>


    <td width="71">Pendapatan</td>
    <td width="72">Jasa Dr</td>
    <td width="96">Manajemen</td>
    <td width="111">Pendukung</td>
  </tr>
<? while ($list = mysql_fetch_array($qry)){  ?>  
  
  <tr>
    <td><?= $list['poly'];?></td>
    <td><?= $list['namadokter'];?></td>
    <td><?= $list['nama_jasa'];?></td>
    <td><?= number_format($list['tarif'],0);?></td>
    <td><?= number_format($list['jsdr'],0);?></td>
    <td><?= number_format($list['manajemen'],0);?></td>
    <td><?= number_format($list['pendukung'],0);?></td>
  </tr>
 <? } ?>     
</table>
