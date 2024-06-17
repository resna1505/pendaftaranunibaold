<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
printheader( );
echo "\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t<td align=left width=150 class=submenu>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td width=520 align=center>\r\n\r\n";
if ( $aksi == "Update" )
{
    $query = "SELECT NAMA FROM user \r\n\t\tWHERE ID='superadmin' \r\n\t\tAND '{$idupdate}'='superadmin' \r\n\t\tAND SUBSTRING(PASSWORD,1,32)=SUBSTRING(OLD_PASSWORD('{$passwordupdate}'),1,32)";
    $hasil = mysqli_query($koneksi,$query);
    if ( sqlnumrows( $hasil ) <= 0 )
    {
        $errmesg = "Password yang Anda berikan tidak benar";
        $aksi = "";
    }
    else
    {
        $sql[] = "ALTER TABLE mahasiswa ADD KELAS VARCHAR(3) DEFAULT '1'";
        $sql[] = "CREATE table komponenpembayaran (\r\n\tID CHAR(5) NOT NULL PRIMARY KEY,\r\n\tNAMA VARCHAR(100),\r\n\tJENIS SMALLINT UNSIGNED NOT NULL DEFAULT 0\r\n)";
        $sql[] = "CREATE TABLE biayakomponen (\r\n\tIDKOMPONEN CHAR(5) NOT NULL,\r\n\tIDPRODI INT UNSIGNED NOT NULL,\r\n\tANGKATAN YEAR NOT NULL,\r\n\tBIAYA DECIMAL(12,2),\r\n\tPRIMARY KEY(IDKOMPONEN,IDPRODI,ANGKATAN)\r\n)";
        $sql[] = "CREATE TABLE bayarkomponen (\r\n\tIDMAHASISWA CHAR(20) NOT NULL,\r\n\tIDKOMPONEN CHAR(5) NOT NULL,\r\n\tTANGGALBAYAR DATE NOT NULL,\r\n\tJENIS SMALLINT UNSIGNED NOT NULL,\r\n\tJUMLAH DECIMAL(12,2),\r\n\tKET TINYTEXT,\r\n\tTAHUNAJARAN YEAR,\r\n\tSEMESTER SMALLINT UNSIGNED NOT NULL,\r\n\tPRIMARY KEY(IDMAHASISWA,IDKOMPONEN,TANGGALBAYAR)\r\n)";
        foreach ( $arraypt as $k => $v )
        {
            if ( trim( $v ) != "" )
            {
                $sql[] = str_replace( ";", "", $v );
            }
        }
        $i = 1;
        if ( is_array( $sql ) )
        {
            printjudulmenu( "Update SITU" );
            echo "<table class=data>\r\n\t\t<tr align=center class=juduldata>\r\n\t\t\t<td>No</td>\r\n\t\t\t<td>Query</td>\r\n\t\t\t<td>Hasil</td>\r\n\t\t</tr>\r\n\t";
            foreach ( $sql as $q )
            {
                $h = mysqli_query($koneksi,$q);
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
    printjudulmenu( "Update Basis Data SITU Akademik" );
    printmesg( $errmesg );
    echo "<p>\r\n<form action=updateakademik.php method=post>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengupdate basis data SITU, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td align=center width=150  class=submenu>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n";
printfooter( );
?>
