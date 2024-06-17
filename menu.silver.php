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
    $arraykelompokmenu[1] = "Tata Usaha";
    $arraykelompokmenu[12] = "Keuangan";
    $arraykelompokmenu[10] = "Komunikasi";
    $arraykelompokmenu[13] = "Dikti";
}
if ( $jenisusers != 3 )
{
    $arraykelompokmenu[2] = "Sistem";
}
if ( $jenisusers == 1 )
{
    $arraymenu[201][Judul] = " Data Pribadi Dosen";
    $arraymenu[202][Judul] = " Wali Akademik";
    $arraymenu[203][Judul] = " Bimbingan Tugas Akhir";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenu[301][Judul] = " Data Pribadi Mahasiswa";
}
$arraymenu[18][Judul] = "Cadangan Basis Data";
$arraymenu[25][Judul] = "Chatting";
$arraymenu[12][Judul] = "Forum Diskusi";
$arraymenu[10][Judul] = "Password & Tampilan";
if ( $prodis == "" )
{
    $arraymenu[9][Judul] = "Data Operator";
}
$arraymenu[7][Judul] = "Pengumuman dan Info";
$arraymenu[14][Judul] = "Pesan-pesan";
$arraymenu[8][Judul] = "Data Info Sistem";
$arraymenu[13][Judul] = "Tukar File";
if ( $prodis == "" )
{
    $arraymenu[30][Judul] = " Badan Hukum/PT";
}
$arraymenu[31][Judul] = " Dosen";
$arraymenu[32][Judul] = " Mahasiswa";
$arraymenu[33][Judul] = " Kurikulum/KRS";
$arraymenu[34][Judul] = " Nilai Kuliah";
$arraymenu[39][Judul] = " Keuangan Mhs";
$arraymenu[40][Judul] = " Transaksi Lain";
$arraymenu[38][Judul] = " Referensi";
$arraymenu[777][Judul] = "Konversi DIKTI";
$arraymenu[331][Judul] = " Kurikulum/KRS";
$arraymenu[342][Judul] = " Nilai Kuliah";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[35][Judul] = " Bahan Kuliah";
    $arraymenu[101][Judul] = " Tugas Kuliah";
    $arraymenu[401][Judul] = " Bahan Kuliah SP";
    $arraymenu[402][Judul] = " Tugas Kuliah SP";
}
if ( $STEIINDONESIA != 1 )
{
    if ( $jenisusers != 3 )
    {
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    if ( $KRSONLINE == 1 )
    {
    }
}
if ( $jenisusers == 0 )
{
    $arraymenu[105][Judul] = " Cetak Kartu";
    $arraymenu[106][Judul] = " Cetak Kartu";
    $arraymenu[105][t] = "F5";
    $arraymenu[106][t] = "F5";
}
$arraymenu[X1][Judul] = "Upgrade";
$arraymenu[7][href] = "pengumuman/index.php";
$arraymenu[8][href] = "sistem/index.php";
if ( $prodis == "" )
{
    $arraymenu[9][href] = "pegawai/index.php";
}
$arraymenu[10][href] = "password/index.php";
$arraymenu[12][href] = "forum/index.php";
$arraymenu[13][href] = "file/index.php";
$arraymenu[14][href] = "pesan/index.php";
$arraymenu[18][href] = "cadangan/index.php";
$arraymenu[25][href] = "diskusi/index.php";
$arraymenu[777][href] = "dbfparser/index.php";
if ( $prodis == "" )
{
    $arraymenu[30][href] = "fakultas/index.php";
}
$arraymenu[31][href] = "dosen/index.php";
$arraymenu[32][href] = "mahasiswa/index.php";
$arraymenu[33][href] = "makul/index.php";
$arraymenu[34][href] = "nilai/index.php";
$arraymenu[38][href] = "pt/index.php";
$arraymenu[39][href] = "uangmhs/index.php";
$arraymenu[40][href] = "lain/index.php";
$arraymenu[331][href] = "makulsp/index.php";
$arraymenu[342][href] = "nilaisp/index.php";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[101][href] = "tugas/index.php";
    if ( $KRSONLINE == 1 )
    {
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[35][href] = "bahan/index.php";
    $arraymenu[401][href] = "bahansp/index.php";
    $arraymenu[402][href] = "tugassp/index.php";
}
if ( $STEIINDONESIA != 1 )
{
    if ( $jenisusers != 3 )
    {
    }
}
if ( $jenisusers == 0 )
{
    $arraymenu[105][href] = "kartu/index.php";
    $arraymenu[106][href] = "kartusp/index.php";
}
if ( $jenisusers == 1 )
{
    $arraymenu[201][href] = "dosen2/index.php";
    $arraymenu[202][href] = "mahasiswa/index.php";
    $arraymenu[203][href] = "bimbingan/index.php";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenu[301][href] = "mahasiswa2/index.php";
}
$arraymenu[X1][href] = "update/index.php";
$arraymenu[7][t] = "Z";
$arraymenu[8][t] = "A";
$arraymenu[9][t] = "A";
$arraymenu[10][t] = "";
$arraymenu[12][t] = "";
$arraymenu[13][t] = "";
$arraymenu[14][t] = "";
$arraymenu[15][t] = "K";
$arraymenu[18][t] = "X";
$arraymenu[25][t] = "";
$arraymenu[777][t] = "D";
if ( $prodis == "" )
{
    $arraymenu[30][t] = "F1";
}
$arraymenu[31][t] = "F2";
$arraymenu[32][t] = "F3";
$arraymenu[33][t] = "F4";
$arraymenu[34][t] = "F5";
$arraymenu[38][t] = "D";
$arraymenu[39][t] = "F9";
$arraymenu[40][t] = "D";
$arraymenu[331][t] = "F4";
$arraymenu[342][t] = "F5";
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[101][t] = "F6";
    if ( $KRSONLINE == 1 )
    {
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[35][t] = "F6";
    $arraymenu[401][t] = "F6";
}
if ( $STEIINDONESIA != 1 )
{
    if ( $jenisusers != 3 )
    {
    }
}
if ( $jenisusers == 1 )
{
    $arraymenu[201][t] = "";
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenu[301][t] = "";
}
$arraymenu[X1][t] = "A";
$arraymenu[7][k] = 10;
$arraymenu[8][k] = 2;
$arraymenu[9][k] = 2;
$arraymenu[10][k] = 2;
$arraymenu[12][k] = 10;
$arraymenu[13][k] = 10;
$arraymenu[14][k] = 10;
$arraymenu[15][k] = 4;
$arraymenu[18][k] = 2;
$arraymenu[25][k] = 10;
$arraymenu[777][k] = 13;
if ( $prodis == "" )
{
    $arraymenu[30][k] = 5;
}
$arraymenu[31][k] = 5;
$arraymenu[32][k] = 5;
$arraymenu[33][k] = 6;
$arraymenu[34][k] = 6;
$arraymenu[38][k] = 13;
$arraymenu[39][k] = 12;
$arraymenu[40][k] = 13;
$arraymenu[331][k] = 7;
$arraymenu[342][k] = 7;
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[101][k] = 6;
    if ( $KRSONLINE == 1 )
    {
    }
}
if ( $STEIINDONESIA != 1 )
{
    if ( $jenisusers != 3 )
    {
    }
}
if ( $jenisusers != 0 && $jenisusers != 3 )
{
    $arraymenu[35][k] = 6;
    $arraymenu[401][k] = 7;
    $arraymenu[402][k] = 7;
}
if ( $jenisusers == 1 )
{
    $arraymenu[201][k] = 5;
    $arraymenu[202][k] = 5;
    $arraymenu[203][k] = 5;
}
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $arraymenu[301][k] = 6;
}
if ( $jenisusers == 0 )
{
    $arraymenu[105][k] = 6;
    $arraymenu[106][k] = 7;
}
$arraymenu[X1][k] = 2;
if ( $jenisusers == 3 )
{
    $arraykelompokmenu[12] = "Keuangan";
    $arraymenu[399][Judul] = " Keuangan Mhs";
    $arraymenu[399][href] = "uangmhs/index.php";
    $arraymenu[399][t] = "";
    $arraymenu[399][k] = 12;
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
