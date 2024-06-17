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
        $sql['20090102'][] = "ALTER TABLE `tbkmk` \r\nADD `KDUTATBKMK` CHAR(1) NOT NULL AFTER `DIKTTTBKMK`, \r\nADD `KDKUGTBKMK` CHAR(1) NOT NULL AFTER `KDUTATBKMK`, \r\nADD `KDLAITBKMK` CHAR(1) NOT NULL AFTER `KDKUGTBKMK`, \r\nADD `KDMPATBKMK` CHAR(1) NOT NULL AFTER `KDLAITBKMK`, \r\nADD `KDMPBTBKMK` CHAR(1) NOT NULL AFTER `KDMPATBKMK`, \r\nADD `KDMPCTBKMK` CHAR(1) NOT NULL AFTER `KDMPBTBKMK`, \r\nADD `KDMPDTBKMK` CHAR(1) NOT NULL AFTER `KDMPCTBKMK`, \r\nADD `KDMPETBKMK` CHAR(1) NOT NULL AFTER `KDMPDTBKMK`, \r\nADD `KDMPFTBKMK` CHAR(1) NOT NULL AFTER `KDMPETBKMK`, \r\nADD `KDMPGTBKMK` CHAR(1) NOT NULL AFTER `KDMPFTBKMK`, \r\nADD `KDMPHTBKMK` CHAR(1) NOT NULL AFTER `KDMPGTBKMK`, \r\nADD `KDMPITBKMK` CHAR(1) NOT NULL AFTER `KDMPHTBKMK`, \r\nADD `KDMPJTBKMK` CHAR(1) NOT NULL AFTER `KDMPITBKMK`, \r\nADD `CRMKLTBKMK` CHAR(1) NOT NULL AFTER `KDMPJTBKMK`, \r\nADD `PRSTDTBKMK` CHAR(1) NOT NULL AFTER `CRMKLTBKMK`, \r\nADD `SMGDSTBKMK` CHAR(1) NOT NULL AFTER `PRSTDTBKMK`, \r\nADD `RPSIMTBKMK` CHAR(1) NOT NULL AFTER `SMGDSTBKMK`, \r\nADD `CSSTUTBKMK` CHAR(1) NOT NULL AFTER `RPSIMTBKMK`, \r\n\r\nADD `DISLNTBKMK` CHAR(1) NOT NULL AFTER `CSSTUTBKMK`, \r\nADD `SDILNTBKMK` CHAR(1) NOT NULL AFTER `DISLNTBKMK`, \r\nADD `CODLNTBKMK` CHAR(1) NOT NULL AFTER `SDILNTBKMK`, \r\nADD `COLLNTBKMK` CHAR(1) NOT NULL AFTER `CODLNTBKMK`, \r\nADD `CTXINTBKMK` CHAR(1) NOT NULL AFTER `COLLNTBKMK`, \r\n\r\nADD `PJBLNTBKMK` CHAR(1) NOT NULL AFTER `CTXINTBKMK`, \r\nADD `PBBLNTBKMK` CHAR(1) NOT NULL AFTER `PJBLNTBKMK`, \r\n\r\nADD `UJTLSTBKMK` INT NOT NULL AFTER `PBBLNTBKMK`, \r\nADD `TGMKLTBKMK` INT NOT NULL AFTER `UJTLSTBKMK`, \r\nADD `TGMODTBKMK` INT NOT NULL AFTER `TGMKLTBKMK`, \r\nADD `PSTSITBKMK` INT NOT NULL AFTER `TGMODTBKMK`, \r\nADD `SIMULTBKMK` INT NOT NULL AFTER `PSTSITBKMK`, \r\nADD `LAINNTBKMK` INT NOT NULL AFTER `SIMULTBKMK`, \r\nADD `UJTL1TBKMK` INT NOT NULL AFTER `LAINNTBKMK`, \r\nADD `TGMK1TBKMK` INT NOT NULL AFTER `UJTL1TBKMK`, \r\nADD `TGMO1TBKMK` INT NOT NULL AFTER `TGMK1TBKMK`, \r\nADD `PSTS1TBKMK` INT NOT NULL AFTER `TGMO1TBKMK`, \r\nADD `SIMU1TBKMK` INT NOT NULL AFTER `PSTS1TBKMK`, \r\nADD `LAIN1TBKMK` INT NOT NULL AFTER `SIMU1TBKMK`";
        $sql['20090102'][] = "ALTER TABLE `tbdos` ADD `KDJENTBDOS` CHAR( 1 ) NOT NULL AFTER `PTINDTBDOS` ,\r\nADD `KDPSTTBDOS` CHAR( 5 ) NOT NULL AFTER `KDJENTBDOS`";
        $sql['20090102'][] = "ALTER TABLE `tbdos` ADD `GELARTBDOS` CHAR( 10 ) NOT NULL";
        $sql['20090116'][] = "ALTER TABLE `penandatangan` ADD `FILE1` BLOB NOT NULL ,\r\nADD `FILE2` BLOB NOT NULL ";
        $sql['20090116'][] = "CREATE TABLE `penandatanganumum` (\r\n`FILE1` BLOB NOT NULL ,\r\n`FILE2` BLOB NOT NULL ,\r\n`FILE3` BLOB NOT NULL ,\r\n`FILE4` BLOB NOT NULL ,\r\n`LASTUPDATE` DATETIME NOT NULL ,\r\n`UPDATER` VARCHAR( 20 ) NOT NULL \r\n) ENGINE = MYISAM";
        $sql['20090116'][] = "ALTER TABLE `penandatanganumum` ADD `ID` INT NOT NULL ";
        $sql['20090116'][] = "ALTER TABLE `penandatanganumum` ADD PRIMARY KEY ( `ID` )";
        $sql['20090116'][] = "INSERT INTO `penandatanganumum` \r\n(`LASTUPDATE` ,`UPDATER` ,`ID` )\r\nVALUES ('', '', '')";
        $sql['20090116'][] = "ALTER TABLE `tbdos` ADD PRIMARY KEY ( `NIDNNTBDOS` )";
        $sql['20090116'][] = "ALTER TABLE `tbpst`\r\n    ADD PRIMARY KEY(\r\n     `KDPSTTBPST`,\r\n     `KDJENTBPST`)";
        $sql['20090116'][] = "ALTER TABLE `tbpti` ADD PRIMARY KEY ( `KDPTITBPTI` ) ";
        $sql['20090213'][] = "ALTER TABLE `user` ADD `SETTINGTAMPILAN` VARCHAR(200) NOT NULL DEFAULT 'MENUUTAMA=0;SUBMENU=1'";
        $sql['20090213'][] = "ALTER TABLE `mahasiswa` ADD `SETTINGTAMPILAN` VARCHAR(200) NOT NULL DEFAULT 'MENUUTAMA=0;SUBMENU=1'";
        $sql['20090213'][] = "ALTER TABLE `dosen` ADD `SETTINGTAMPILAN` VARCHAR(200) NOT NULL DEFAULT 'MENUUTAMA=0;SUBMENU=1'";
        $i = 1;
        if ( is_array( $sql ) )
        {
            printjudulmenu( "Update SITU AKADEMIK" );
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
    echo "<p>\r\n<form action=update2.php>\r\n<table class=form>\r\n<tr>\r\n<td align=center>\r\nJika anda hendak mengupdate basis data SITU AKADEMIK, silakan isi login dan password Administrator dan \r\ntekan tombol Update dan tunggu sampai selesai. Terima kasih\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n<p>\r\n<table class=form>\r\n<tr>\r\n<td class=judulform>\r\nID Administrator \r\n</td>\r\n<td>\r\n<input class=masukan type=text name=idupdate size=20>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\nPassword</td>\r\n<td>\r\n <input class=masukan type=password name=passwordupdate size=20>\r\n</td>\r\n<tr>\r\n<td colspan=2>\r\n<input class=tombol type=submit name=aksi value=Update>\r\n</td>\r\n</tr>\r\n</table>\r\n</p>\r\n</form>\r\n</center>\r\n\t\r\n\r\n";
}
echo "</p>\r\n \r\n \r\n";
?>
