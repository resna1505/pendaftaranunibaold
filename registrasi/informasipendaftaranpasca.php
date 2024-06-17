<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
printjudulmenu( "<b>Informasi Pendaftaran PMB Pascasarjana</b>" );

$q = "SELECT
    waktudaftarpmb.*,
    DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,
    DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,
    IF (
      CURDATE() >= waktudaftarpmb.TANGGALMULAI AND
      CURDATE() <= waktudaftarpmb.TANGGALSELESAI,
      1,
      0    
    ) AS STATUSONLINE
     FROM waktudaftarpmb 
     ORDER BY tahun DESC LIMIT 1";

    $h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi );
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $tahunupdate = $d['TAHUN'];
        $tanggalmulai = $d['TM'];
        $tanggalselesai = $d['TS'];
        $data['biaya'] = $d['BIAYA'];
        $pilihtampil = 1;
        $jadwalada = true;
        if ( $d['STATUSONLINE'] == 1 ) {
            $online = true;
        }
    }
    if ( !$jadwalada ) {
        $errmesg = "Jadwal Pendaftaran Belum Ada. Anda tidak dapat melakukan entri data.";
        printmesg($errmesg);

    } else {
        if ( !$online ) {
                $errmesg = "Maaf, pendaftaran dibuka pada tanggal {$tanggalmulai} s.d {$tanggalselesai}. Silakan melakukan pendaftaran pada tanggal tersebut. Terima kasih.";
		        printmesg($errmesg);

        } else { 
    echo "
        <table> 
            <tr>
                <td>1.</td>
                <td> Klik menu <a class='tambahcalonpasca' href='../lib/termsandconditionpasca.php'> Registrasi calon mahasiswa </a><script>
                    jQuery(document).ready(function () {
                        jQuery('a.tambahcalonpasca').colorbox();
                    });
                </script> untuk mendapatkan username dan password sebagai calon mahasiswa Universitas Batam </td>
            </tr>
            <tr>
                <td>2.</td>
                <td> Cetak Kuitansi Pembayaran untuk dibawa ke bank sebagai dokumen untuk melakukan pembayaran pendaftaran calon mahasiswa Universitas Batam </td>
            </tr>
            <tr>
                <td>3.</td>
                <td> Sertakan bukti pembayaran pendaftaran kepada petugas keuangan Universitas Batam dan Dokumen Biodata Diri kepada petugas Penerimaan Mahasiswa Baru</td>
            </tr>
            <tr>
                <td>4.</td>
                <td> Anda akan mendapatkan pemberitahuan akun anda sudah aktif melalui email</td>
            </tr>
            <tr>
                <td>5.</td>
                <td> Masuk menu <a href='http://pmb.univbatam.ac.id' target='_blank'>login calon mahasiswa</a> menggunakan username dan password yang dikirim lewat email untuk pengisian biodata dan cetak form peserta ujian setelah mendapatkan email aktivasi</td>
            </tr>
        </table>";
	}
}	
?>
