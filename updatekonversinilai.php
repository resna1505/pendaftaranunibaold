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
        $q = "\r\nSELECT NIMHSTRNLP\t,KDKMKTRNLP,COUNT(THSMSTRNLP)\tAS JUMLAH\r\nFROM trnlp,nilaikonversi\r\nWHERE  \r\nIDMAHASISWA=NIMHSTRNLP AND\r\nIDMAKUL=KDKMKTRNLP \r\nGROUP BY NIMHSTRNLP,KDKMKTRNLP,KDPSTTRNLP,KDJENTRNLP,KDPTITRNLP \r\nHAVING JUMLAH > 1  ";
        $h = mysqli_query($koneksi,$q);
        $i = 1;
        printjudulmenu( "Update BASISDATA SITU AKADEMIK" );
        echo "<table class=data width=95% border=1>\r\n\t\t<tr align=center class=juduldata>\r\n\t\t\t<td>No</td>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>Kode Makul</td>\r\n\t\t\t<td>Jumlah Data</td>\r\n\t\t\t<td>Status Perbaikan</td>\r\n\t\t</tr>\r\n\t";
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "datagenap";
            }
            else
            {
                $kelas = "dataganjil";
            }
            $q = "DELETE FROM trnlp WHERE THSMSTRNLP='00000' AND NIMHSTRNLP='{$d['NIMHSTRNLP']}' AND KDKMKTRNLP='{$d['KDKMKTRNLP']}'";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $status = "BERHASIL";
            }
            else
            {
                $status = "GAGAL";
            }
            echo "\r\n\t\t<tr class={$kelas}>\r\n\t\t\t<td>{$i}</td>\r\n\t\t\t<td>{$d['NIMHSTRNLP']}</td>\r\n\t\t\t<td  >{$d['KDKMKTRNLP']}</td>\r\n\t\t\t<td align=center >{$d['JUMLAH']}</td>\r\n\t\t\t<td align=center > {$status}</td>\r\n\t\t</tr>";
            ++$i;
        }
    }
    echo "<p>";
    printmesg( "\r\nProses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa\r\n" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Perbaikan Data Konversi Nilai SITU AKADEMIK" );
    printmesg( $errmesg );
    echo "<p>\r\n<form method=post action=updatekonversinilai.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengupdate basis data SITU AKADEMIK, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
