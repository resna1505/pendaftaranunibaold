<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\n\ttd {\n\t\tpadding:0px;\n\t\tmargin:0px;\n\t\t}\n</style>\n";
periksaroot( );
$namafakultas = "";
$q = "SELECT * FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
    $namadekan = "{$df['NAMAPIMPINAN']}";
    $nipdekan = "{$df['NIPPIMPINAN']}";
}
$tmpcetakawal .= "\n    \t\t\t<div align=center><b style='font-size:16pt;'> TRANSKRIP AKADEMIK ACADEMIC TRANSCRIPT </b><br></div>\n    \t\t\t<table><tr><td>NOMOR : {$NO_SERITRANSKRIP} </td></tr></table>\n    \t\t\t<br><br>\n    \t\t\t";
$tmpcetakawal .= " \n \n\t\t\t<center>\n\n\t\t\t<table border=0 width=95%  >\n\t\t\t\t<tr valign=top>\n\t\t\t\t<td width=75%>\n\t\t\t\t<table    >\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td>Nama Mahasiswa / <i>Name of Student</i></td>\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\n\t\t\t\t\t</tr>\n\n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td class=judulform>Nomor Pokok Mahasiswa / <i>Registration Number</i></td>\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\n\t\t\t\t\t</tr> \n\t\t\t\t\t<tr align=left>\n\t\t\t\t\t\t<td nowrap>Tempat, Tanggal Lahir /<i> Place, Date of Birth </i></td>\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\n\t\t\t\t\t</tr> \t\t\t\t</table>\n\t\t\t</td>\n\t\t\t<td  width=50%>\n\n\t\t\t\t<table   >";
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " \n          \t<tr align=left>\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Program Studi /  <i>Departmen</i></td>\n\t\t\t\t\t\t<td nowrap >: {$d['NAMAP']} / <i>{$d['NAMAP2']}</td>\n\t\t\t\t\t</tr>  \n          \t<tr align=left>\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Jenjang Studi / <i>Study Level</i></td>\n\t\t\t\t\t\t<td nowrap >: ".$arraynamajenjang[$d[TINGKAT]]." /<i>{$d['NAMAJENJANG2']}</td>\n\t\t\t\t\t</tr> \n          \t<tr align=left>\n\t\t\t\t\t\t<td nowrap class=judulform nowrap>Tanggal Lulus /  <i>Date of Final Examination</i></td>\n\t\t\t\t\t\t<td nowrap >: {$tanggallulus}</td>\n\t\t\t\t\t</tr>  \n                    \n          ";
$tmpcetakawal .= " \n\t\t\t\t</table>\t\t\t\t\n\t\t\t\t\n\t\t\t</td>\n\t\t</tr>\n\t\t</table>\n\t \n\t\t\t";
?>
