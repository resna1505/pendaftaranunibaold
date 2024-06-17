<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

session_start( );
include_once( "install/data.php" );
include_once( "install/fungsi.php" );
echo "\r\n<html>\r\n<head>\r\n<title>INSTALASI BASIS DATA {$namaprogram}</title>\r\n<link rel=\"stylesheet\" href=\"install/indexc.css\" type=\"text/css\" /> \r\n</head>\r\n<body>\r\n\r\n<h1>INSTALASI BASIS DATA {$namaprogram}</h1>\r\n<table class=data border=1 width=95%>\r\n  <tr class=juduldata>\r\n    <td colspan=2 width=200>INFO UMUM SERVER</td>\r\n   </tr>\r\n  <tr class=datagenap>\r\n    <td width=200>Waktu Eksekusi Maksimum</td>\r\n    <td>".ini_get( "max_execution_time" )." detik</td>\r\n  </tr>\r\n  <tr class=dataganjil>\r\n    <td>Batasan Memori</td>\r\n    <td>".ini_get( "memory_limit" )."</td>\r\n  </tr>\r\n  <tr  class=datagenap>\r\n    <td>Ukuran file instalasi</td>\r\n    <td>".number_format( filesize( "install/data.sql" ) / ( 1024 * 1024 ), 2 )."M</td>\r\n  </tr>\r\n </table>\r\n";
if ( $_POST['pilihan'] == 3 )
{
    include_once( "install/proses4.php" );
}
if ( $_POST['pilihan'] == 2 )
{
    include_once( "install/proses3.php" );
}
if ( $_POST['pilihan'] == 1 )
{
    include_once( "install/proses2.php" );
}
if ( $_POST['pilihan'] == "" )
{
    include_once( "install/proses1.php" );
}
echo "\r\n<br>\r\n\t\t<div id=\"siteInfo\">\r\n\t\t\t\t{$namaprogram} &copy; Suteki-Tech (<a class=glink style=\"border:none\"  \r\n\t\t\t\thref='http://www.suteki.co.id'>www.suteki.co.id</a>).  \r\n\t\t\t\t Saran dan kritik yang membangun, kirimkan ke info@suteki.co.id\r\n\t\t\t\t \r\n\t\t\t</div><!--siteInfo -->\r\n";
?>
