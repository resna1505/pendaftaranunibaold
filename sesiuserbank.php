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
#print_r($_SESSION);
if ( is_array( $_SESSION ) )
{
	#echo "aaaa";
    foreach ( $_SESSION as $k => $v )
    {
		#echo "Key: $k Value: $v";
        $$k = $v;
    }
	
	#echo $$k;
}
#exit();
#echo $root;exit();
include( $root."globaloff.php" );
include_once( $root."header.php" );
$iddle_time = getaturan( "BATASDIAM" ) * 60;
#$iddle_time = 1 * 15;
$d = status_login( $users_bank, $jenisusers_bank, "bank" );
$statuslogin = $d[STATUSLOGIN];
$tokenlogin = $d[TOKEN];
if ( 0 < $iddle_time && $iddle_time < $d[LAMADIAM] )
{
    $aksi = "logout";
}
if ( !( session_is_registered_sikad( "users_bank" ) && session_is_registered_sikad( "namausers_bank" ) && session_is_registered_sikad( "URLS_bank" ) && ereg_sikad( $URLS_bank, $SCRIPT_FILENAME ) && session_id( ) == $PHPSESSID && $tokenlogin == $tokenusers_bank && $statuslogin == 1 ) )
{
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."loginbank.php" );
    set_status_login( $users, $jenisusers, 0, "", "bank" );
}
if ( $aksi == "logout" )
{
    $users = $users_bank;
    $ketlog = "Logout Operator Bank sukses. ID={$users}";
    buatlog( 62 );
    session_destroy( );
    @mysqli_close($koneksi );
    Header( "Location:".$root."loginbank.php" );
    set_status_login( $users, $jenisusers, 0, "", "bank" );
}
session_regenerate_id( );
?>
