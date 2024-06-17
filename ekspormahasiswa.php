<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
$q = "SELECT *,DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS TGLLAHIR FROM mahasiswa ORDER BY ID";
$h = mysqli_query($koneksi,$q);
while ( $d = sqlfetcharray( $h ) )
{
    $id = $d[ID];
    $nim = $d[ID];
    if ( $d[KELAMIN] == "L" )
    {
        $kelamin = 0;
    }
    else
    {
        $kelamin = 1;
    }
    $nama = $d[NAMA];
    $jabatan = "MAHASISWA";
    $prodi = $d[IDPRODI];
    $angkatan = $d[ANGKATAN];
    $tempatlahir = $d[TEMPAT];
    $tanggallahir = $d[TGLLAHIR];
    $alamatmhs = $d[ALAMAT];
    $telepon = $d[TELEPON];
    $alamatortu = $d[ALAMATAYAH];
    $jenisanggota = "MAHASISWA";
    echo "INSERT INTO anggota (ID,NAMA,JKELAMIN,TTL,ALAMAT,TELEPON,TGL_DAFTAR,TGL_AKTIF,JENIS,STATUS,NPM,PRODI,ALAMATORTU,ANGKATAN) VALUES ('{$id}','{$nama}','{$kelamin}','{$tempatlahir},{$tanggallahir}','{$alamatmhs}','{$telepon}',NOW(),NOW(),'{$jenisanggota}','normal','{$nim}','2{$prodi}','{$alamatortu}','{$angkatan}');<br>";
    echo "INSERT INTO login (LOGIN,JENIS,PASSWORD,CSS) VALUES ('{$id}','anggota',PASSWORD('{$id}'),'indexc.css');<br>";
}
?>
