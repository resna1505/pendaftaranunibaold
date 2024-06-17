<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $pilihan == "" )
{
    $pilihan = "berita";
    $REQUEST_URI .= "?pilihan=berita";
}
$arraymenu[0]['Judul'] = "Berita dan Pengumuman";
$arraymenu[1]['Judul'] = "Jadwal Kuliah";
$arraymenu[2]['Judul'] = "Forum";
$arraymenu[3]['Judul'] = "Layar Sentuh";
$arraymenu[0]['href'] = "index.php?pilihan=berita";
$arraymenu[1]['href'] = "index.php?pilihan=jadwal";
$arraymenu[2]['href'] = "index.php?pilihan=forum";
$arraymenu[3]['href'] = "index2.php?pilihan=forum";
$jumlahmenu = count( $arraymenu );
echo "\r\n    <!-- Begin Navigasi --><div><img src=\"gambar/uniba.png\" width=\"60\" height=\"54\"></div><div align=\"center\" style=\"margin-top:-40px;font-size:17px;\">";
echo "Selamat Datang di Academic Management System";
echo "</div>";
echo "\r\n <div style=\"margin-top:-33px;float:right;\"><img src=\"gambar/uniba.png\" width=\"60\" height=\"54\"></div>";
#echo "<li>Selamat Datang di Sistem Informasi Manajemen Akademik Universitas Batam</li><li>Selamat Datang di Sistem Informasi Manajemen Akademik Universitas Batam</li>";
#echo "\r\n    </ul></div>";
#echo "\r\n    </ul><p class=\"datepresent\">";
#include( $root."tampilan/siteheaderclock.php" );
#echo "</p></div><!-- End Navigasi --> ";
?>
