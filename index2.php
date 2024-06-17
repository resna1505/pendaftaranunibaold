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
if ( trim( $aksi ) == "Login" && $REQUEST_METHOD == POST )
{
    if ( !( anti_sql_injection( $iduser ) && anti_sql_injection( $password ) ) )
    {
        $errmesg = "Jangan macam-macam please...";
    }
    else if ( trim( $iduser == "" ) )
    {
        $errmesg = "ID User harus diisi";
        $errlogin = "id";
    }
    else if ( trim( $password == "" ) )
    {
        $errmesg = "Password harus diisi";
        $errlogin = "password";
    }
    else
    {
        $jenisuser = 2;
        if ( $jenisuser == 2 )
        {
            $tabeluser = "mahasiswa";
            $ftambahan = "ANGKATAN,IDPRODI,";
            $query = "SELECT NAMA,ID,{$ftambahan}  CSS,SETTINGTAMPILAN \r\n                     FROM {$tabeluser} WHERE ID='{$iduser}' \r\n                     AND PASSWORD=PASSWORD('{$password}')\r\n                     AND STATUS='A' ";
            $hasil = mysql_query( $query, $koneksi );
            if ( 0 < sqlnumrows( $hasil ) )
            {
                $data = sqlfetcharray( $hasil );
                session_start( );
                $URLS = str_replace( "index2.php", "", $SCRIPT_FILENAME );
                $css = $data[CSS];
                $users = $iduser;
                $namausers = $data[NAMA];
                $bidangs = $data[BIDANG];
                if ( $jenisuser == 1 )
                {
                    $tingkats = "F5:T,F6:T";
                    $jenisusers = 1;
                }
                else
                {
                    $tingkats = "F5:B,F6:B";
                    $jenisusers = 2;
                    $angkatanusers = $data[ANGKATAN];
                    $prodiusers = $data[IDPRODI];
                }
                $jabatans = $data[JABATAN];
                $_SESSION['users'] = $users;
                $_SESSION['namausers'] = $namausers;
                $_SESSION['prodis'] = $prodis;
                $_SESSION['bidangs'] = $bidangs;
                $_SESSION['jabatans'] = $jabatans;
                $_SESSION['tingkats'] = $tingkats;
                $_SESSION['css'] = $css;
                $_SESSION['URLS'] = $URLS;
                $_SESSION['jenisusers'] = $jenisusers;
                $_SESSION['statusoperatormakul'] = $statusoperatormakul;
                $_SESSION['angkatanusers'] = $angkatanusers;
                $_SESSION['prodiusers'] = $prodiusers;
                $_SESSION['TS'] = 1;
                if ( $data[SETTINGTAMPILAN] == "" )
                {
                    $data[SETTINGTAMPILAN] = "MENUUTAMA=0;SUBMENU=1";
                }
                $tmp = explode( ";", trim( $data[SETTINGTAMPILAN] ) );
                if ( is_array( $tmp ) )
                {
                    foreach ( $tmp as $k => $v )
                    {
                        $tmp2 = explode( "=", $v );
                        $_SESSION[TAMPILAN][trim( $tmp2[0] )] = trim( $tmp2[1] );
                    }
                }
                mysql_close( );
                Header( "Location:ts/index.php" );
                exit( );
            }
            else
            {
                $errmesg = "Maaf, ID dan Password Anda tidak sesuai. \r\n\t\t\t\tSilakan mengisi kembali ID dan Password Anda.";
                $errlogin = "id";
            }
        }
    }
}
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 60 );
echo "\r\n    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head>\r\n        <title>{$namaprogram} </title>   \r\n        <script type=\"text/javascript\" src=\"".$root."/tampilan/keyboard.js\" charset=\"UTF-8\"></script>\r\n        <link rel=\"stylesheet\" type=\"text/css\" href=\"".$root."/tampilan/keyboard.css\"> \r\n        <link rel=\"stylesheet\" type=\"text/css\" href=\"".$root."/tampilan/touchscreen_login_style.css\">\r\n    </head>\r\n    <body>\t\t\r\n    <div id='wrap'>\r\n    \t<div id='banner'>\r\n        \t\r\n        </div>\r\n        <div id='attribute'>\r\n        \t<img class='logoid' src='{$dirgambar}/{$logo['0']}'  width='194' height='113'>\r\n            <h2 class='title'>{$judul}</h2>\r\n\t\t\t<h2 class='instancename'>{$namakantor}</h2>\r\n            <p class='address'>{$alamat}</p>\r\n        </div>\r\n        <div id='formwrap'>\r\n            <form id='formtouchscreen' method='post' action='index2.php'>\r\n            <a class='backbutton' href='index.php'>&nbsp;</a>\r\n            <p class='firsttitle'>Account Layar Sentuh</p>\r\n            <h2>Account Login</h2>\r\n    \t\t\t<fieldset>\r\n                \t<p class='texttopform'><b>*</b>Untuk Masuk ke Halaman Layar Sentuh, Silahkan Login Terlebih dahulu</p>\r\n    \t\t\t\t<p class='first'>\r\n    \t\t\t\t\t<label for='name'>User Name</label>\r\n    \t\t\t\t\t<input type='text' name='iduser' id=inputlayarsentuh class=\"keyboardInput\"/>\r\n    \t\t\t\t</p>\r\n    \t\t\t\t<p>\r\n    \t\t\t\t\t<label for='email'>Password</label>\r\n    \t\t\t\t\t<input type='password' name='password' id=inputlayarsentuh class=\"keyboardInput\"/>\r\n    \t\t\t\t</p>\t\t\t\t\t\r\n    \t\t\t\t<input name='aksi' class='submit' type='submit' value='Login'/>\r\n    \t\t\t</fieldset>\t\r\n            </form>\r\n            <div id='spacer'>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    </body>\r\n    </html>\r\n    ";
?>
