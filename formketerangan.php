<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $pilihan == "datang" )
{
    if ( $toleran == "awal" )
    {
        $errmesg = "Anda terlambat (jam {$jam}) pada toleransi keterlambatan ".$data[TOLERANSI] / 2." menit.  Silakan mengisi alasan keterlambatan.  Terima kasih.";
    }
    else if ( $toleran == "akhir" )
    {
        $errmesg = "Anda terlambat (jam {$jam}) pada toleransi keterlambatan ".$data[TOLERANSI]." menit.  Silakan mengisi alasan keterlambatan.  Terima kasih.";
    }
    if ( $status == "telatsekali" )
    {
        $errmesg = "Anda terlambat sekali (jam {$jam}) melewati toleransi keterlambatan ".$data[TOLERANSI]." menit.  Silakan mengisi alasan keterlambatan atau Anda akan dianggap tidak hadir.  Terima kasih.";
    }
}
else
{
    $errmesg = "Anda pulang terlalu cepat (jam {$jam}).  Silakan mengisi alasan kepulangan Anda.  Terima kasih.";
}
printheader( );
include( "welcomemenu.php" );
echo "\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t<td align=left class=submenu>\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
include( "isidaftarhadir.php" );
include( "loginuser.php" );
include( "pooling.php" );
include( "link.php" );
echo "\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td width=90% align=center >\r\n\t\t\t\t\t\t\t\t";
printmesg( $errmesg );
if ( $pilihan == "datang" )
{
    echo "\r\n\r\n\t\t\t\t\t\t\t\t\t\t<form action=presensi.php method=post \r\n\t\t\t\t\t\t\t\t\t\t\tonsubmit=\"if (ket.value=='') {alert('Keterangan/alasan keterlambatan harus diisi'); return false;} else {return true;}\"\r\n\t\t\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=iduser value='";
    echo $iduser;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=pindahhari value='";
    echo $pindahhari;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=shift value='";
    echo $shift;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t";
    if ( $status == "telatsekali" )
    {
        echo "<input type=hidden name=status value=telatsekali>";
    }
    echo "\t\t\t\t\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=kodedaftarhadir value=\"";
    echo $kodedaftarhadir;
    echo "\">\r\n\t\t\t\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td width=100>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\tAlasan terlambat\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<textarea class=masukan name=ket cols=65 rows=4></textarea>\t\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<tr height=50 valign=middle>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td align=center></td><td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<input class=tombol type=submit name=aksiterlambat value='  Isi   '>\r\n\t\t\t\t\t\t\t\t";
    echo "\t\t\t\t\t<input class=tombol  type=reset value=Reset>\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t\t\t\t\t";
}
else
{
    echo "\t\t\t\t\t\t\t\t\t\t";
    echo "\t\t\t\t\t\t\t\t\t\t<form name=formket action=presensi.php method=post\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=iduser value='";
    echo $iduser;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=pindahhari value='";
    echo $pindahhari;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=shift value='";
    echo $shift;
    echo "'>\r\n\t\t\t\t\t\t\t\t\t\t<input type=hidden name=kodedaftarhadir value=\"";
    echo $kodedaftarhadir;
    echo "\">\r\n\t\t\t\t\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\tAlasan pulang cepat\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t";
    unset( $dataalasanpulang[N] );
    echo "\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<select name=alasan class=masukan>";
    foreach ( $dataalasanpulang as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t";
    echo "\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\tKeterangan pulang cepat\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<textarea class=masukan name=ket cols=65 rows=4></textarea>\t\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t\t<tr height=50 valign=middle>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<td></td><td>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<input class=tombol type=submit name=aksipulangcepat";
    echo " value='  Isi   '\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t onClick=\"if (formket.ket.value=='' ) {alert('Keterangan/alasan pulang cepat harus diisi'); return false;} else {return true;}\">\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<input class=tombol type=submit name=aksipulangcepat value='  Batal   '>\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t";
}
echo "\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td align=center width=150  class=submenu>\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
include( "info.php" );
echo "\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\t\t\t";
printfooter( );
?>
