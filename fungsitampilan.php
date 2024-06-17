<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getpenandatangan( )
{
    global $koneksi;
    global $nipdirektur;
    global $namadirektur;
    global $nipkabag;
    global $namakabag;
    global $jabatandirektur;
    global $jabatankabag;
    global $namabaak;
    global $jabatanbaak;
    global $nipbaak;
    global $namadirektur2;
    global $nipdirektur2;
    global $jabatandirektur2;
    global $namadirektur5;
    global $nipdirektur5;
    global $jabatandirektur5;
    global $namakhs;
    global $nipkhs;
    global $jabatankhs;
    global $namapasca;
    global $nippasca;
    global $jabatanpasca;
    $q = "SELECT * from penandatanganumum WHERE ID=0 ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nipdirektur = $d[NIPDIREKTUR];
        $namadirektur = $d[NAMADIREKTUR];
        $nipkabag = $d[NIPKABAG];
        $namakabag = $d[NAMAKABAG];
        $jabatandirektur = $d[JABATANDIREKTUR];
        $jabatankabag = $d[JABATANKABAG];
        $namabaak = $d[NAMABAAK];
        $jabatanbaak = $d[JABATANBAAK];
        $nipbaak = $d[NIPBAAK];
        $namadirektur2 = $d[NAMADIREKTUR2];
        $nipdirektur2 = $d[NIPDIREKTUR2];
        $jabatandirektur2 = $d[JABATANDIREKTUR2];
        $namadirektur5 = $d[NAMADIREKTUR5];
        $nipdirektur5 = $d[NIPDIREKTUR5];
        $jabatandirektur5 = $d[JABATANDIREKTUR5];
        $namakhs = $d[NAMAKHS];
        $nipkhs = $d[NIPKHS];
        $jabatankhs = $d[JABATANKHS];
        $namapasca = $d[NAMAPASCA];
        $nippasca = $d[NIPPASCA];
        $jabatanpasca = $d[JABATANPASCA];
    }
}

function getarraysemestercuti( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM\t= '{$idmahasiswa}' AND STMHSTRLSM = 'C' ORDER BY THSMSTRLSM";
    $h = mysqli_query($koneksi,$q);
	if(0 < sqlnumrows( $h )){
    #while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
		while($d = sqlfetcharray( $h ))
		{
			$tahuncuti = substr( $d[THSMSTRLSM], 0, 4 );
			$semestercuti = substr( $d[THSMSTRLSM], 4, 1 );
			$tmp[$d[THSMSTRLSM]][tahun] = $tahuncuti;
			$tmp[$d[THSMSTRLSM]][semester] = $semestercuti;
		}
	}
    return $tmp;
}

function createinputtahunajaransemestercuti( $semua = 1, $semester = "semester", $idmahasiswa )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM\t= '{$idmahasiswa}' AND STMHSTRLSM = 'C' ORDER BY THSMSTRLSM";
	#echo $q;
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $tmp .= "\r\n                <select name={$semester} class=masukan> \r\n              \r\n    \t\t\t\t\t\t ";
        if ( $semua == 1 )
        {
            $tmp .= "\r\n                    <option value=''>Semua</option>\r\n                  ";
        }
        while ( $d = sqlfetcharray( $h ) )
        {
            $tahuncuti = substr( $d[THSMSTRLSM], 0, 4 );
            $semestercuti = substr( $d[THSMSTRLSM], 4, 1 );
            $selected = "";
            if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
            {
                if ( $k == $waktu[year] + 1 )
                {
                    $selected = "selected";
                }
            }
            else if ( $k == $waktu[year] )
            {
                $selected = "selected";
            }
            $tmp .= "\r\n\t\t\t\t\t\t\t<option value='{$d['THSMSTRLSM']}' {$selected} >{$tahuncuti}/".( $tahuncuti + 1 )."  ".$arraysemester[$semestercuti]."  </option>\r\n\t\t\t\t\t\t\t";
        }
        $tmp .= "\r\n\t\t\t\t\t\t</select>\t";
    }
    else
    {
        $tmp = "Data cuti mahasiswa tidak ditemukan";
    }
    return $tmp;
}

function createinputtahunmasuk( $semua = 1, $tahun = "tahun", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=masukan> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    $arrayangkatan = getarrayangkatan( "", $addnumber );
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n  \r\n  ";
    return $tmp;
}

function createinputtahunakademik( $semua = 1, $tahun = "tahun", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=masukan> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    $arrayangkatan = getarrayangkatan( "K", $addnumber );
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".$v."/".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n  \r\n  ";
    return $tmp;
}

