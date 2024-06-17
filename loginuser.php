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
echo "=\"stylized\" name=log action=index.php method=post><table width='100%' border='0'><tr><!--<td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><h3>Login Form</h3></td></tr><tr><td colspan=\"2\"> <p class=\"notify\">Untuk menggunakan fasilitas-fasilitas seperti data akademik, melihat nilai, dll. silahkan login terlebih dahulu</p>\r\n</td></tr><tr><td><label>Jenis User</label>\r\n</td><td>    ";
echo "<s";
echo "elect name=\"jenisuser\" class=\"textfieldlogin\" style=\"width:159px;\">\r\n\t\t<option value=0>Pegawai</option>\r\n        <option value=1>Dosen</option>\r\n        <option value=2>Mahasiswa</option>\r\n\t\t<option value=3>Ortu/Wali</option>\r\n  \t</select>\r\n </td></tr><tr><td><label>User ID</label>\r\n</td><td>    <input type=\"text\" name=\"iduser\" class=\"textfieldlogin\"/>\r\n</td></tr><tr><td> <label>Password</label> </td><td> <input type=\"passwor";
echo "d\" name=\"password\" class=\"textfield\"/></td></tr>";
echo "<tr><td><h3 class=\"antispam\">Anti Spam</h3>\r\n</td><td> <img class=\"codenumber\" src=\"antispam.php?idspam=1\" width='220' height='50'/></td></tr><tr><td><label class=\"small\">* Masukan kode di atas</label></td><td><input type=\"text\" name=\"randlogin\" class=\"textfieldspam\"/></td></tr><tr><td colspan=\"2\"> <ul class=\"info2\">\r\n        <li>Apabila kode tidak jelas Refresh untuk memperoleh kode baru</li>\r\n        <li>Karakter yg";
echo " tampil adalah 0-9 dan a-z tanpa huruf kapital</li>\r\n    </ul></td></tr><tr><td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><input name=aksi class=\"login\" type=\"submit\" value=\"  Login  \" onClick=\"return teslogin(log);\"/>\r\n    <input class=\"reset\" type=\"reset\" value=\"Reset\"/> </td>--><td align='center'><img src=\"gambar/Maintenance-Page.jpg\"></td></tr></table>                       \r\n</form>\r\n<!-- end form login -->\r\n    \r\n";


#echo "=\"stylized\" name=log action=index.php method=post><table width='50%' border='0'><tr><td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><h3>Login Form</h3></td></tr><tr><td colspan=\"2\"> <p class=\"notify\"><br>Untuk menggunakan fasilitas-fasilitas seperti data akademik, <br><br>lihat nilai, dll. silahkan login terlebih dahulu</p>\r\n</td></tr>";
#echo "<s";
#echo "<tr><td><label>User ID</label>\r\n</td><td>    <input type=\"text\" name=\"iduser\" class=\"textfieldlogin\"/>\r\n</td></tr><tr><td> <label>Password</label> </td><td> <input type=\"passwor";
#echo "d\" name=\"password\" class=\"textfield\"/></td></tr>";
#echo "<tr><td><h3 class=\"antispam\">Anti Spam</h3>\r\n</td><td> <img class=\"codenumber\" src=\"antispam.php?idspam=1\" width='220' height='50'/></td></tr><tr><td><label class=\"small\">* Masukan kode di atas</label></td><td><input type=\"text\" name=\"randlogin\" class=\"textfieldspam\"/></td></tr><tr><td colspan=\"2\"> <ul class=\"info2\">\r\n        <li>Apabila kode tidak jelas Refresh untuk memperoleh kode baru</li>\r\n        <li>Karakter yg";
#echo " tampil adalah 0-9 dan a-z tanpa huruf kapital</li>\r\n    </ul></td></tr><tr><td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><input name=aksi class=\"login\" type=\"submit\" value=\"  Login  \" onClick=\"return teslogin(log);\"/>\r\n    <input class=\"reset\" type=\"reset\" value=\"Reset\"/> </td></tr></table>                       \r\n</form>\r\n<!-- end form login -->\r\n    \r\n";

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
