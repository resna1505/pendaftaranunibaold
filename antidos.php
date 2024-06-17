<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getRealIpAddr( )
{
    if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    else if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$nowsec = time();
$rip = getrealipaddr();
$wanted = $_SERVER['REQUEST_URI'];
$logit = "INSERT INTO recent (tstamp, remoteaddr, calledfor) ".( "values (" ).$nowsec.", "."\"{$rip}\", "."\"{$wanted}\") ";
mysqli_query($koneksi,$logit );
$keeptime = 120;
$hurdle = 50;
$nn = $nowsec - $keeptime;
$q = mysqli_query($koneksi,"select count(tstamp) from recent ".@"where remoteaddr = '{$rip}' and tstamp > {$nn}" );
$res = mysqli_fetch_row($q);
$balloon = $res[0];
if ( $hurdle < $balloon )
{
    mysqli_query($koneksi,"INSERT INTO warned (tstamp, remoteaddr, ".( "calledfor) values (" ).@$nowsec.", ".@"\"{$rip}\", ".@"\"{$wanted}\") " );
    sleep( 10 );
    header( "location: dos.html" );
    exit( );
}
$q = mysqli_query($koneksi,"delete from recent where tstamp < {$nn}" );
?>