function createinputtahunajaransemester( $semua = 1, $tahun = "tahun", $semester = "semester", $addnumber = 0, $plus1 = 0, $tambah1 = 0 )
{
    global $koneksi;
    global $arraysemester;
    $tmp = explode( "-", getaturan( "TAHUNAJARAN" ) );
	#print_r($tmp);exit();
    $tahunajaran[tgl] = $tmp[2];
    $tahunajaran[bln] = $tmp[1];
    $tahunajaran[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGANJIL" ) );
    $semesterganjil[tgl] = $tmp[2];
    $semesterganjil[bln] = $tmp[1];
    $semesterganjil[thn] = $tmp[0];
    $tmp = explode( "-", getaturan( "SEMESTERGENAP" ) );
    $semestergenap[tgl] = $tmp[2];
    $semestergenap[bln] = $tmp[1];
    $semestergenap[thn] = $tmp[0];
    $tmp = "";
    $waktu = getdate( );
    $tmp .= "\r\n            <select name={$tahun} class=masukan> \r\n          \r\n\t\t\t\t\t\t ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    
	//$arrayangkatan = getarrayangkatan( "K", $addnumber );
	//ubah hafizd
	$arrayangkatan = getarrayangkatan( "R", $addnumber );
	#print_r($arrayangkatan);
    foreach ( $arrayangkatan as $k => $v )
    {
        $v = $v + $plus1;
        $selected = "";
        if ( $tahunajaran[bln] <= $waktu[mon] && $tahunajaran[tgl] <= $waktu[mday] )
        {
            if ( $k == $waktu[year] + 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    if ( $tambah1 == 1 )
    {
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."'  >".$v."/".( $v + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>\t\t \r\n            <select name={$semester} class=masukan> \r\n            ";
    if ( $semua == 1 )
    {
        $tmp .= "\r\n                <option value=''>Semua</option>\r\n              ";
    }
    foreach ( $arraysemester as $k => $v )
    {
        $selected = "";
        if ( $semesterganjil[bln] <= $waktu[mon] && $semesterganjil[tgl] <= $waktu[mday] )
        {
            if ( $k == 1 )
            {
                $selected = "selected";
            }
        }
        else if ( $semestergenap[bln] <= $waktu[mon] && $semestergenap[tgl] <= $waktu[mday] && $k == 2 )
        {
            $selected = "selected";
        }
        $tmp .= "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    $tmp .= "\r\n\t\t\t\t\t\t</select>  \r\n  \r\n  ";
    return $tmp;
}

function printheader( )
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    global $csskantor;
    echo "\r\n    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head>\r\n    <title>{$namaprogram} </title>\t\r\n    ";
    include($root."javascript.js" );
    echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    echo "<script src='".$root."/tampilan/lib/script_luar.js' type='text/javascript'></script>";
    if ( $csskantor == "newyear" )
    {
        echo "<script src='".$root."/tampilan/lib/snow.js' type='text/javascript'></script>";
    }
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$csskantor}/style.css\" type=\"text/css\" />";
	echo "<meta charset=\"UTF-8\">";
	echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
    include( $root."tampilan/jam.php" );
    echo "</head><link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' /><body  onLoad='startclock()'  >\r\n\t<div class='gradient'>\r\n    <div id=\"wrap\">\r\n\t\r\n    ";
    #include( $root."tampilan/siteheader.php" );
}

function printmesg( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "<p class=\"alert\">{$errmesg}</p>";
    }
}

function printheader_dlm( )
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    global $arraycss;
    global $csskantor;
    global $users_bank;
    $css = "";
    if ( $jenisusers === 0 )
    {
        $q = "SELECT CSS FROM user WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 1 )
    {
        $q = "SELECT CSS FROM dosen WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        $q = "SELECT CSS FROM mahasiswa WHERE ID='{$users}'";
    }
    else if ( session_is_registered_sikad( "users_bank" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    }
    else if ( session_is_registered_sikad( "users_pmb" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    
	}
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $cssasli = $css = $d[CSS];
    }
    if ( $arraycss[$css] == "" )
    {
        $css = "default";
    }
	#echo $root;
    echo "\r\n        <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n        <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n        <head>\r\n        <title>{$namaprogram} </title>\r\n        <link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' />\t\r\n\t\t";
    include( $root."javascript.js" );
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/style_main.css\" type=\"text/css\" />";
    echo "<script type='text/javascript' src='".$root."tampilan/lib/multilevel.dropdown.js'></script>";
    echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    echo "<script src='".$root."/tampilan/lib/script.js' type='text/javascript'></script>";
    echo "\r\n        <link rel=\"stylesheet\" href=\"".$root."/tampilan/lib/colorbox.css\" />\r\n        <script src=\"".$root."/tampilan/lib/jquery.min.js\"></script>\r\n        <script src=\"".$root."/tampilan/lib/jquery.colorbox-min.js\"></script>\r\n\t";
    echo "\r\n<style type='text/css'>@import '".$root."/tampilan/lib/countdown/jquery.countdown.css';</style> \r\n<script type='text/javascript' src='".$root."/tampilan/lib/countdown/jquery.countdown.js'></script> \r\n<script type='text/javascript' src='".$root."/tampilan/lib/JqueryUI/js/jquery-ui-1.8.18.custom.min.js'></script> \r\n<style type='text/css'>@import '".$root."/tampilan/lib/JqueryUI/css/ui-lightness/jquery-ui-1.8.18.custom.css';</style> \r\n\r\n \r\n\r\n";
    echo "\r\n<script type=\"text/javascript\" src=\"".$root."/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js\"></script>\r\n<script type=\"text/javascript\" src=\"".$root."/tiny_mce/plugins/asciisvg/js/ASCIIsvg.js\"></script>\r\n<script type=\"text/javascript\">\r\n  var AScgiloc = '".$root."/tiny_mce/php/svgimg.php';\r\n \r\n var AMTcgiloc = \"http://www.imathas.com/cgi-bin/mimetex.cgi\";\r\n</script>\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"".$root."/tiny_mce/tiny_mce.js\"></script>\r\n";
    include( $root."tampilan/jam.php" );
    echo "<script type='text/javascript'>$(function() { $('#chkall').click(function() { $('.chkbox').attr('checked', $( this ).is( ':checked' ) ? 'checked' :'');});});</script>";
    echo "    </head>\r\n        <body  onLoad='startclock()'  >\r\n         {$scr}\r\n        <div id=\"wrap\">\r\n        ";
    include( $root."tampilan/siteheader_dlm.php" );
}

function printheader_dlmbank( )
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    global $arraycss;
    global $csskantor;
    global $users_bank;
    $css = "";
    if ( $jenisusers === 0 )
    {
        $q = "SELECT CSS FROM user WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 1 )
    {
        $q = "SELECT CSS FROM dosen WHERE ID='{$users}'";
    }
    else if ( $jenisusers == 2 || $jenisusers == 3 )
    {
        $q = "SELECT CSS FROM mahasiswa WHERE ID='{$users}'";
    }
    else if ( session_is_registered_sikad( "users_bank" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    }
    else if ( session_is_registered_sikad( "users_pmb" ) )
    {
        $q = " SELECT '{$csskantor}' AS CSS ";
    
	}else{
	
		$q = " SELECT '{$csskantor}' AS CSS ";
    
	}
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $cssasli = $css = $d['CSS'];
    }
    if ( $arraycss[$css] == "" )
    {
        $css = "default";
    }
	#echo $root;
    echo "\r\n        <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n        <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n        <head>\r\n        <title>{$namaprogram} </title>\r\n        <link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' />\t\r\n\t\t";
    include( $root."javascript.js" );
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/{$css}/style_main.css\" type=\"text/css\" />";
    echo "<script type='text/javascript' src='".$root."tampilan/lib/multilevel.dropdown.js'></script>";
    echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    echo "<script src='".$root."/tampilan/lib/script.js' type='text/javascript'></script>";
    echo "\r\n        <link rel=\"stylesheet\" href=\"".$root."/tampilan/lib/colorbox.css\" />\r\n        <script src=\"".$root."/tampilan/lib/jquery.min.js\"></script>\r\n        <script src=\"".$root."/tampilan/lib/jquery.colorbox-min.js\"></script>\r\n\t";
    echo "\r\n<style type='text/css'>@import '".$root."/tampilan/lib/countdown/jquery.countdown.css';</style> \r\n<script type='text/javascript' src='".$root."/tampilan/lib/countdown/jquery.countdown.js'></script> \r\n<script type='text/javascript' src='".$root."/tampilan/lib/JqueryUI/js/jquery-ui-1.8.18.custom.min.js'></script> \r\n<style type='text/css'>@import '".$root."/tampilan/lib/JqueryUI/css/ui-lightness/jquery-ui-1.8.18.custom.css';</style> \r\n\r\n \r\n\r\n";
    echo "\r\n<script type=\"text/javascript\" src=\"".$root."/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js\"></script>\r\n<script type=\"text/javascript\" src=\"".$root."/tiny_mce/plugins/asciisvg/js/ASCIIsvg.js\"></script>\r\n<script type=\"text/javascript\">\r\n  var AScgiloc = '".$root."/tiny_mce/php/svgimg.php';\r\n \r\n var AMTcgiloc = \"http://www.imathas.com/cgi-bin/mimetex.cgi\";\r\n</script>\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"".$root."/tiny_mce/tiny_mce.js\"></script>\r\n";
    include( $root."tampilan/jam.php" );
    echo "<script type='text/javascript'>$(function() { $('#chkall').click(function() { $('.chkbox').attr('checked', $( this ).is( ':checked' ) ? 'checked' :'');});});</script>";
    echo "    </head>\r\n        <body  onLoad='startclock()'  >\r\n         {$scr}\r\n        <div id=\"wrap\">\r\n        ";
    include( $root."tampilan/siteheader_dlmbank.php" );
}

/*function printmenudropdown( $arraymenu )
{
    include( $root."unik.php" );
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    global $JUDULFAKULTAS;
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    global $jenisusers;
	print_r($arraykelompokmenu);
	print_r($arraymenu);
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n        <!-- navigator -->\r\n        <div id='navigator'>\r\n        <ul class='menu' id='menu'>\t\t\t\t \r\n        ";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t             <li><a href='#' class='menulink'>{$vv}</a><ul>\r\n                 ";
        
		$k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = FALSE;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = TRUE;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $tmpx .= " <li> <a href='../{$v['href']}'  class='sub'>{$v['Judul']} </a>";
                unset( $arraysubmenu );
                $filesubmenu = "../".str_replace( "index.php", "", $v[href] )."/submenu.php";
                $dirsubmenu = "../".str_replace( "index.php", "", $v[href] )."";
                if ( file_exists( $filesubmenu ) )
                {
                    include( "../".str_replace( "index.php", "", $v[href] )."/submenu.php" );
                    if ( is_array( $arraysubmenu ) )
                    {
                        $tmpx .= " <ul> ";
                        foreach ( $arraysubmenu as $k => $v )
                        {
                            if ( $v[t] == "T" && $tingkataksesusers[$kodemenu] != "T" )
                            {
                            }
                            else if ( $v[href] != "" )
                            {
                                #$tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
								$tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>{$v['Judul']}</a></li>";
                            }
                        }
                        $tmpx .= " </ul> ";
                    }
                }
                $tmpx .= " </li> ";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "</ul></li>";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "<li><a href='index.php?aksi=logout' class='menulink'>Logout</a></li>       </ul><ul class='rightlink'><li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
}*/

function printmenudropdown($arraymenu){
	include $root."unik.php";
	global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	global $tingkats,$tingkataksesusers,$users,$borderdata,$root,$arrayikonsubmenu,$jenisusers;
	$jumlahmenu=count($arraymenu);
	$ii=0;
	#print_r($kodemenu);
	#print_r($tingkataksesusers);
 	$tmp="
        <!-- navigator -->
        <div id='navigator'>
        <ul class='menu' id='menu'>				 
        ";
		/*$tmpx = "";
		echo $tingkats;
		if($tingkats=='F5:B,F6:B'){
			$tmpx .= "
	             <li><a href='#' class='menulink'>Mahasiswa</a>
					<ul>
						<li><a href='../mahasiswa2/index.php'  class='sub'>Data Mahasiswa</a><li>
					</ul>
                 ";
    	
		}
		$tmp.=$tmpx;
		$tmp .= "<li><a href='index.php?aksi=logout' class='menulink'>Logout</a></li>       </ul><ul class='rightlink'><li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
		echo $tmp;*/
		#print_r($arraysubmenu);
	foreach ($arraykelompokmenu as $kk=>$vv) {
		#print_r($arraykelompokmenu);
		#echo 'WHAT<br>';
		#print_r($kk);
		#echo 'WHERE<br>';
		#print_r($vv);
		#echo 'WHEN<br>';
 		$kelas=kelasmenu($ii);
	 	$tmpx = "";
		$tmpx .= "
	             <li><a href='#' class='menulink'>$vv</a><ul>
                 ";
    	$k=0;
		#print_r($arraysubmenu);
				foreach ($arraymenu as $i=>$v) {
					#print_r($arraysubmenu);
					#print_r($arraymenu);
					#echo 'AH<br>';
					#print_r($i);
					#echo 'OH<br>';
					#print_r($v);
					#echo 'UH<br>';
					#echo $kk.'AAA<br>';		
					#echo $kk.'AAA'."ZZZ".$v[k]."SSS".$i.'<br>';
					#print_r($arraysubmenu);
					if ($v[k]!=$kk) {
						#echo "XXX".'<br>';
						#echo $kk.'XXX'."DDD".$v[k]."FFF".$i.'<br>';
						continue;
					} 
					else{
						#echo $kk.'AAA'."ZZZ".$v[k]."SSS".$i.'<br>';					
						$bolehdiakses=false;
						#echo "AAA".$v[t].'<br>'."MM".$tingkataksesusers[$v[t]];
						if ($v[t]!="" && $tingkataksesusers[$v[t]]!="") {
							$bolehdiakses=true;
						}
						#echo $bolehdiakses."MMM";
						#print_r(session_is_registered_sikad("tingkats")).'AKAK ';
						#if  (session_is_registered_sikad("tingkats") && ($bolehdiakses || ($v[t]==""))) {
						if  (session_is_registered_sikad("tingkats") && ($bolehdiakses || ($v[t]==""))) {
							#echo "AAmmm".'<br>';
							  $tmpx.= " <li> <a href='../$v[href]'  class='sub'>$v[Judul] </a>";
							  #$tmpx.= " <li> <a href='#'  class='sub'>$v[Judul] </a>";
							  #print_r($arraysubmenu);
							  unset($arraysubmenu);
							  $filesubmenu="../".str_replace("index.php","",$v[href])."/submenu.php";
							  $dirsubmenu="../".str_replace("index.php","",$v[href])."";
							  #echo $filesubmenu;
							  #echo '<br>';
							  if (file_exists($filesubmenu)) {
								  include "../".str_replace("index.php","",$v[href])."/submenu.php";
								  if (is_array($arraysubmenu)) {
								   $tmpx.=" <ul> ";
									#foreach ($arraysubmenu as $k=>$v) {
									foreach ($arraysubmenu as $k=>$vsub) {
										#print_r($arraysubmenu);
										#echo 'AAA<br>';
										#print_r($k);
										#echo 'CC<br>';
										#print_r($vsub);
										#echo 'AAA<br>';
										#print_r($kk);
										#echo 'INI<br>';
										if ($vsub[t]=="T" && $tingkataksesusers[$kodemenu]!="T") {
											#continue;
										}else {
				
										if ($vsub[href]!="") {										
										   
										  #$tmpx.=" <li><a href='".$dirsubmenu."$v[href]'>".$arrayikonsubmenu[$v[ico]]." $v[Judul]</a></li>";
										  #$tmpx .= " <li><a href='".$dirsubmenu."$v[href]'>$v[Judul]</a></li>";
										  $tmpx .= " <li><a href='".$dirsubmenu."$vsub[href]'>$vsub[Judul]</a>";
											unset($arraysubsubmenu);
											$filesubsubmenu="../".str_replace("index.php","",$v[href])."/subsubmenu.php";
											$dirsubsubmenu="../".str_replace("index.php","",$v[href])."";
											#echo $filesubsubmenu;
											#echo '<br>';
											if (file_exists($filesubsubmenu)) {
											
												include "../".str_replace("index.php","",$v[href])."/subsubmenu.php";
												
												if (is_array($arraysubsubmenu)) {
												
													$tmpx.=" <ul> ";
													#$jj=0;
													foreach ($arraysubsubmenu as $ksubsub=>$vsubsub){
														#print_r($arraysubsubmenu);
														#echo 'AKU<br>';
														#print_r($ksubsub);
														#echo 'INGIN<br>';
														#print_r($vsubsub);
														#echo 'BEGINI<br>';
														#print_r($k);
														#echo 'BEGITU<br>';
														#if ($vsubsub[k]!=$k) {
															#echo "XXX".'<br>';
														#	continue ;
														#}
														#else{
														#	$tmpx .= " <li><a href='".$dirsubsubmenu."$vsubsub[href]'>$vsubsub[Judul]</a></li>";
														#}
														#if ( !isangka($ksubsub))
														#{
														#	$hasil = "</ul><h2 class='titlebarbottom'>{$vsubsub['Judul']}</h2><ul class='leftnav'>";
														#}
														#else
														#{
															#$hasil = "<li> <a href='{$va['href']}' >".$arrayikonsubmenu[$va[ico]]." {$va['Judul']}</a></li>";
															#$hasil = "<li> <a href='{$vsubsub['href']}' >{$vsubsub['Judul']}</a></li>";
														#	$tmpx .= " <li><a href='".$dirsubsubmenu."$vsubsub[href]'>$vsubsub[Judul]</a></li>";
														#}
														#echo
														#echo $vsubsub[k];
														#echo 'APA<br>';
														#echo $k;
														#echo 'IPI<br>';														
														#echo $tingkataksesusers[$kodemenu];
														#echo 'UPU<br>';
														if ($vsubsub[k]!=$k){
														#{	
															#if ($vsubsub[k]!=$k){
																#print_r($vsubsub[t]);
																#if ($vsubsub[t] == "T"){
																#if ( $vsubsub[t] == "T" && $tingkataksesusers[$kode] != "T" ){
																	
																	#if ($vsubsub[t] == "T" && $tingkataksesusers[$kodemenu] != "T" ){
																		
																		#continue;
																		#echo $tingkataksesusers[$kodemenu];
																		
																		#if ($vsubsub[k]!=$k && $vsubsub[t] == "T" && $tingkataksesusers[$kodemenu] != "T"){
																		
																			continue;
																		}
																	#}
																	#else{
																		
																	#}
																
																#}
																
															#}
														#}
														if ( $tipe == ""  && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
														{
															#echo " {$tmp}  ";
															#$jj++;
															if ($vsubsub[t] == "T" && $tingkataksesusers[$kodemenu] != "T" ){
																continue;
															}else{
																$tmpx .= " <li><a href='".$dirsubsubmenu."$vsubsub[href]'>$vsubsub[Judul]</a></li>";
															}
															
														}
														
														#$jj++;
													
													}
												
													$tmpx.=" </ul> ";
													
												}
											
											
											}
										}
									  }
									}
								   $tmpx.=" </ul> ";
								   }
							  }
							  $tmpx.= " </li> ";
									
							 $k++;
							 $j++;
						}
					}
				}

            #$k++;
			#$j++;
		$tmpx.= "</ul></li>";
 		if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		}
 	}
	#$tmp.=$tmpx;
	$tmp .= "<li><a href='index.php?aksi=logout' class='menulink'>Logout</a></li>       </ul><ul class='rightlink'><li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
    
	/*$tmp .="        
        </ul>
        </div>
        <script type='text/javascript'>
        var menu=new menu.dd('menu');
        menu.init('menu','menuhover');
        </script>
	   ";
       
 	echo $tmp;*/
}

function createsubmenu( $judul, $kode, $arraysubmenu, $tipe = "" )
{
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
	
	
    echo "\r\n         <div class='submenu'>\r\n         <h2 class='titlebar'>{$judul}</h2>\r\n         <ul class='leftnav'>\r\n         ";
    $jj = 0;
	/*if($judul==='Data Mahasiswa'){
	
		$hasil = "	<li> <a href='?' >Akademik</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Nilai Semester</a></li><li> <a href='' >Konversi Nilai</a></li>
					<li> <a href='?' >Kelulusan/Cuti/Non Aktif/DO</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>
					<li> <a href='?' >Aktivitas Kuliah</a></li><li> <a href='' >Aktivitas Kuliah</a></li>";
	}*/
	#echo $hasil;	
    foreach ( $arraysubmenu as $ia => $va )
    {
        if ( !isangka( $ia ) )
        {
            $hasil = "</ul><h2 class='titlebarbottom'>{$va['Judul']}</h2><ul class='leftnav'>";
        }
        else
        {
            #$hasil = "<li> <a href='{$va['href']}' >".$arrayikonsubmenu[$va[ico]]." {$va['Judul']}</a></li>";
			$hasil = "<li> <a href='{$va['href']}' >{$va['Judul']}</a></li>";
        }
        if ( $va[t] == "T" && $tingkataksesusers[$kode] != "T" )
        {
            continue;
        }
        if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
        {
            echo " {$hasil}  ";
            $jj++;
        }
    }
    echo "</ul></div>";
}

function printmenudropdownbank($arraysubmenu){
	include $root."unik.php";
	#global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	#global $tingkats,$tingkataksesusers,$users,$borderdata,$users_bank,$root,$arrayikonsubmenu,$jenisusers;
	global $tingkats_bank,$users_bank;
	$jumlahmenu=count($arraysubmenu);
	$ii=0;
	$tipe="bank";
	#print_r($kodemenu);
	#print_r($tingkataksesusers);
 	$tmp="
        <!-- navigator -->
        <div id='navigator'>
        <ul class='menu' id='menu'>				 
        ";
		#include("")
		#print_r($arraysubmenu);
		foreach ($arraysubmenu as $kk=>$vv) {
			#print_r($arraykelompokmenu);
			#echo '<br>';
			#print_r($kk);
			#echo '<br>';
			#print_r($vv);
			#echo '<br>';
			$kelas=kelasmenu($ii);
			$tmpx = "";
			/*if ( $vv[t] == "T" && session_is_registered_sikad( "tingkats_bank" ) != "T" )
			{
				#echo "lll";
				#continue;
				$tmpx .= "
					 <li><a href='$vv[href]' class='menulink'>$vv[Judul] </a>
					 ";
					 #continue;
			}
			#if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
			if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) )
			
			{*/
				#echo " {$hasil}  ";
				#$jj++;
				$tmpx .= "
					 <li><a href='$vv[href]' class='menulink'>$vv[Judul] </a>
					 ";
			#}
			
		#	$k=0;
		#$tmpx.= "</ul></li>";	
		$tmpx.= "</li>";
 		#if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		#}
 	}
	#$q = "SELECT * FROM operatorbank WHERE ID='{$users_bank}'";
	#echo $q;
	#$h = mysqli_query($koneksi,$q);
	#$d = sqlfetcharray( $h );

	#$tmp.=$tmpx;
	#$tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    $tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank}</strong></li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
		
}

function printmenudropdownpmb($arraysubmenu){
	include $root."unik.php";
	#global $tingkataksesusers,$tingkatakses,$tingkats,$arraykelompokmenu,$JUDULFAKULTAS;
	#global $tingkats,$tingkataksesusers,$users,$borderdata,$users_bank,$root,$arrayikonsubmenu,$jenisusers;
	global $tingkats_pmb,$users_pmb,$namausers_pmb;
	$jumlahmenu=count($arraysubmenu);
	$ii=0;
	$tipe="pmb";
	#print_r($kodemenu);
	#print_r($tingkataksesusers);
 	$tmp="
        <!-- navigator -->
        <div id='navigator'>
        <ul class='menu' id='menu'>				 
        ";
		#include("")
		#print_r($arraysubmenu);
		foreach ($arraysubmenu as $kk=>$vv) {
			#print_r($arraykelompokmenu);
			#echo '<br>';
			#print_r($kk);
			#echo '<br>';
			#print_r($vv);
			#echo '<br>';
			$kelas=kelasmenu($ii);
			$tmpx = "";
			if ( $vv[t] == "T" && session_is_registered_sikad( "tingkats_pmb" ) != "T" )
			{
				continue;
			}
			if ( $tipe == "" && session_is_registered_sikad( "tingkats" ) || $tipe == "pmb" && session_is_registered_sikad( "tingkats_pmb" ) || $tipe == "bank" && session_is_registered_sikad( "tingkats_bank" ) )
			{
				#echo " {$hasil}  ";
				#$jj++;
				$tmpx .= "
					 <li><a href='$vv[href]' class='menulink'>$vv[Judul] </a>
					 ";
			}
			
		#	$k=0;
		#$tmpx.= "</ul></li>";	
		$tmpx.= "</li>";
 		#if ($k>0) {
 			$tmp.=$tmpx;
			$ii++;
 		#}
 	}
	#$q = "SELECT * FROM operatorbank WHERE ID='{$users_bank}'";
	#echo $q;
	#$h = mysqli_query($koneksi,$q);
	#$d = sqlfetcharray( $h );

	#$tmp.=$tmpx;
	#$tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$users_bank} ( ".printid( $users )." ) </strong>{$pesan}</li><li><a href='#'></a></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    $tmp .= "</ul><ul class='rightlink'><li>selamat datang <strong> {$namausers_pmb}</strong></li></ul> </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
		
}

function printfooter_dlm( )
{
    global $koneksi;	
    $q = "SELECT * FROM mspti LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    $r = sqlfetcharray( $h );
    echo "\r\n         <!-- footer -->\r\n         <div id=\"footer\">\r\n         <p class=\"textfoot\">Academic Management System  {$r['NMPTIMSPTI']} <br/> Developed by &#169; ICT {$r['NMPTIMSPTI']}</p>\r\n         </div>\r\n         <!-- end footer -->\r\n         ";
}

function printjudulmenu( $judul, $idbantuan = "", $ikon = "" )
{
    echo "\r\n        <div class='titlecontent'>\r\n            \r\n            <h2 class='titlepostcontent'>".strtoupper( $judul )."</h2>\r\n        </div>\r\n        <div class='postcontent'>   \r\n    ";
}

function printjudul( $judul )
{
    global $koneksi;
    global $tabellatar;
    global $namausers;
    global $users;
    global $arraykomponenpembayaran2;
    global $jenisusers;
    global $angkatanusers;
    global $prodiusers;
    global $arrayjeniskomponenpembayaran;
    global $waktu;
    global $arraysemester;
    global $arraybulan;
    global $arrayhari;
    global $root;
    if ( $users != "" )
    {
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND DIBACA IS NULL";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $jumlahpesan = $d[JML];
        if ( $jumlahpesan != "" && 0 < $jumlahpesan )
        {
            $pesan = ". Anda mendapatkan <b>{$jumlahpesan} <a href='../pesan/index.php'>pesan baru</a></b>\r\n\t\t";
        }
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND ALERT ='0'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $jumlahpesana = $d[JML];
        if ( $jumlahpesana != "" && 0 < $jumlahpesana )
        {
            $pesan .= "\r\n\t\t<script language='Javascript' type=\"text/javascript\">\r\n\t\t\talert('Anda mendapatkan {$jumlahpesan} pesan baru. Silakan dibaca. Terima kasih');\r\n\t\t</script>\r\n\t\t";
            $q = "UPDATE pesan SET ALERT='1' WHERE KE = '{$users}' AND ALERT ='0'";
            $h = mysqli_query($koneksi,$q);
        }
       # echo "\r\n        <!-- topheader --> \r\n    \t<div id='topheader'>\r\n        \t<ul class='rightlink'>\r\n            \t<li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li>\r\n                <li><a href='#'>";
       # include( $root."tampilan/siteheaderclock.php" );
       # echo "</a></li>\r\n                <li><a class=\"red\" href='index.php?aksi=logout'><b>[ Logout ]</b></a></li>\r\n            </ul>\r\n        </div>\r\n        <!-- end topheader -->\r\n\t    ";
        if ( $pesanbayar != "" )
        {
            echo "\r\n\t\t\t<div id='welcome2'><center>{$pesanbayar} </div>\r\n\t\t";
        }
    }
}

function printjudulmenucetak( $judul )
{
    echo "\r\n\t<h2 class='judulmenucetak'>\r\n\t\t{$judul}\r\n\t</h2>\r\n<div class='postcontent'> \r\n\t";
}

function printjudulmenukecil( $judul )
{
    echo "\r\n\t<p>\r\n\t<table class=judulmenukecil>\r\n\t\t<tr align=left>\r\n\t\t\t<td>\r\n\t\t\t{$judul}\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</p>\r\n   \r\n\t";
}

function cetakpimpinan( )
{
    global $koneksi;
    global $arraybulan;
    global $arraylokasi;
    global $idlokasikantor;
    global $waktu;
    global $namakantor;
    $q = "select NIP,NAMA FROM user WHERE JABATAN=0";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nama = $d[NAMA];
        $nip = $d[NIP];
    }
    echo "\r\n<br><br>\r\n\t<table width=100%>\t\r\n\t<tr><td width=40%></td>\r\n\t<td>\r\n\t".$arraylokasi[$idlokasikantor].", {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t{$namakantor} \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\tKepala, \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<BR><BR><BR>\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<u>{$nama}</u><br>\r\n\tNIP. {$nip}\r\n\t</td></tr>\r\n\t</table>\r\n\t";
}

function printjudul2( $judul )
{
    global $tabeljudul;
    if ( $judul != "" )
    {
        echo "\r\n\t<table width=100% {$tabelpengumuman}>\r\n\t\t<tr valign=middle>\r\n\t\t\t<td >\r\n\t\t\t\t<font  style='font-size:10pt;font-family: Arial;'><b>{$judul}</b></font>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
    }
}

function printfooter( )
{
    global $root;
    global $tabelisian3;
    global $versi;
    global $namaprogram;
    include( $root."tampilan/footer.php" );
    mysqli_close($koneksi );
}

function printjudulmenulama( $judul, $idbantuan = "", $ikon = "" )
{
    global $root;
    global $CSS_IKON_FOLDER;
    echo "\r\n\t<div id=\"pageName\">\r\n\t <table  >\r\n\t <tr>\r\n\t <td>\r\n    <h2 class='judulmenu'>".strtoupper( $judul )." </h2>\r\n    ";
    if ( $idbantuan != "" )
    {
        echo "\r\n      </td><td align=right>\r\n        <a href=# onclick=\"showhide('{$idbantuan}');\">\r\n        <img src='".$root."/".$CSS_IKON_FOLDER."tanya.png' height=30 border=0>\r\n        </a>\r\n      ";
    }
    echo "\r\n    </td></tr>\r\n    </table>\r\n\t\t</div>\r\n\t";
}

function printhelp( $string, $id = "bantuan", $display = "" )
{
    if ( $display == "" )
    {
        $disp = "style='display:none;'";
    }
    echo "\r\n  <div id='{$id}' {$disp}>\r\n  <table class=form cellpadding=4 cellspacing=2 width=95% border=1 style='background-color:#DDFFDD;'>\r\n    <tr>\r\n      <td>".nl2br( $string )."</td>\r\n    </tr>\r\n  </table>\r\n  <br>\r\n  </div>\r\n";
}

function printmesgcetak( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "\r\n\t<p class='printerrmesg'>\r\n\t{$errmesg}\r\n\t</p>\r\n\t";
    }
}

function printmenu( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    global $JUDULFAKULTAS;
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    global $jenisusers;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id='menu' >\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<ul  >\r\n  \t\t\t\t\t<li>\r\n    \t\t\t\t\t <h2>{$vv}</h2> \r\n                <ul>\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = FALSE;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = TRUE;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $tmpx .= " <li> <a     href='../{$v['href']}'>{$v['Judul']} </a>";
                unset( $arraysubmenu );
                $filesubmenu = "../".str_replace( "index.php", "", $v[href] )."/submenu.php";
                $dirsubmenu = "../".str_replace( "index.php", "", $v[href] )."";
                if ( file_exists( $filesubmenu ) )
                {
                    include( "../".str_replace( "index.php", "", $v[href] )."/submenu.php" );
                    if ( is_array( $arraysubmenu ) )
                    {
                        $tmpx .= " <ul> ";
                        foreach ( $arraysubmenu as $k => $v )
                        {
                            if ( $v[t] == "T" && $tingkataksesusers[$kodemenu] != "T" )
                            {
                            }
                            else if ( $v[href] != "" )
                            {
                                $tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
                            }
                        }
                        $tmpx .= " </ul> ";
                    }
                }
                $tmpx .= " </li> ";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n      \t\t</ul>\r\n     \t\t</li>\r\n     \t\t</ul>\r\n     \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n </div>\r\n <!--globalnav -->\r\n\t";
    echo $tmp;
}

function printmenulama( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id=\"globalNav\" >\r\n\t\t\t\t\t<table width=100% cellpadding=0 cellspacing=0>\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<tr height=18 {$kelas} valign=middle id=globallink  >\r\n\t\t\t\t\t<td  nowrap class=\"glinktd\">\r\n\t\t\t\t\t<b>{$vv}</b>\r\n\t\t\t\t\t</td><td nowrap >\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = FALSE;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = TRUE;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $br = "&nbsp;";
                $tkiri = "<font style='font-size:8px'> {$br} [</font>";
                $tkanan = "<font style='font-size:8px'>]</font>";
                $reg = str_replace( "?", "\\?", $v[href] );
                if ( ereg_sikad( "({$reg})", $REQUEST_URI ) )
                {
                    $ta = "style='color:#ee2222'";
                    $b = "<b>";
                    $tb = "</b>";
                }
                $tmpx .= "<a class=glink {$ta} href='../{$v['href']}'>\r\n\t\t\t\t\t\t\t{$v['Judul']} </a>";
                $t = "";
                $ta = "";
                $td = "";
                $b = "";
                $tb = "";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n\t\t</td>\r\n \t\t</tr>\r\n \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n</table> \r\n</div><!--globalnav -->\r\n\t";
    echo $tmp;
}

function printhtml( )
{
    global $style;
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body>\r\n \t";
}

function printhtmlcetak( )
{
    global $root;
    include( $root."css/printstyle.inc" );
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body class=cetak>\r\n \t";
}

function kelas( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenap";
    }
    else
    {
        $kelas = " class=dataganjil";
    }
    return $kelas;
}

function kelasmenu( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapmenu";
    }
    else
    {
        $kelas = " class=dataganjilmenu";
    }
    return $kelas;
}

function kelassm( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapsm";
    }
    else
    {
        $kelas = " class=dataganjilsm";
    }
    return $kelas;
}

