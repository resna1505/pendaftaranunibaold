<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan2.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Laporan Keuangan: Mahasiswa yg Belum Membayar" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>semua</option>\r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>semua</option>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t<tr >\r\n\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=checkbox name=istglbayar value=1>\r\n\t\t\t".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."\r\n\t\t\ts.d \r\n\t\t\t".createinputtanggal( "tglbayar2", $tglbayar2, " class=masukan" )."\r\n\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\t\r\n\t\t<tr valign=top>\r\n\t\t\t<td>Komponen Pembayaran</td>\r\n\t\t\t<td> \r\n\t\t\t<select class=masukan name=idkomponen>\r\n\t\t\t \r\n\t\t\t";
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "<option value={$k}>{$v}</option>";
        break;
    }
    echo "\r\n\t\t\t</select> <br><br>\r\n\t\t\tTahun Ajaran : \r\n\t\t\t\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    $ii = 1900;
    while ( $ii <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $ii == $d2[TAHUNAJARAN] )
        {
            $cek = "selected";
        }
        else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
        ++$ii;
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t</select> (Khusus pilihan Per Tahun Ajaran\tdan Semester )\t\t\r\n\t\t\t<br>\r\n\t\t\tSemester : \r\n\t\t\t\t\t\t\t\t\t\t<select name=semesterbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
    foreach ( $arraysemester as $k => $v )
    {
        $cek = "";
        if ( $k == $d2[SEMESTER] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>  (Khusus pilihan Semester )\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\t\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>
