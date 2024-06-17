<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
echo "\r\n        <div class=\"titlecontent\"><!-- wrap title -->\r\n            <img class=\"icontitle\" src=\"images/logoberita.png\"/>\r\n            <h1 class=\"decorator\">Berita dan Pengumuman</h1> <!-- Judul menu -->\r\n        </div>\r\n        ";
printmesg( $errmesg );
if ( $aksi == detil )
{
    $query = "SELECT ID,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n           SUBSTRING(RINCIAN,1,LENGTH(RINCIAN)+1) AS RINCIAN2,\r\n           IF(TO_DAYS(TANGGAL)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n           pengumuman WHERE ID='{$id}'";
}
else
{
    $query = "SELECT ID,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n            SUBSTRING(RINCIAN,1,500) AS RINCIAN2,\r\n            IF(LENGTH(RINCIAN)>500,1,0) AS P, \r\n            IF(TO_DAYS(TANGGAL)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n            pengumuman ORDER BY TANGGAL DESC LIMIT 0,11";
}
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
        if ( file_exists( "pengumuman/gambar/".$data[ID].".txt" ) )
        {
            $logo = file( "pengumuman/gambar/".$data[ID].".txt" );
            $filelogo = $logo[0];
            $size = imgsizeprop( "pengumuman/gambar/{$filelogo}", 150 );
            $img = "<a target='_blank' href='pengumuman/gambar/{$filelogo}'>\r\n        \t\t\t<img  border=0 align=left height={$size['1']} width={$size['0']} \r\n        \t\t\tsrc='pengumuman/gambar/{$filelogo}'>\r\n        \t\t\t</a>";
        }
        $selengkapnya = "";
        if ( $data[P] == 1 )
        {
            $selengkapnya = "<a href='index.php?pilihan=berita&aksi=detil&id={$data['ID']}'><b>Selengkapnya...</b></a>";
        }
        echo "\r\n            <!-- begin boxwrap content kanan --><div class=\"contentwrapping\"><h3 class=\"titlepostcontent\">".$data[JUDUL]."</h3> <!-- main title -->\r\n            <p class=\"postcontent\">".$img.html_entity_decode( "{$data['RINCIAN2']}...." )."<b style='color:#000088'>".$data[BARU]."</b>(".$data[IDUSER]."), ".$arraylokasi[$data[LOKASI]].", ".$data[TGL].")\r\n            <br/><br/>\r\n            <a href=\"#\">".$selengkapnya."</a></p> <!-- main content --></div><!-- end boxwrap content kanan -->\r\n            ";
        $img = "";
        $filelogo = "";
        ++$i;
    }
    if ( 10 < $i && 10 < sqlnumrows( $hasil ) )
    {
    }
}
else
{
    echo "<p class='alert'>Tidak ada pengumuman...</p>";
}
echo "<!--</td>\r\n</tr>\r\n</table>-->\r\n";
echo "<S";
echo "CRIPT>\r\n\tsetTimeout(\"history.go(0)\",1000*60*30);\r\n</SCRIPT>";
?>
