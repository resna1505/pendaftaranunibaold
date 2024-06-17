<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$arraykelompokmenu[5] = "Master Akademik";
$arraykelompokmenu[6] = "Sem. Reguler";
$arraykelompokmenu[7] = "Sem. Pendek";
if ( $jenisusers == 0 )
{
    $arraykelompokmenu[11] = "PMB";
    $arraykelompokmenu[1] = "Tata Usaha";
    $arraykelompokmenu[12] = "Keuangan";
    $arraykelompokmenu[10] = "Komunikasi";
    $arraykelompokmenu[13] = "Dikti";
    $arraykelompokmenu[90] = "Executive Summary";
}
if ( $jenisusers != 3 )
{
    $arraykelompokmenu[2] = "Sistem";
}
if ( $jenisusers == 1 )
{
    $arraymenuacuan[201][Judul] = " Data Pribadi Dosen";
    $arraymenuacuan[202][Judul] = " Wali Akademik";
    $arraymenuacuan[203][Judul] = " Bimbingan Tugas Akhir";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenuacuan[301][Judul] = " Data Pribadi Mahasiswa";
}
$arraymenuacuan[111][Judul] = "Penerimaan Mhsw Baru";
$arraymenuacuan[1112][Judul] = "Ujian PMB";
$arraymenuacuan[112][Judul] = "Proses Penerimaan";
$arraymenuacuan[113][Judul] = "Daftar Ulang";
$arraymenuacuan[18][Judul] = "Perbaiki Data";
$arraymenuacuan[25][Judul] = "Chatting";
$arraymenuacuan[12][Judul] = "Forum Diskusi";
$arraymenuacuan[10][Judul] = "Password & Tampilan";
if ( $prodis == "" )
{
    $arraymenuacuan[9][Judul] = "Data Operator";
}
$arraymenuacuan[7][Judul] = "Pengumuman dan Info";
$arraymenuacuan[14][Judul] = "Pesan-pesan";
$arraymenuacuan[8][Judul] = "Data Info Sistem";
$arraymenuacuan[13][Judul] = "Tukar File";
if ( $prodis == "" )
{
    $arraymenuacuan[30][Judul] = " Badan Hukum/PT";
}
$arraymenuacuan[31][Judul] = " Dosen";
$arraymenuacuan[32][Judul] = " Mahasiswa";
$arraymenuacuan[33][Judul] = " Kurikulum/KRS";
$arraymenuacuan[34][Judul] = " Nilai Kuliah";
$arraymenuacuan[37][Judul] = " Alumni";
$arraymenuacuan[39][Judul] = " Keuangan Mhs";
$arraymenuacuan[16][Judul] = " Akunting";
$arraymenuacuan[40][Judul] = " Transaksi Lain";
$arraymenuacuan[38][Judul] = " Referensi";
$arraymenuacuan[777][Judul] = "Konversi DIKTI";
$arraymenuacuan[331][Judul] = " Kurikulum/KRS";
$arraymenuacuan[342][Judul] = " Nilai Kuliah";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[35][Judul] = " Bahan Kuliah";
    $arraymenuacuan[101][Judul] = " Tugas Kuliah";
    $arraymenuacuan[401][Judul] = " Bahan Kuliah SP";
    $arraymenuacuan[402][Judul] = " Tugas Kuliah SP";
}
if ( $STEIINDONESIA != 1 && $jenisusers != 3 )
{
    $arraymenuacuan[102][Judul] = " Jadwal Kuliah";
    $arraymenuacuan['102B'][Judul] = " Jadwal Kuliah SP";
}
$arraymenuacuan[103][Judul] = " Info (SMS)";
if ( $jenisusers != 0 && $jenisusers != 3 && $KRSONLINE == 1 )
{
    $arraymenuacuan[104][Judul] = " KRS Online";
    $arraymenuacuan[1042][Judul] = " KRS Online Semester Pendek";
}
if ( $jenisusers == 0 )
{
    $arraymenuacuan[105][Judul] = " Cetak Kartu";
    $arraymenuacuan[106][Judul] = " Cetak Kartu";
    $arraymenuacuan[9001][Judul] = "Laporan";
}
$arraymenuacuan[X1][Judul] = "Upgrade";
$arraymenuacuan[111][href] = "daftar/index.php";
$arraymenuacuan[1112][href] = "ujianpmb/index.php";
$arraymenuacuan[7][href] = "pengumuman/index.php";
$arraymenuacuan[8][href] = "sistem/index.php";
if ( $prodis == "" )
{
    $arraymenuacuan[9][href] = "pegawai/index.php";
}
$arraymenuacuan[10][href] = "password/index.php";
$arraymenuacuan[12][href] = "forum/index.php";
$arraymenuacuan[13][href] = "file/index.php";
$arraymenuacuan[14][href] = "pesan/index.php";
$arraymenuacuan[18][href] = "cadangan/index.php";
$arraymenuacuan[25][href] = "diskusi/index.php";
$arraymenuacuan[777][href] = "dbfparser/index.php";
if ( $prodis == "" )
{
    $arraymenuacuan[30][href] = "fakultas/index.php";
}
$arraymenuacuan[31][href] = "dosen/index.php";
$arraymenuacuan[32][href] = "mahasiswa/index.php";
$arraymenuacuan[33][href] = "makul/index.php";
$arraymenuacuan[34][href] = "nilai/index.php";
$arraymenuacuan[37][href] = "alumni/index.php";
$arraymenuacuan[38][href] = "pt/index.php";
$arraymenuacuan[39][href] = "uangmhs/index.php";
$arraymenuacuan[16][href] = "uang/index.php";
$arraymenuacuan[40][href] = "lain/index.php";
$arraymenuacuan[331][href] = "makulsp/index.php";
$arraymenuacuan[342][href] = "nilaisp/index.php";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[101][href] = "tugas/index.php";
    if ( $KRSONLINE == 1 )
    {
        $arraymenuacuan[104][href] = "krs/index.php";
        $arraymenuacuan[1042][href] = "krssp/index.php";
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[35][href] = "bahan/index.php";
    $arraymenuacuan[401][href] = "bahansp/index.php";
    $arraymenuacuan[402][href] = "tugassp/index.php";
}
if ( $STEIINDONESIA != 1 && $jenisusers != 3 )
{
    $arraymenuacuan[102][href] = "jadwal/index.php";
    $arraymenuacuan['102B'][href] = "jadwalsp/index.php";
}
$arraymenuacuan[103][href] = "infosms/index.php";
if ( $jenisusers == 0 )
{
    $arraymenuacuan[105][href] = "kartu/index.php";
    $arraymenuacuan[106][href] = "kartusp/index.php";
    $arraymenuacuan[9001][href] = "executive/index.php";
}
if ( $jenisusers == 1 )
{
    $arraymenuacuan[201][href] = "dosen2/index.php";
    $arraymenuacuan[202][href] = "mahasiswa/index.php";
    $arraymenuacuan[203][href] = "bimbingan/index.php";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenuacuan[301][href] = "mahasiswa2/index.php";
}
$arraymenuacuan[X1][href] = "update/index.php";
$arraymenuacuan[111][t] = "P1";
$arraymenuacuan[1112][t] = "P1";
$arraymenuacuan[7][t] = "Z";
$arraymenuacuan[8][t] = "A";
$arraymenuacuan[9][t] = "A";
$arraymenuacuan[10][t] = "";
$arraymenuacuan[12][t] = "";
$arraymenuacuan[13][t] = "";
$arraymenuacuan[14][t] = "";
$arraymenuacuan[15][t] = "K";
$arraymenuacuan[16][t] = "F9";
$arraymenuacuan[18][t] = "X";
$arraymenuacuan[25][t] = "";
$arraymenuacuan[777][t] = "D";
if ( $prodis == "" )
{
    $arraymenuacuan[30][t] = "F1";
}
$arraymenuacuan[31][t] = "F2";
$arraymenuacuan[32][t] = "F3";
$arraymenuacuan[33][t] = "F4";
$arraymenuacuan[34][t] = "F5";
$arraymenuacuan[37][t] = "F7";
$arraymenuacuan[38][t] = "D";
$arraymenuacuan[39][t] = "F9";
$arraymenuacuan[40][t] = "D";
$arraymenuacuan[105][t] = "F5";
$arraymenuacuan[106][t] = "F5";
$arraymenuacuan[331][t] = "F4";
$arraymenuacuan[342][t] = "F5";
$arraymenuacuan[9001][t] = "E";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[101][t] = "F6";
    if ( $KRSONLINE == 1 )
    {
        $arraymenuacuan[104][t] = "";
        $arraymenuacuan[1042][t] = "";
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[35][t] = "F6";
    $arraymenuacuan[401][t] = "F6";
}
if ( $STEIINDONESIA != 1 && $jenisusers != 3 )
{
    $arraymenuacuan[102][t] = "";
    $arraymenuacuan['102B'][t] = "";
}
$arraymenuacuan[103][t] = "Z";
if ( $jenisusers == 1 )
{
    $arraymenuacuan[201][t] = "";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenuacuan[301][t] = "";
}
$arraymenuacuan[X1][t] = "A";
$arraymenuacuan[111][k] = 11;
$arraymenuacuan[1112][k] = 11;
$arraymenuacuan[7][k] = 10;
$arraymenuacuan[8][k] = 2;
$arraymenuacuan[9][k] = 2;
$arraymenuacuan[10][k] = 2;
$arraymenuacuan[12][k] = 10;
$arraymenuacuan[13][k] = 10;
$arraymenuacuan[14][k] = 10;
$arraymenuacuan[15][k] = 4;
$arraymenuacuan[16][k] = 12;
$arraymenuacuan[18][k] = 2;
$arraymenuacuan[25][k] = 10;
$arraymenuacuan[777][k] = 13;
if ( $prodis == "" )
{
    $arraymenuacuan[30][k] = 5;
}
$arraymenuacuan[31][k] = 5;
$arraymenuacuan[32][k] = 5;
$arraymenuacuan[33][k] = 6;
$arraymenuacuan[34][k] = 6;
$arraymenuacuan[37][k] = 5;
$arraymenuacuan[38][k] = 13;
$arraymenuacuan[39][k] = 12;
$arraymenuacuan[40][k] = 13;
$arraymenuacuan[331][k] = 7;
$arraymenuacuan[342][k] = 7;
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[101][k] = 6;
    if ( $KRSONLINE == 1 )
    {
        $arraymenuacuan[104][k] = 6;
        $arraymenuacuan[1042][k] = 7;
    }
}
if ( $STEIINDONESIA != 1 && $jenisusers != 3 )
{
    $arraymenuacuan[102][k] = 6;
    $arraymenuacuan['102B'][k] = 7;
}
$arraymenuacuan[103][k] = 10;
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenuacuan[35][k] = 6;
    $arraymenuacuan[401][k] = 7;
    $arraymenuacuan[402][k] = 7;
}
if ( $jenisusers == 1 )
{
    $arraymenuacuan[201][k] = 5;
    $arraymenuacuan[202][k] = 5;
    $arraymenuacuan[203][k] = 5;
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenuacuan[301][k] = 6;
}
if ( $jenisusers == 0 )
{
    $arraymenuacuan[105][k] = 6;
    $arraymenuacuan[106][k] = 7;
    $arraymenuacuan[9001][k] = 90;
}
$arraymenuacuan[X1][k] = 2;
if ( $jenisusers == 3 || $jenisusers == 2 )
{
    $arraykelompokmenu[12] = "Keuangan";
    $arraymenuacuan[399][Judul] = " Keuangan Mhs";
    $arraymenuacuan[399][href] = "uangmhs/index.php";
    $arraymenuacuan[399][t] = "";
    $arraymenuacuan[399][k] = 12;
}
unset( $tingkatakses );
$tingkatakses = explode( ",", $tingkats );
unset( $tmp );
foreach ( $tingkatakses as $k => $v )
{
    $tmp2 = explode( ":", $v );
    $tmp["{$tmp2['0']}"] = $tmp2[1];
}
$tingkataksesusers = $tmp;
unset( $tmp );
?>
