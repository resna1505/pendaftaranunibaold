<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arrayfolder[] = "bahan/file";
$arrayfolder[] = "cadangan/file";
$arrayfolder[] = "daftarhadir/gambardiagram";
$arrayfolder[] = "file/bidang";
$arrayfolder[] = "file/p";
$arrayfolder[] = "file/umum";
$arrayfolder[] = "mahasiswa/foto";
$arrayfolder[] = "pegawai/barcode";
$arrayfolder[] = "pegawai/foto";
$arrayfolder[] = "pengumuman/gambar";
$arrayfolder[] = "pesan/file";
$arrayfolder[] = "pesan/filet";
$arrayfolder[] = "nilai/gambardiagram";
$arrayfolder[] = "gambar/logo.txt";
$arrayfolder[] = "log";
foreach ( $arrayfolder as $k => $v )
{
    $hasil = @chmod( @$v, 511 );
    if ( $hasil == 1 )
    {
        echo "chmod 775 {$v} sukses<br>";
    }
    else
    {
        echo "chmod 775 {$v} gagal<br>";
    }
}
?>
