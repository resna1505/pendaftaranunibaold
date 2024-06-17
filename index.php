<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
/*
session_start( );
include( "header.php" );
periksaroot( );
if ( trim( $aksi ) == "Login" && $REQUEST_METHOD == POST )
{
    $ketlog = "Login ID={$iduser}, Jenis={$jenisuser}";
    buatlog( 0 );
    if ( !( anti_sql_injection( $iduser ) && anti_sql_injection( $password ) ) )
    {
        $errmesg = "<p class='error'>Jangan macam-macam please...</p>";
    }
    else if ( trim( $iduser == "" ) )
    {
        $errmesg = "<p class='error'>ID User harus diisi</p>";
        $errlogin = "id";
    }
    else if ( trim( $password == "" ) )
    {
        $errmesg = "<p class='error'>Password harus diisi</p>";
        $errlogin = "<p class='error'>password</p>";
    }
    else
    {
        $ok = 1;
        $d = status_login( $iduser, $jenisuser, "bank" );
        $iddle_time = getaturan( "BATASDIAM" ) * 60;
        if ( $iddle_time < $d[LAMADIAM] )
        {
            set_status_login( $iduser, $jenisuser, 0, "", "bank" );
        }
        if ( 0 < $iddle_time && is_sedang_login( $iduser, $jenisuser ) )
        {
            $ok = 0;
            $errmesg = "<p class='error'>Maaf, ID Anda sedang login di tempat lain. Sementara ini Anda tidak dapat login sebelum ID Anda di tempat lain tersebut logout. Apabila Anda merasa hal ini adalah kesalahan, silakan hubungi administrator Anda.</p>";
        }
        $tokenlogin = md5( uniqid( rand( ), TRUE ) );
        if ( $jenisuser == 0 )
        {
            $query = "SELECT *\r\n  \t\t\tFROM operatorbank WHERE ID='{$iduser}' AND \r\n  \t\t\tPASSWORD=MD5('{$password}') AND  STATUS=1 ";
            #echo $query;exit();
			$hasil = mysqli_query($koneksi,$query);
            if ( 0 < sqlnumrows( $hasil ) )
            {
                $data = sqlfetcharray( $hasil );
                session_start( );
                session_register_sikad( "users_bank" );
                session_register_sikad( "namausers_bank" );
                session_register_sikad( "tingkats_bank" );
                session_register_sikad( "css_bank" );
                session_register_sikad( "URLS_bank" );
                session_register_sikad( "tokenusers_bank" );
                $css_bank = $data[CSS];
                $users_bank = $iduser;
                $namausers_bank = $data[NAMA];
                $tingkats_bank = "BANK:T";
                $tokenusers_bank = $tokenlogin;
                $URLS_bank = str_replace( "{$PHP_SELF}", "", $SCRIPT_FILENAME );
                $_SESSION['users_bank'] = $users_bank;
                $_SESSION['namausers_bank'] = $namausers_bank;
                $_SESSION['tingkats_bank'] = $tingkats_bank;
                $_SESSION['css_bank'] = $css_bank;
                $_SESSION['URLS_bank'] = $URLS_bank;
                $_SESSION['tokenusers_bank'] = $tokenlogin;
				#print_r($_SESSION).'<br>';
                if ( $data[SETTINGTAMPILAN] == "" )
                {
                    $data[SETTINGTAMPILAN] = "MENUUTAMA=0;SUBMENU=1";
                }
                $tmp = explode( ";", trim( $data[SETTINGTAMPILAN] ) );
				#print_r($tmp);exit();
                if ( is_array( $tmp ) )
                {
                    foreach ( $tmp as $k => $v )
                    {
                        $tmp2 = explode( "=", $v );
                        $_SESSION[TAMPILAN][trim( $tmp2[0] )] = trim( $tmp2[1] );
                    }
                }
                mysqli_close($koneksi );
                Header( "Location:operatorbank/index.php" );
                $ketlog = "Login Operator Bank sukses. ID={$iduser}";
                $users = $users_bank;
                buatlog(61);
                set_status_login( $iduser, $jenisuser, 1, $tokenlogin, "bank" );
                exit( );
            }
            else
            {
                $errmesg = "<p class='error'>Maaf, ID dan Password Anda tidak sesuai. \r\n  \t\t\t\tSilakan mengisi kembali ID dan Password Anda.</p>";
                $errlogin = "id";
            }
        }
    }
}
$waktu = getdate( time( ) );
echo "<!doctype html>\r\n<html lang=\"en\">\r\n<head>\r\n  <meta charset=\"utf-8\">\r\n  <title>AMS Login Bank</title>\r\n  <link rel=\"stylesheet\" href=\"tampilan/login_bank_pmb/lib/login.css\">\r\n  <link rel=\"shortcut icon\" href=\"images/favicon.png\">\r\n  ";
echo "<s";
echo "cript src=\"tampilan/login_bank_pmb/lib/jquery-1.7.1.min.js\"></script>\r\n  <!--";
echo "<s";
echo "cript src=\"js/jquery.spinner.js\"></script>-->\r\n  <!--[if lt IE 9]>\r\n  <![endif]-->\r\n    <!---FadeIn Effect, Validation and Spinner-->\r\n  ";
echo "<s";
echo "cript>\r\n    $(document).ready(function () {\r\n       $('div.wrapper').hide();\r\n        $('div.wrapper').fadeIn(1200);\r\n        $('#lg-form').validate();\r\n        $('.submit').click(function() {\r\n        var \$this = $(this);\r\n        \$this.spinner();\r\n        setTimeout(function() {\r\n                \$this.spinner('remove');\r\n        }, 1000);\r\n       });\r\n    });\r\n  </script>\r\n  \r\n  \r\n  <!-- js notifi";
echo "kasi -->\r\n  ";
echo "<s";
echo "cript language=JAVASCRIPT>\r\n\tfunction teslogin (form) {\r\n\t\tif (form.iduser.value=='') {\r\n\t\t\talert('ID harus diisi');\r\n\t\t\tform.iduser.focus();\r\n\t\t}else if (form.password.value=='') {\r\n\t\t\talert('Password harus diisi');\r\n\t\t\tform.password.focus();\r\n\t\t} else {\r\n\t\t\treturn true;\r\n\t\t}\r\n\t\treturn false;\r\n\t}\r\n</script>\r\n\r\n</head>\r\n<body>\r\n\t<div class=\"wrapper\">\r\n      \t";
printmesg($errmesg);
echo "\t <div class=\"lg-body\"><div><img width=\"60\" height=\"54\" src=\"gambar/uniba.png\"></div>";
echo "<div align=\"center\" style=\"margin-top:-40px;font-size:17px;\">Selamat Datang di Academic Management System</div>";
echo "<div style=\"margin-top:-33px;float:right;\"><img width=\"60\" height=\"54\" src=\"gambar/uniba.png\"></div><br/><br/><br/><div style=\"margin-left:0px;\"><form id=\"lg-form\" method=\"post\" class=\"stylized\" name=\"log\" action='";
echo $PHP_SELF;
echo "'><table width='100%' border='0'><tr><td colspan=\"2\" style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\"><h3>Login Form</h3></td></tr><tr><td colspan=\"2\"> <p class=\"notify\">Untuk menggunakan aplikasi login bank. Silahkan login terlebih dahulu</p>\r\n</td></tr><tr><td><label>User ID</label>\r\n</td><td><input class=\"textfieldlogin\" name=\"iduser\" type=\"text\" size=\"26\" minlength =\"1\" placeholder=\"Username...\" /></td></tr><tr><td><label>Password</label>\r\n</td><td><input class=\"textfieldlogin\" name=\"password\" type=\"password\" size=\"26\" minlength=\"1\" placeholder=\"Password...\" /";
echo "></td></tr><tr><td>&nbsp;</td></tr><tr><td colspan='2' style=\"background-color:#309BCB;font-size:25px;color:#FFF;padding:10px 30px;\" ><input class=\"submit\" type=\"submit\" value=\"Login\" name=\"aksi\" onClick=\"return teslogin(log);\"/><input class=\"submit\" type=\"reset\" value=\"Reset\"/></td></tr></form></div></div></body>\r\n</html>\r\n    \r\n";
#echo "'>\r\n           <fieldset>\r\n              <ul>\r\n                 <li id=\"usr-field\">\r\n                  <input class=\"input required\" name=\"iduser\" type=\"text\" size=\"26\" minlength =\"1\" placeholder=\"Username...\" />\r\n                 </li>\r\n                 <li id=\"psw-field\">\r\n                  <input class=\"input required\" name=\"password\" type=\"password\" size=\"26\" minlength=\"1\" placeholder=\"Password...\" /";
#echo ">\r\n                 </li>\r\n                 <li>\r\n                  <input class=\"submit\" type=\"submit\" value=\"Login\" name=\"aksi\" onClick=\"return teslogin(log);\"/>\r\n                  <input class=\"submit\" type=\"reset\" value=\"Reset\"/>\r\n                 </li>\r\n              </ul>\r\n           </fieldset>\r\n          </form>\r\n          \r\n        </div>\r\n     </div>\r\n    </div>\r\n \r\n\t</div>\r\n</body>\r\n</html>\r\n    \r\n";
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
}*/
#$users_bank =1;
#$tingkats_bank = "BANK:T";
Header( "Location:registrasi/index.php" );
?>
