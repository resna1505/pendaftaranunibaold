<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
if ( $aksi == "Perbaiki Tabel" )
{
    $q = "SHOW TABLES";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printjudulmenukecil( "Daftar Tabel yang diperbaiki" );
        echo "\r\n\t\t<table class=data>\r\n\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td>Nama Tabel</td>\r\n\t\t\t\t<td>Status Perbaikan</td>\r\n\t\t\t</tr>\r\n\t\t";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "dataganjil";
            }
            else
            {
                $kelas = "datagenap";
            }
            ++$i;
            $status = "";
            $hh = mysql_query( "REPAIR TABLE {$d['0']}", $koneksi );
            if ( 0 < sqlnumrows( $hh ) )
            {
                $dd = sqlfetcharray( $hh );
                $status = $dd[3];
            }
            echo "\r\n\t\t\t\t<tr valign=top class={$kelas}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td nowrap >{$d['0']}</td>\r\n\t\t\t\t\t\t<td align=center>{$status}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t";
        }
        echo "</table>";
    }
    else
    {
        printmesg( "Tabel tidak ada" );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Perbaiki Basis Data SAUNG" );
    printmesg( $errmesg );
    echo "<p>\r\n<form method=post action=perbaikitabel.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak memperbaiki basis data SAUNG, \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n <tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value='Perbaiki Tabel'>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
