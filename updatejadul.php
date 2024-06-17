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
        $sql[] = "ALTER TABLE `penandatangan` ADD `FILE1` BLOB NOT NULL ,\r\nADD `FILE2` BLOB NOT NULL ";
        $sql[] = "CREATE TABLE IF NOT EXISTS `penandatanganumum` (\r\n`FILE1` BLOB NOT NULL ,\r\n`FILE2` BLOB NOT NULL ,\r\n`FILE3` BLOB NOT NULL ,\r\n`FILE4` BLOB NOT NULL ,\r\n`LASTUPDATE` DATETIME NOT NULL ,\r\n`UPDATER` VARCHAR( 20 ) NOT NULL \r\n) ENGINE = MYISAM";
        $sql[] = "ALTER TABLE `penandatanganumum` ADD `ID` INT NOT NULL ";
        $sql[] = "ALTER TABLE `penandatanganumum` ADD PRIMARY KEY ( `ID` )";
        $sql[] = "INSERT INTO `penandatanganumum` \r\n(`LASTUPDATE` ,`UPDATER` ,`ID` )\r\nVALUES ('', '', '')";
        $sql[] = "\r\nALTER TABLE  `aturan` ADD  `KRSONLINE3` CHAR( 1 ) NOT NULL DEFAULT  '0'";
        $sql[] = "\r\nCREATE TABLE IF NOT EXISTS `statusbimbingan` (\r\n`IDMAHASISWA` CHAR( 20 ) NOT NULL ,\r\n`TAHUN` YEAR NOT NULL ,\r\n`SEMESTER` SMALLINT NOT NULL ,\r\n`STATUS` SMALLINT NOT NULL DEFAULT  '0',\r\n`LASTUPDATE` DATETIME NOT NULL ,\r\n`UPDATER` VARCHAR( 20 ) NOT NULL ,\r\nPRIMARY KEY (  `IDMAHASISWA` ,  `TAHUN` ,  `SEMESTER` )\r\n)  ";
        $sql[] = "\r\nCREATE  TABLE IF NOT EXISTS `statusbimbingansp` (\r\n`IDMAHASISWA` CHAR( 20 ) NOT NULL ,\r\n `TAHUN` YEAR( 4 ) NOT NULL ,\r\n `SEMESTER` SMALLINT( 6 ) NOT NULL ,\r\n `STATUS` SMALLINT( 6 ) NOT NULL DEFAULT  '0',\r\n `LASTUPDATE` DATETIME NOT NULL ,\r\n `UPDATER` VARCHAR( 20 ) NOT NULL ,\r\nPRIMARY KEY (  `IDMAHASISWA` ,  `TAHUN` ,  `SEMESTER` )\r\n)";
        $sql[] = "ALTER TABLE  `mahasiswa` ADD  `PASSWORD2` VARCHAR( 100 ) NOT NULL ";
        $sql[] = "ALTER TABLE  `mahasiswa` ADD  `STATUSLOGIN2` SMALLINT UNSIGNED NOT NULL ,\r\nADD  `LASTLOGIN2` DATETIME NOT NULL ,\r\nADD  `LASTAKSI2` DATETIME NOT NULL ,\r\nADD  `TOKEN2` VARCHAR( 100 ) NOT NULL ";
        $sql[] = "ALTER TABLE  `mahasiswa` ADD  `SISTEMKRS` SMALLINT UNSIGNED NOT NULL DEFAULT  '0'";
        $sql[] = "ALTER TABLE `tbdos` ADD PRIMARY KEY ( `NIDNNTBDOS` )";
        $sql[] = "ALTER TABLE `tbpst`\r\n    ADD PRIMARY KEY(\r\n     `KDPSTTBPST`,\r\n     `KDJENTBPST`)";
        $sql[] = "ALTER TABLE `tbpti` ADD PRIMARY KEY ( `KDPTITBPTI` ) ";
        $sql[] = "ALTER TABLE  `penandatanganumum` ADD  `FILE5` LONGBLOB NOT NULL ";
        $sql[] = "CREATE TABLE  IF NOT EXISTS `trlsd2` (\r\n`THSMSTRLSD` CHAR( 5 ) NOT NULL ,\r\n `KDPTITRLSD` CHAR( 6 ) NOT NULL ,\r\n `KDJENTRLSD` CHAR( 1 ) NOT NULL ,\r\n `KDPSTTRLSD` CHAR( 5 ) NOT NULL ,\r\n `NODOSTRLSD` CHAR( 10 ) NOT NULL ,\r\n `STDOSTRLSD` CHAR( 1 ) NOT NULL ,\r\nPRIMARY KEY (  `THSMSTRLSD` ,  `KDPTITRLSD` ,  `KDJENTRLSD` ,  `KDPSTTRLSD` ,  `NODOSTRLSD` )\r\n)";
        $sql[] = "ALTER TABLE  `trlsm` ADD  `SIMBOL` CHAR( 3 ) NOT NULL ";
        $i = 1;
        if ( is_array( $sql ) )
        {
            printjudulmenu( "Update BASISDATA SITU AKADEMIK" );
            echo "<table class=data>\r\n\t\t<tr align=center class=juduldata>\r\n\t\t\t<td>No</td>\r\n\t\t\t<td>Query</td>\r\n\t\t\t<td>Hasil</td>\r\n\t\t</tr>\r\n\t";
            foreach ( $sql as $q )
            {
                $h = mysqli_query($koneksi,$query);
                if ( $i % 2 == 0 )
                {
                    $kelas = "datagenap";
                }
                else
                {
                    $kelas = "dataganjil";
                }
                if ( mysql_error( ) != "" )
                {
                    $hasil = "Update gagal, ".mysql_error( );
                }
                else
                {
                    $hasil = "Update OK";
                }
                echo "\r\n\t\t<tr class={$kelas}>\r\n\t\t\t<td>{$i}</td>\r\n\t\t\t<td>{$q}</td>\r\n\t\t\t<td  >{$hasil}</td>\r\n\t\t</tr>";
                ++$i;
            }
        }
        echo "<p>";
        printmesg( "\r\nProses update selesai.  Silakan klik <a style='color:#4466aa' href='index.php'>disini</a> untuk menggunakan program seperti biasa\r\n" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Update Basis Data SITU AKADEMIK" );
    printmesg( $errmesg );
    echo "<p>\r\n<form method=post action=updatejadul.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengupdate basis data SITU AKADEMIK, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
