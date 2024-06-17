<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
#include( $root."sesiuserbank.php" );
include( $root."header.php" );
periksaroot( );
include( "init.php" );
echo "\n";
echo "<s";
echo "tyle type=\"text/css\">\n\n\n* {\n\tmargin:0px;\n\tpadding:0px;\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\n\t}\n\t\t\t\na {\n\tcolor:#000;\n\ttext-decoration:none;\n\t}\n\t\t\t\na:hover {\n\ttext-decoration:underline;\n\t}\n\n.dataprint {\n\twidth:600px;\n\tfont-size:12px;\n\tborder-top:1px solid black;\n\tborder-right:1px solid black;\n\t}\n\n\t\t\n.dataprint tr {\n\tborder:1px solid black;\n\theight:30px;\n\t}\n\t\t\n.dataprint td {\n\tb";
echo "order-left:1px solid black;\n\tborder-bottom:1px solid black;\n\theight:30px;\n\tpadding:0px 3px;\n\t}\n\t\t\n.dataprint tr:last-child {\n\tborder-left:none;\n\tborder-bottom:none;\n\t}\n\t\t\n.judulmenucetak {\n\twidth:600px;\n\tmargin-bottom:10px;\n\ttext-align:left;\n\t}\n\t\t\n.printerrmesg {\n\tfont-weight:bold;\n\tmargin-bottom:10px;\n\t}\n\t\t\n.juduldatacetak {\n\tfont-weight:bold;\n\tfont-size:14px;\n\t}\n\t\t\n.lineborder {\n\tborder-bottom:n";
echo "one;\n\t}\n\t\n.formcetak {\n\t\tborder-top:1px solid black;\n\t\tborder-left:1px solid black;\n\t\t}\n\t\t\n.formcetak td {\n\tpadding:2px;\n\tborder-right:1px solid black;\n\tborder-bottom:1px solid black;\n\t}\n\n</style>\n\n\n";
$cetak = $aksi = "cetak";
$border = " border=0 width=95% ";
$q = "SELECT \n\tcalonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR \n\tFROM calonmahasiswa  WHERE \n\tcalonmahasiswa.ID='{$idupdate}'\n\tAND  TAHUN='{$tahunupdate}' AND GELOMBANG='{$gelupdate}' AND\n\tPILIHAN='{$pilihanupdate}'\n\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printmesg( $errmesg );
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TANGGALDAFTAR] );
    $d[thn] = $tmp[0];
    $d[tgl] = $tmp[2];
    $d[bln] = $tmp[1];
    echo "\n\t\t<center>\n\t\t<h2>KWITANSI PEMBAYARAN</h2>\n\t <br>\n <table width=800 class=form{$aksi} cellpadding=0 cellspacing=0>\n    <tr class=judulform>\n\t\t\t<td width=200>Tahun Daftar</td>\n\t\t\t<td>{$d['TAHUN']} </td>\n\t\t</tr> \n    <tr class=judulform>\n\t\t\t<td>Gelombang</td> \n\t\t\t<td> {$d['GELOMBANG']} </td>\n\t\t</tr> \n<tr class=judulform>\n\t\t\t<td>Pilihan</td>\n\t\t\t<td>".$arraypilihanpmb[$d[PILIHAN]]." </td>\n\t\t</tr>\n        <tr class=judulform>\n\t\t\t<td>ID Pendaftaran PMB</td> \n\t\t\t<td>{$d['ID']} </td>\n\t\t</tr>  \n  \n  \t<tr class=judulform>\n\t\t\t<td>Biaya Rp.</td>\n\t\t\t<td>".cetakuang( $d[BIAYA] )." </td>\n\t\t</tr>\n\t \n \n   \t<tr class=judulform>\n\t\t\t<td colspan=2 style='height:20px;'>&nbsp;</td>\n \t\t</tr>\n\t\t<tr class=judulform>\n\t\t\t<td>Nama Calon Mahasiswa *</td>\n\t\t\t<td>{$d['NAMA']}</td>\n\t\t</tr> \n \n \n    <tr class=judulform>\n\t\t\t<td>No HP</td>\n\t\t\t<td> {$d['HP']} </td>\n\t\t</tr>\n    <tr class=judulform>\n\t\t\t<td>E-mail</td>\n\t\t\t<td> {$d['EMAIL']} </td>\n\t\t</tr>   <tr class=judulform>\n\t\t\t<td>Pilihan Program Studi</td>\n\t\t\t<td>".$arrayprodidep[$d[PRODI1]]."</td>\n\t\t</tr>\n  \n \n\t\t\t</table>\n\t\t\t</form>\n    \n    <table width=800>\n      <tr >\n        <td style='font-size:10pt;' width=50%>\n        Terbilang:\n        <br>\n         <i>( ".angkatoteks( $d[BIAYA], 0 )." Rupiah ) </i><br><br>\n         Dicetak jam ".date( "H:i:s", time( ) )."\n        </td>\n        <td width=50%>\n        \n        </td>\n \n      </tr>\n\n      <tr valign=top align=center>\n        <td width=50% style='font-size:10pt;'>\n        <br>\n        Tanda Tangan Teller\n        <br><br><br><br>\n        (..............................)\n         </td>\n        <td width=50% style='font-size:10pt;'>\n        ".$arraylokasi[$idlokasikantor].", {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}\n        <br>\n        Petugas\n        <br><br><br><br>\n        (................................)\n        </td>\n \n      </tr>\n    </table>\n\t\t";
    $ketlog = "Cetak Form Pendaftaran Calon Mahasiswa dengan ID={$idupdate} dan Nama={$d['NAMA']}";
    $users = $users_bank;
    buatlog( 65 );
}
else
{
    $errmesg = "Data Calon Mahasiswa dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
