<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<!--<table style='font-family:Verdana;' ";
echo $tabelpengumuman;
echo ">\r\n<tr valign=top>\r\n<td align=center>-->\r\n ";
echo "\r\n        <div class=\"titlecontent\"><!-- wrap title -->\r\n            <img class=\"icontitle\" src=\"images/forumicon.png\"/>\r\n            <h1 class=\"decorator\">Topik Forum</h1> <!-- Judul menu -->\r\n        </div>\r\n        ";
$q = "SELECT COUNT(ID) AS JML FROM forum";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$totaltopik = $d[JML];
if ( $halaman == "" )
{
    $halaman = 1;
}
$perpage = 10;
$start = ( $halaman - 1 ) * $perpage;
settype( $totaltopik, "integer" );
settype( $perpage, "integer" );
$jumlahhalaman = $totaltopik / $perpage;
if ( 0 < $totaltopik % $perpage )
{
    ++$jumlahhalaman;
}
$jumlahhalaman = floor( $jumlahhalaman );
if ( 1 < $jumlahhalaman )
{
    if ( $halaman < $jumlahhalaman )
    {
        $next = "Selanjutnya >>";
        $next = "<a href='index.php?pilihan=forum&halaman=".( $halaman + 1 )."'>{$next}</a>";
    }
    if ( 1 < $halaman )
    {
        $prev = "<< Sebelumnya";
        $prev = "<a href='index.php?pilihan=forum&halaman=".( $halaman - 1 )."'>{$prev}</a>";
    }
}
if ( $next != "" || $prev != "" )
{
    $nav = " {$prev}      {$next} ";
}
$query = "SELECT forum.ID,NAMA,PENGIRIM,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL, \r\n            RINCIAN, IF(TO_DAYS(TANGGAL)>=TO_DAYS(NOW())-7,'Baru,','') AS BARU, forum.LOKASI FROM\r\n            forum,user WHERE forum.PENGIRIM=user.ID \r\n            ORDER BY TANGGAL DESC LIMIT {$start},{$perpage}";
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
        $q = "SELECT COUNT(ID) AS JML FROM tanggapanforum WHERE IDFORUM='{$data['ID']}' AND LOKASI='{$data['LOKASI']}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $tanggapan = $d[JML];
        if ( $tanggapan == "" )
        {
            $tanggapan = 0;
        }
        echo "\r\n                <!-- begin boxwrap content kanan -->\r\n                <div class='contentwrapping'>             \r\n                    <p class='postcontent'>{$data['RINCIAN']}...<br/>\r\n                    (Pengirim : {$data['NAMA']}, {$data['TGL']})<br/><br/>Tanggapan: {$tanggapan} | \r\n                    <a style='font-size:8pt' href='index.php?pilihan=lihattanggapan&id={$data['ID']}&lokasiforum={$data['LOKASI']}'><b>Lihat / Kirim tanggapan</b></a></p> <!-- main content -->\r\n                </div> \r\n                <!-- end boxwrap content kanan -->\r\n                ";
        $img = "";
        $filelogo = "";
        ++$i;
    }
    echo $nav;
}
else
{
    echo "<p class='alert'>Tidak ada topik diskusi...</p>";
}
echo "<!--</td>\r\n</tr>\r\n</table>-->\r\n";
echo "<S";
echo "CRIPT>\r\n\tsetTimeout(\"history.go(0)\",1000*60*10);\r\n</SCRIPT>";
?>
