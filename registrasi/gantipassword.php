<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "ganti" && $REQUEST_METHOD == POST )
{
    $ok = true;
    if ( trim( $passlama ) == "" )
    {
        $ok = false;
        $errmesg = "Password lama harus diisi";
        buatlog( 5, $iduser );
    }
    else if ( trim( $pass == "" ) || strlen( $pass ) < 4 )
    {
        $ok = false;
        $errmesg = "Password baru harus diisi minimum 4 karakter";
        buatlog( 5, $iduser );
    }
    else if ( trim( $pass2 == "" ) || strlen( $pass2 ) < 4 )
    {
        $ok = false;
        $errmesg = "Konfirmasi password baru harus diisi minimum 4 karakter";
        buatlog( 5, $iduser );
    }
    else if ( $pass != $pass2 )
    {
        $ok = false;
        $errmesg = "Password baru dan konfirmasi password baru harus sama";
        buatlog( 5, $iduser );
    }
    else
    {
        $pass = str_replace( "'", "\\'", $pass );
        $pass2 = str_replace( "'", "\\'", $pass2 );
        $passlama = str_replace( "'", "\\'", $passlama );
        $query = "UPDATE operatorbank SET PASSWORD=MD5('{$pass}') WHERE ID='{$users_bank}' AND PASSWORD=MD5('{$passlama}')";
        mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) == 1 )
        {
            $errmesg = "Password Anda telah diganti dengan yang baru. Terima kasih";
            $iduser = "";
            $passlama = "";
            $pass = "";
            $pass2 = "";
            $ketlog = "Calon Mahasiswa Ganti Password via WEB. ID={$users_bank}";
            $users = $users_bank;
            buatlog( 71 );
        }
        else
        {
            $errmesg = "User ID dan password Anda tidak sesuai. Silakan ulangi penggantian password";
            $passlama = "";
            $pass = "";
            $pass2 = "";
        }
    }
}
if ( $errmesg != "" && $pgl != "" )
{
    $errmesg = "{$pgl}. ".$errmesg;
}
printjudulmenu( "Ganti Password" );
printmesg( $errmesg );
echo "<form action=index.php method=post>\r\n<input type=hidden name=aksi value=\"ganti\">\r\n<input type=hidden name=pilihan value=\"password\">\r\n";
echo IKONKUNCI48;
echo "<table  class=form>\r\n \t<tr valign=top>\r\n\t\t<td  width=250>Password lama</td>\r\n\t\t<td>\r\n\t\t\t<input class=masukan type=password name=passlama size=20 value=";
echo $passlama;
echo ">\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr valign=top>\r\n\t\t<td >Password baru</td>\r\n\t\t<td>\r\n\t\t\t<input class=masukan type=password name=pass size=20 value=";
echo $pass;
echo ">\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr valign=top>\r\n\t\t<td >Konfirmasi password baru</td>\r\n\t\t<td>\r\n\t\t\t<input class=masukan type=password name=pass2 size=20 value=";
echo $pass2;
echo ">\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr valign=top>\r\n\t\t<td colspan=2 >\r\n\t\t\t<input class=tombol type=submit value='  Ganti  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n\r\n";
?>
