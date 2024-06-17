<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT PERTANYAAN,JENIS FROM pooling";
$hasil = mysqli_query($koneksi,$q);
$data = sqlfetcharray( $hasil );
$tanya = $data[PERTANYAAN];
if ( $data[JENIS] == 0 )
{
    $ketjenis = "Jajak Pendapat ini bersifat <b>Tertutup</b>";
}
else
{
    $ketjenis = "Jajak Pendapat ini bersifat <b>Terbuka</b>";
}
echo "\r\n\r\n<form action='";
echo $root;
echo "hasilpooling.php' target=_blank method=post>\r\n\r\n\r\n<table cellpadding=2 cellspacing=0\t >\r\n\t<tr valign=top class=judulsubmenu>\r\n\t\t<td align=center colspan=2 height=19\r\n\t\tclass=judulsubmenu >\r\n\t\t<h3 class=\"submenutitle\">Jajak Pendapat</h3></td>\r\n\t</tr>\r\n\t<tr><td align=center class=submenu2>\r\n\t\t<table   class=submenudalam>\r\n\t\t\t<tr valign=top height=30 class=datasubmenudalambesar>\r\n\t\t\t\t<td align=center> \r\n\t\t\t\t";
echo "\r\n\t\t\t\t<p>\r\n\t\t\t\t{$tanya}\r\n\t\t\t\t</p>\r\n\t\t\t\t<p>\r\n\t\t\t\t{$ketjenis}\r\n\t\t\t\t</p>\r\n\t\t\t\t";
echo "</td>\r\n\t\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td align=center> \r\n\t\t\t<br>\r\n\t\t\t<p>\r\n\t\t\t\tUntuk mengikuti jajak pendapat ini dan menggunakan fasilitas-fasilitas internal lainnya, Anda harus login terlebih dahulu.\r\n\t\t\t\t</p>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</td></tr>\r\n\t<tr valign=top class=submenu2>\r\n\t\t<td colspan=2 align=center class=submenu2>\r\n\t\t\t<input style='font-size:7pt;' class=tombol type=submit name=aksi value='Hasi";
echo "l'>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n";
$tanya = "";
unset( $daftarjawab );
?>
