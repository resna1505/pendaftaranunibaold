<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$w = getdate( time( ) );
$konfigc = file( $root."cadangan/konfig" );
$dirc = trim( $konfigc[0] );
if ( trim( $konfigc[1] ) == "M" )
{
    $idhari = trim( $konfigc[2] );
}
else
{
    $idhari = $w[wday];
}
$cwd = getcwd( );
if ( $w[wday] == $idhari && isset( $WINDIR ) )
{
    $dirc = str_replace( "\\\\", "\\", $dirc )."\\";
    if ( !file_exists( $dirc ) )
    {
        @exec( @"mkdir {$dirc} " );
    }
    include_once( $root."cadangan/zip.lib.php" );
    $filebackup = $dirc.$basisdatasql."_{$w['year']}_{$w['mon']}_{$w['mday']}".".sql.zip";
    $namacadangan = $basisdatasql."_{$w['year']}_{$w['mon']}_{$w['mday']}";
    $strfile = "";
    if ( 0 )
    {
        include( $root."cadangan/fungsi.php" );
        $what = "data";
        $crlf = "\r\n";
        $tables = mysql_list_tables( $basisdatasql );
        $num_tables = @mysql_numrows( @$tables );
        if ( $num_tables == 0 )
        {
            echo $strNoTablesFound;
        }
        else
        {
            $i = 0;
            $strfile .= "# Nama Basis Data : {$basisdatasql} {$crlf}";
            $strfile .= "# Tanggal Pembuatan : {$waktu['mday']}-{$waktu['mon']}-{$waktu['year']}{$crlf}";
            $strfile .= "# Jam Pembuatan : {$waktu['hours']}:{$waktu['minutes']}:{$waktu['seconds']}{$crlf}";
            $strfile .= "# ID Pembuat : {$users} {$crlf}";
            while ( $i < $num_tables )
            {
                $table = mysql_tablename( $tables, $i );
                $strfile .= $crlf;
                $strfile .= "# --------------------------------------------------------{$crlf}";
                $strfile .= "#{$crlf}";
                $strfile .= "#{$crlf}";
                $strfile .= $crlf;
                $strfile .= get_table_def( $basisdatasql, $table, $crlf ).";{$crlf}{$crlf}";
                if ( $what == "data" )
                {
                    get_table_content( $basisdatasql, $table );
                    $strfile .= "#{$crlf}";
                    $strfile .= "# {$strDumpingData} '{$table}'{$crlf}";
                    $strfile .= "#{$crlf}";
                    $strfile .= $crlf;
                }
                ++$i;
            }
            $zip = new zipfile( );
            $zip->addFile( $strfile, "{$namacadangan}.sql.txt" );
            $zipcontent = $zip->file( );
            if ( $f = fopen( "{$filebackup}", "w" ) )
            {
                fwrite( $f, $zipcontent );
                fclose( $f );
            }
        }
    }
}
?>
