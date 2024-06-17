<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "cript language=JAVASCRIPT>\r\n\tfunction tesdh (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.pass.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.pass.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n\r\nvar awal=0;\r\nvar akhir=0;\r\n\r\nfunction copy(){\r\n\tdh.iduser.value='';\r\n   dh.iduser.focus();\r\n}\r\nfunction ccopy";
echo "(){\r\n        var now = new Date();\r\n        var hours = now.getHours();\r\n        var minutes = now.getMinutes();\r\n        var seconds = now.getSeconds();\r\n   keyPressed = String.fromCharCode(window.event.keyCode);\r\n\r\n\tif ((keyPressed == \"\\r\" || keyPressed == \"\\n\") && (true)) {\r\n\t\t\takhir=(hours*3600)+(minutes*60)+seconds;\t\r\n\t\t\tif (akhir - awal < 2) {\r\n\t      //  document.dh.submit();\r\n\t        retur";
echo "n true;\r\n\t      } else {\r\n\t      \treturn false;\r\n\t      }\r\n   } else {\r\n   \tif (dh.iduser.value=='') {\r\n   \t\tawal=(hours*3600)+(minutes*60)+seconds;\r\n   \t}\r\n   }\r\n   dh.iduser.focus();\r\n\treturn false;\r\n}\r\n\r\nfunction cekwaktu() {\r\n\t\t\tif (akhir - awal < 1) {\r\n\t        return true;\r\n\t      } else {\r\n\t      \tdh2.err.value='Silakan gunakan alat pemindai yang telah disediakan. Terima kasih.';\r\n\t      \t//";
echo "alert('Silakan gunakan alat pemindai yang telah disediakan. Terima kasih.');\r\n\t      \tdh.iduser.value='';\r\n\r\n\t      \treturn false;\r\n\t      }\r\n }\r\n</script>\r\n\r\n\r\n<center>\r\n<table width=770 height=250 \r\n";
echo $tabelisian;
echo " onmousedown='copy();' onmouseup='copy();'>\r\n\t<tr  >\r\n\t<td class=submenu width=130>&nbsp;\r\n\t \r\n\t</td>\r\n\t<td  align=center>\r\n \t\t<table class=form>\r\n\t\t\t<tr>\r\n\t\t\t<td>Pemindaian pertama: Isi daftar hadir saat datang</td></tr>\r\n\t\t\t<tr>\r\n\t\t\t<td>Pemindaian kedua: Isi daftar hadir saat pulang</td></tr>\r\n\t\t\t</table>\r\n\t\t<br>\r\n\t\t<table class=form>\r\n\t\t\t<tr valign=top>\r\n\t\t\t\t<td  > \r\n\t\t\t\t\t<form width=100% height=50% name=dh actio";
echo "n=indexb.php method=post onsubmit='return cekwaktu();'\r\n\t\t\t\t\tonmousedown='copy();' onmouseup='copy();' onkeydown='ccopy();' onkeyup='ccopy();'\r\n\t\t\t\t\t>\r\n\t\t\t\t\t<input type=hidden name=aksi value=\"isipresensi\">\r\n\t\t\t\t\t<input type=hidden name=kodedaftarhadir value=\"";
echo $kodeharian;
echo "\">\r\n\t\t\t\t\t<input class=masukantype=password name=iduser  size=25>\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t";
echo "<s";
echo "cript>\r\n\t\t\t\t\t\tdh.iduser.focus();\r\n\t\t\t\t\t</script>\r\n\t\t\t\t\t<form width=100% height=50% name=dh2 onmousedown='copy();' onmouseup='copy();'>\r\n\t\t\t\t\t<input class=teksboxb \r\n\t\t\t\t\tstyle=\"border: 1px solid #FFFFFF;font-size:8pt;\"\r\n\t\t\t\t\ttype=text name=err  size=70 readonly>\r\n\t\t\t\t\t</form>\r\n\r\n\t\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t</td>\r\n\t<td class=submenu  width=130>&nbsp;\r\n\t \r\n\t</td>\r\n\t</tr>\r\n </table>\r\n\r\n\r\n";
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
