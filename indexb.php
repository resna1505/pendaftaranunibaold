<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
include( "teskompubarcode.php" );
if ( !!( ereg_sikad( "1", $caraisidh ) || ereg_sikad( "3", $caraisidh ) ) || $REQUEST_METHOD == POST && $aksi == "isipresensi" )
{
    $q = "SELECT ID,PASSWORD,SHIFT FROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
    $h = mysql_query( $q, $koneksi );
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $iduser = $d[ID];
        $pass = $d[PASSWORD];
        $shift = $d[SHIFT];
        Header( "Location:presensib.php?aksi=isipresensi&iduser={$iduser}&pass={$pass}&kodedaftarhadir={$kodedaftarhadir}&shift={$shift}" );
    }
}
$errdh = "id";
$waktu = getdate( time( ) );
printheader( );
include( "hasilisidaftarhadir.php" );
echo "\r\n\r\n\r\n\r\n\t<tr valign=top   height=5 class=footer>\r\n\t\t<td colspan=2    \r\n\t\talign=center colspan=2><b>Isi Daftar Hadir dengan Menggunakan Pemindai /<i> Scanner</i></td>\r\n\t</tr>\r\n\r\n\t<tr valign=middle height=* >\r\n\t\t<td align=center colspan=2>\r\n\t\t\t<CENTER>\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
include( "isidaftarhadirb.php" );
echo "\t\t\t</CENTER>\r\n\t\t</td>\r\n\t</tr>\r\n\t\t\t";
printfooter( );
echo "</table>\r\n\r\n";
?>
