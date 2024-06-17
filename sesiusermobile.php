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
$iddle_time = getaturan( "BATASDIAM" ) * 60;
$d = status_login( $users_mobile, $jenisusers_mobile );
$statuslogin = $d[STATUSLOGIN];
$tokenlogin = $d[TOKEN];
if ( 0 < $iddle_time && $iddle_time < $d[LAMADIAM] )
{
    $aksi = "logout";
}
if ( !( session_is_registered_sikad( "users_mobile" ) && session_is_registered_sikad( "namausers_mobile" ) && session_is_registered_sikad( "URLS_mobile" ) && ereg_sikad( $URLS_mobile, $SCRIPT_FILENAME ) && session_id( ) == $PHPSESSID && $tokenlogin == $tokenusers_mobile && $statuslogin == 1 ) )
{
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."mobile" );
    set_status_login( $users, $jenisusers, 0, "" );
}
if ( $aksi == "logout" )
{
    $ketlog = "Logout Mobile Mahasiswa sukses. ID={$users}, Jenis={$jenisusers}";
    buatlog( 1 );
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."mobile" );
    set_status_login( $users, $jenisusers, 0, "" );
}
session_regenerate_id( );
?>
