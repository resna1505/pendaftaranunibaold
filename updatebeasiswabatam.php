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
    $q = "SELECT diskonbeasiswa.*,komponenpembayaran.JENIS,mahasiswa.ANGKATAN\n FROM diskonbeasiswa,komponenpembayaran,mahasiswa WHERE \n diskonbeasiswa.IDKOMPONEN=komponenpembayaran.ID AND\n diskonbeasiswa.IDMAHASISWA=mahasiswa.ID \n  AND diskonbeasiswa.TAHUN='0000' AND (komponenpembayaran.JENIS=2 OR komponenpembayaran.JENIS=3)";
    $h = mysqli_query($koneksi,$q);
    echo mysql_error( );
    if ( 0 < sqlnumrows( $h ) )
    {
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $idmahasiswa = $d[IDMAHASISWA];
            $idkomponen = $d[IDKOMPONEN];
            $angkatan = $d[ANGKATAN];
            $jenis = $d[JENIS];
            if ( $jenis == 2 )
            {
                $q = "UPDATE diskonbeasiswa SET TAHUN='".( $angkatan + 1 )."' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}'; ";
                $tahun = $angkatan + 1;
                for ( ; $tahun <= $angkatan + 4; $tahun++ )
                {
                    $q .= "REPLACE diskonbeasiswa  (IDMAHASISWA,IDKOMPONEN,DISKON,KET,UPDATER,TANGGALUPDATE,TAHUN,SEMESTER) \n        VALUES ('{$idmahasiswa}','{$idkomponen}','{$d['DISKON']}','{$d['KET']}','{$d['UPDATER']}',NOW(),'".( $tahun + 1 )."','0') ";
                }
            }
            else if ( $jenis == 3 )
            {
                $q = "UPDATE diskonbeasiswa SET TAHUN='".( $angkatan + 1 )."',SEMESTER='1' WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TAHUN='{$d['TAHUN']}' AND SEMESTER='{$d['SEMESTER']}';<br> ";
                $q .= "REPLACE diskonbeasiswa  (IDMAHASISWA,IDKOMPONEN,DISKON,KET,UPDATER,TANGGALUPDATE,TAHUN,SEMESTER) \n      VALUES ('{$idmahasiswa}','{$idkomponen}','{$d['DISKON']}','{$d['KET']}','{$d['UPDATER']}',NOW(),'".( $angkatan + 1 )."','2'); <br> ";
                $tahun = $angkatan + 1;
                for ( ; $tahun <= $angkatan + 3; $tahun++ )
                {
                    $q .= "REPLACE diskonbeasiswa  (IDMAHASISWA,IDKOMPONEN,DISKON,KET,UPDATER,TANGGALUPDATE,TAHUN,SEMESTER) \n        VALUES ('{$idmahasiswa}','{$idkomponen}','{$d['DISKON']}','{$d['KET']}','{$d['UPDATER']}',NOW(),'".( $tahun + 1 )."','1');<br> ";
                    $q .= "REPLACE diskonbeasiswa  (IDMAHASISWA,IDKOMPONEN,DISKON,KET,UPDATER,TANGGALUPDATE,TAHUN,SEMESTER) \n        VALUES ('{$idmahasiswa}','{$idkomponen}','{$d['DISKON']}','{$d['KET']}','{$d['UPDATER']}',NOW(),'".( $tahun + 1 )."','2');<br>  ";
                }
            }
            echo $q."<br>";
            $i++;
        }
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Update Basis Data Beasiswa SITU AKADEMIK - 2012" );
    printmesg( $errmesg );
    echo "<p>\n<form method=post action=updatebeasiswabatam.php>\n<table class=form>\n<tr>\n<td align=center>\nJika anda hendak mengupdate basis data SITU AKADEMIK, silakan isi login dan password Administrator dan \ntekan tombol Update dan tunggu sampai selesai. Terima kasih\n</td>\n</tr>\n</table>\n</p>\n<p>\n<table class=form>\n \n<tr>\n<td colspan=2>\n<input class=tombol type=submit name=aksi value=Update>\n</td>\n</tr>\n</table>\n</p>\n</form>\n</center>\n\t\n\n";
}
echo "</p>\n \n \n";
?>
