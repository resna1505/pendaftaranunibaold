<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "hmm";exit();
$TES = 1;
$POLTITEKNIK = 0;
if ( $POLTITEKNIK == 1 )
{
    $PENANDATANGAN_KHS = "KETUA JURUSAN";
    $namaprodikhs = "namaprodi";
    $namapimpinankhs = "namapimpinanprodi";
    $nippimpinankhs = "nippimpinanprodi";
    $KRSONLINE = 0;
    $FILEIJAZAH = "ijazahpoltek.php";
    $JUDULKHUSUSS3 = "Khusus Program Spesialist";
    $JUDULFAKULTAS = "Fakultas (Politeknik)";
}
else
{
    $PENANDATANGAN_KHS = "Ka. PRODI";
    $namaprodikhs = "namafakultas";
    $namapimpinankhs = "namapimpinanfakultas";
    $nippimpinankhs = "nippimpinanfakultas";
    $KRSONLINE = 1;
    $FILEIJAZAH = "ijazah.php";
    $JUDULKHUSUSS3 = "Khusus S3";
    $JUDULFAKULTAS = "Fakultas";
}
$NOLABELFAKULTAS = 0;
$PROSESKRS = "proseskrs.php";
$JUDULTRANSKRIP = "Transkrip Nilai";
$NOSERIIJASAH = "No. Seri Ijazah";
$FILEKHS = "proseskhs.php";
$JUDULKHS = "Kartu Hasil Studi";
$BATAM = 1;
$BIAYASKS = 0;
$BIAYASKSKULIAH = 0;
$UNIVERSITAS = "STIKES_UBUDIYAH";
$UNIVERSITAS = "UNIVERSITAS BATAM";
if ( $UNIVERSITAS == "STEI INDONESIA" )
{
    $PROSESKRS = "proseskrsstei.php";
    $FILETRANSKRIP = "prosestranskripstei.php";
    $JUDULTRANSKRIP = "TRANSKRIP HASIL BELAJAR";
    $HEADERTRANSKRIP = "headertranskripstei.php";
}
if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
{
    $JENISKELAS = 1;
    $FILEKHS = "proseskhsuntag.php";
    $HEADERKHS = "headerkhsuntag.php";
    $PROSESKRS = "proseskrsuntag.php";
    $FILEIJAZAH = "ijazahuntag.php";
    $FILETRANSKRIP = "prosestranskripuntag.php";
    $HEADERTRANSKRIP = "headertranskripuntag.php";
}
if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
{
    $FILEKHS = "proseskhsuniversitasborobudur.php";
    $HEADERKHS = "headerkhsuniversitasborobudur.php";
    $FILETRANSKRIP = "prosestranskripuniversitasborobudur.php";
    $HEADERTRANSKRIP = "headertranskripuniversitasborobudur.php";
}
if ( $UNIVERSITAS == "UNIVERSITAS BATAM" )
{
    $FILEKHS = "proseskhsuniversitasbatam.php";
    $FILEKHS2 = "proseskhsuniversitasbatam2.php";
    $HEADERKHS = "headerkhsuniversitasbatam.php";
    $JUDULKHS = 0;
    $PROSESKRS = "proseskrsuniversitasbatam.php";
    $FILEIJAZAH = "ijazahuniversitasbatam.php";
    $FILETRANSKRIP = "prosestranskripuniversitasbatam.php";
    $HEADERTRANSKRIP = "headertranskripuniversitasbatam.php";
    $KODESPP = "032";
	#$KODESPP = "002";
    $TANGGALDENDA = 14;
    $JUMLAHDENDA = 75000;
}
if ( $UNIVERSITAS == "MITRA RIA HUSADA" )
{
    $FILEKHS = "proseskhsmitrariahusada.php";
    $HEADERKHS = "headerkhsmitrariahusada.php";
    $PROSESKRS = "proseskrsmitrariahusada.php";
    $FILEIJAZAH = "ijazahmitrariahusada.php";
    $PENANDATANGAN_KHS = "PROGRAM STUDI";
    $FILETRANSKRIP = "prosestranskripmitrariahusada.php";
    $HEADERTRANSKRIP = "headertranskripmitrariahusada.php";
}
if ( $UNIVERSITAS == "UNILAK" )
{
    $FILEKHS = "proseskhsunilak.php";
    $HEADERKHS = "headerkhsunilak.php";
    $PROSESKRS = "proseskrsunilak.php";
    $FILEIJAZAH = "ijazahunilak.php";
    $FILETRANSKRIP = "prosestranskripunilak.php";
    $HEADERTRANSKRIP = "headertranskripunilak.php";
}
if ( $UNIVERSITAS == "STIKES SAMARINDA" )
{
    $FILEIJAZAH = "ijazahstikessamarinda.php";
    $FILETRANSKRIP = "prosestranskripstikessamarinda.php";
    $JUDULTRANSKRIP = "TRANSKRIP AKADEMIK<br><i>(ACADEMIC TRANSCRIPT)</i>";
    $HEADERTRANSKRIP = "headertranskripstikessamarinda.php";
    $FILEKHS = "proseskhsstikessamarinda.php";
    $HEADERKHS = "headerkhsstikessamarinda.php";
    $PROSESKRS = "proseskrssamarinda.php";
}
if ( $UNIVERSITAS == "STIKES IMANUEL" )
{
    $NOLABELFAKULTAS = 1;
    $FILEIJAZAH = "ijazahimanuel.php";
    $FILETRANSKRIP = "prosestranskripimanuel.php";
    $JUDULTRANSKRIP = "TRANSKRIP AKADEMIK";
    $NOSERIIJASAH = "Nomor: ";
    $HEADERTRANSKRIP = "headertranskripimanuel.php";
    $FILEKHS = "proseskhsimanuel.php";
    $HEADERKHS = "headerkhsimanuel.php";
    $JUDULKHS = "DAFTAR NILAI AKADEMIK";
    $KODETRANSKRIP = 1;
    $PROSESKRS = "proseskrsimanuel.php";
}
if ( $UNIVERSITAS == "STEI INDONESIA" )
{
    $PROSESKRS = "proseskrsstei.php";
    $FILETRANSKRIP = "prosestranskripstei.php";
    $JUDULTRANSKRIP = "TRANSKRIP HASIL BELAJAR";
    $HEADERTRANSKRIP = "headertranskripstei.php";
}
else if ( $UNIVERSITAS == "UMJ" )
{
    $NOLABELFAKULTAS = 1;
    $FILETRANSKRIP = "prosestranskripumj.php";
    $JUDULTRANSKRIP = "DAFTAR PRESTASI AKADEMIK MAHASISWA";
    $NOSERIIJASAH = "Nomor Seri Transkrip";
    $HEADERTRANSKRIP = "headertranskripumj.php";
    $FILEKHS = "proseskhsumj.php";
    $HEADERKHS = "headerkhsumj.php";
    $JUDULKHS = "KARTU HASIL STUDI SEMESTER";
    $KODETRANSKRIP = 1;
}
if ( $UNIVERSITAS == "UNIKAL" )
{
    $JUDULTRANSKRIP = "TRANSKRIP AKADEMIK";
    $HEADERTRANSKRIP = "headertranskripunikal.php";
    $FILEKHS = "proseskhsunikal.php";
    $HEADERKHS = "headerkhsunikal.php";
    $FILEIJAZAH = "ijazahunikal.php";
}
if ( $UNIVERSITAS == "STIKES_UBUDIYAH" )
{
    $FILETRANSKRIP = "prosestranskripstikesubudiyah.php";
    $JUDULTRANSKRIP = "TRANSKRIP NILAI";
    $HEADERTRANSKRIP = "headertranskripstikesubudiyah.php";
    $FILEKHS = "proseskhsstikesubudiyah.php";
    $FILEIJAZAH = "ijazahstikesubudiyah.php";
    $HEADERKHS = "headerkhsstikesubudiyah.php";
}
if ( $UNIVERSITAS == "STMIK_UBUDIYAH" )
{
    $FILETRANSKRIP = "prosestranskripstmikubudiyah.php";
    $JUDULTRANSKRIP = "TRANSKRIP NILAI";
    $HEADERTRANSKRIP = "headertranskripstmikubudiyah.php";
    $FILEKHS = "proseskhsstmikubudiyah.php";
    $FILEIJAZAH = "ijazahstmikubudiyah.php";
    $HEADERKHS = "headerkhsstmikubudiyah.php";
}
if ( $UNIVERSITAS == "UNM" )
{
    $FILETRANSKRIP = "prosestranskripunm.php";
    $JUDULTRANSKRIP = "LAMPIRAN IJAZAH";
    $JUDULTRANSKRIP2 = "** DAFTAR MATA KULIAH YANG TELAH DILULUSI **";
    $HEADERTRANSKRIP = "headertranskripunm.php";
}
?>
