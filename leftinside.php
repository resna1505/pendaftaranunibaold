<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "  <!-- content kiri -->\r\n    \t<div class='leftcontent'>\r\n ";
if ( $user_kind == "administrator" || $user_kind == "operator" || $user_kind == "anggota" )
{
    echo "            <div class='boxinfo'>\r\n                <h1 class='titleinfo'>{$user_menu}</h1>\r\n                <ul class='leftnavigator'>";
    include_once( "submenu.php" );
    $i = 0;
    while ( $i < count( $menu ) )
    {
        if ( $user_kind == "anggota" )
        {
            $query = "select STATUS,TGL_AKTIF,JENIS from anggota where ID='{$user_id}'";
            dbquery( $con, $query, $stmt, $d );
            $stmta = dbfetch( $stmt );
            $tgl = dbresult( $stmta, "TGL_AKTIF" );
            $tgltab = explode( " ", $tgl );
            $tgl = $tgltab[0];
            $tgltab = explode( "-", $tgl );
            $jenis_anggota = dbresult( $stmta, "JENIS" );
            $query = "select * from jenis_anggota where JENIS='{$jenis_anggota}'";
            dbquery( $con, $query, $stmt, $d );
            $stmta = dbfetch( $stmt );
            $masa = dbresult( $stmta, "WAKTU_MASA" );
            if ( $masa == "tahun" )
            {
                $pengali = 12;
            }
            else
            {
                $pengali = 1;
            }
            $masa_aktif = dbresult( $stmta, "MASA" ) * $pengali;
        }
        if ( $user_kind == "anggota" && $tambahan[$i] == 1 && ( dbresult( $stmta, "STATUS" ) == "blacklist" || 0 < ( mktime( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) ) - @mktime( 0, 0, 0, @$tgltab[1] + @$masa_aktif, @$tgltab[2], @$tgltab[0] ) + 0 ) / 86400 ) )
        {
            echo "<li>{$menu[$i]}</li>";
        }
        else if ( $teksjudul == $aktif[$i] )
        {
            echo "<li><a href='".$lompat[$i].".php".$tambah[$i]."'>{$menu[$i]}</a></li>";
        }
        else
        {
            echo "<li><a href='".$lompat[$i].".php".$tambah[$i]."'>{$menu[$i]}</a></li>";
        }
        ++$i;
    }
    echo "                </ul>\r\n            </div>";
}
else
{
    echo "\t\t\t<form action='login.php' method='post' name='forma'>\r\n                <div class='box'>\r\n                \r\n                <h1 class='titlelogin'>Login User</h1>\r\n\t\t\t\t\r\n\t\t\t\t\t<input type=hidden name='teksjudul' value='";
    print $teksjudul;
    echo "'>\r\n\t\t\t\t\t\r\n                <label class='smallabel'>\r\n                   ";
    echo "<s";
    echo "pan class='smallspan'>User ID</span>\r\n                    <input class='input_text' name='u_id' type='text'>   \r\n                </label>\r\n                \r\n                <label class='smallabel'>\r\n                   ";
    echo "<s";
    echo "pan class='smallspan'>Password</span>\r\n                   <input class='input_text' name='u_pass' type='password'>\r\n                </label>\r\n                \r\n                <label class='smallabel'>\r\n                \t";
    echo "<s";
    echo "pan class='smallspan'>Security Code</span>\r\n                    <img class='captcha' src='captcha.php'>\r\n                    <p class='tinytext'>Numerik & Capital</p>\r\n                </label>\r\n                \r\n                <label class='smallabel'>\r\n                   ";
    echo "<s";
    echo "pan class='smallspan'>Enter Security</span>\r\n                   <input class='input_text' name='sec_key' type='text'>\r\n                </label>\r\n                \r\n                <input class='login' value='Login' type='submit'>\r\n                 \r\n                </div> \r\n            </form>\r\n\t\t\t\t";
    echo "<s";
    echo "cript language=\"JavaScript\">document.forma.u_id.focus();</script>\r\n ";
}
echo "            <div class='boxinfo'>\r\n                <h1 class='titleinfo'>informasi</h1>\r\n                <ul class='leftnavigator'>\r\n\t\t\t\t\t";
if ( in_array( $version, array( "univ_platinum", "umum_platinum" ) ) )
{
    echo "\t\t\t\t\t\t<li><a href='dataseminar.php'>lihat data seminar</a></li>\r\n\t\t\t\t\t\t<li><a href='datapenelitian.php'>lihat info kerjasama / penelitian</a></li>\r\n\t\t\t\t\t\t<li><a href='datapelatihan.php'>lihat data pelatihan</a></li>\t\t\t\t\t\r\n\t\t\t\t\t";
}
echo "\t\t\t\t\t\t<li><a href='daftarbuku.php'>daftar buku baru</a></li>\r\n                </ul>\r\n            </div>\r\n            \r\n\t\t\t";
$query = "select * from berita order by NO_URUT desc";
dbquery( $con, $query, $stmt, $d );
$count = 0;
echo "\t\t\t\r\n            <div class='visitor'>\r\n            \t<p>";
echo $counterpengunjung;
echo "</p>\r\n            </div>\r\n            \r\n            <div class='useronline'>\r\n            \t<p>";
echo $counterpengunjungonline;
echo "</p>\r\n            </div>\r\n            \r\n            \r\n        </div>\r\n        <!-- end of content kiri -->\r\n\t\t\r\n\t\t<!-- masih ada yg kurang nihh -->\r\n\t\t\r\n <!-- content utama / kanan -->\r\n        <!-- div class='maincontent' -->";
?>
