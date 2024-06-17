<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$folder = "gambardiagram/";
$datatabel[panjang] = 400;
$datatabel[lebar] = 250;
$datatabel[jarakbingkai] = 30;
$datatabel[minx] = 0;
$datatabel[miny] = 0;
$datatabel[maxx] = 5;
$datatabel[maxy] = $kehadiran;
$pembagi = getpembagiinteger( $kehadiran );
$datatabel[jmltitiky] = $pembagi;
$datatabel[jmltitikx] = 20;
$datatabel[jarakbatang] = 10;
$datanx[1] = "Tepat Waktu";
$datanx[2] = "Tidak Isi<br>Kehadiran";
$datanx[3] = "Pulang Cepat";
$data[1] = $kehadiran - $tidakabsenpulang - $pulangcepat;
$data[2] = $tidakabsenpulang;
$data[3] = $pulangcepat;
$juduldiagram[1][nama] = "Diagram Rekapitulasi Pulang";
$juduldiagram[2][nama] = getnama( $iduser )." ({$iduser}) ";
$juduldiagram[x][nama] = "";
$juduldiagram[y][nama] = "Jumlah Hari";
$juduldiagram[x][font] = 1;
$juduldiagram[y][font] = 1;
$juduldiagram[1][font] = 4;
$juduldiagram[2][font] = 3;
$juduldiagram[ny][font] = 1;
$juduldiagram[nx][font] = 1;
$xx = creatediagrambatang( $datatabel, $data, $datanx, $juduldiagram, $folder, $xx );
$q = "INSERT INTO gambartemp VALUES('{$folder}"."{$xx}',NOW())";
mysql_query( $q, $koneksi );
if ( 0 < sqlaffectedrows( $koneksi ) )
{
    echo "\r\n\t<p>\r\n\t<table class=form>\r\n\t\t<tr><td>\r\n\t\t<image src='{$folder}"."{$xx}' >\r\n\t\t</td></tr></table>\r\n\t</p>\r\n\t";
}
?>
