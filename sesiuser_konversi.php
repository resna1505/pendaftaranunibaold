<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( !( $root == "../" ) )
{
    $root = "./";
}
session_start( );
include( $root."db.php" );
$koneksi = @mysql_connect( @$hostsql, @$loginsql, @$passwordsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit( );
}
mysql_select_db( $basisdatasql, $koneksi );
if ( is_array( $_SESSION ) )
{
    foreach ( $_SESSION as $k => $v )
    {
        $$k = $v;
    }
}
include( $root."globaloff.php" );
include_once( $root."header.php" );
#echo getaturan( "BATASDIAM" );
$iddle_time = getaturan( "BATASDIAM" ) * 60;
#$iddle_time = 1 * 15;
$d = status_login( $users, $jenisusers );
$statuslogin = $d[STATUSLOGIN];
$tokenlogin = $d[TOKEN];
#echo $iddle_time."LLL".$d[LAMADIAM];
#if ( 0 < $iddle_time && $iddle_time < $d[LAMADIAM] )
#{
#    $aksi = "logout";
#}
if (0 < $iddle_time && $iddle_time < $d[LAMADIAM] )
{
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."index.php" );
    set_status_login( $users, $jenisusers, 0 );
}
if ( !( session_is_registered_sikad( "users" ) && session_is_registered_sikad( "namausers" ) && session_is_registered_sikad( "URLS" ) && ereg_sikad( $URLS, $SCRIPT_FILENAME ) && session_id( ) == $PHPSESSID && $tokenlogin == $tokenusers && $statuslogin == 1 ) )
#if ( !( session_is_registered_sikad( "users" ) && session_is_registered_sikad( "namausers" ) && session_is_registered_sikad( "URLS" ) && ereg_sikad( $URLS, $SCRIPT_FILENAME ) && session_id() == $PHPSESSID && $tokenlogin == $tokenusers) )
{
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."index.php" );
    set_status_login( $users, $jenisusers, 0 );
}
else if ( isoperator( ) )
{
   # $q = "SELECT NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS,LOGINWAKTU,\r\n        IF(CURTIME()>=JAM1 AND CURTIME()<= JAM2,1,0) AS STATUSWAKTU,JAM1,JAM2 FROM user WHERE ID='{$users}'";
	$q = "SELECT NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS FROM user WHERE ID='{$users}'";
   	$h = mysqli_query($koneksi,$q);
    $datass = sqlfetcharray( $h );
    $css = $datass[CSS];
    $namausers = $datass[NAMA];
    $prodis = $datass[IDPRODI];
    $tingkats = $datass[TINGKAT];
    $jeniss = $datass[JENIS];
    $_SESSION['namausers'] = $namausers;
    $_SESSION['prodis'] = $prodis;
    $_SESSION['tingkats'] = $tingkats;
    $_SESSION['css'] = $css;
    $_SESSION['jeniss'] = $jeniss;
}
if ( $aksi == "logout" )
{
    $ketlog = "Logout sukses. ID={$users}, Jenis={$jenisusers}";
    buatlog( 1 );
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."index.php" );
    set_status_login( $users, $jenisusers, 0 );
}
session_regenerate_id();
?>
