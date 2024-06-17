<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
$hasil = generaterandomcaptcha(4);
$_SESSION['tokenlogin'] = $hasil['token'];
$_SESSION['antispamlogin'] = $hasil['rand'];
#print_r($_SESSION);
#$_SESSION['tokenlogin'] = '123AA';
#$_SESSION['antispamlogin'] = '123AA';

echo "<s";
echo "cript language=JAVASCRIPT>\r\n\tfunction teslogin (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.password.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.password.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script><!--  form login -->\r\n<form class";
echo "=\"stylizedpengumuman\" name=log action=index.php method=post><table width='100%' border='0'>";
echo "<tr><td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><h3>Pengumuman</h3></td></tr>";
if ( $aksi == detil )
{
    $query = "SELECT ID,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n           SUBSTRING(RINCIAN,1,LENGTH(RINCIAN)+1) AS RINCIAN2,\r\n           IF(TO_DAYS(TANGGAL)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n           pengumuman WHERE ID='{$id}'";
}
else
{
    $query = "SELECT ID,DATE_FORMAT(TANGGAL,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n            SUBSTRING(RINCIAN,1,500) AS RINCIAN2,\r\n            IF(LENGTH(RINCIAN)>500,1,0) AS P, \r\n            IF(TO_DAYS(TANGGAL)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n            pengumuman ORDER BY TANGGAL DESC LIMIT 3";
}
$hasil = mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
	$i = 1;
    while ( $data = sqlfetcharray( $hasil ) )
    {
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
		echo "<tr><td colspan=\"2\"><h3 class=\"titlepostcontent\">".$data[JUDUL]."</td></tr>";
		echo "<tr><td colspan=\"2\">ditulis oleh (".$data[IDUSER]."), ".$arraylokasi[$data[LOKASI]].", ".$data[TGL].")</td></tr>";
		echo "<tr><td colspan=\"2\"><p class=\"postcontent\">".$img.html_entity_decode( "{$data['RINCIAN2']}...." )."<br/><br/>\r\n            <a href=\"#\">".$selengkapnya."</a></p></td></tr>";
	}
}else
{
echo "<tr><td colspan=\"2\"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><p class='alert'>Belum ada pengumuman saat ini..</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr>";
}
echo "</table></form>";
#echo "d\" name=\"password\" class=\"textfield\"/></td></tr>";
#echo "<tr><td><input name=aksi class=\"login\" type=\"submit\" value=\"  Login  \" onClick=\"return teslogin(log);\"/>\r\n    <input class=\"reset\" type=\"reset\" value=\"Reset\"/> </td></tr></table>                       \r\n</form>\r\n<!-- end form login -->\r\n    \r\n";

if ( $errlogin != "" )
{
    echo "<SCRIPT>";
    if ( $errlogin == "id" )
    {
        echo "log.iduser.focus();";
    }
    else
    {
        echo "log.password.focus();";
    }
    echo "</SCRIPT>";
}
?>
