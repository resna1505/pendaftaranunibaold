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
    $q = "SELECT diskonbeasiswa.*,komponenpembayaran.JENIS,mahasiswa.ANGKATAN\n FROM diskonbeasiswa,komponenpembayaran,mahasiswa WHERE \n diskonbeasiswa.IDKOMPONEN=komponenpembayaran.ID AND\n diskonbeasiswa.IDMAHASISWA=mahasiswa.ID  ";
    $h = mysqli_query($koneksi,$q);
    echo mysql_error( );
    if ( 0 < sqlnumrows( $h ) )
    {
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $beasiswa = $d[DISKON];
            $idmahasiswa = $d[IDMAHASISWA];
            $idkomponen = $d[IDKOMPONEN];
            $angkatan = $d[ANGKATAN];
            $jenis = $d[JENIS];
            if ( 0 < $beasiswa )
            {
                if ( $jenis == 0 || $jenis == 1 || $jenis == 4 )
                {
                    $q = "UPDATE bayarkomponen SET BEASISWA='".$beasiswa."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' ; ";
                }
                else if ( $jenis == 2 )
                {
                    $q = "UPDATE bayarkomponen SET BEASISWA='".$beasiswa."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$d['TAHUN']}'  ; ";
                }
                else if ( $jenis == 3 )
                {
                    $q = "UPDATE bayarkomponen SET BEASISWA='".$beasiswa."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' ; ";
                }
                else if ( $jenis == 5 )
                {
                    $q = "UPDATE bayarkomponen SET BEASISWA='".$beasiswa."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' ; ";
                }
                else if ( $jenis == 6 )
                {
                    $q = "UPDATE bayarkomponen SET BEASISWA='".$beasiswa."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUNAJARAN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}' ; ";
                }
                echo $q."<br>";
                $i++;
            }
        }
        echo "UPDATE bayarkomponen SET DISKON=0 WHERE BEASISWA>0;<br><br><br>";
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Update Basis Data Beasiswa SITU AKADEMIK - 2012" );
    printmesg( $errmesg );
    echo "<p>\n<form method=post action=updatebayarkeuangan.php>\n<table class=form>\n<tr>\n<td align=center>\nJika anda hendak mengupdate basis data SITU AKADEMIK, silakan isi login dan password Administrator dan \ntekan tombol Update dan tunggu sampai selesai. Terima kasih\n</td>\n</tr>\n</table>\n</p>\n<p>\n<table class=form>\n \n<tr>\n<td colspan=2>\n<input class=tombol type=submit name=aksi value=Update>\n</td>\n</tr>\n</table>\n</p>\n</form>\n</center>\n\t\n\n";
}
echo "</p>\n \n \n";
?>
