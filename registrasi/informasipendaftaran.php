<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
printjudulmenu( "<b>Informasi Pendaftaran PMB</b>" );
    
#$q = "SELECT \r\n     waktudaftarpmb.*,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,\r\n      IF (\r\n        CURDATE() >= waktudaftarpmb.TANGGALMULAI AND\r\n        CURDATE() <= waktudaftarpmb.TANGGALSELESAI,\r\n        1,\r\n        0\r\n      \r\n      ) AS STATUSONLINE\r\n       FROM waktudaftarpmb  WHERE  \r\n       waktudaftarpmb.GELOMBANG = '{$gelombang}' AND \r\n       waktudaftarpmb.TAHUN = '{$tahuna}'  \r\n      \r\n    ";
$q = "SELECT \r\n     waktudaftarpmb.*,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,\r\n      IF (\r\n        CURDATE() >= waktudaftarpmb.TANGGALMULAI AND\r\n        CURDATE() <= waktudaftarpmb.TANGGALSELESAI,\r\n        1,\r\n        0\r\n      \r\n      ) AS STATUSONLINE\r\n       FROM waktudaftarpmb  ORDER BY tahun DESC LIMIT 1";

      #echo $q;
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
            if ( $d['STATUSONLINE'] == 1 )
            {
                $online = true;
            }
        }
        if ( !$jadwalada )
        {
            $errmesg = "Jadwal Pendaftaran Belum Ada. Anda tidak dapat melakukan entri data.";
		printmesg($errmesg);

        }
else{
	if ( !$online )
            {
		#printjudulmenu( "<b>Informasi Pendaftaran PMB</b>" );

                $errmesg = "Maaf, pendaftaran dibuka pada tanggal {$tanggalmulai} s.d {$tanggalselesai}. Silakan melakukan pendaftaran pada tanggal tersebut. Terima kasih.";
		printmesg($errmesg);

            }
	else{
#printjudulmenu( "<b>Informasi Pendaftaran PMB</b>" );

    echo "\r\n    <table>\r\n ";
	#echo "<tr><td>1.</td><td> Klik menu <a href='index.php?pilihan=tambahcalon'>registrasi calon mahasiswa </a> untuk mendapatkan username dan password sebagai calon mahasiswa Universitas Batam </td> \r\n      </tr>\r\n    ";
    echo "<tr><td>1.</td><td> Klik menu <a class='tambahcalon' href='../lib/termsandcondition.php'> Registrasi calon mahasiswa </a><script>
            jQuery(document).ready(function () {
                jQuery('a.tambahcalon').colorbox();
            });
        </script> untuk mendapatkan username dan password sebagai calon mahasiswa Universitas Batam </td> \r\n      </tr>\r\n    ";
    
	echo "<tr><td>2.</td><td> Cetak Kuitansi Pembayaran untuk dibawa ke bank sebagai dokumen untuk melakukan pembayaran pendaftaran calon mahasiswa Universitas Batam </td> \r\n      </tr>\r\n    ";
    echo "<tr><td>3.</td><td> Sertakan bukti pembayaran pendaftaran kepada petugas keuangan Universitas Batam dan Dokumen Biodata Diri kepada petugas Penerimaan Mahasiswa Baru</td> \r\n      </tr>\r\n    ";
    echo "<tr><td>4.</td><td> Anda akan mendapatkan pemberitahuan akun anda sudah aktif melalui email</td> \r\n      </tr>\r\n    ";
    
	echo "<tr><td>5.</td><td> Masuk menu <a href='http://pmb.univbatam.ac.id' target='_blank'>login calon mahasiswa</a> menggunakan username dan password yang dikirim lewat email untuk pengisian biodata dan cetak form peserta ujian setelah mendapatkan email aktivasi</td> \r\n      </tr>\r\n    ";
    
	echo "</table>";
	}
}	
?>
