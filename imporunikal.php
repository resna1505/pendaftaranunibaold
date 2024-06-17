<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
if ( $aksi == "Update" )
{
    $query = "SELECT NAMA FROM user \r\n\t\tWHERE ID='superadmin' \r\n\t\tAND '{$idupdate}'='superadmin' \r\n\t\tAND PASSWORD=PASSWORD('{$passwordupdate}')";
    $hasil = mysqli_query($koneksi,$query);
    if ( sqlnumrows( $hasil ) <= 0 )
    {
        $errmesg = "Password yang Anda berikan tidak benar";
        $aksi = "";
    }
    else
    {
        $arraydata = file( "mahasiswa2.csv" );
        $i = 0;
        echo "<table width=95% border=1>";
        foreach ( $arraydata as $k => $v )
        {
            $d = explode( ";", $v );
            $no = $d[0];
            $nourut = $d[1];
            $prodi = $d[2];
            $kelas = $d[3];
            $kodepindahan = $d[4];
            $kuitansi = $d[5];
            $prodi2 = $d[6];
            $kelas = $d[7];
            $ps = $d[8];
            $pindahan = $d[9];
            $npm = str_replace( ".", "", $d[10] );
            $tglregistrasi = $d[11];
            $nama = $d[12];
            $koderegistrasi = $d[13];
            $reg = $d[14];
            $tempat = $d[15];
            $tgllahir = $d[16];
            $kewarganegaraan = $d[17];
            $ktp = str_replace( "'", "", $d[18] );
            $agama = $d[19];
            $sex = $d[20];
            $kawin = $d[21];
            $alamat = str_replace( "'", "", $d[22] );
            $jeniskota = $d[23];
            $namakota = $d[24];
            $ibu = str_replace( "'", "", $d[25] );
            $bapak = str_replace( "'", "", $d[26] );
            $alamat3 = str_replace( "'", "", $d[27] );
            $kota3 = str_replace( "'", "", $d[28] );
            $telepon3 = str_replace( "'", "", $d[29] );
            $jaket = $d[30];
            $sekolah = str_replace( "'", "", $d[31] );
            $jurusansekolah = $d[32];
            $tahunlulus = $d[33];
            $alamatsekolah = str_replace( "'", "", $d[34] );
            $kotasekolah = $d[35];
            $namakotasekolah = $d[36];
            $ptasal = $d[37];
            $jurusanptasal = $d[38];
            $tahunlulusptasal = $d[39];
            $alamatptasal = $d[40];
            $kotaptasal = $d[41];
            $namakotaptasal = $d[42];
            $namainstansi = str_replace( "'", "", $d[43] );
            $jabataninstansi = $d[44];
            $alamatinstansi = $d[45];
            $kotainstansi = $d[46];
            $teleponinstansi = $d[47];
            $tgldaftar = $d[48];
            $haridaftar = $d[49];
            $nilaites = $d[50];
            if ( 0 < $i )
            {
                $q2 = "INSERT INTO mahasiswa2 \r\n    (NOMOR_KTP_ATAU_SIM,STATUS_PERKAWINAN,KAB_ATAU_KOTA,NAMA_KABUPATEN_ATAU_KOTA,KAB_ATAU_KOTA_ORTU,\r\n    NAMA_KABUPATEN_ATAU_KOTA_ORTU,ALAMAT_SEKOLAH,TAHUN_LULUS_PT_ASAL,NAMA_INSTANSI_BEKERJA,ALAMAT_KANTOR,\r\n    JABATAN,ALAMAT_PT_ASAL,ID)\r\n    VALUES ('{$ktp}','{$kawin}','{$jeniskota}','{$namakota}' ,'{$jeniskota}','{$kota3}','{$alamatsekolah}\n{$namakotasekolah}',\r\n    '{$tahunlulusptasal}','{$namainstansi}','{$alamatinstansi}\n{$kotainstansi}','{$jabataninstansi}',\r\n    '{$alamatptasal}\n{$namakotaptasal}','{$npm}')\r\n     ";
                $q = "UPDATE mahasiswa SET \r\n    ALAMAT='{$alamat}' ,\r\n    NAMAAYAH='{$bapak}',\r\n    ALAMATAYAH='{$alamat3}',\r\n    NAMAIBU='{$ibu}',\r\n    ALAMATIBU='{$alamat3}',\r\n    TELEPON='{$telepon3}',\r\n    ASAL='{$sekolah}',\r\n    TAHUNLULUS='{$tahunlulus}'\r\n     WHERE ID='{$npm}'";
                $status1 = $status2 = "";
                mysqli_query($koneksi,$q);
                $error1 = mysql_error( );
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $status1 = "UPDATE OK";
                }
                else
                {
                    $status1 = "UPDATE GAGAL. ".$error1;
                }
                mysql_query( $q2, $koneksi );
                $error2 = mysql_error( );
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $status2 = "UPDATE OK";
                }
                else
                {
                    $q2 = "UPDATE mahasiswa2 SET \r\n      NOMOR_KTP_ATAU_SIM='{$ktp}',\r\n      STATUS_PERKAWINAN='{$kawin}', \r\n      KAB_ATAU_KOTA='{$jeniskota}' ,\r\n      NAMA_KABUPATEN_ATAU_KOTA='{$namakota}' ,\r\n      KAB_ATAU_KOTA_ORTU='{$jeniskota}',\r\n      NAMA_KABUPATEN_ATAU_KOTA_ORTU='{$kota3}',\r\n      ALAMAT_SEKOLAH='{$alamatsekolah}\n{$namakotasekolah}',\r\n      TAHUN_LULUS_PT_ASAL='{$tahunlulusptasal}',\r\n      NAMA_INSTANSI_BEKERJA='{$namainstansi}',\r\n      ALAMAT_KANTOR='{$alamatinstansi}\n{$kotainstansi}',\r\n      JABATAN='{$jabataninstansi}',\r\n      ALAMAT_PT_ASAL='{$alamatptasal}\n{$namakotaptasal}'\r\n      WHERE ID='{$npm}'";
                    mysql_query( $q2, $koneksi );
                    $error2 = mysql_error( );
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $status2 = "UPDATE OK";
                    }
                    else
                    {
                        $status2 = "UPDATE GAGAL. ".$error2;
                    }
                }
                if ( trim( $kodepindahan ) == "P" )
                {
                    $q = "SELECT  KDPTIMSMHS,KDJENMSMHS,KDPSTMSMHS FROM msmhs WHERE NIMHSMSMHS='{$npm}'";
                    $h = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $d2 = sqlfetcharray( $h );
                        $kodept = $d2[KDPTIMSMHS];
                        $kodejen = $d2[KDJENMSMHS];
                        $kodepst = $d2[KDPSTMSMHS];
                        $q3 = "INSERT INTO trpid \r\n      (KDPTITRPID,KDJENTRPID,KDPSTTRPID,NIMHSTRPID,NMPTITRPID,NMPSTTRPID)\r\n      VALUES\r\n      ('{$kodept}','{$kodejen}','{$kodepst}','{$npm}','{$ptasal}','{$jurusanptasal}')";
                        mysqli_query($koneksi,$q);
                        if ( sqlaffectedrows( $koneksi ) <= 0 )
                        {
                            $q3 = "UPDATE trpid \r\n        SET\r\n        NMPTITRPID='{$ptasal}',\r\n        NMPSTTRPID'{$jurusanptasal}'\r\n        WHERE\r\n        KDPTITRPID='{$kodept}' AND \r\n        KDJENTRPID='{$kodejen}' AND\r\n        KDPSTTRPID='{$kodepst}' AND \r\n        NIMHSTRPID='{$npm}'";
                            mysqli_query($koneksi,$q);
                        }
                    }
                }
                echo "\r\n  <tr valign=top>\r\n    <td nowrap>{$i}</td>\r\n    <td nowrap>{$npm}</td>\r\n    <td nowrap>{$nama}</td>\r\n    <td  >".nl2br( $q )." <b>{$status1}</td>\r\n    <td  >".nl2br( $q2 )." <b>{$status2}</td>\r\n\r\n<!--    \r\n    <td nowrap>{$no}</td>\r\n    <td nowrap>{$nourut}</td>\r\n    <td nowrap>{$prodi}</td>\r\n    <td nowrap>{$kelas}</td>\r\n    <td nowrap>{$kodepindahan}</td>\r\n    <td nowrap>{$kuitansi}</td>\r\n    <td nowrap>{$prodi2}</td>\r\n    <td nowrap>{$kelas}</td>\r\n    <td nowrap>{$ps}</td>\r\n    <td nowrap>{$pindahan}</td>\r\n    <td nowrap>{$npm}</td>\r\n    <td nowrap>{$tglregistrasi}</td>\r\n    <td nowrap>{$nama}</td>\r\n    <td nowrap>{$koderegistrasi}</td>\r\n    <td nowrap>{$reg}</td>\r\n    <td nowrap>{$tempat}</td>\r\n    <td nowrap>{$tgllahir}</td>\r\n    <td nowrap>{$kewarganegaraan}</td>\r\n    <td nowrap>{$ktp}</td>\r\n    <td nowrap>{$agama}</td>\r\n    <td nowrap>{$sex}</td>\r\n    <td nowrap>{$kawin}</td>\r\n    <td nowrap>{$alamat}</td>\r\n    <td nowrap>{$jeniskota}</td>\r\n    <td nowrap>{$namakota}</td>\r\n    <td nowrap>{$ibu}</td>\r\n    <td nowrap>{$bapak}</td>\r\n    <td nowrap>{$alamat3}</td>\r\n    <td nowrap>{$kota3}</td>\r\n    <td nowrap>{$telepon3}</td>\r\n    <td nowrap>{$jaket}</td>\r\n    <td nowrap>{$sekolah}</td>\r\n    <td nowrap>{$jurusansekolah}</td>\r\n    <td nowrap>{$tahunlulus}  </td>\r\n    <td nowrap>{$alamatsekolah}  </td>\r\n    <td nowrap>{$kotasekolah}  </td>\r\n    <td nowrap>{$namakotasekolah}  </td>\r\n    <td nowrap>{$ptasal}  </td>\r\n    <td nowrap>{$jurusanptasal}  </td>\r\n    <td nowrap>{$tahunlulusptasal}  </td>\r\n    <td nowrap>{$alamatptasal}</td>\r\n    <td nowrap>{$kotaptasal}  </td>\r\n    <td nowrap>{$namakotaptasal} </td>\r\n    <td nowrap>{$namainstansi} </td>\r\n    <td nowrap>{$jabataninstansi} </td>\r\n    <td nowrap>{$alamatinstansi} </td>\r\n    <td nowrap>{$kotainstansi} </td>\r\n    <td nowrap>{$teleponinstansi} </td>\r\n    <td nowrap>{$tgldaftar}</td>\r\n    <td nowrap>{$haridaftar} </td>\r\n    <td nowrap>{$nilaites} </td>\r\n    -->\r\n  </tr> ";
            }
            ++$i;
        }
        echo "</table>";
        echo "<p>";
        printmesg( "\r\nProses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa\r\n" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "IMPORT Data Mahasiswa SITU AKADEMIK UNIKAL" );
    printmesg( $errmesg );
    echo "<p>\r\n<form action=imporunikal.php method=post>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengimport data mahasiswa SITU AKADEMIK UNIKAL, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo " \r\n";
?>
