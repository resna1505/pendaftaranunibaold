<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
if ( $pilihan == "tambahcalon" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "operatorbank.php" );

}elseif ( $pilihan == "tambahcalonpasca" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "operatorbankpasca.php" );

}elseif ( $pilihan == "tambahcalontest" )
{
    if ( $aksi == "" )
    {
        $aksi = "formtambah";
    }
    include( "operatorbanktest.php" );

}
else{

	#	$aksi = "formtambah";
	 if ( $pilihan == "lihatcalon" )
    {
        include( "operatorbank.php" );
    }

	elseif ( $pilihan == "lihatinformasi" )
    {
      	  include( "informasipendaftaran.php" );

    }
    elseif ( $pilihan == "lihatinformasipascasarjana" )
    {
      	  include( "informasipendaftaranpasca.php" );

    }
    else
    {
        if ( $pilihan == "jadwal" || $pilihan == "" )
        {
           # include( "jadwal.php" );
		include( "informasipendaftaran.php" );

        }
    }
}
/*else
{
    if ( $pilihan == "lihatcalon" )
    {
        include( "operatorbank.php" );
    }
    else
    {
        if ( $pilihan == "jadwal" || $pilihan == "" )
        {
            include( "jadwal.php" );
        }
    }
}*/
?>
