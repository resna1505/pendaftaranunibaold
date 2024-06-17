<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
if ( $aksi == "Update" )
{
    $query = "SELECT NAMA FROM user \r\n\t\tWHERE ID='superadmin' \r\n\t\tAND '{$idupdate}'='superadmin' \r\n\t\tAND PASSWORD=PASSWORD('{$passwordupdate}')";
    $hasil = mysqli_query($koneksi,$query);
    if ( sqlnumrows( $hasil ) <= 0 )
    {
        $errmesg = "Password yang Anda berikan tidak benar";
        $aksi = "";
    }
    else
    {
        $q = "SELECT * FROM tbdos WHERE PTINDTBDOS='113082'";
        $h = mysqli_query($koneksi,$q);
        $i = 0;
        echo "<table  border=0>";
        while ( $d = sqlfetcharray( $h ) )
        {
            $q = "\r\nINSERT INTO   `msdos` (\r\n`KDPTIMSDOS` ,\r\n`KDJENMSDOS` ,\r\n`KDPSTMSDOS` ,\r\n`NOKTPMSDOS` ,\r\n`NODOSMSDOS` ,\r\n`NMDOSMSDOS` ,\r\n`GELARMSDOS` ,\r\n`TPLHRMSDOS` ,\r\n`TGLHRMSDOS` ,\r\n`KDJEKMSDOS` ,\r\n`KDJANMSDOS` ,\r\n`KDPDAMSDOS` ,\r\n`KDSTAMSDOS` ,\r\n`STDOSMSDOS` ,\r\n`MLSEMMSDOS` ,\r\n`STKATMSDOS` ,\r\n`SRTIJMSDOS` ,\r\n`NIPNSMSDOS` ,\r\n`PTINDMSDOS` ,\r\n`NIDNNMSDOS` ,\r\n`SMAWLMSDOS` ,\r\n`NODOS_` ,\r\n`CETAKMSDOS`\r\n)\r\nVALUES ('{$d['PTINDTBDOS']}' ,\r\n'{$d['KDJENTBDOS']}' ,\r\n'{$d['KDPSTTBDOS']}' ,\r\n'{$d['NOKTPTBDOS']}' ,\r\n'{$d['NIDNNTBDOS']}' ,\r\n'{$d['NMDOSTBDOS']}' ,\r\n'{$d['GELARTBDOS']}' ,\r\n'{$d['TPLHRTBDOS']}' ,\r\n'{$d['TGLHRTBDOS']}' ,\r\n'{$d['KDJEKTBDOS']}' ,\r\n'{$d['KDJANTBDOS']}' ,\r\n'{$d['KDPDATBDOS']}' ,\r\n'{$d['KDSTATBDOS']}' ,\r\n'{$d['STDOSTBDOS']}' ,\r\n'{$d['MLSEMMSDOS']}' ,\r\n'{$d['STKATMSDOS']}' ,\r\n'{$d['SRTIJMSDOS']}' ,\r\n'{$d['NIPNSTBDOS']}' ,\r\n'{$d['PTINDTBDOS']}' ,\r\n'{$d['NIDNNTBDOS']}' ,\r\n'{$d['SMAWLMSDOS']}' ,\r\n'{$d['NODOS_']}' ,\r\n'{$d['CETAKMSDOS']}'\r\n);  \r\n  ";
            mysqli_query($koneksi,$q);
            echo "\r\n  <tr valign=top>\r\n    <td nowrap>{$q};</td>\r\n    <td nowrap>".mysql_error( )."</td>\r\n \r\n\r\n \r\n  </tr> ";
            ++$i;
        }
        echo "</table>";
        echo "<p>";
        printmesg( "\r\nProses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa\r\n" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "IMPORT Data Mahasiswa SITU AKADEMIK UNIKAL" );
    printmesg( $errmesg );
    echo "<p>\r\n<form action=impormsdossamarinda.php method=post>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengimport data mahasiswa SITU AKADEMIK UNIKAL, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo " \r\n";
?>
