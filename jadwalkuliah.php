<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "jadwal/init.php" );
    $_SESSION['asal'] = 0;
    include( "jadwal/prosestampildosen.php" );
}
if ( $aksi == "" )
{
    echo "\r\n        <div class=\"titlecontent\"><!-- wrap title -->\r\n            <img class=\"icontitle\" src=\"images/logojadwal.png\"/>\r\n            <h1 class=\"decorator\">Jadwal Kuliah</h1> <!-- Judul menu -->\r\n        </div>\r\n        ";
    $_SESSION['asal'] = "depan";
    echo "\r\n        <!-- form data jadwal kuliah -->\r\n        <form name='form' action='index.php' class='scheduleform' method='post'> \r\n            <input type=hidden name=pilihan value='{$pilihan}'>\r\n            <input type=hidden name=asal value='depan'>\r\n            <input type=hidden name=aksi value='tampilkan'>\r\n        <table width='100%' border='0'>\r\n        <tr>\r\n            <td width='34%' align='right'>Semester / Tahun Ajaran</td>\r\n            <td width='4%'>&nbsp;</td>\r\n            <td width='62%'>\r\n        <select name='semester' class='inputschedule'>\r\n        ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "              \t\r\n        </select>&nbsp;/\r\n        <select name='tahun' class='inputschedule'>\r\n        ";
    $selected = "";
    $i = 1901;
    while ( $i <= $w[year] + 10 )
    {
        $selected = "";
        if ( $i == $w[year] )
        {
            $selected = "selected";
        }
        echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
        ++$i;
    }
    echo "\r\n        </select>\r\n        </td>\r\n        </tr>\r\n        <tr>\r\n        <td align='right'>Jurusan / Program Studi</td>\r\n        <td>&nbsp;</td>\r\n        <td>\r\n        <select name='iddepartemen' class='inputschedule'>\r\n        <option value=''>Semua</option>\r\n        ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n    </select>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n        <td align='right'>Kode Mata Kuliah</td>\r\n        <td>&nbsp;</td>\r\n        <td>\r\n            ".createinputtext( "makul", $makul, " class='inputschedule' size='18'" )."\r\n            <a href=\"javascript:daftarmakul2('form,wewenang,makul',\r\n            document.form.makul.value)\" >Daftar Mata Kuliah</a>\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td align='right'>Kelas</td>\r\n        <td>&nbsp;</td>\r\n        <td>".createinputtext( "kelasjadwal", $kelasjadwal, " class='inputschedule' size='18'" )."</td>\r\n    </tr>\r\n    <tr>\r\n        <td height='43' align='right'>Hari</td>\r\n        <td>&nbsp;</td>\r\n        <td>\r\n            <select name='hari' class='inputschedule'>\r\n            <option value=''>Semua</option>\r\n    ";
    foreach ( $arrayhari as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "              \t\r\n        </select>\r\n        </td>\r\n        </tr>\r\n        <tr>\r\n            <td align='right'>&nbsp;</td>\r\n            <td>&nbsp;</td>\r\n            <td align='left'>\r\n                <input type='submit' name='button' class='show' value='Tampilkan' />\r\n            </td>\r\n        </tr>\r\n        </table>\r\n        </form>\r\n        <!-- end of form data jadwal kuliah -->";
}
?>
