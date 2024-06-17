<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM waktudaftarpmb ORDER BY TAHUN,GELOMBANG";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printjudulmenu( "<b>Jadwal Pendaftaran PMB</b>" );
    echo "\r\n    <table>\r\n      <tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Gelombang</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td> \r\n        <td>Biaya (Rp)</td> \r\n      </tr>\r\n    ";
    $i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TANGGALMULAI] );
        $tglmulai = $tmp[2];
        $blnmulai = $tmp[1];
        $thnmulai = $tmp[0];
        $tmp = explode( "-", $d[TANGGALSELESAI] );
        $tglselesai = $tmp[2];
        $blnselesai = $tmp[1];
        $thnselesai = $tmp[0];
        echo "\r\n      <tr {$kelas}>\r\n        <td align=center>{$d['TAHUN']} </td>\r\n        <td align=center> {$d['GELOMBANG']} </td>\r\n        <td  align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td> \r\n        <td align=right>".cetakuang( $d[BIAYA] )." </td>\r\n       </tr>\r\n      ";
    }
    echo "</table>";
}
else
{
    printmesg( "Jadwal Pendaftaran PMB Tidak Ada" );
}
?>
