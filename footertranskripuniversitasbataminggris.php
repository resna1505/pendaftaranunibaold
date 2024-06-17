<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE1];
    $gambarttd2 = $dttd[FILE2];
    $field1 = "FILE1";
    $field2 = "FILE2";
    $idprodix = "";
}
unset( $dttd );
$footertranskrip .= "\n    <style type=\"text/css\">\n\ntd {\n\tpadding:none;\n\t}\n\n</style>\n    ";
$footertranskrip .= "\n\t\t\t\t\t <center>\n\t\t\t\t\t\t<table border=0 width=100%>\n\t\t\t\t\t\t\t<tr >\n \t\t\t\t\t\t\t\t<td align=left nowrap width=50%>\n\t\t\t\t\t\t\t\t\t<div style='position:relative; right:230px; top:8px;'>\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\n\t\t\t\t\t\t\t\t<br><br><br><br><br>  ";
}
else
{
    $footertranskrip .= "\n\t\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur}\t\n\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t<td width=50%>\n \t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']} <br>\n \t\t\t\t\t\t\t\t\tDEKAN {$namafakultas}\n \t\t\t\t\t\t\t\t\t<br><br><br><br><br>\n \t\t\t\t\t\t\t\t\t\n                    <u>{$namadekan}</u><br>\n                    NIDN. {$nipdekan}\n                \n                </td>\n\n\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t</table>\n\t\t\t\t \n\t\t\t\t\t";
?>
