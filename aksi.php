<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"../tiny_mce/init_tiny_mce.js\"></script>\r\n";
if ( $pilihan == "bidangsoalpmb" )
{
    include( "bidangsoal.php" );
}
else if ( $pilihan == "formtambah" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "banksoalpmb.php" );
}
else if ( $pilihan == "cari" || $pilihan == "" )
{
    include( "banksoalpmb.php" );
}
else if ( $pilihan == "copy" )
{
    include( "copybanksoalpmb.php" );
}
else if ( $pilihan == "tambahoperatorbank" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "operatorbank.php" );
}
else if ( $pilihan == "lihatoperatorbank" )
{
    include( "operatorbank.php" );
}
else if ( $pilihan == "jadwalp" )
{
    include( "waktupendaftaran.php" );
}
else if ( $pilihan == "jadwalu" )
{
    include( "waktuujianpmb.php" );
}
else if ( $pilihan == "konfigmail" )
{
    include( "konfigmail.php" );
}
else if ( $pilihan == "konfigresetpassword" )
{
    include( "konfigresetpassword.php" );
}
else if ( $pilihan == "konfigpendaftaran" )
{
    include( "konfigpendaftaran.php" );
}
else if ( $pilihan == "settingwaktu" )
{
    include( "settingwaktu.php" );
}
else
{
    if ( $pilihan == "keterangan" )
    {
        include( "keterangan.php" );
    }
    else
    {
        if ( $pilihan == "konfigpengumuman" )
        {
            include( "konfigpengumuman.php" );
        }
    }
}
?>
