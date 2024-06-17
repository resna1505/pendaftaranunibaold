<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "Isi Daftar Hadir" )
{
    if ( trim( $namapeserta ) == "" )
    {
        $errmesg = "Nama Peserta harus diisi";
    }
    else
    {
        $tmp = explode( "-", $idpeserta );
        $q = "INSERT INTO kehadiranpeserta VALUES('{$idpeserta}',NOW(),NOW(),'{$namapeserta}')";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "{$namapeserta}, terima kasih sudah mengisi daftar hadir";
        }
        else
        {
            $errmesg = "{$namapeserta}, Anda sudah pernah mengisi daftar hadir";
        }
    }
}
$q = "SELECT NAMA,ID,IDCOUNTER,JUMLAH FROM peserta WHERE \r\nTANGGALM <=NOW() AND TANGGALS >= NOW() ORDER BY IDCOUNTER";
$h = mysqli_query($koneksi,$q);
printjudulmenu( "Isi Daftar Hadir Peserta Kegiatan" );
printmesg( $errmesg );
if ( 0 < sqlnumrows( $h ) )
{
    while ( $d = sqlfetcharray( $h ) )
    {
        echo "\r\n\t<p>\r\n\t<form action=index.php>\r\n\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=aksi value='Isi Daftar Hadir'>\r\n\t<table class=form bgcolor=#eeeeff>\r\n\t<tr class=juduldata><td colspan=2 align=center style='font-size:12pt'> {$d['NAMA']}</td></tr>\r\n\t<tr><td> ID Peserta </td>\r\n\t<td>\r\n\t\r\n\t";
        echo "<select name=idpeserta class=masukan>";
        $i = 1;
        while ( $i <= $d[JUMLAH] )
        {
            echo "<option value='{$d['IDCOUNTER']}-{$d['ID']}-{$i}' >{$d['IDCOUNTER']}{$i}</option>";
            ++$i;
        }
        echo "</select>\r\n\t\r\n\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t<td>Nama Peserta</td>\r\n\t<td>\r\n\t\t<input type=text class=masukan name=namapeserta>\r\n\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t<td colspan=2>\r\n\t\t<input type=submit class=tombol  value='Isi Daftar Hadir'>\r\n\t</td>\r\n\t</tr>\r\n\t</table>\r\n\t</form>\r\n\t";
    }
}
printmesg( "Tidak ada kegiatan hari ini" );
?>
