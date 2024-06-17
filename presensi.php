<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $REQUEST_METHOD != POST )
{
    exit( );
}
include( "header.php" );
if ( !( ereg_sikad( "1", $caraisidh ) || ereg_sikad( "2", $caraisidh ) ) )
{
    exit( );
}
if ( $kodedaftarhadir != $kodeharian )
{
    exit( );
}
if ( $iduser == "superadmin" )
{
    mysqli_close($koneksi );
    Header( "Location:index.php?err=admin&iduser={$iduser}" );
}
$w = getdate( time( ) );
$jam = ( $w[hours] < 10 ? "0".$w[hours] : $w[hours] ).":".( $w[minutes] < 10 ? "0".$w[minutes] : $w[minutes] ).":".( $w[seconds] < 10 ? "0".$w[seconds] : $w[seconds] );
$idusr = rawurlencode( $iduser );
$query = "SELECT \r\nHOUR(JAMDATANG) AS JD,\r\nMINUTE(JAMDATANG) AS MD,\r\nSECOND(JAMDATANG) AS SD\r\nFROM presensi WHERE IDUSER='{$iduser}' AND \r\nTANGGAL<NOW()\r\nAND JAMDATANG IS NOT NULL \r\n ORDER BY TANGGAL DESC LIMIT 0,1";
$hasil = mysqli_query($koneksi,$query);
$d = sqlfetcharray( $hasil );
$jamdatangkemarin = jamtodetik( $d[JD], $d[MD], $d[SD] );
$query = "SELECT \r\nHOUR(JAMPULANG) AS JP,\r\nMINUTE(JAMPULANG) AS MP,\r\nSECOND(JAMPULANG) AS SP\r\nFROM presensi WHERE IDUSER='{$iduser}' AND \r\nTANGGAL<NOW()\r\nAND JAMPULANG IS NOT NULL \r\n ORDER BY TANGGAL DESC LIMIT 0,1";
$hasil = mysqli_query($koneksi,$query);
$d = sqlfetcharray( $hasil );
$jampulangkemarin = jamtodetik( $d[JP], $d[MP], $d[SP] );
$hpindah = 0;
if ( $pindahhari == true )
{
    $hpindah = 0 - 1;
}
if ( trim( $aksiterlambat ) == "Isi" )
{
    if ( $status == "telatsekali" )
    {
        $query = "INSERT INTO presensi VALUES\r\n\t\t\t('{$iduser}',NOW(),NOW(),NULL,'TS',NULL,'{$ket}',NULL,'".getasal( )."',\r\n\t\t\tNULL,{$idlokasikantor},'{$shift}',0,'',0,NULL,NULL,0,NULL,NULL,NULL)";
        mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) == 1 )
        {
            if ( cekisidatang( "{$iduser}" ) == true )
            {
                mysqli_close($koneksi );
                Header( "Location:index.php?err=datangtelat&iduser={$idusr}" );
            }
            else
            {
                mysqli_close($koneksi );
                Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
            }
        }
        else
        {
            mysqli_close($koneksi );
            Header( "Location:index.php?err=keterangangagal&iduser={$idusr}" );
        }
    }
    else
    {
        $query = "UPDATE presensi SET KETDATANG='{$ket}',ASALDATANG='".getasal( )."' \r\n\t\t\tWHERE IDUSER='{$iduser}' AND TANGGAL=NOW()";
        mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) == 1 )
        {
            if ( cekisidatang( "{$iduser}" ) == true )
            {
                mysqli_close($koneksi );
                Header( "Location:index.php?err=datangbatastoleransi&iduser={$idusr}" );
            }
            else
            {
                mysqli_close($koneksi );
                Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
            }
        }
        else
        {
            mysqli_close($koneksi );
            Header( "Location:index.php?err=keterangangagal&iduser={$idusr}" );
        }
    }
}
if ( trim( $aksipulangcepat ) == "Isi" )
{
    $query = "UPDATE presensi SET KETPULANG='{$ket}', STATUSPULANG='{$alasan}',ASALPULANG='".getasal( )."'\r\n\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
    mysqli_query($koneksi,$query);
    if ( sqlaffectedrows( $koneksi ) == 1 )
    {
        if ( cekisipulang( "{$iduser}", $pindahhari ) == true )
        {
            mysqli_close($koneksi );
            Header( "Location:index.php?err=pulangcepat&alasan={$alasan}&iduser={$idusr}" );
        }
        else
        {
            mysqli_close($koneksi );
            Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
        }
    }
    else
    {
        mysqli_close($koneksi );
        Header( "Location:index.php?err=keterangangagal&iduser={$idusr}" );
    }
}
else if ( trim( $aksipulangcepat ) == "Batal" )
{
    $query = "UPDATE presensi SET KETPULANG=NULL, STATUSPULANG=NULL, JAMPULANG = NULL,ASALPULANG=''\r\n\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
    mysqli_query($koneksi,$query);
    mysqli_close($koneksi );
    Header( "Location:index.php" );
}
if ( $aksi == "isipresensi" )
{
    if ( $iduser == "" )
    {
        mysqli_close($koneksi );
        Header( "Location:index.php?err=noid" );
    }
    else
    {
        if ( $pass == "" )
        {
            mysqli_close($koneksi );
            Header( "Location:index.php?err=nopass" );
        }
        else
        {
            $iduser = str_replace( "'", "\\'", $iduser );
            $pass = str_replace( "'", "\\'", $pass );
            $wnow = getdate( time( ) );
            $query = "SELECT NAMA,SHIFT FROM user WHERE ID='{$iduser}' AND PASSWORD=PASSWORD('{$pass}') AND ID!='superadmin'  AND STATUSKERJA=0";
            $hasil = mysqli_query($koneksi,$query);
            if ( sqlnumrows( $hasil ) == 0 )
            {
                mysqli_close($koneksi );
                Header( "Location:index.php?err=nouser&iduser={$iduser}" );
            }
            else
            {
                $datauser = sqlfetcharray( $hasil );
                $libur = true;
                if ( $datauser[SHIFT] == 255 )
                {
                    $shift = $datauser[SHIFT];
                    $libur = false;
                }
                else
                {
                    $shift = $datauser[SHIFT];
                }
                if ( $datauser[SHIFT] == 255 )
                {
                    $libur = false;
                }
                else
                {
                    $query = "SELECT KET FROM libur WHERE \r\n\t\t\t\t\tDAYOFMONTH(TGLLIBUR)={$wnow['mday']} AND\r\n\t\t\t\t\tMONTH(TGLLIBUR)={$wnow['mon']} AND\r\n\t\t\t\t\tYEAR(TGLLIBUR)={$wnow['year']}";
                    $hasil = mysqli_query($koneksi,$query);
                    if ( sqlnumrows( $hasil ) < 1 )
                    {
                        $query = "SELECT \r\n\t\t\t\t\t\t\tHARIKERJA \r\n\t\t\t\t\t\t\tFROM shift WHERE ID='{$shift}'";
                        $hasil = mysqli_query($koneksi,$query);
                        $data = sqlfetcharray( $hasil );
                        $harikerja = explode( " ", $data[HARIKERJA] );
                        if ( in_array( "{$wnow['wday']}", $harikerja ) )
                        {
                            $libur = false;
                        }
                    }
                }
                if ( $libur == true )
                {
                    mysqli_close($koneksi );
                    Header( "Location:index.php?err=liburs&iduser={$idusr}" );
                }
                else
                {
                    if ( $w[wday] == 5 )
                    {
                        $dua = "5";
                    }
                    else if ( $w[wday] == 6 )
                    {
                        $dua = "6";
                    }
                    else if ( $w[wday] == 0 )
                    {
                        $dua = "7";
                    }
                    else if ( $w[wday] == 4 )
                    {
                        $dua = "4";
                    }
                    else if ( $w[wday] == 3 )
                    {
                        $dua = "3";
                    }
                    else if ( $w[wday] == 2 )
                    {
                        $dua = "2";
                    }
                    $query = "SELECT \r\n\t\t\t\t\t\tHOUR(JAMPULANG{$dua}) AS JMPULANG,  MINUTE(JAMPULANG{$dua}) AS MNTPULANG, SECOND(JAMPULANG{$dua}) AS DTKPULANG,\r\n\t\t\t\t\t\tHOUR(JAMDATANG{$dua}) AS JMDATANG,  MINUTE(JAMDATANG{$dua}) AS MNTDATANG, SECOND(JAMDATANG{$dua}) AS DTKDATANG,\r\n\t\t\t\t\t\t TOLERANSI \r\n\t\t\t\t\t\tFROM shift WHERE ID='{$shift}'";
                    $hasil = mysqli_query($koneksi,$query);
                    $data = sqlfetcharray( $hasil );
                    $wdatang = Mktime( $data[JMDATANG], $data[MNTDATANG], $data[DTKDATANG] );
                    $now = Mktime( );
                    $mnttoleran = ( $data[TOLERANSI] + $wnow[minutes] ) % 60;
                    $jamtoleran = $wnow[hours] + ( $data[TOLERANSI] + $wnow[minutes] ) / 60;
                    settype( $jamtoleran, "integer" );
                    $wtoleran = Mktime( $data[JMDATANG], $data[MNTDATANG] + $data[TOLERANSI], $data[DTKDATANG] );
                    $wtoleranawal = Mktime( $data[JMDATANG], $data[MNTDATANG] + $data[TOLERANSI] / 2, $data[DTKDATANG] );
                    $wpulang = Mktime( $data[JMPULANG], $data[MNTPULANG], $data[DTKPULANG] );
                    $pindahhari = false;
                    $hpindah = 0;
                    if ( $wpulang < $wdatang )
                    {
                        $pindahhari = true;
                        if ( $pilihan == "pulang" )
                        {
                            $hpindah = 0 - 1;
                        }
                    }
                    if ( $pilihan == "datang" )
                    {
                        if ( ereg_sikad( "1", $caraisidhdatang ) )
                        {
                            $q = "SELECT COUNT(IDUSER) AS JML FROM jadwalp\r\n\t\t\t\t\t\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
                            $hasil2 = mysqli_query($koneksi,$q);
                            $dt = sqlfetcharray( $hasil2 );
                            if ( $dt[JML] < 1 )
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php?err=belumisijadwal&iduser={$idusr}&pindahhari={$pindahhari}" );
                                exit( );
                            }
                        }
                        $query = "SELECT IDUSER,JAMDATANG,STATUSDATANG,JAMPULANG, \r\n\t\t\t\t\t\tHOUR(JAMDATANG) AS JMDATANG,  MINUTE(JAMDATANG) AS MNTDATANG, \r\n\t\t\t\t\t\tSECOND(JAMDATANG) AS DTKDATANG\r\n\t\t\t\t\t\r\n\t\t\t\t\t\tFROM presensi WHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\tTANGGAL=DATE_ADD('{$wnow['year']}-{$wnow['mon']}-{$wnow['mday']}',\r\n\t\t\t\t\t\tINTERVAL {$hpindah} DAY)";
                        $hasil = mysqli_query($koneksi,$query);
                        if ( sqlnumrows( $hasil ) == 0 )
                        {
                            if ( abs( $jamdatangkemarin - jamtodetik( $w[hours], $w[minutes], $w[seconds] ) ) < 5 )
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php" );
                                exit( );
                            }
                            if ( $now <= $wdatang || $datauser[SHIFT] == 255 )
                            {
                                $query = "INSERT INTO presensi VALUES\r\n\t\t\t\t\t\t\t\t\t('{$iduser}',NOW(),NOW(),NULL,'N',NULL,NULL,NULL,\r\n\t\t\t\t\t\t\t\t\t'".getasal( )."',NULL,'{$idlokasikantor}','{$datauser['SHIFT']}',0,'',0,NULL,NULL\r\n\t\t\t\t\t\t\t\t\t,0,NULL,NULL,NULL)";
                                mysqli_query($koneksi,$query);
                                if ( 0 < sqlaffectedrows( $koneksi ) )
                                {
                                    mysqli_close($koneksi );
                                    Header( "Location:index.php?err=datangtepatwaktu&iduser={$idusr}&jam={$jam}" );
                                    return 1;
                                    mysqli_close($koneksi );
                                    Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                }
                                else
                                {
                                    mysqli_close($koneksi );
                                    Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                }
                            }
                            else
                            {
                                if ( $now <= $wtoleranawal )
                                {
                                    $toleran = "awal";
                                    $query = "INSERT INTO presensi VALUES\r\n\t\t\t\t\t\t\t\t\t('{$iduser}',NOW(),NOW(),NULL,'T',NULL,NULL,NULL,'".getasal( )."',\r\n\t\t\t\t\t\t\t\t\tNULL,'{$idlokasikantor}','{$shift}',0,'',0,NULL,NULL,0,NULL,NULL,NULL)";
                                    mysqli_query($koneksi,$query);
                                    if ( 0 < sqlaffectedrows( $koneksi ) )
                                    {
                                        if ( cekisidatang( "{$iduser}" ) == true )
                                        {
                                            include( "formketerangan.php" );
                                        }
                                        else
                                        {
                                            mysqli_close($koneksi );
                                            Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                        }
                                    }
                                    else
                                    {
                                        mysqli_close($koneksi );
                                        Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                    }
                                }
                                else
                                {
                                    if ( $now <= $wtoleran )
                                    {
                                        $toleran = "akhir";
                                        $query = "INSERT INTO presensi VALUES\r\n\t\t\t\t\t\t\t\t\t('{$iduser}',NOW(),NOW(),NULL,'T',NULL,NULL,NULL,\r\n\t\t\t\t\t\t\t\t\t'".getasal( )."',NULL,'{$idlokasikantor}','{$shift}',0,'',0,NULL,NULL\r\n\t\t\t\t\t\t\t\t\t,0,NULL,NULL,NULL)";
                                        mysqli_query($koneksi,$query);
                                        if ( 0 < sqlaffectedrows( $koneksi ) )
                                        {
                                            if ( cekisidatang( "{$iduser}" ) == true )
                                            {
                                                include( "formketerangan.php" );
                                            }
                                            else
                                            {
                                                mysqli_close($koneksi );
                                                Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                            }
                                        }
                                        else
                                        {
                                            mysqli_close($koneksi );
                                            Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                        }
                                    }
                                    else
                                    {
                                        if ( $wtoleran < $now )
                                        {
                                            $status = "telatsekali";
                                            include( "formketerangan.php" );
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            $d = sqlfetcharray( $hasil );
                            if ( $d[JAMDATANG] == "" )
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php?err=tidakhadir&iduser={$idusr}" );
                            }
                            else
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php?err=sudahabsen&iduser={$idusr}" );
                            }
                        }
                    }
                    else
                    {
                        if ( $pilihan == "pulang" )
                        {
                            $query = "SELECT DATE_FORMAT(TANGGAL,'%Y-%m-%d') AS TGL,\r\n\t\t\t\t\t\tDATE_FORMAT(NOW(),'%Y-%m-%d') AS TGLNOW, \r\n\t\t\t\t\t\tIDUSER,JAMDATANG,STATUSDATANG,JAMPULANG, \r\n\t\t\t\t\t\tHOUR(JAMDATANG) AS JMDATANG,  MINUTE(JAMDATANG) \r\n\t\t\t\t\t\tAS MNTDATANG, SECOND(JAMDATANG) AS DTKDATANG\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\tFROM presensi WHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\t(\r\n\t\t\t\t\t\t\tTANGGAL=NOW() OR \r\n\t\t\t\t\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL -1 DAY)\r\n\t\t\t\t\t\t) ORDER BY TANGGAL DESC LIMIT 0,1";
                            $hasil = mysqli_query($koneksi,$query);
                            if ( 0 < sqlnumrows( $hasil ) )
                            {
                                $data = sqlfetcharray( $hasil );
                            }
                            if ( $datauser[SHIFT] == 255 && $data[TGL] != $data[TGLNOW] )
                            {
                                $pindahhari = true;
                                $hpindah = 0 - 1;
                            }
                            if ( ereg_sikad( "1", $caraisidhpulang ) )
                            {
                                $q = "SELECT COUNT(IDUSER) AS JML FROM kegiatan\r\n\t\t\t\t\t\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
                                $hasil2 = mysqli_query($koneksi,$q);
                                $dt = sqlfetcharray( $hasil2 );
                                if ( $dt[JML] < 1 )
                                {
                                    mysqli_close($koneksi );
                                    Header( "Location:index.php?err=belumisikegiatan&iduser={$idusr}&pindahhari={$pindahhari}" );
                                    exit( );
                                }
                            }
                            if ( abs( $jampulangkemarin - jamtodetik( $w[hours], $w[minutes], $w[seconds] ) ) < 5 )
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php" );
                            }
                            if ( sqlnumrows( $hasil ) == 1 && $data[TGL] == $data[TGLNOW] )
                            {
                                if ( $data[JAMPULANG] != "" )
                                {
                                    mysqli_close($koneksi );
                                    Header( "Location:index.php?err=sudahabsenpulang&iduser={$idusr}&pindahhari={$pindahhari}" );
                                }
                                else
                                {
                                    if ( $wpulang <= $now || $datauser[SHIFT] == 255 )
                                    {
                                        if ( $data[STATUSDATANG] == "N" || $datauser[SHIFT] == 255 )
                                        {
                                            $query = "UPDATE presensi SET JAMPULANG=NOW(), STATUSPULANG='N',ASALPULANG='".getasal( )."' \r\n\t\t\t\t\t\t\t\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\t\t\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
                                            mysqli_query($koneksi,$query);
                                            if ( 0 < sqlaffectedrows( $koneksi ) )
                                            {
                                                if ( cekisipulang( "{$iduser}", $pindahhari ) == true )
                                                {
                                                    mysqli_close($koneksi );
                                                    Header( "Location:index.php?err=pulangtepatwaktu&iduser={$idusr}&pindahhari={$pindahhari}" );
                                                }
                                                else
                                                {
                                                    mysqli_close($koneksi );
                                                    Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                                }
                                            }
                                            else
                                            {
                                                mysqli_close($koneksi );
                                                Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                            }
                                        }
                                        else
                                        {
                                            $wdatanguser = Mktime( $data[JMDATANG], $data[MNTDATANG], $data[DTKDATANG] );
                                            $wkompensasi = $wdatanguser - $wdatang + Mktime( 0, 0, 0 );
                                            $wkmp = getdate( $wkompensasi );
                                            if ( 30 < $wkmp[minutes] && ( $wkmp[hours] == 0 || $wkmp[hours] == 16 && $wkmp[year] == 1969 ) || 0 < $wkmp[hours] && 1969 < $wkmp[year] )
                                            {
                                                $wkompensasi = Mktime( 0, 30, 0, 0, 0 ) - Mktime( 0, 0, 0, 0, 0 );
                                            }
                                            else
                                            {
                                                $wkompensasi -= Mktime( 0, 0, 0 );
                                            }
                                            $wkmp = getdate( $wkompensasi );
                                            if ( $wpulang + $wkompensasi < time( ) )
                                            {
                                                $query = "UPDATE presensi SET JAMPULANG=NOW(), STATUSPULANG='N',ASALPULANG='".getasal( )."'\r\n\t\t\t\t\t\t\t\t\t\t\tWHERE IDUSER='{$iduser}' AND TANGGAL=DATE_ADD('{$wnow['year']}-{$wnow['mon']}-{$wnow['mday']}',INTERVAL {$hpindah} DAY)";
                                                mysqli_query($koneksi,$query);
                                                if ( 0 < sqlaffectedrows( $koneksi ) )
                                                {
                                                    if ( cekisipulang( "{$iduser}", $pindahhari ) == true )
                                                    {
                                                        mysqli_close($koneksi );
                                                        Header( "Location:index.php?err=pulangtepatwaktu&iduser={$idusr}&pindahhari={$pindahhari}" );
                                                    }
                                                    else
                                                    {
                                                        mysqli_close($koneksi );
                                                        Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                                    }
                                                }
                                                else
                                                {
                                                    mysqli_close($koneksi );
                                                    Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                                }
                                            }
                                            else
                                            {
                                                $wkmp = getdate( $wpulang + $wkompensasi );
                                                $jam = $wkmp[hours];
                                                if ( $jam < 10 )
                                                {
                                                    $jam = "0".$jam;
                                                }
                                                $mnt = $wkmp[minutes];
                                                if ( $mnt < 10 )
                                                {
                                                    $mnt = "0".$mnt;
                                                }
                                                $dtk = $wkmp[seconds];
                                                if ( $dtk < 10 )
                                                {
                                                    $dtk = "0".$dtk;
                                                }
                                                mysqli_close($koneksi );
                                                Header( "Location:index.php?err=kompensasi&iduser={$idusr}&jam={$jam}&mnt={$mnt}&dtk={$dtk}&pindahhari={$pindahhari}" );
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ( $now < $wpulang )
                                        {
                                            $query = "UPDATE presensi SET JAMPULANG=NOW(), STATUSPULANG='C',ASALPULANG='".getasal( )."'\r\n\t\t\t\t\t\t\t\t\tWHERE IDUSER='{$iduser}' AND \r\n\t\t\t\t\t\t\t\t\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
                                            mysqli_query($koneksi,$query);
                                            if ( 0 < sqlaffectedrows( $koneksi ) )
                                            {
                                                if ( cekisipulang( "{$iduser}", $pindahhari ) == true )
                                                {
                                                    include( "formketerangan.php" );
                                                }
                                                else
                                                {
                                                    mysqli_close($koneksi );
                                                    Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                                }
                                            }
                                            else
                                            {
                                                mysqli_close($koneksi );
                                                Header( "Location:index.php?err=koneksi&iduser={$idusr}" );
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                mysqli_close($koneksi );
                                Header( "Location:index.php?err=belumabsendatang&iduser={$idusr}" );
                            }
                        }
                    }
                }
            }
        }
    }
}
?>
