<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
echo "<html>\r\n<head>\r\n\t<title>Pengumuman\r\n\t</title>\r\n</head>\r\n<body>\r\n<table style='color:#000000;border-collapse:collapse;'  width=100% height=100% border=1 cellpadding=3 cellspacing=0\r\n bordercolor=#000000  style='color:#ffffff;font-size:11pt;'>\r\n<tr valign=top >\r\n<td  align=justify>\r\n<h2 align=center>Pengumuman</h3>\r\n";
$query = "SELECT DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL, RINCIAN FROM\r\n\tpengumuman ORDER BY TANGGAL DESC LIMIT 10,10000000";
$hasil = mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    echo "<ol>";
    while ( $data = sqlfetcharray( $hasil ) )
    {
        echo "<li align=justify>{$data['RINCIAN']}... <font style='font-size:8pt;'>({$data['TGL']})</font>";
    }
    echo "</ol>";
}
else
{
    echo "<center>Tidak ada pengumuman...</center>";
}
echo "</td>\r\n</tr>\r\n</table>\r\n\r\n\r\n\r\n\r\n\r\n</body>\r\n</html>";
?>
