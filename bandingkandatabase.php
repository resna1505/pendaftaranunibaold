<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( file_exists( "connect.php" ) )
{
    include( "connect.php" );
    $loginsql = $login_name;
    $passwordsql = $password;
    $basisdatasql = $dbname;
}
else
{
    include( "header.php" );
}
if ( $aksi == "Proses" )
{
    $koneksi1 = @mysql_connect( @$host1, @$id1, @$password1 );
    if ( !$koneksi1 )
    {
        echo "Error koneksi ke server {$host1}. Periksa apakah server basis data telah dihidupkan atau password dan login Anda tidak benar.  Hubungi Administrator Anda";
        exit( );
    }
    if ( !mysql_select_db( $basisdata1, $koneksi1 ) )
    {
        echo "Error koneksi Basis Data Asli/Terbaru {$basisdata1}. Periksa apakah nama basis data sudah benar.  Hubungi Administrator Anda";
        exit( );
    }
    echo "Koneksi ke basisdata <b>{$basisdata1}</b> di server <b>{$host1}</b> berhasil..<br>";
    $q = "SHOW TABLES";
    $h1 = mysql_query( $q, $koneksi1 );
    while ( !( 0 < sqlnumrows( $h1 ) ) || !( $d1 = sqlfetcharray( $h1 ) ) )
    {
        $q = "SHOW COLUMNS FROM {$d1['0']} ";
        $h2 = mysql_query( $q, $koneksi1 );
        unset( $datatabel1 );
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $datatabel1[$d2[0]] = $d2;
        }
        $tabel1[$d1[0]] = $datatabel1;
        ++$totaltabel1;
    }
    $koneksi2 = @mysql_connect( @$host2, @$id2, @$password2 );
    if ( !$koneksi2 )
    {
        echo "Error koneksi ke server {$host2}. Periksa apakah server basis data telah dihidupkan atau password dan login Anda tidak benar.  Hubungi Administrator Anda";
        exit( );
    }
    if ( !mysql_select_db( $basisdata2, $koneksi2 ) )
    {
        echo "Error koneksi Basis Data Asli/Terbaru {$basisdata2}. Periksa apakah nama basis data sudah benar.  Hubungi Administrator Anda";
        exit( );
    }
    echo "Koneksi ke basisdata <b>{$basisdata2}</b> di server <b>{$host2}</b> berhasil...<br>";
    unset( $h1 );
    unset( $d1 );
    unset( $h2 );
    unset( $d2 );
    $q = "SHOW TABLES";
    $h1 = mysql_query( $q, $koneksi2 );
    while ( !( 0 < sqlnumrows( $h1 ) ) || !( $d1 = sqlfetcharray( $h1 ) ) )
    {
        $q = "SHOW COLUMNS FROM {$d1['0']} ";
        $h2 = mysql_query( $q, $koneksi2 );
        unset( $datatabel2 );
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $datatabel2[$d2[0]] = $d2;
        }
        $tabel2[$d1[0]] = $datatabel2;
        ++$totaltabel2;
    }
    if ( is_array( $tabel1 ) )
    {
        $rincian = "<table border=1 >\r\n      <tr align=center>\r\n        <td rowspan=2><b>No</td>\r\n         <td  rowspan=2><b>Nama Tabel</td>\r\n        <td colspan=2><b>{$basisdata1}</td>\r\n        <td colspan=2><b>{$basisdata2}</td>\r\n         <td  rowspan=2><b>Status Kolom</td>\r\n   \r\n      </tr>      \r\n      <tr align=center>\r\n        <td><b>Daftar Kolom</td>\r\n        <td><b>Tipe Kolom</td>\r\n         <td><b>Daftar Kolom</td>\r\n        <td><b>Tipe Kolom</td>\r\n       </tr>\r\n      ";
        $i = 0;
        $jumlahtabel1 = 0;
        foreach ( $tabel1 as $k => $v )
        {
            ++$i;
            ++$jumlahtabel1;
            ++$jumlahtabel2;
            $rincian .= "\r\n        <tr   >\r\n          <td align=center>{$i}</td>\r\n          <td><b>{$k}</b></td>\r\n          <td> </td>\r\n          <td> </td>";
            $status = "";
            $style = $idtabel = "";
            $namatabel2 = "";
            if ( !isset( $tabel2[$k] ) )
            {
                $idtabel = " id='tabel{$k}' ";
                --$jumlahtabel2;
                $style = "style='background-color:#FF0000'";
                $status = "Tidak ada di basisdata {$basisdata2}";
                $rincian .= "\r\n          <td colspan=3 align=center {$style} {$status} {$idtabel} >Tidak ada</td>";
                $daftartabeltidakada[$k] = 1;
            }
            else
            {
                $rincian .= "\r\n \r\n          <td> </td>\r\n          <td> </td>";
            }
            $rincian .= "\r\n \r\n        </tr>";
            foreach ( $v as $k2 => $v2 )
            {
                $rincian .= "<tr>";
                $rincian .= "\r\n  \r\n            <td></td><td></td>\r\n            <td>{$k2}</td>\r\n            <td>{$v2['Type']}</td>\r\n            \r\n            ";
                $stylekolom = $statuskolom = $idkolom = "";
                if ( $status == "" && isset( $tabel2["{$k}"]["{$k2}"] ) )
                {
                    $statustipe = "";
                    $styletipe = $idtipe = "";
                    if ( $v2[Type] != $tabel2[$k][$k2][Type] )
                    {
                        $statustipe = "Tipe tidak sama";
                        $styletipe = "style='background-color:#FFFF00'";
                        $daftartipekolomtidakada[$k][$k2] = 1;
                        $idtipe = " id='tipe{$k_}{$k2}' ";
                    }
                    $rincian .= "\r\n                \r\n                <td {$idtipe} >".$tabel2[$k][$k2][Field]."</td>\r\n                <td>".$tabel2[$k][$k2][Type]."</td>\r\n                <td {$styletipe} >{$statustipe}</td>\r\n\r\n              ";
                }
                else
                {
                    $stylekolom = "style='background-color:#FF0000'";
                    $statuskolom = "Tidak ada";
                    $idkolom = " id='kolom{$k_}{$k2}' ";
                    $rincian .= "\r\n               <td {$stylekolom} colspan=3 align=center {$idkolom} >{$statuskolom}</td>\r\n               ";
                    if ( $status == "" )
                    {
                        $daftarkolomtidakada[$k][$k2] = 1;
                    }
                }
                $rincian .= "</tr>";
            }
        }
        $rincian .= "</table>";
    }
    $simpulan = "\r\n    <br><br>\r\n    <table border=1>\r\n      <tr align=center>\r\n        <td><b></td>\r\n        <td><b>{$basisdata1}</td>\r\n        <td><b>{$basisdata2}</td>\r\n        \r\n      </tr>";
    $status = "OK";
    $style = "";
    if ( $jumlahtabel1 != $jumlahtabel2 )
    {
        $style = "style='background-color:#FFFF00'";
        $status = "Tidak sama";
    }
    $simpulan .= "\r\n      <tr align=center {$style}>\r\n        <td><b>Jumlah Tabel</td>\r\n        <td>{$jumlahtabel1}</td>\r\n        <td>{$jumlahtabel2}</td>\r\n        \r\n      </tr>";
    $style = "";
    if ( is_array( $daftartabeltidakada ) )
    {
        $style = "style='background-color:#FFFF00'";
        $simpulan .= "\r\n            <tr {$style} >\r\n              <td>Tabel yang tidak ada</td>\r\n              <td colspan=2><ol>\r\n           ";
        foreach ( $daftartabeltidakada as $k => $v )
        {
            $simpulan .= "\r\n            <li><a href='#tabel{$k}'>{$k}</a></li>\r\n           ";
        }
        $simpulan .= "</ol></td></tr>";
    }
    $style = "";
    if ( is_array( $daftarkolomtidakada ) )
    {
        $style = "style='background-color:#FFFF00'";
        $simpulan .= "\r\n            <tr {$style} >\r\n              <td>Kolom yang tidak ada</td>\r\n              <td colspan=2><ol>\r\n           ";
        foreach ( $daftarkolomtidakada as $k => $v )
        {
            $simpulan .= "\r\n            <li>{$k}\r\n            <ol>\r\n           ";
            foreach ( $v as $k2 => $v2 )
            {
                $simpulan .= "\r\n              <li><a href='#kolom{$k_}{$k2}'>{$k2}</a></li>\r\n             ";
            }
            $simpulan .= "</ol></li>";
        }
        $simpulan .= "</ol></td></tr>";
    }
    $style = "";
    if ( is_array( $daftartipekolomtidakada ) )
    {
        $style = "style='background-color:#FFFF00'";
        $simpulan .= "\r\n            <tr {$style} >\r\n              <td>Tipe kolom yang tidak sama</td>\r\n              <td colspan=2><ol>\r\n           ";
        foreach ( $daftartipekolomtidakada as $k => $v )
        {
            $simpulan .= "\r\n            <li>{$k}\r\n            <ol>\r\n           ";
            foreach ( $v as $k2 => $v2 )
            {
                $simpulan .= "\r\n              <li><a href='#tipe{$k_}{$k2}'>{$k2}</a></li>\r\n             ";
            }
            $simpulan .= "</ol></li>";
        }
        $simpulan .= "</ol></td></tr>";
    }
    $simpulan .= "\r\n    </table> <br><br>\r\n    ";
    echo "\r\n    {$simpulan}\r\n    {$rincian}";
}
if ( $aksi == "" )
{
    echo "<p>\r\n<form method=post action=bandingkandatabase.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nIsi data berikut ini untuk membandingkan dua buah basisdata</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td colspan=2 class=judulform>\r\n<b>Basis Data Asli/Terbaru</b>\r\n</td>\r\n </tr>\r\n<tr>\r\n<tr>\r\n  <td class=judulform>\r\n    Host Mysql\r\n  </td>\r\n  <td>\r\n    <input class=masukan type=text name=host1 size=20 value='{$hostsql}'>\r\n  </td>\r\n</tr>\r\n\r\n<tr>\r\n  <td class=judulform>\r\n    ID Mysql\r\n  </td>\r\n  <td>\r\n    <input class=masukan type=text name=id1 size=20 value='{$loginsql}'>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>\r\n    Password Mysql</td>\r\n  <td>\r\n   <input class=masukan type=text name=password1 size=20 value='{$passwordsql}'>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>\r\n    Nama Basis Data Mysql</td>\r\n  <td>\r\n   <input class=masukan type=text name=basisdata1 size=20 value='{$basisdatasql}'>\r\n  </td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n<td colspan=2 class=judulform>\r\n<b>Basis Data Yang Hendak Diperiksa</b>\r\n</td>\r\n </tr>\r\n<tr>\r\n<tr>\r\n  <td class=judulform>\r\n    Host Mysql\r\n  </td>\r\n  <td>\r\n    <input class=masukan type=text name=host2 size=20 value='{$hostsql}'>\r\n  </td>\r\n</tr>\r\n\r\n<tr>\r\n  <td class=judulform>\r\n    ID Mysql\r\n  </td>\r\n  <td>\r\n    <input class=masukan type=text name=id2 size=20 value='{$loginsql}'>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>\r\n    Password Mysql</td>\r\n  <td>\r\n   <input class=masukan type=text name=password2 size=20 value='{$passwordsql}'>\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>\r\n    Nama Basis Data Mysql</td>\r\n  <td>\r\n   <input class=masukan type=text name=basisdata2 size=20 value='{$basisdatasql}'>\r\n  </td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Proses>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
