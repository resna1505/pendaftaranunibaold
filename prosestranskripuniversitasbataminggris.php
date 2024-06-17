<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\n\n.borderline {\n\tborder-bottom:1px solid black;\n\t}\n\nthead tr td{\n\tborder-top:1px solid black;\n\tborder-bottom:1px solid black;\n\t}\n\t\ntfoot td {\n\tborder-bottom:1px solid black;\n\t}\n\n</style>\n";
unset( $totalbm );
periksaroot( );
$qcuti = prepare_cuti_mahasiswa( $d[ID], "pengambilanmk" );
unset( $arraydatatranskrip2 );
if ( $penempatansemester == 1 )
{
    $fpenempatan = " pengambilanmk.SEMESTERMAKUL ";
    $fpenempatansp = " pengambilanmksp.SEMESTERMAKUL ";
    $fpenempatankonversi = " nilaikonversi.SEMESTERMAKUL ";
}
else
{
    $fpenempatan = " makul.SEMESTER ";
    $fpenempatansp = " makul.SEMESTER ";
    $fpenempatankonversi = " makul.SEMESTER ";
}
$jmlkonversi = 0;
if ( $statuspindahan == "P" )
{
    $q = "SELECT IDMAKUL,NAMAMAKUL AS NAMA,makul.JENIS, \n          {$fpenempatankonversi} SEMESTER ,BOBOT ,NILAI AS SIMBOL,nilaikonversi.SKS\n          FROM nilaikonversi,makul\n          WHERE\n          nilaikonversi.IDMAKUL=makul.ID\n          AND IDMAHASISWA='{$d['ID']}'\n          ORDER BY SEMESTERMAKUL,IDMAKUL";
    $hn2 = mysqli_query($koneksi,$q);
    $jumlahmakuldiambil += sqlnumrows( $hn2 );
    if ( 0 < sqlnumrows( $hn2 ) )
    {
        while ( $dn2 = sqlfetcharray( $hn2 ) )
        {
            $arraydatatranskrip2["{$dn2['IDMAKUL']}"] = $dn2;
            $jmlkonversi++;
        }
    }
}
$q = "\n\t\t\t\tSELECT pengambilanmk.IDMAKUL, pengambilanmk.BOBOT,pengambilanmk.NILAI,pengambilanmk.SIMBOL,\n\t\t\t\tpengambilanmk.SKSMAKUL SKS,pengambilanmk.NAMA,\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMAMAKUL,makul.JENIS,\n\t\t\t\t{$fpenempatan} SEMESTER\n\t\t\t\tFROM pengambilanmk,makul ,tbkmk,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmk.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmk.KDPSTTBKMK=mspst.KDPSTMSPST AND\n \t\t\t\tpengambilanmk.IDMAKUL=makul.ID\n    \t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \n    \t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n\t\t\t\t{$qcuti}\n\t\t\t\tORDER BY pengambilanmk.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n\t\t\t";
$hn = mysqli_query($koneksi,$q);
$jumlahmakuldiambil = sqlnumrows( $hn ) + $jmlkonversi;
while ( $d2 = sqlfetcharray( $hn ) )
{
    if ( $nilaidiambil != 1 )
    {
        if ( $arraydatatranskrip2["{$d2['IDMAKUL']}"][BOBOT] <= $d2[BOBOT] )
        {
            $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
        }
    }
    else
    {
        $arraydatatranskrip2["{$d2['IDMAKUL']}"] = $d2;
    }
}
if ( $sp == 1 )
{
    $q = "\n    \t\t\t\tSELECT   pengambilanmksp.IDMAKUL, pengambilanmksp.BOBOT,pengambilanmksp.NILAI,pengambilanmksp.SIMBOL,\n\t\t\t\t  pengambilanmksp.SKSMAKUL SKS,\n    \t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,makul.JENIS,\n    \t\t\t\t{$fpenempatansp} SEMESTER\n    \t\t\t\tFROM pengambilanmksp,makul,tbkmksp ,mspst\n\t\t\t\tWHERE \n        mspst.IDX='{$d['IDPRODI']}' AND\n        tbkmksp.KDJENTBKMK=mspst.KDJENMSPST AND\n        tbkmksp.KDPSTTBKMK=mspst.KDPSTMSPST AND\n     \t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\n    \t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \n    \t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \n    \t\t\t\tAND IDMAHASISWA='{$d['ID']}'\n    \t\t\t\tORDER BY pengambilanmksp.SEMESTERMAKUL,IDMAKUL,TAHUN ,SEMESTER \n    \t\t\t";
    $hn3 = mysqli_query($koneksi,$q);
    $bodytranskrip .= mysql_error( );
    if ( 0 < sqlnumrows( $hn3 ) )
    {
        while ( $d3 = sqlfetcharray( $hn3 ) )
        {
            if ( $nilaidiambil != 1 )
            {
                if ( $arraydatatranskrip2["{$d3['IDMAKUL']}"][BOBOT] <= $d3[BOBOT] )
                {
                    $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
                }
            }
            else
            {
                $arraydatatranskrip2["{$d3['IDMAKUL']}"] = $d3;
            }
            $jumlahmakuldiambil++;
        }
    }
}
@usort( $arraydatatranskrip2, "SortBySemester" );
unset( $arraydatatranskrip );
$arraydatatranskrip = $arraydatatranskrip2;
$jumlahmakuldiambilper2 = ceil( $jumlahmakuldiambil / 2 );
if ( 0 < $jumlahmakuldiambil )
{
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\n\t\t\t\t\t<br>\n\t\t\t\t\t<table width=95% >\n\t\t\t\t\t<tr valign=top>\n\t\t\t\t\t<td width=50% valign=top>";
    }
    $bodytranskrip .= "\n\t\t\t\t\t\n\t\t\t\t\t<table  class=borderline  width=100% border=0 cellpadding=0 cellspacing=0>\n\t\t\t\t\t <thead class=borderhead>\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center valign=top> \n\t \n\t\t\t\t\t\t\t<td align=center><b>No</td>\n\t\t\t\t\t\t\t<!-- <td align=center><b>Kode</td>-->\n\t\t\t\t\t\t\t<td align=center><b>MATA KULIAH<br>\n              <i>Courses Title</i></td>\n\t\t\t\t\t\t\t<td align=center><b>KREDIT<br>\n              <i>Credit</i></td>\n \n\t\t\t\t\t\t\t<td align=center><b>NILAI<br>\n              <i>Grade</td>\n\t\t\t\t\t\t\t<td align=center><b>ANGKA<br>\n              <i>Score</td>\n \t\t\t\t\t\t\t<td align=center><b>KxA</td>\n\t\t\t\t\t\t</tr>\n\t\t\t\t\t</thead>\n\t\t\t\t";
    $i = 1;
    $semlama = "";
    unset( $totals );
    if ( is_array( $arraydatatranskrip ) )
    {
        foreach ( $arraydatatranskrip as $k => $d2 )
        {
            if ( $aksi == "cetak" )
            {
                if ( $i == $jumlahmakuldiambilper2 + 1 )
                {
                    $bodytranskrip .= "\n\t\t\t\t\t\t\t\t</table>\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t<td valign=top>\n\t\t\t\t\t\t\t\t<table class=borderline  width=100% border=0 cellpadding=0 cellspacing=0 style='margin-left:10px;'>\n      \t\t\t\t\t <thead>\n\t\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center valign=top>\n\t\t\t\t \n\t\t\t\t\t\t\t\t\t\t<td align=center><b>No</td>\n      \t\t\t\t\t\t\t<!-- <td align=center><b>Kode</td>-->\n      \t\t\t\t\t\t\t<td align=center><b>MATA KULIAH<br>\n                    <i>Courses Title</i></td>\n      \t\t\t\t\t\t\t<td align=center><b>KREDIT<br>\n                    <i>Credit</i></td>\n       \n      \t\t\t\t\t\t\t<td align=center><b>NILAI<br>\n                    <i>Grade</td>\n      \t\t\t\t\t\t\t<td align=center><b>ANGKA<br>\n                    <i>Score</td>\n       \t\t\t\t\t\t\t<td align=center><b>KxA</td>\n\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\n\t\t\t            </thead>\t\t\t\t\t\n\t\t\t\t\t\t\t";
                }
            }
            unset( $kp );
            if ( $konversisemua == 0 )
            {
                unset( $kon );
            }
            $kelas = kelas( $i );
            unset( $d2[TAHUN] );
            unset( $d2[KELAS] );
            unset( $ddmk );
            $simbolmax = "-";
            $bobot = 0;
            $nilai = "";
            $nilai2 = 0;
            $bobot = $d2[BOBOT];
            $nilai = $d2[SIMBOL];
            $nilaiakhir = $d2[NILAI];
            $nilai2 = 0;
            $simbolmax = $nilai;
            if ( $nilaikosong == 1 || $nilai != "MD" && $nilai != "T" && $nilai != "" && $nilaikosong == 0 )
            {
                $bobots += $d2[SEMESTER];
                $totals += $d2[SEMESTER];
                $bobotsemua += $d2[SKS];
                $totalsemua += $bobot * $d2[SKS];
                $bobots2[$d2[SEMESTER]] += $d2[JENIS];
                $totals2[$d2[SEMESTER]] += $d2[JENIS];
                $totalbm += $d2[SKS] * $bobot;
            }
            else
            {
                $bobot = "";
            }
            if ( $d2[NAMA] == "" )
            {
                $d2[NAMA] = $d2[NAMAMAKUL];
            }
            $bodytranskrip .= "\n\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left valign=top>\n\t\t\t\t\t\t\t\t<td class=whiteborder >{$i}</td>\n\t\t\t\t\t\t\t\t<!-- <td>{$d2['IDMAKUL']}</td> -->\n\t\t\t\t\t\t\t\t<td  class=whiteborder ><i> {$d2['NAMA']}</i></td>\n\t\t\t\t\t\t\t\t<td class=whiteborder  align=center>{$d2['SKS']} </td>\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>{$nilai}</td>\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>".number_format_sikad( $bobot, 0 )."</td>\n  \t\t\t\t\t\t\t\t<td class=whiteborder  align=center>".number_format_sikad( $d2[SKS] * $bobot, 0 )."  </td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t";
            $i++;
        }
    }
    $bodytranskrip .= "\n\t\t\t\t\t\t<!-- \t<tr {$kelas}{$cetak}  align=left>\n\t\t\t\t\t\t\t\t<td colspan=3 align=center><b>JUMLAH</td>\n\t\t\t\t\t\t\t\t<td align=center><b>{$bobotsemua} </td>\n \n\t\t\t\t\t\t\t\t<td align=center> </td>\n \t\t\t\t\t\t\t\t<td align=center><b>".number_format_sikad( $totalbm, 0 )."</td>\n\t\t\t\t\t\t\t</tr> -->\n\t\t\t\t\t\t\t</table>";
    if ( $aksi == "cetak" )
    {
        $bodytranskrip .= "\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td colspan=2>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t";
    }
    else
    {
        $bodytranskrip .= "<TABLE>";
    }
    $catatan = "";
    if ( $bobotsemua < $d[SKSMIN] )
    {
    }
    $bodytranskrip .= "\n\t\t\t\t\t</table>\n\t\t\t\t\t<table border=0>\n\t\t\t\t\t\t<tr  align=left width=95% valign=top>\n\t\t\t\t\t\t\t<td width=77%>\n\t\t\t\t\t\t\t\t<table  width=100%>\n\t\t\t\t\t\t\t\n \t\t\t\t\t\t\t\t\t";
    if ( $d[JENIS] == 0 )
    {
        $ipkku = @$totalsemua / $bobotsemua;
        $ipkkuteks = number_format_sikad( @$totalsemua / $bobotsemua, 2 );
        $tmp = explode( ".", $ipkkuteks );
        $tmp1 = angkatoteks( $tmp[0] );
        $blkkoma = $tmp[1];
        $tmp2 = "";
        $ia = 0;
        for ( ; $ia <= strlen( $blkkoma ) - 1; $ia++ )
        {
            $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
        }
        $bodytranskrip .= "\n\t\t\t\t\t\t\t\t\t<tr><td width=25%>\n\t\t\t\t\t\t\t\t\t\t<b>IPK / <i>GPA</i></td><td><b>:  ".number_format_sikad( $totalbm, 0 )." / {$bobotsemua} = {$ipkkuteks} ({$tmp1} koma {$tmp2})<br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>";
    }
    else
    {
        if ( issudahlulus( $d[ID] ) )
        {
            $ipkku = @( @$totalsemua / $bobotsemua + @$d[IPKUAP] ) / 2;
            $ipkkuteks = number_format_sikad( @( @$totalsemua / $bobotsemua + @$d[IPKUAP] ) / 2, 2 );
        }
        else
        {
            $ipkku = @$totalsemua / $bobotsemua;
            $ipkkuteks = number_format_sikad( @$totalsemua / $bobotsemua, 2 );
        }
        $ipkku = @( @$totalsemua / $bobotsemua + @$d[IPKUAP] ) / 2;
        $tmp = explode( ".", $ipkkuteks );
        $tmp1 = angkatoteks( $tmp[0] );
        $blkkoma = $tmp[1];
        $tmp2 = "";
        $ia = 0;
        for ( ; $ia <= strlen( $blkkoma ) - 1; $ia++ )
        {
            $tmp2 .= $angka[$blkkoma[$ia] + 0]." ";
        }
        $bodytranskrip .= "\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\t<b>Indeks Prestasi Kumulatif Semester </td><td><b>:   ".number_format_sikad( @$totalsemua / $bobotsemua, 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\t<b>Indeks Prestasi Ujian AKhir Program (UAP)</td><td><b>:  ".number_format_sikad( @$d[IPKUAP], 2, ".", "," )." <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t\t\t<b>Indeks Prestasi Kumulatif </td><td><b>: {$ipkkuteks}  ({$tmp1} koma {$tmp2}) <br>\n\t\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t\t";
    }
    $predikat = "";
    if ( is_array( $konpredikat ) )
    {
        foreach ( $konpredikat as $k => $v )
        {
            if ( $v[SYARAT] <= $ipkku && $d[MASABELAJAR] <= $v[SYARATW] )
            {
                $predikat = " {$v['NAMA']} / <i>{$v['NAMA2']}</i>";
                break;
            }
        }
    }
    $bodytranskrip .= "\n\t\t\t\t\t\t\t\t<!-- \t<tr><td>\n\t\t\t\t\t\t\t\t<b>Tanggal Yudisium </td><td>:  <b>{$tglyudisium2} <br>\n\t\t\t\t\t\t\t\t\t</td></tr> -->\n\t\t\t\t\t\t\t\t\t<tr><td>\n\t\t\t\t\t\t\t\t<b>Yudisium / <i>Yudicium</i> </td><td>:  <b>{$predikat} <br>\n\t\t\t\t\t\t\t\t\t</td></tr>\n\t\t\t\t\t\t\t\t\t<tr valign=top align=left>\n\t\t\t\t\t\t\t\t\t\t<td   ><b>Judul Skripsi / <i>Title of Scripsi</i> </td> \n\t\t\t\t\t\t\t\t\t\t\t<td><b>: \n\t\t\t\t\t\t\t\t\t\t".str_replace( "\n", "<br>", $d[TA] )." </td>\n\t\t\t\t\t\t\t\t\t\t \n\t\t\t\t\t\t\t\t\t\t</tr> \n\n\t\t\t\t\t\t\t\t</table>\n\t\t\t\t\t\t\t\t</p>\n\t\t\t\t\t\t\t\t<br><br><br>\n\t\t\t\t\t\t\t\tSistem Penilaian / Grading System : A=4 B=3 C=2 D=1 E=0\n\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t<td>\n \n ";
    $footertranskrip = "";
    @include( "footertranskripuniversitasbataminggris.php" );
    $footertranskrip2 = $footertranskrip;
    $footertranskrip = "";
    $bodytranskrip .= "\n\t\t\t\t\t\t";
    $q = "UPDATE mahasiswa SET SKS='{$bobotsemua}',\n\t\t\t\t\t\tBOBOT='{$totalsemua}' \n\t\t\t\t\t\tWHERE\n\t\t\t\t\t\tID='{$d['ID']}'";
    mysqli_query($koneksi,$q);
    $bodytranskrip .= "\n \t\t\t\t\t\n \t\t\t\t\t{$footertranskrip2}\n \t\t\t\t</td>\n \t\t\t\t</tr></table>\n \t\t\t\t\t";
}
if ( $diagram == 1 )
{
    include( "../libchart/libchart.php" );
    if ( is_array( $totals ) )
    {
        $xx1 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
        mysqli_query($koneksi,$q);
        $chart = new VerticalChart( );
        foreach ( $totals as $k => $v )
        {
            $chart->addPoint( new Point( "{$k}", @$v / @$bobots[$k] ) );
        }
        $chart->setTitle( "Grafik Perkembangan IP per Semester ({$d['ID']})" );
        $chart->render( "gambardiagram/{$xx1}.png" );
        $bodytranskrip .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
    }
}
$bodytranskrip.="<br><br>";
?>
