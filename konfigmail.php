<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$aksi = "";
if ( $aksi2 == "Tes Kirim Email ke" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else
    {
        $q = "SELECT * FROM konfigsmtp WHERE ID='PMB'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $dmail[to] = $tesemail;
            $dmail[subject] = "Tes Kirim Email / SMTP - PMB";
            $dmail[body] = "Konfigurasi SMTP sudah benar.";
            $hasil = kirimemail_calonmahasiswa( $dmail );
            if ( $hasil == 1 )
            {
                $errmesg = "Tes pengiriman email ke {$tesemail} berhasil dilakukan. Konfigurasi sudah benar. Terima kasih";
            }
            else
            {
                $errmesg = "Tes pengiriman email ke {$tesemail} tidak berhasil dilakukan. Konfigurasi mungkin belum benar. Terima kasih<br>{$hasil}";
            }
        }
        else
        {
            $errmesg = "Maaf, onfigurasi tidak ada.";
        }
    }
    $aksi = "";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else
    {
        $q = "\r\n\r\n          REPLACE INTO   `konfigsmtp` (\r\n           ID,\r\n          `FROM` ,\r\n          `HOST` ,\r\n          `PORT` ,\r\n          `USERNAME` ,\r\n          `PASSWORD` ,\r\n          `UPDATER` ,\r\n          `TANGGALUPDATE`  \r\n          )\r\n          VALUES ( 'PMB',  '{$from}',  '{$host}',  '{$port}',  '{$username}',  '{$password}',  \r\n          '{$users}',  NOW() \r\n          )\r\n        \r\n        ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Konfigurasi Mail/SMTP berhasil disimpan";
        }
        else
        {
            $errmesg = "Konfigurasi Mail/SMTP tidak berhasil disimpan";
        }
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    printjudulmenu( "Konfigurasi SMTP" );
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM konfigsmtp WHERE ID='PMB'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    echo "\r\n\t\t<form name=form action=index.php method=post >\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n \r\n \t\t<tr class=judulform>\r\n\t\t\t<td width=200>Email Pengirim</td>\r\n\t\t\t<td>".createinputtext( "from", $d[FROM], " class=masukan  size=50" )." Alamat email yang akan digunakan untuk mengirim email pada pemrosesan PMB (misal untuk reset password PMB). Contoh: pmb@gmail.com\r\n  \t\t\t</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Host</td>\r\n\t\t\t<td>".createinputtext( "host", $d[HOST], " class=masukan  size=50" )." Server SMTP. Contoh : ssl://smtp.gmail.com\r\n  \t\t\t</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Port</td>\r\n\t\t\t<td>".createinputtext( "port", $d[PORT], " class=masukan  size=5" )." Port SMTP. Contoh 465 (ssl)\r\n  \t\t\t</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>User name</td>\r\n\t\t\t<td>".createinputtext( "username", $d[USERNAME], " class=masukan  size=50" )." username SMTP contoh : pmb@gmail.com\r\n  \t\t\t</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Password</td>\r\n\t\t\t<td>".createinputtext( "password", $d[PASSWORD], " class=masukan  size=50" )." Password Username SMTP\r\n  \t\t\t</td>\r\n\t\t</tr> \r\n \r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan onClick=\"return confirm('Simpan data konfigurasi Mail/SMTP?')\"> <br><br>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tes Kirim Email ke' class=masukan>\r\n\t\t\t\t\t<input type=text name=tesemail value='{$d['FROM']}' size=20>\r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \r\n\t";
}
?>
