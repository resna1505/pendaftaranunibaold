<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

session_start( );
include( "header.php" );
periksaroot( );
echo "\r\n  <head>\r\n\t<link rel=\"stylesheet\" href=\"".$root."css/indexc.css\" type=\"text/css\" />\r\n\t<!--[if lte IE 6]>\r\n\t<link href=\"".$root."css/iehackc.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n\t<![endif]--> \r\n\t<!--[if lte IE 7]>\r\n\t<link href=\"".$root."css/iehackc.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n\t<![endif]--> \r\n\t</head>\r\n";
$q = "\r\nCREATE TABLE `statusupdate` (\r\n  `ID` char(8) NOT NULL,\r\n  `PENJELASAN` mediumtext NOT NULL,\r\n  `STATUS` tinytext NOT NULL,\r\n  `TANGGALUPDATE` datetime NOT NULL,\r\n  `KET` mediumtext NOT NULL,\r\n  `NAMA` varchar(255) NOT NULL,\r\n  `TANGGAL` date NOT NULL,\r\n  `FILE` tinytext NOT NULL,\r\n  PRIMARY KEY  (`ID`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=utf8\r\n";
mysqli_query($koneksi,$query);
include( "update/daftar.php" );
unset( $tmpcetak );
if ( $aksi == "Update" )
{
    include_once( "update/unzip.lib.php" );
    if ( $_SESSION['tokenlogin'] != md5( $randlogin ) )
    {
        $errmesg = "Kode anti-spam yang Anda masukkan salah.";
        $aksi = "";
    }
    else
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
            $i = 1;
            if ( is_array( $penjelasan ) )
            {
                $hasil = "";
                $hasilfile = "";
                foreach ( $penjelasan as $k => $v )
                {
                    if ( is_array( $sql[$k] ) )
                    {
                        $berhasil = 0;
                        foreach ( $sql[$k] as $q )
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
                                $hasil .= "Update gagal, ".mysql_error( )."\n";
                            }
                            else
                            {
                                ++$berhasil;
                            }
                        }
                        $hasilfile .= "{$berhasil} dari ".count( $sql[$k] )." query berhasil dilakukan <br>";
                    }
                    if ( $penjelasan[$k][file] != "" )
                    {
                        if ( file_exists( "update/file/".$penjelasan[$k][file] ) )
                        {
                            unset( $zip );
                            $zip = @new SimpleUnzip( @"update/file/".@$penjelasan[$k][file] );
                            $berhasil = 0;
                            $i = 0;
                            while ( $i < $zip->Count( ) )
                            {
                                if ( $zip->GetErrorMsg( $i ) == "" )
                                {
                                    $namafile = $zip->GetPath( $i )."/".$zip->GetName( $i );
                                    $zip->GetPath( $i )."/".$zip->GetName( $i )."<br>";
                                    if ( $f = fopen( $namafile, "w" ) )
                                    {
                                        fwrite( $f, $zip->GetData( $i ) );
                                        fclose( $f );
                                        ++$berhasil;
                                    }
                                    else
                                    {
                                        $hasil .= "Gagal ekstraksi file ".$zip->GetPath( $i )."/".$zip->GetName( $i )."<br>";
                                    }
                                }
                                else
                                {
                                    $hasil .= "Gagal ekstraksi file ".$zip->GetPath( $i )."/".$zip->GetName( $i )."<br>";
                                }
                                ++$i;
                            }
                            $hasilfile .= "{$berhasil} dari ".$zip->Count( )." file berhasil di ekstrak <br>";
                            unset( $zip );
                        }
                        else
                        {
                            $hasil .= "File ".$penjelasan[$k][file]." tidak ada!!! <br>";
                        }
                    }
                    ++$i;
                    $judul = mysql_real_escape_string( $penjelasan[$k][nama] );
                    $ket = mysql_real_escape_string( $penjelasan[$k][ket] );
                    $tanggal = mysql_real_escape_string( $penjelasan[$k][tgl] );
                    $namafilezip = mysql_real_escape_string( $penjelasan[$k][file] );
                    if ( $hasil != "" )
                    {
                        $q = "INSERT INTO statusupdate\r\n                  (ID,NAMA,PENJELASAN,STATUS,KET,TANGGAL,TANGGALUPDATE,FILE)\r\n                  VALUES \r\n                  ('{$k}','{$judul}','{$ket}','Sudah diupdate. Ada yang gagal.','".mysql_real_escape_string( $hasilfile.$hasil )."',\r\n                  '{$tanggal}',NOW(),'{$namafilezip}')";
                        mysqli_query($koneksi,$query);
                    }
                    else
                    {
                        $q = "INSERT INTO statusupdate\r\n                  (ID,NAMA,PENJELASAN,STATUS,KET,TANGGAL,TANGGALUPDATE,FILE)\r\n                  VALUES \r\n                  ('{$k}','{$judul}','{$ket}','Sudah diupdate','".mysql_real_escape_string( $hasilfile.$hasil )."',\r\n                  '{$tanggal}',NOW(),'{$namafilezip}')";
                        mysqli_query($koneksi,$query);
                        if ( sqlaffectedrows( $koneksi ) <= 0 )
                        {
                            $q = "\r\n                      UPDATE statusupdate\r\n                      SET\r\n                      PENJELASAN='".$ket."',\r\n                      NAMA='".$judul."',\r\n                      TANGGAL='{$tanggal}',\r\n                      FILE='{$namafilezip}',\r\n                      STATUS='Sudah diupdate',\r\n                      TANGGALUPDATE=NOW()\r\n                     \r\n                      WHERE ID='{$k}'\r\n                    ";
                            mysqli_query($koneksi,$query);
                        }
                    }
                }
            }
            echo "<p>";
            $errmesg = "\r\n      {$hasilfile}\r\n      {$hasil}\r\n      <br>\r\n      <br>\r\n      Proses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa \r\n      ";
        }
    }
    $aksi = "";
}
$hasil = generaterandomcaptcha( );
$_SESSION['tokenlogin'] = $hasil[token];
$_SESSION['antispamlogin'] = $hasil[rand];
if ( $aksi == "" )
{
    echo "<h1 align=center style='font-size=20pt;'>Update Program dan Basis Data SITU AKADEMIK</h1>";
    printmesg( $errmesg );
    echo "<p>\r\n<form action=update.php method=post  >\r\n<table class=form>\r\n<tr>\r\n<td align=left style='font-size:12pt;'>\r\n<b>\r\nJika anda hendak mengupdate program dan basis data SITU AKADEMIK, silakan isi login, password Administrator, kode anti-Spam dan \r\ntekan tombol Update kemudian tunggu sampai selesai. \r\n<br>\r\n<br>PERINGATAN!!<br><br>\r\nSebelum melakukan update apapun, backup dulu program dan database terakhir Anda untuk meminimalisir kejadian2 yang tidak diharapkan.  \r\n\r\nKami tidak bertanggung jawab apabila terjadi sesuatu yang tidak benar setelah proses update, tanpa adanya proses Backup Data terakhir terlebih dahulu.\r\n\r\n<br><br>\r\nTerima kasih\r\n</b>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form border=1>\r\n<tr>\r\n<td  width=150>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n <tr valign=top>\r\n  <td>Anti-SPAM</td>\r\n\t<td  >\r\n \t\t <img border=1 src='antispam.php?idspam=1'> = <input name=randlogin class=masukan type=text size=3 maxchars=3 >\r\n\t</td>\r\n</tr>\r\n\r\n\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update >\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
    if ( is_array( $penjelasan ) )
    {
        printjudulmenu( "&nbsp;&nbsp;&nbsp;&nbsp;Daftar Update Sekarang" );
        echo "\r\n  <table class=form  >\r\n    <tr class=juduldata align=center>\r\n      <td>No</td>\r\n      <td>Tanggal</td>\r\n      <td>Judul</td>\r\n      <td>Penjelasan</td>\r\n      <td>File</td>\r\n      <td>Status</td>\r\n      <td>Terupdate</td>\r\n    </tr>\r\n  ";
        $i = 0;
        foreach ( $penjelasan as $k => $v )
        {
            $judul = $v[nama];
            $ket = $v[ket];
            $tanggal = $v[tgl];
            $namafilezip = $v[file];
            $kelas = kelas( $k );
            ++$i;
            $q = "SELECT * FROM statusupdate WHERE ID='{$k}'";
            $h = mysqli_query($koneksi,$query);
            $status = "Belum diupdate";
            $tanggalupdate = "";
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $status = $d[STATUS];
                $tanggalupdate = $d[TANGGALUPDATE];
            }
            $statusfile = "";
            if ( $namafilezip != "" && !file_exists( "update/file/{$namafilezip}" ) )
            {
                $statusfile = "<font style=' color:#FF0000;;'> - FILE TIDAK ADA !!!</font>";
            }
            echo "\r\n     <tr {$kelas} align=center>\r\n      <td>{$i}</td>\r\n      <td nowrap><b>{$tanggal}</td>\r\n      <td nowrap align=left><b>{$judul}</td>\r\n      <td align=left>{$ket}</td>\r\n      <td ><b>{$namafilezip}  {$statusfile}</td>\r\n      <td ><b>{$status}</td>\r\n      <td>{$tanggalupdate}</td>\r\n    </tr>\r\n  ";
        }
        echo "</table>\r\n  <br><br><br>";
    }
    printjudulmenu( "&nbsp;&nbsp;&nbsp;&nbsp;Daftar Update Sebelumnya" );
    $q = "SELECT * FROM statusupdate ORDER BY TANGGAL";
    $h = mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n  <table class=form  >\r\n    <tr class=juduldata align=center>\r\n      <td>No</td>\r\n      <td>Tanggal</td>\r\n      <td>Judul</td>\r\n      <td>Penjelasan</td>\r\n      <td>File</td>\r\n      <td>Status</td>\r\n      <td>Terupdate</td>\r\n      <td>Keterangan</td>\r\n    </tr>\r\n  ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            ++$i;
            echo "\r\n     <tr {$kelas} align=center valign=top>\r\n      <td>{$i}</td>\r\n      <td nowrap>{$d['TANGGAL']}</td>\r\n      <td nowrap align=left>{$d['NAMA']}</td>\r\n      <td align=left>".nl2br( $d[PENJELASAN] )."</td>\r\n      <td align=left>{$d['FILE']}</td>\r\n      <td align=left>{$d['STATUS']}</td>\r\n      <td nowrap>{$d['TANGGALUPDATE']}</td>\r\n      <td align=left>".nl2br( $d[KET] )."</td>\r\n    </tr>\r\n  ";
        }
        echo "</table>";
    }
    else
    {
        printmesg( "Data tidak ada" );
    }
}
echo "</p>\r\n \r\n \r\n";
?>