function createform( $nama, $metod, $action, $attr )
{
    $tmp = "\r\n\t\t<form method='{$metod}' name='{$nama}' action='{$action}' {$attr}>\r\n\t\t\t<--isi-->\r\n\t\t</form>\r\n\t";
    return $tmp;
}

function createinputhidden( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=hidden name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputtext( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=text name=\"{$nama}\" value=\"{$value}\" {$attr} >\r\n\t";
    return $tmp;
}

function createinputtextarea( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<textarea name='{$nama}'  {$attr}>{$value}</textarea>\r\n\t";
    return $tmp;
}

function createinputpassword( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=password name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputcek( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=checkbox name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputcekarray( $nama, $tabelvalue, $tabelkey, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( @in_array( @$k, @$tabelkey ) )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name={$nama}"."[{$k}] type=checkbox value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

function createinputradio( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=radio name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputradioarray( $nama, $tabelvalue, $key, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( $k == $key )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name='{$nama}' type=radio value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

/*function createinputselect( $nama, $tabelvalue, $key, $multiple, $attr )
{
	#echo $nama."ll".$tabelvalue."zzz".$key."".$multiple."".$attr."VV".$multiple;
	#echo "LALA".trim($multiple);
	#print_r($tabelvalue);
    $tmp = "<select name='$nama' $attr $multiple>";
    foreach ( $tabelvalue as $k => $v )
    {
		#echo $key."MM".$k."LL".$key;
       /* if ( $key == $k && trim( $multiple ) != "multiple" )
        {
            $cek = "selected";
        }
        #elseif (in_array( $k, $key ) && trim( $multiple ) == "multiple" )
		elseif (trim( $multiple ) == "multiple" )
        {
            $cek = "selected";
        
		}else{
			
			$cek = "";
        
		}*/
		/*if ($key==$k && trim($multiple)!="multiple") {
				$cek="selected";
			} elseif ((@in_array($k,$key) && trim($multiple)=="multiple")) {
				$cek="selected";
			}

        $tmp .= "\r\n\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t";
        $cek = "";
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}*/

function createinputselect($nama,$tabelvalue,$key,$multiple,$attr) {
	$tmp ="
		<select name='$nama' $attr $multiple>";
		foreach ($tabelvalue as $k=>$v) {
			if ($key==$k && trim($multiple)!="multiple") {
				$cek="selected";
			} elseif ((@in_array($k,$key) && trim($multiple)=="multiple")) {
				$cek="selected";
			}
			$tmp.= "
			<option value='$k' $cek>$v</option>
			";
			$cek="";
		}
	$tmp.="
		</select>
	";
	return $tmp;
}


function createinputtanggalblank( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n\t\t<option value='' >tgl</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n\t\t<option value='' >bln</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n\t\t<option value='' >thn</option>\r\n\t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputbulantahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
	while ( $i <= $waktu[year] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    /*do
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    } while ( 1 );*/
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtanggalbulan( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mday] == $i && @$value[tgl] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select> \r\n\t";
    return $tmp;
}

function createinputtanggal( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( @$value[tgl] == $i && @$value[tgl] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu['mday'] == $i && @$value[tgl] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( @$value[bln] == $i && @$value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu['mon'] == $i && @$value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
    while ( $i <= $waktu['year'] + 5 )
    {
        if ( @$value[thn] == $i && @$value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu['year'] == $i && @$value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahunajaran( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputjam( $nama, $value, $isdetik, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[jam]' {$attr}>";
    $i = 0;
    while ( $i <= 23 )
    {
        if ( $value[jam] == $i && $value[jam] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[hours] == $i && $value[jam] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[mnt]' {$attr}>";
    $i = 0;
    while ( $i <= 59 )
    {
        if ( $value[mnt] == $i && $value[mnt] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[minutes] == $i && $value[mnt] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    if ( $isdetik != "" )
    {
        $tmp .= "\r\n\t\t\t<select name='".$nama."[dtk]' {$attr}>\r\n\t\t\t";
        $i = 0;
        while ( $i <= 59 )
        {
            if ( $value[dtk] == $i && $value[dtk] != "" )
            {
                $cek = "selected";
            }
            else if ( $waktu[seconds] == $i && $value[dtk] == "" )
            {
                $cek = "selected";
            }
            $tmp .= "\r\n\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t";
            $cek = "";
            ++$i;
        }
        $tmp .= "\r\n\t\t\t</select>\r\n\t\t";
    }
    else
    {
        $tmp .= "00\r\n\t\t\t<input type=hidden name='".$nama."[dtk]' value=0>\r\n\t\t";
    }
    return $tmp;
}

function printdemo( )
{
    echo "\r\n\t<table class=form>\r\n\t\t<tr align=center>\r\n\t\t\t<td>\r\n\t\t\t\tTerima Kasih telah menggunakan SITU versi Demo.  <br>\r\n\t\t\t\tUntuk fitur yang lebih lengkap, silakan membeli versi asli dari SITU.\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
}

periksaroot( );
?>
