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
        $sql[] = "UPDATE pengambilanmk SET BOBOT='1.5' WHERE SIMBOL='D+'";
        $sql[] = "UPDATE pengambilanmk SET BOBOT='2.5' WHERE SIMBOL='C+'";
        $sql[] = "UPDATE pengambilanmk SET BOBOT='3.5' WHERE SIMBOL='B+'";
        $sql[] = "UPDATE trnlm SET BOBOTTRNLM='1.5' WHERE NLAKHTRNLM='D+'";
        $sql[] = "UPDATE trnlm SET BOBOTTRNLM='2.5' WHERE NLAKHTRNLM='C+'";
        $sql[] = "UPDATE trnlm SET BOBOTTRNLM='3.5' WHERE NLAKHTRNLM='B+'";
        $i = 1;
        if ( is_array( $sql ) )
        {
            printjudulmenu( "Update BASISDATA SITU AKADEMIK UNIKAL" );
            echo "<table class=data>\r\n\t\t<tr align=center class=juduldata>\r\n\t\t\t<td>No</td>\r\n\t\t\t<td>Query</td>\r\n\t\t\t<td>Hasil</td>\r\n\t\t</tr>\r\n\t";
            foreach ( $sql as $q )
            {
                $h = mysqli_query($koneksi,$query);
                if ( $i % 2 == 0 )
                {
                    $kelas = "datagenap";
                }
                else
                {
                    $kelas = "dataganjil";
                }
                if ( mysql_error( ) != "" )
                {
                    $hasil = "Update gagal, ".mysql_error( );
                }
                else
                {
                    $hasil = "Update OK";
                }
                echo "\r\n\t\t<tr class={$kelas}>\r\n\t\t\t<td>{$i}</td>\r\n\t\t\t<td>{$q}</td>\r\n\t\t\t<td  >{$hasil}</td>\r\n\t\t</tr>";
                ++$i;
            }
        }
        echo "<p>";
        printmesg( "\r\nProses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa\r\n" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Update Basis Data SITU AKADEMIK" );
    printmesg( $errmesg );
    echo "<p>\r\n<form method=post action=updateunikal.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengupdate basis data SITU AKADEMIK UNIKAL, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
