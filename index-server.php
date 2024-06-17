<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ccc";exit();
session_start();
include("header.php" );
periksaroot( );
include( "link.php" );
#echo "aaaa".$root;
$errdh = "id";
if ( trim( $aksi ) == "Login" && $REQUEST_METHOD == POST )
{
	#print_r($_SESSION);exit();
	#echo "aaa";exit();
    $ketlog = "Login ID={$iduser}, Jenis={$jenisuser}";
    buatlog( 0 );
    if ( $_SESSION['tokenlogin'] != md5( $randlogin ) )
    {
        $errmesg = "Kode anti-spam yang Anda masukkan salah.";
    }
    else if ( !( anti_sql_injection( $iduser ) && anti_sql_injection( $password ) ) )
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
        $ok = 1;
        $d = status_login( $iduser, $jenisuser );
        $iddle_time = getaturan( "BATASDIAM" ) * 60;
        if ( $iddle_time < $d[LAMADIAM] )
        {
            set_status_login( $iduser, $jenisuser, 0 );
        }
        if ( 0 < $iddle_time && is_sedang_login( $iduser, $jenisuser ) )
        {
            $ok = 0;
            $errmesg = "Maaf, ID Anda sedang login di tempat lain. Sementara ini Anda tidak dapat login sebelum ID Anda di tempat lain tersebut logout. Apabila Anda merasa hal ini adalah kesalahan, silakan hubungi administrator Anda.";
        }
        if ( $ok == 1 )
        {
			#echo $jenisuser;exit();
			
            $tokenlogin = md5( uniqid( rand( ), TRUE ) );
            if ( $jenisuser == 0 )
            {
                $query = "SELECT  NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS,LOGINWAKTU, IF(CURTIME()>=JAM1 AND CURTIME()<= JAM2,1,0) AS STATUSWAKTU,JAM1,JAM2 FROM user WHERE ID='{$iduser}' AND  ((PASSWORD=PASSWORD('{$password}') AND FLAGPASSWORD=1 ) OR (PASSWORD=PASSWORD('{$password}') AND FLAGPASSWORD=1))    AND STATUS=1 ";
				
				#$query="SELECT  NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS,LOGINWAKTU,IF(CURTIME()>=JAM1 AND CURTIME()<= JAM2,1,0) ".
				#"AS STATUSWAKTU,JAM1,JAM2 FROM user WHERE ID='{$iduser}' AND PASSWORD=MD5('{$password}') AND FLAGPASSWORD=1";
				#echo $query;exit();
				#$query = "SELECT  NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS,LOGINWAKTU,\r\n        IF(CURTIME()>=JAM1 AND CURTIME()<= JAM2,1,0) AS STATUSWAKTU,JAM1,JAM2\r\n  \t\t\tFROM user WHERE ID='{$iduser}' AND \r\n  \t\t\t\r\n      \r\n          (\r\n            (FLAGPASSWORD=0) \r\n            OR\r\n            (FLAGPASSWORD=1 ) \r\n          )        \r\n         \r\n        AND \r\n        (STATUS=1  OR ID='superadmin') ";
				
			   $hasil = mysql_query( $query, $koneksi );
                if ( 0 < sqlnumrows( $hasil ) )
                {
					#$query_update_password="UPDATE user SET PASSWORD=PASSWORD('{$password}') WHERE ID='{$iduser}'";
					#mysql_query( $query_update_password, $koneksi );
					
                    $data = sqlfetcharray( $hasil );
                    if ( $data[LOGINWAKTU] == 1 && $data[STATUSWAKTU] == 0 )
                    {
                        $errmesg = "Maaf Anda hanya bisa login antara jam {$data['JAM1']} s.d jam {$data['JAM2']}  ";
                    }
                    else
                    {
                        session_start();
                        $css = $data[CSS];
                        $users = $iduser;
                        $jenisusers = 0;
                        $namausers = $data[NAMA];
                        $prodis = $data[IDPRODI];
                        $tingkats = $data[TINGKAT];
                        $jeniss = $data[JENIS];
                        $statusoperatormakul = 0;
                        $tokenusers = $tokenlogin;
                        $URLS = str_replace( "index.php", "", $SCRIPT_FILENAME );
                        $_SESSION['users'] = $users;
                        $_SESSION['namausers'] = $namausers;
                        $_SESSION['prodis'] = $prodis;
                        $_SESSION['tingkats'] = $tingkats;
                        $_SESSION['css'] = $css;
                        $_SESSION['URLS'] = $URLS;
                        $_SESSION['jeniss'] = $jeniss;
                        $_SESSION['jenisusers'] = $jenisusers;
                        $_SESSION['statusoperatormakul'] = $statusoperatormakul;
                        $_SESSION['tokenusers'] = $tokenlogin;
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
                        Header( "Location:pesan/index.php" );
                        $ketlog = "Login sukses. ID={$iduser}, Jenis={$jenisuser}";
                        buatlog( 0 );
                        set_status_login( $iduser, $jenisuser, 1, $tokenlogin );
                        exit();
                    }
                }
                else
                {
                    $errmesg = "Maaf, ID dan Password Anda tidak sesuai. \r\n  \t\t\t\tSilakan mengisi kembali ID dan Password Anda.";
                    $errlogin = "id";
                }
            }
            else if ( $jenisuser == 1 || $jenisuser == 2 || $jenisuser == 3 )
            {
				#echo "lll";exit();
                $wali = "";
                if ( $jenisuser == 1 )
                {
                    $tabeluser = "dosen";
                    $qstatus = "AND STATUSKERJA='A'";
                    $qpwd = "AND ((PASSWORD=PASSWORD('{$password}') AND FLAGPASSWORD=0 ) OR(PASSWORD=MD5('{$password}') AND FLAGPASSWORD=1))                  \r\n          \r\n          ";
				    #$qpwd = "AND (FLAGPASSWORD=0 OR FLAGPASSWORD=1)                  \r\n          \r\n          ";
               
			    }
                else
                {
					#echo "lll";exit();
                    $tabeluser = "mahasiswa";
                    $ftambahan = "ANGKATAN,IDPRODI,";
                    $qstatus = "AND STATUS='A'";
                    $qpwd = " AND ((PASSWORD=PASSWORD('{$password}') AND FLAGPASSWORD=0) OR(PASSWORD=MD5('{$password}') AND FLAGPASSWORD=1 ) OR(PASSWORD=PASSWORD('{$password}') AND FLAGPASSWORD=1 )                         )                  \r\n          \r\n          ";
                    #$qpwd = " AND PASSWORD=MD5('{$password}') ";
                    #$qpwd = " AND (FLAGPASSWORD=0 OR FLAGPASSWORD=1)                   \r\n          \r\n          ";
                   # $qpwd = " AND PASSWORD=MD5('{$password}') ";
                    
					$wali = "WALI MAHASISWA : ";
                }
				
                $query = "SELECT NAMA,ID,{$ftambahan}  CSS,SETTINGTAMPILAN FROM {$tabeluser} WHERE ID='{$iduser}' {$qpwd} {$qstatus}";
				//echo $query;exit();
			   $hasil = mysql_query( $query, $koneksi );
                if ( 0 < sqlnumrows( $hasil ) )
                {
					#$query_update_password="UPDATE {$tabeluser} SET PASSWORD=PASSWORD('{$password}') WHERE ID='{$iduser}' {$qpwd} {$qstatus}";
					#mysql_query( $query_update_password, $koneksi );
					
                    $data = sqlfetcharray( $hasil );
                    session_start( );
                    session_register_sikad( "users" );
                    session_register_sikad( "namausers" );
                    session_register_sikad( "bidangs" );
                    session_register_sikad( "tingkats" );
                    session_register_sikad( "jabatans" );
                    session_register_sikad( "jenisusers" );
                    session_register_sikad( "css" );
                    session_register_sikad( "URLS" );
                    session_register_sikad( "tokenusers" );
                    $URLS = str_replace( "index.php", "", $SCRIPT_FILENAME );
                    $css = $data[CSS];
                    $users = $iduser;
                    $namausers = $data[NAMA];
                    $bidangs = $data[BIDANG];
                    $tokenusers = $tokenlogin;
                    if ( $jenisuser == 1 )
                    {
                        $tingkats = "F5:T,F6:T";
                        $jenisusers = 1;
                    }
                    else
                    {
                        $tingkats = "F5:B,F6:B";
                        $jenisusers = $jenisuser;
                        session_register_sikad( "angkatanusers" );
                        session_register_sikad( "prodiusers" );
                        $angkatanusers = $data[ANGKATAN];
                        $prodiusers = $data[IDPRODI];
                    }
                    $jabatans = $data[JABATAN];
                    $_SESSION['users'] = $users;
                    $_SESSION['namausers'] = $wali.$namausers;
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
                    $_SESSION['tokenusers'] = $tokenlogin;
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
                    Header( "Location:nilai/index.php" );
                    $ketlog = "Login sukses. ID={$iduser}, Jenis={$jenisuser}";
                    buatlog( 0 );
                    set_status_login( $iduser, $jenisuser, 1, $tokenlogin );
                    exit( );
                }
                else
                {
                   $errmesg = "Maaf, ID dan Password Anda tidak sesuai. \r\n  \t\t\t\tSilakan mengisi kembali ID dan Password Anda.";
				   $errlogin = "id";
                }
            }
        }
    }
}
#echo "aaaa";exit();
$waktu = getdate(time());
printheader();
#echo "ttt";exit();
include( "welcomemenu.php" );
include( "welcomemenu2.php" );
#echo "<div id=\"content\"><div class=\"leftcontent\">";
#include( "loginuser.php" );
#include( "info.php" );
#echo "        </div><!-- end leftcontent --><div class=\"maincontent\">";
printmesg( $errmesg );
echo "<br><div style=\"margin-left:200px;\">";
include( "loginuser.php" );
#include( "jadwalkuliah.php" );
/*if ( $pilihan == "berita" || $pilihan == "" )
{
   # include( "pengumuman.php" );
   include( "loginuser.php" );

}
else if ( $pilihan == "jadwal" )
{
    include( "jadwalkuliah.php" );
}
else if ( $pilihan == "forum" )
{
    include( "forum.php" );
}
else if ( $pilihan == "lihattanggapan" )
{
    include( "tanggapanforum.php" );
}*/
echo " </div><!-- end maincontent --></div><!-- end content --></div><!--end wrap--></div>";
#printfooter( );
echo "</body></html>";
?>
