<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
session_start( );
if ( $aksi == "Kirim" )
{
    if ( $_SESSION['token'] != md5( $rand ) )
    {
        $errmesg = "Kode anti-spam yang Anda masukkan salah.";
    }
    else if ( trim( $idtanggapan ) == "" )
    {
        $errmesg = "ID harus diisi.";
    }
    else if ( trim( $passwdtanggapan ) == "" )
    {
        $errmesg = "Password harus diisi.";
    }
    else
    {
        $rincian = htmlspecialchars( $rincian );
        $q = "SELECT NAMA  FROM user WHERE \r\n\t\tID='{$idtanggapan}' AND  \r\n    \r\n          (\r\n            (PASSWORD=PASSWORD('{$passwdtanggapan}') AND FLAGPASSWORD=0 ) \r\n            OR\r\n            (PASSWORD=MD5('{$passwdtanggapan}') AND FLAGPASSWORD=1 ) \r\n          )     \r\n    \r\n    ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $q = "SELECT COUNT(ID) AS JML  FROM tanggapanforum WHERE \r\n\t\t\tRINCIAN='{$rincian}' AND PENGIRIM='{$nama}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            if ( $d[JML] <= 0 )
            {
                $q = "SELECT MAX(ID)+1 AS JML  FROM tanggapanforum WHERE \r\n\t\t\t\tIDFORUM='{$idforum}' AND LOKASI='{$lokasiforum}'";
                $h = mysqli_query($koneksi,$q);
                $d = sqlfetcharray( $h );
                if ( $d[JML] == "" )
                {
                    $d[JML] = 0;
                }
                $q = "INSERT INTO tanggapanforum VALUES({$d['JML']},{$idforum},'{$rincian}',NOW(),'{$idtanggapan}','{$REMOTE_ADDR}',{$lokasiforum},{$idlokasikantor})";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Tanggapan Anda berhasil disimpan.  \r\n\t\t\t\t\tTerima kasih telah bepartisipasi di dalam forum diskusi ini.";
                    $idtanggapan = "";
                    $passwdtanggapan = "";
                    $rincian = "";
                }
                else
                {
                    $errmesg = "Tanggapan Anda gagal disimpan.  \r\n\t\t\t\t\tAda kesalahan dalam pengaksesan basis data.";
                }
            }
            else
            {
                $errmesg = "Anda telah pernah mengisi Tanggapan forum ini.  ";
                $idtanggapan = "";
                $passwdtanggapan = "";
                $rincian = "";
            }
        }
        else
        {
            $errmesg = "ID dan password tidak sesuai.  ";
        }
    }
    $id = $idforum;
    unset( $_SESSION['token'] );
    unset( $_SESSION['antispam'] );
}
if ( $id == "" )
{
    $id = 1;
}
echo "        <div class=\"titlecontent\"><!-- wrap title -->\r\n            <img class=\"icontitle\" src=\"images/forumicon.png\"/>\r\n            <h1 class=\"decorator\">Topik Forum</h1> <!-- Judul menu -->\r\n        </div>";
echo "<br>";
printmesg( $errmesg );
$query = "SELECT forum.ID,NAMA,PENGIRIM,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL, \r\nRINCIAN, forum.LOKASI  FROM\r\n\tforum,user WHERE forum.PENGIRIM=user.ID \r\n\t AND forum.ID='{$id}' AND forum.LOKASI='{$lokasiforum}'";
$hasil = mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    $data = sqlfetcharray( $hasil );
    echo "\r\n                <!-- begin boxwrap content kanan -->\r\n                <div class='contentwrapping'>             \r\n                    <p class='postcontent'>{$data['RINCIAN']}...<br/>\r\n                    ({$data['BARU']}, {$data['TGL']})<br/><br/><!-- main content -->\r\n                </div> \r\n                <!-- end boxwrap content kanan -->\r\n                ";
    $q = "SELECT COUNT(ID) AS JML FROM tanggapanforum WHERE IDFORUM='{$id}' AND LOKASI='{$lokasiforum}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $totaltanggapan = $d[JML];
    $perpage = 10;
    $jumlahhalaman = $totaltanggapan / $perpage;
    if ( 0 < $totaltanggapan % $perpage )
    {
        ++$jumlahhalaman;
    }
    $jumlahhalaman = floor( $jumlahhalaman );
    if ( $halaman == "" )
    {
        $halaman = 1;
    }
    $start = ( $jumlahhalaman - $halaman ) * $perpage;
    if ( $start < 0 )
    {
        $start = 0;
    }
    settype( $totaltanggapan, "integer" );
    settype( $perpage, "integer" );
    if ( 1 < $jumlahhalaman )
    {
        if ( $halaman < $jumlahhalaman )
        {
            $next = "Selanjutnya >>";
            $next = "<a href='index.php?pilihan=lihattanggapan&id={$id}&lokasiforum={$lokasiforum}&halaman=".( $halaman + 1 )."'>{$next}</a>";
        }
        if ( 1 < $halaman )
        {
            $prev = "<< Sebelumnya";
            $prev = "<a href='index.php?pilihan=lihattanggapan&id={$id}&lokasiforum={$lokasiforum}&halaman=".( $halaman - 1 )."'>{$prev}</a>";
        }
    }
    if ( $next != "" || $prev != "" )
    {
        $nav = "\r\n\t\t\t<table cloass=form>\r\n\t\t\t<tr>\r\n\t\t\t\t<td width=50% align=left>\r\n\t\t\t\t\t{$prev}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td width=50% align=right>\r\n\t\t\t\t\t{$next}\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t";
    }
    echo "\t\t";
    echo $nav;
    echo " \t\t";
    $query = "SELECT NAMA,ASAL,PENGIRIM,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL, \r\n\t\tRINCIAN , LOKASITANGGAPAN FROM\r\n\t\t\ttanggapanforum,user WHERE tanggapanforum.PENGIRIM=user.ID AND  IDFORUM='{$id}' \r\n\t\t\tAND tanggapanforum.LOKASI='{$lokasiforum}'\r\n\t\t\tORDER BY TANGGAL  LIMIT {$start},{$perpage}";
    $hasil = mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        $i = 1;
        while ( $data = sqlfetcharray( $hasil ) )
        {
            if ( 10 < $i )
            {
                break;
            }
            echo "\r\n    \t\t\t\t<table class=form>\r\n    \t\t\t\t<tr>\r\n    \t\t\t\t<td>\r\n    \t\t\t\t<p align=justify>\r\n    \t\t\t\t<font style='font-size:10pt;'>\r\n    \t\t\t\t\t".nl2br( $data[RINCIAN] )."... \r\n    \t\t\t\t</font>\r\n    \t\t\t\t\r\n    \t\t\t\t</td>\r\n    \t\t\t\t</tr>\r\n    \t\t\t\t<tr  style='font-size:9pt;font-family:Verdana;'>\r\n    \t\t\t\t\t<td align=right>\r\n    \t\t\t\t\t\t<font style='font-size:8pt;'>\r\n    \t\t\t\t\t\t\r\n    \t\t\t\t\t\t\tPengirim: <b>{$data['NAMA']}</b>, Asal: <b>{$data['ASAL']}, ".$arraylokasi[$data[LOKASITANGGAPAN]]."</b>, \r\n    \t\t\t\t\t\t\r\n    \t\t\t\t\t\t\t{$data['TGL']}\r\n    \t\t\t\t\t\t</font>\r\n    \t\t\t\t\t</td>\r\n    \t\t\t\t</tr>\r\n    \t\t\t\t</table>\r\n\t\t\t\t<hr size=0>";
            $img = "";
            $filelogo = "";
            ++$i;
        }
        echo $nav;
    }
    else
    {
        printmesg( "Belum ada Tanggapan" );
    }
    echo " \r\n\r\n";
}
else
{
    echo "<center>Tidak ada topik diskusi...</center>";
}
echo " \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
$hasil = generaterandomcaptcha( 4 );
$_SESSION['token'] = $hasil[token];
$_SESSION['antispam'] = $hasil[rand];
echo "\r\n";
echo "<s";
echo "cript language=JAVASCRIPT>\r\n\tfunction tesforum (form) {\r\n\t\tif (form.idtanggapan.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.idtanggapan.focus();\r\n\t\t}else if (form.passwdtanggapan.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.passwdtanggapan.focus();\r\n\t\t}\telse if (form.rincian.value=='') {\r\n\t\t\talert('Tanggapan harus diisi');\r\n\t\t\tform.rincian.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n";
echo "\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script>\r\n\r\n    \t<form class=\"scheduleform\" name=forum action=index.php method=post>\r\n    \t<input type=hidden name=pilihan value=lihattanggapan>\r\n    \t<input type=hidden name=idforum value=";
echo $id;
echo ">\r\n";
echo "\t<input type=hidden name=lokasiforum value=";
echo $lokasiforum;
echo ">\r\n\t<table  class=form>\r\n\t\t<tr valign=top>\r\n\t\t\t<td>\r\n\t\t\t\tID\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input name=idtanggapan class=masukan type=text size=30 maxchars=30 value='";
echo $idtanggapan;
echo "'>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td>\r\n\t\t\t\tPassword\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input name=passwdtanggapan class=masukan type=password size=30 maxchars=30  >\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td>\r\n\t\t\t\tTanggapan\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n\t\t\t\t<textarea name=rincian class=masukan cols=40 rows=6>";
echo $rincian;
echo "</textarea>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td>\r\n\t\t\t\tAnti spam\r\n\t\t\t</td>\r\n\t\t\t<td>\r\n                <img class=\"codenumber\" src=\"antispam.php\" width='220' height='50'/>   &nbsp;= <input name=rand class=masukan type=text size=3 maxchars=3 >\r\n \t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td colspan=2>\r\n            <br />\r\n\t\t\t\t<input class=show  type=submit name=aksi value=Kirim onClick='return tesforum(foru";
echo "m);'>\r\n\t\t\t\t<input class=show  type=reset >\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</form>\r\n";
?>
