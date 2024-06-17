<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT INFO,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL,TANGGAL,IDUSER FROM \r\ninfo ORDER BY TANGGAL DESC \r\nLIMIT 0,21";
$h = mysql_query( $q, $koneksi );
if ( sqlnumrows( $h ) <= 0 )
{
}
else
{
    echo "<h2 class=\"shortinfo\">Info Singkat</h2>\r\n\t<table cellpadding=2 cellspacing=0>\r\n    <tr><td>&nbsp;&nbsp;</td></tr>";
    $i = 0;
    settype( $i, "integer" );
    while ( $d = sqlfetcharray( $h ) )
    {
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap";
        }
        else
        {
            $kelas = "class=dataganjil";
        }
        echo "\r\n\t\t\t<tr {$kelas} align=center valign=top>\r\n\t\t\t\t<td width=90% {$kelas}>\r\n\t\t\t\t\t".html_entity_decode( $d[INFO] )."\r\n\t\t\t\t\t<br><br>\r\n\t\t\t\t\t".getnama( $d[IDUSER] ).",\r\n\t\t\t\t\t{$d['TGL']}\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
        ++$i;
    }
    echo "\r\n\t</table>\r\n\t";
}
?>
