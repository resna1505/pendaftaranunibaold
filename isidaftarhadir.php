<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $waktu[hours] <= 11 )
{
    $cekdatang = "checked";
}
else
{
    $cekpulang = "checked";
}
echo "<s";
echo "cript language=JAVASCRIPT>\r\n\tfunction tesdh (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.pass.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.pass.focus();\r\n\t\t} else {\r\n\t\t\treturn confirm('Isi daftar hadir?');\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script>\r\n<form name=dh action=presensi.php method=post >\r\n<input type=hidden name=aksi v";
echo "alue=\"isipresensi\">\r\n<input type=hidden name=kodedaftarhadir value=\"";
echo $kodeharian;
echo "\">\r\n\r\n\r\n<table class=submenu>\r\n\t<tr valign=top class=judulsubmenu>\r\n\t\t<td align=center colspan=2 \r\n\t\t>\r\n\t Isi Daftar Hadir</td>\r\n\t</tr>\r\n\t<tr><td align=center>\r\n\t\t\r\n\t\t<table  class=submenudalam>\r\n\t\t<tr valign=top>\r\n\t\t\t<td align=right>User ID </td>\r\n\t\t\t<td>\r\n\t\t\t\t<input class=masukan type=text name=iduser  size=7>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td align=right>Password </td>\r\n\t\t\t<td>\r\n\t\t\t\t<input class=masuka";
echo "n type=password name=pass size=7>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td align=right>Pilihan </td>\r\n\t\t\t<td>\r\n\t\t\t\t<input class=masukan type=radio name=pilihan value=\"datang\" ";
echo $cekdatang;
echo ">Datang \r\n\t\t\t\t<input class=masukan type=radio name=pilihan value=\"pulang\" ";
echo $cekpulang;
echo ">Pulang\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</td></tr>\r\n\t<tr valign=top class=judulsubmenu>\r\n\t\t<td colspan=2 align=center\r\n\t\t>\r\n\t\t\t<input \r\n\t\t\t \r\n\t\t\tclass=tombol type=submit value='  OK  ' onClick=\"return tesdh(dh);\">\r\n\t\t\t<input class=tombol type=reset value=Reset >\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n";
if ( $errdh != "" )
{
    echo "<SCRIPT>";
    if ( $errdh == "id" )
    {
        echo "dh.iduser.focus();";
    }
    else
    {
        echo "dh.pass.focus();";
    }
    echo "</SCRIPT>";
}
echo "\r\n";
?>
