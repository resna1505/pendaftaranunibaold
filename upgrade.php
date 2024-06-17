<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
$data[0][sql] = "ALTER TABLE user ADD COLUMN STATUSPEGAWAI2 SMALLINT UNSIGNED DEFAULT 0 AFTER STATUSPEGAWAI";
$data[1][sql] = "ALTER TABLE user ADD COLUMN STATUSKERJA SMALLINT UNSIGNED DEFAULT 0 AFTER STATUSPEGAWAI2";
$data[1][ket] = "Mengalter tabel user, tambah Status Kerja";
$i = 1;
foreach ( $data as $k => $v )
{
    mysql_query( $v[sql], $koneksi );
    echo "{$i}. {$v['ket']} ...<br>{$v['sql']}<br>";
    $data[$k][err] = mysql_error( );
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        echo "Berhasil";
    }
    else
    {
        echo "Tidak Berhasil<br>";
        echo $data[$k][err];
    }
    echo "<br>";
    ++$i;
}
?>
