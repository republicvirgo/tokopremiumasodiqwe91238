<?php session_start();
  
include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
    

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];


    
 ?>


 	<?php echo $data1['nama_perusahaan']; ?><br>
 	<?php echo $data1['alamat_perusahaan']; ?><br><br>
 	===================<br>
 	No Faktur : <?php echo $data0['no_faktur']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
 	===================<br>

</font>
 
 <table>

  <tbody>


           <?php 
           while ($data2 = mysqli_fetch_array($query2)){

                      // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
            $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,konversi  FROM satuan_konversi WHERE kode_produk = '$data2[kode_barang]' AND id_satuan = '$data2[satuan]' ");
            $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

            // QUERY CEK BARCODE DI SATUAN KONVERSI

            if ($data2['harga_konversi'] != 0) {
             $harga = $data2['harga_konversi'];
            }else{
              $harga = $data2['harga'];
            }

                        // IF CEK BARCODE DI SATUAN KONVERSI
            if ($data_satuan_konversi['jumlah_data'] > 0) {//    if ($data_satuan_konversi['jumlah_data'] > 0) {
                    
                    $jumlah_barang = $data2['jumlah_barang'] / $data_satuan_konversi['konversi'];
                                        
                  }else{
                      
                     $jumlah_barang = $data2['jumlah_barang'];

                  }
           
           echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. koma($jumlah_barang,3) .'</td>  <td style="padding:3px"> '. rp($harga) .'</td>  <td style="padding:3px"> '. rp($data2['subtotal']) . ' </td></tr>';
           
           }
           
                   //Untuk Memutuskan Koneksi Ke Database
                   
                   mysqli_close($db); 
        
           
           
           ?> 
 </tbody>
</table>
 	
    ===================<br>
 <table>
  <tbody>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo koma($data0['potongan'],2);?> </tr>
      <tr><td width="50%">Biaya Admin</td> <td> :</td> <td><?php echo koma($data0['biaya_admin'],2);?> </tr>

      <!--<tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo koma($data0['tax']);?> </td></tr>-->
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo koma($total_item,3); ?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo koma($data0['total'],2); ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo koma($data0['tunai'],2); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo koma($data0['sisa'],2); ?>  </td></tr>
            

  </tbody>
</table>

     ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($data0['tanggal']);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Selamat Datang Kembali<br>
    Telp. <?php echo $data1['no_telp']; ?><br>
    (* Sudah Termasuk PPN 10%)
    
 <script>
$(document).ready(function(){
  window.print();
});
</script>


 </body>
 </html>

