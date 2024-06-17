<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$pgl = getpanggilan( $iduser );
if ( $err == "datangtepatwaktu" )
{
    if ( cekisidatang( $iduser ) == true )
    {
        $errmesg = "Terima kasih Anda datang tepat pada waktunya pada jam {$jam}. ";
    }
    else
    {
        $errmesg = "Maaf, ada kesalahan koneksi ke basis data.  Silakan isi kembali daftar hadir Anda, terima kasih.";
    }
}
else if ( $err == "kompensasi" )
{
    $errmesg = "Tadi Anda terlambat melebihi toleransi jam kedatangan. \r\n\tSebagai kompensasi, untuk hari ini Anda baru \r\n\tdiperbolehkan mengisi daftar hadir  pulang \r\n\tsetelah jam {$jam}:{$mnt}:{$dtk}. Terima kasih.";
}
else if ( $err == "belumisikegiatan" )
{
    $errmesg = "Anda belum mengisi laporan kegiatan untuk hari ini. \r\n\tSilakan isi terlebih dahulu laporan kegiatan harian, setelah itu barulah\r\n\tAnda diperbolehkan pulang. Terima kasih.";
}
else if ( $err == "belumisijadwal" )
{
    $errmesg = "Anda belum mengisi rencana/jadwal kegiatan untuk hari ini. \r\n\tSilakan isi terlebih dahulu rencana/jadwal kegiatan, setelah itu barulah\r\n\tAnda diperbolehkan mengisi daftar hadir. Terima kasih.";
}
else if ( $err == "tidakhadir" )
{
    $errmesg = "Data kehadiran Anda hari ini telah diupdate oleh bag. Kepegawaian. Anda dianggap tidak hadir karena Sakit/Izin/Dinas. Silakan konfirmasi ke Bag. Kepegawaian apabila terjadi kesalahan.";
}
else if ( $err == "pulangtepatwaktu" )
{
    if ( cekisipulang( $iduser, $pindahhari ) == true )
    {
        $errmesg = "Terima kasih Anda pulang pada waktunya";
    }
    else
    {
        $errmesg = "Maaf, ada kesalahan koneksi ke basis data.  Silakan isi kembali daftar hadir Anda, terima kasih.";
    }
}
else if ( $err == "datangbatastoleransi" )
{
    if ( cekisidatang( $iduser ) == true )
    {
        $errmesg = "Anda datang terlambat, lain kali datanglah lebih awal. Terima kasih";
    }
    else
    {
        $errmesg = "Maaf, ada kesalahan koneksi ke basis data.  Silakan isi kembali daftar hadir Anda, terima kasih.";
    }
}
else if ( $err == "datangtelat" )
{
    if ( cekisidatang( $iduser ) == true )
    {
        $errmesg = "Anda melewati batas toleransi keterlambatan shift Anda.  \r\n\t\tLain kali datanglah lebih awal. Terima kasih";
    }
    else
    {
        $errmesg = "Maaf, ada kesalahan koneksi ke basis data.  Silakan isi kembali daftar hadir Anda, terima kasih.";
    }
}
else if ( $err == "sudahabsen" )
{
    $errmesg = "Anda sudah pernah mengisi presensi kedatangan hari ini. Terima kasih";
}
else if ( $err == "sudahabsenpulang" )
{
    $errmesg = "Anda sudah pernah mengisi presensi pulang hari ini. Terima kasih";
}
else if ( $err == "belumabsendatang" )
{
    $errmesg = "Anda belum mengisi presensi kedatangan hari ini. Isi dulu presensi kedatangan. Terima kasih";
}
else if ( $err == "nouser" )
{
    $errmesg = "Maaf. ID dan Password tidak cocok. Silakan ulangi pengisian ID dan Password.  Apabila Anda lupa, silakan hubungi Administrator Anda";
}
else if ( $err == "noid" )
{
    $errmesg = "Maaf. Anda belum mengisi User ID. Silakan ulangi pengisian ID dan Password.  Apabila Anda lupa, silakan hubungi Administrator Anda";
}
else if ( $err == "nopass" )
{
    $errmesg = "Maaf. Anda belum mengisi Password. Silakan ulangi pengisian ID dan Password.  Apabila Anda lupa, silakan hubungi Administrator Anda";
}
else if ( $err == "liburs" )
{
    $errmesg = "Hari ini hari libur shift Anda. Anda tidak perlu mengisi presensi. Terima kasih";
}
else if ( $err == "libur" )
{
    $errmesg = "Hari ini hari libur '{$ket}'. Anda tidak perlu mengisi presensi. Terima kasih";
}
else if ( $err == "koneksi" )
{
    $errmesg = "Maaf, ada kesalahan koneksi ke basis data.  Silakan isi kembali daftar hadir Anda, terima kasih.";
}
else if ( $err == "keterangangagal" )
{
    $errmesg = "Data keterangan gagal disimpan. Anda datang terlambat. Lain kali datanglah lebih awal. Terima kasih";
}
else if ( $alasan == "S" )
{
    $errmesg = "Semoga lekas sembuh. Hati-hati di jalan.Terima kasih";
}
else
{
    $errmesg = "Semoga urusan Anda lekas selesai. Hati-hati di jalan.Terima kasih";
}
if ( $errmesg != "" && $pgl != "" )
{
    $errmesg = "<b> {$pgl}. ".$errmesg." </b>";
}
?>
