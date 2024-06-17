<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\tbody {\r\n\t\twidth:98%;\r\n\t\tmargin:auto;\r\n\t\t}\r\n\t.formcetak {\r\n\t\tborder-top:1px solid black;\r\n\t\tborder-left:1px solid black;\r\n\t\t}\r\n\t\t\r\n\t.formcetak td {\r\n\t\tpadding:2px;\r\n\t\tborder-right:1px solid black;\r\n\t\tborder-bottom:1px solid black;\r\n\t\t}\r\n\t\t\r\n\t.form {\r\n\t\tfont-size:14px;\r\n\t\t}\r\n</style>\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "calonmahasiswa.ID";
$arraysort[1] = "calonmahasiswa.NAMA";
$arraysort[2] = "calonmahasiswa.TAHUN";
$arraysort[3] = "calonmahasiswa.GELOMBANG";
$arraysort[4] = "calonmahasiswa.PILIHAN";
$arraysort[5] = "calonmahasiswa.TANGGALDAFTAR";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $iftgl == 1 )
{
    $qfield .= " AND \r\n    (\r\n      DATE_FORMAT('{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}','%Y-%m-%d') <= TANGGALDAFTAR\r\n      AND\r\n      DATE_FORMAT('{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}','%Y-%m-%d') >= TANGGALDAFTAR\r\n    \r\n    )\r\n    ";
    $qjudul .= " Tanggal Pendaftaran {$tgl1['tgl']}-{$tgl1['bln']}-{$tgl1['thn']} s.d {$tgl2['tgl']}-{$tgl2['bln']}-{$tgl2['thn']}<br>";
    $qinput .= " <input type=hidden name=iftgl value='{$iftgl}'>";
    $qinput .= " <input type=hidden name='tgl1[tgl]' value='{$tgl1['tgl']}'>";
    $qinput .= " <input type=hidden name='tgl1[bln]' value='{$tgl1['bln']}'>";
    $qinput .= " <input type=hidden name='tgl1[thn]' value='{$tgl1['thn']}'>";
    $qinput .= " <input type=hidden name='tgl2[tgl]' value='{$tgl2['tgl']}'>";
    $qinput .= " <input type=hidden name='tgl2[bln]' value='{$tgl2['bln']}'>";
    $qinput .= " <input type=hidden name='tgl2[thn]' value='{$tgl2['thn']}'>";
    $href .= "iftgl={$iftgl}&tgl1[tgl]={$tgl1['tgl']}&tgl1[bln]={$tgl1['bln']}&tgl1[thn]={$tgl1['thn']}";
    $href .= "tgl2[tgl]={$tgl2['tgl']}&tgl2[bln]={$tgl2['bln']}&tgl2[thn]={$tgl2['thn']}";
}
if ( $tahunmasuk != "" )
{
    $qfield .= " AND TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}
if ( $notes != "" )
{
    $qfield .= " AND NOTES = '{$notes}'";
    $qjudul .= " No. Tes '{$notes}' <br>";
    $qinput .= " <input type=hidden name=notes value='{$notes}'>";
    $href .= "notes={$notes}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID = '{$id}'";
    $qjudul .= " Urutan '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $idpilihan != "" )
{
    $qfield .= " AND PILIHAN='{$idpilihan}'";
    $qjudul .= " Pilihan '".$arraypilihanpmb["{$idpilihan}"]."' <br>";
    $qinput .= " <input type=hidden name=idpilihan value='{$idpilihan}'>";
    $href .= "idpilihan={$idpilihan}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM calonmahasiswa \r\n\tWHERE UPDATERBANK='{$users_bank}' \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT * ,DATE_FORMAT(TANGGALDAFTAR,'%d-%m-%Y') AS TANGGALDAFTAR2\r\n  FROM calonmahasiswa \r\n\tWHERE UPDATERBANK='{$users_bank}' \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi );
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Pendaftaran Calon Mahasiswa" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Pendaftaran Calon Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo " \t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakoperatorbank.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>";
        echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table class=form{$aksi} width=95% cellpadding=0 cellspacing=0>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>No. Tes</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Tanggal Daftar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gel.</td> \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Pilihan</td> \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t<td> No. HP</td> \r\n\t\t\t\t<td> E-mail</td> \r\n\t\t\t\t<td> Biaya Pendaftaran</td> \r\n\t\t\t \r\n\r\n\r\n\t\t\t\t ";
    if ( !( $jenisusers == 0 ) || $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TANGGALDAFTAR2']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=center>{$d['GELOMBANG']}</td> \r\n \t\t\t\t\t<td align=center>".$arraypilihanpmb[$d[PILIHAN]]."</td> \r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=center>{$d['HP']}</td> \r\n \t\t\t\t\t<td align=center>{$d['EMAIL']}</td> \r\n \t\t\t\t\t<td align=right>".cetakuang( $d[BIAYA] )."</td> \r\n\t\t\t \r\n           ";
        if ( $tingkataksesusers[$kodemenu] == "T" && $jenisusers == 0 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&gelupdate={$d['GELOMBANG']}&tahunupdate={$d['TAHUN']}&pilihanupdate={$d['PILIHAN']}'>".IKONUPDATE."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center><a target=_blank href='cetakform.php?pilihan={$pilihan}&idupdate={$d['ID']}&gelupdate={$d['GELOMBANG']}&tahunupdate={$d['TAHUN']}&pilihanupdate={$d['PILIHAN']}'>Cetak Form</td>\r\n \t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $totalbiaya += $d[BIAYA];
        ++$i;
    }
    echo "\r\n    \r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td colspan=9><b>TOTAL BIAYA</td>\r\n  \t\t\t\t\t<td align=right><b>".cetakuang( $totalbiaya )."</td> \r\n      </tr>    \r\n    \r\n    </table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Pendaftaran Calon Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
