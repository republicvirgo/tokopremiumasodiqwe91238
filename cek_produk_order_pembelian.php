<?php

include 'db.php';
include 'sanitasi.php';

$session_id = stringdoang($_POST['session_id']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query = $db->query("SELECT kode_barang FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
$jumlah = mysqli_num_rows($query);

if ($jumlah > 0){

  echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>