<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LAPORAN PENDAFTARAN</title>
<style type="text/css">
<!--
.style4 {font-weight: bold}
.style5 {font-size: 24px}
-->
</style>
</head>

<body>
<?php
include "../connect.php";  
?>

<dialog id="data_izin">
  <table width="504" border="0" align="center">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="498"><div align="center" class="style5"><strong>LAPORAN JASPEL</strong></div></td>
    </tr>
    <tr>
      <td><div align="center" class="style5"></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <form method="get" action="report_billing_jaspel_perruang.php">
     <table width="495" border="0">
       <tbody>
         <tr>
           <td colspan="2"><?php include 'inc_carabayar.php'; ?></td>
         </tr>
         <tr>
           <td width="485" colspan="2"><?php include 'inc_ruang.php'; ?></td>
         </tr>
         <tr>
           <td colspan="2"><?php include 'inc_bulan.php'; ?></td>
         </tr>
         <tr>
           <td colspan="2"></td>
         </tr>
         <tr>
           <td colspan="2"><?php include 'inc_tahun.php'; ?></td>
         </tr>
         <tr>
           <td colspan="2"><?php include 'inc_kelas.php'; ?></td>
         </tr>
         <tr>
           <td><input type="reset" value="RESET"></td>
           <td><input type="submit" value="CARI" ></td>
         </tr>
       </tbody>
    </table>
    
  </form>
</dialog>
<menu>
  <button id="updateDetails">KLIK</button>
</menu>

<p>&nbsp;</p>
<script>
  (function() {
    var updateButton = document.getElementById('updateDetails');
    var cancelButton = document.getElementById('cancel');
    var favDialog = document.getElementById('data_izin');

    // Update button opens a modal dialog
    updateButton.addEventListener('click', function() {
      favDialog.showModal();
    });

    // Form cancel button closes the dialog box
    cancelButton.addEventListener('click', function() {
      favDialog.close();
    });

  })();
</script>
</body>
</html>
