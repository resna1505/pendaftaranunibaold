<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$yearnow=date('Y');
$tglhariini=date('Y-m-d');
#periksaroot( );
if ( $aksi == "update" && $aksi2 == "Update" )
{
    cekhaktulis( $kodemenu, "bank" );
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $valdata[] = cekvaliditastelp( "HP/Telepon Seluler", $data['hp'], 64, false );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) ) {
            $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
            unset( $valdata );
        } else {
            $qlogout = "";
            if ( $iflogout == 1 ) {
                $qlogout = ", STATUSLOGIN=0 ";
            }
            if ( trim( $data['password'] ) != "" ) {
                $qpwd = "PASSWORD=PASSWORD('{$data['password']}'),";
            }
            $q = "UPDATE calonmahasiswa SET
                NAMA='{$data['nama']}', 
                HP='{$data['hp']}', 
                EMAIL='{$data['email']}',       
                TANGGALUPDATEBANK=NOW(),
                UPDATERBANK='{$users_bank}' 
                WHERE ID='{$idupdate}'";
            mysqli_query($koneksi,$q);

            $ketlog = "Update data Pendaftaran Calon Mahasiswa dengan ID={$idupdate} dan Nama={$data['nama']}";
            $users = $users_bank;
            if ( 0 < sqlaffectedrows( $koneksi ) ) {
                buatlog( 64 );
                $errmesg = "";
                $errmesg .= "Data Pendaftaran Calon Mahasiswa berhasil diupdate <br>";
                $data = "";
            } else {
                $errmesg .= "Data Pendaftaran Calon Mahasiswa tidak diupdate <br>";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Pendaftaran Calon Mahasiswa", SIMPAN_DATA );
    }
    $aksi = "formupdate";
} else if ( $aksi == "update" && $aksi2 == "Kirim Ulang Password" ) {
    $q = "SELECT calonmahasiswa.*,
        YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR 
        FROM calonmahasiswa 
        WHERE calonmahasiswa.ID='{$idupdate}' 
        AND TAHUN='{$tahunupdate}' 
        AND GELOMBANG='{$gelupdate}' 
        AND PILIHAN='{$pilihanupdate}'";

    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" ) {
    printjudulmenu( "Update Data Pendaftaran Calon Mahasiswa" );

    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;

    $q = "SELECT calonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR 
        FROM calonmahasiswa  
        WHERE calonmahasiswa.ID='{$idupdate}' 
        AND TAHUN='{$tahunupdate}' 
        AND GELOMBANG='{$gelupdate}' 
        AND PILIHAN='{$pilihanupdate}'";
    $h = mysqli_query($koneksi,$q);

    if ( 0 < sqlnumrows( $h ) ) {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d['TANGGALDAFTAR'] );
        $d['thn'] = $tmp[0];
        $d['tgl'] = $tmp[2];
        $d['bln'] = $tmp[1];

        echo "<br>
            <form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'><table class=form>"
            .createinputhidden( "sessid", $_SESSION['token'], "" )
            .createinputhidden( "pilihan", $pilihan, "" )
            .createinputhidden( "aksi", "update", "" )
            .createinputhidden( "idupdate", "{$idupdate}", "" )
            .createinputhidden( "gelupdate", "{$gelupdate}", "" )
            .createinputhidden( "tahunupdate", "{$tahunupdate}", "" )
            .createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" )
            .createinputhidden( "tab", "{$tab}", "" )."
                <tr class=judulform>
                    <td>Tahun Daftar</td>
                    <td>{$d['TAHUN']} </td>
                </tr>
                <tr class=judulform>
                    <td>Gelombang</td>
                    <td> {$d['GELOMBANG']} </td>
                </tr>
                <tr class=judulform>
                    <td>Pilihan</td>
                    <td>".$arraypilihanpmb[$d['PILIHAN']]." </td>
                </tr>
                <tr class=judulform>
                    <td>ID </td>
                    <td>{$d['ID']} </td>
                </tr> ";
        if ( $d['COUNTERPASSWORD'] == 0 ) {
            echo "
            <!-- <tr class=judulform>
                <td>Password </td>
                <td>".str_rot13( $d['PASSWORD2']."y" )." </td>
            </tr> --> ";
        }
       echo "
        <tr class=judulform>
            <td>Biaya Rp.</td>
            <td>".cetakuang( $d['BIAYA'] )." </td>
        </tr>
        <tr class=judulform>
            <td colspan=2><hr></td>
        </tr>
        <tr class=judulform>
            <td>Nama Calon Mahasiswa *</td>
            <td>{$d['NAMA']}</td>
        </tr>
        <tr class=judulform>
            <td>No HP</td>
            <td>{$d['HP']}</td>
        </tr>
        <tr class=judulform>
            <td>E-mail*</td>
            <td>{$d['EMAIL']}</td>
        </tr>
        <tr class=judulform>
            <td>Pilihan Program Studi 1</td>
            <td>".$arrayprodidep[$d['PRODI1']]."</td>
        </tr>
        
        <!--<tr>
            <td colspan=2>\t".IKONUPDATE48."
                <input type=submit name=aksi2 value='Update' class=masukan>
                <input type=reset value='Reset' class=masukan><br>{$d['UPDATERBANK']}, {$d['TANGGALUPDATEBANK']}
            </td>
        </tr>-->
        
        </table>
            </form>
                <script> form.id.focus();</script><div align=center>
                <form method=post action=cetakform.php target=_blank>
                <input type=submit value='Cetak Form' class=masukan>"
                .createinputhidden( "idupdate", "{$idupdate}", "" )
                .createinputhidden( "gelupdate", "{$gelupdate}", "" )
                .createinputhidden( "tahunupdate", "{$tahunupdate}", "" )
                .createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" )."
            </form>
        </div>";  
	}
    else
    {
        $errmesg = "Data Calon Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == "POST" ) {
    $jadwalada = false;
    $online = false;
	$q = "SELECT 
        waktudaftarpmb.*,
        DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,
        DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,
        IF (  CURDATE() >= waktudaftarpmb.TANGGALMULAI AND  CURDATE() <= waktudaftarpmb.TANGGALSELESAI,  1,  0 ) AS STATUSONLINE 
    FROM waktudaftarpmb 
    ORDER BY tahun DESC 
    LIMIT 1";

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
        }
        else
        {
            if ( !$online )
            {
                $errmesg = "Maaf, pendaftaran dibuka pada tanggal {$tanggalmulai} s.d {$tanggalselesai}. Silakan melakukan pendaftaran pada tanggal tersebut. Terima kasih.";
            } else {
                $valdata[] = cekvaliditasnumerik( "Gelombang", $gelombang, 64, false );
                $valdata[] = cekvaliditasnama( "Nama", $data['nama'], 50, false );
                $valdata[] = cekvaliditastelp( "HP/Telepon Seluler", $data['hp'], 50, false );
                $valdata[] = cekvaliditasemail( "E-mail", $data['email'], 50, false );
                $valdata[] = cekvaliditasnama( "Tempat Lahir", $data['tempat'], 50, false );
                $valdata[] = cekvaliditasnama( "Alamat", $data['alamat'], 60, false );
                $valdata[] = cekvaliditasnama( "Kelurahan", $data['KELURAHAN'], 60, false );
                $valdata[] = cekvaliditasnama( "Kecamatan", $data['KECAMATAN'], 60, false );
                $valdata[] = cekvaliditasnama( "Kota", $data['kota'], 50, false );
                $valdata[] = cekvaliditasnama( "Provinsi", $data['provinsi'], 50, false );
                $valdata[] = cekvaliditasnama( "Asal Sekolah", $data['asal'], 50, false );
                $valdata[] = cekvaliditasnumerik( "Tahun Lulus", $data['tahunlulussma'], 4, false );
                $valdata[] = cekvaliditasnama( "No Ijazah", $data['noijazah'], 60, false );
                $valdata[] = cekvaliditasnumerik( "Jumlah Nilai Ujian Nasional", $data['jumlahun'], 2, false );
                $valdata[] = cekvaliditasnumerik( "Jumlah Nilai Ujian Sekolah", $data['jumlahuns'], 2, false );
                $valdata[] = cekvaliditasnumerik( "KTP", $data['ktp'], 30, false );
                $valdata[] = cekvaliditasnama( "Pendidikan Terakhir", $data['pendidikan'], 15, false );
                $valdata[] = cekvaliditasnama( "Nama Ayah", $data['namaayah'], 50, false );
                $valdata[] = cekvaliditasnama( "Alamat Ayah", $data['alamatortu'], 60, false );
                $valdata[] = cekvaliditastelp( "No Kontak Ayah", $data['teleponayah'], 50, false );
                $valdata[] = cekvaliditasnama( "Nama Ibu", $data['namaibu'], 50, false );
                $valdata[] = cekvaliditasnama( "Alamat Ibu", $data['alamatibu'], 60, false );
                $valdata[] = cekvaliditastelp( "No Kontak Ibu", $data['teleponibu'], 50, false );
                
                $valdata = array_filter( $valdata, "filter_not_empty" );
                
                if((isset($valdata)) && (count($valdata) >0)) {
                    $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
                    unset($valdata);
                } else {
                    
                    $ekstensi_diperbolehkan	= array('png','jpg','jpeg');
                    $nama = $_FILES['foto']['name'];
                    $x = explode('.', $nama);
                    $ekstensi = strtolower(end($x));
                    $ukuran	= $_FILES['foto']['size'];
                    $foto_tmp = $_FILES['foto']['tmp_name'];
                    
                    $ekstensi_ijazah_diperbolehkan	= array('doc', 'docx','pdf');
                    $upload_ijazah = $_FILES['ijazah']['name'];
                    $x_ijazah = explode('.', $upload_ijazah);
                    $ekstensi_ijazah = strtolower(end($x_ijazah));
                    $ukuran_ijazah	= $_FILES['ijazah']['size'];
                    $ijazah_tmp = $_FILES['ijazah']['tmp_name'];

                    //cek email yang diinput sudah ada belum
                    $sql_cek_email="SELECT EMAIL FROM calonmahasiswa WHERE EMAIL='{$data['email']}' AND PRODI1='$idprodi1'";
                    #echo $sql_cek_email.'<br>';
                    $h_cek_email = mysqli_query($koneksi,$sql_cek_email);
                    $d_cek_email = sqlfetcharray( $h_cek_email );
                    $emailcalon = $d_cek_email['EMAIL'];
                    #echo $emailcalon.'<br>';
                    $errmesg="";
                    if ( trim( $data['email'] ) == $emailcalon )
                    {
                        $errmesg .= "Email sudah terdaftar<br>";
                    } elseif ( trim( $data['nama'] ) == "" ) {
                        $errmesg .= "Nama Calon Mahasiswa harus diisi<br>";
                    } elseif ( trim( $data['ktp'] ) == "" ) {
                        $errmesg .= "No KTP harus diisi<br>";
                    } elseif ( strlen($data['ktp'])<16) {
                        $errmesg .= "No KTP harus 16 angka<br>";
                    } elseif ( trim( $data['hp'] ) == "" || strlen($data['hp'])<10 ) {
                        $errmesg .= "HP / Telepon harus diisi<br>";
                    } elseif ( trim( $data['email'] ) == "" ) {
                        $errmesg .= "Email harus diisi<br>";
                    } elseif ( trim( $data['tempat'] ) == "" ) {
                        $errmesg .= "Tempat Lahir harus diisi<br>";
                    } elseif ( trim( $data['alamat'] ) == "" ) {
                        $errmesg .= "Alamat harus diisi<br>";
                    } elseif ( trim( $data['KELURAHAN'] ) == "" ) {
                        $errmesg .= "Kelurahan harus diisi<br>";
                    } else if ( substr(trim($data['hp']),0,1) != "0" ) {
                        $errmesg = "Digit Pertama No HP harus angka 0";
                    } elseif ( trim( $data['KECAMATAN'] ) == "" ) {
                        $errmesg .= "Kecamatan harus diisi<br>";
                    } elseif ( trim( $data['kota'] ) == "" ) {
                        $errmesg .= "Kota harus diisi<br>";
                    } elseif ( trim( $data['provinsi'] ) == "" ) {
                        $errmesg .= "Provinsi harus diisi<br>";
                    } elseif ( trim( $data['asal'] ) == "" ) {
                        $errmesg .= "Asal Sekolah harus diisi<br>";
                    } elseif ( trim( $data['tahunlulussma'] ) == "" ) {
                        $errmesg .= "Tahun Lulus harus diisi<br>";
                    } elseif ($foto== "" ) {
                        $errmesg .= "File foto harus diisi<br>";
                    } elseif(in_array($ekstensi, $ekstensi_diperbolehkan) === false){
                        $errmesg .= "File Foto hanya png atau jpg<br>";
                    } elseif ($_FILES["foto"]["size"] > 1044070 ) {
                        $errmesg .= "File Foto maksimal 1 MB<br>";
                    } elseif ( trim( $data['baju'] ) == "" ) {
                        $errmesg .= "Ukuran Baju Almamater harus diisi<br>";
                    } elseif ( trim( $data['infodaftarpmb'] ) == "" ) {
                        $errmesg .= "Informasi belum dpilih<br>";
                    } elseif ( trim( $data['namaayah'] ) == "" ) {
                        $errmesg .= "Nama Ayah harus diisi<br>";
                    } elseif ( trim( $data['alamatortu'] ) == "" ) {
                        $errmesg .= "Alamat Ayah harus diisi<br>";
                    } elseif ( trim( $data['teleponayah'] ) == "" ) {
                        $errmesg .= "Telepon Ayah harus diisi<br>";
                    } elseif ( trim( $data['namaibu'] ) == "" ) {
                        $errmesg .= "Nama Ibu harus diisi<br>";
                    } elseif ( trim( $data['alamatibu'] ) == "" ) {
                        $errmesg .= "Alamat Ibu harus diisi<br>";
                    } elseif ( trim( $data['teleponibu'] ) == "" ) {
                        $errmesg .= "Telepon Ibu harus diisi<br>";
                    } else{
                        $namacalonmhs=mysqli_real_escape_string($koneksi,$data['nama']);                        
                        $passwordacak = substr( md5( uniqid( rand( ), TRUE ) ), 0, 12 );                        
                        $nimbaru = substr( strtolower( str_replace( " ", "", $namacalonmhs ) ), 1, 6 );
                        $nimbaru .= substr( strtolower( str_replace( "-", "", $tglhariini ) ), 2, 6 );                        
                        $nimbaru .= substr( uniqid( rand( ), TRUE ), 0, 4 );                           
			
                        $q_biaya = "SELECT BIAYA FROM waktudaftarpmb  WHERE TAHUN='$tahuna' AND GELOMBANG='$gelombang' AND PRODI='$idprodi1'";
                        $h_biaya = mysqli_query($koneksi,$q_biaya);

                        if ( 0 < sqlnumrows( $h_biaya ) ) {
                            $d_biaya = sqlfetcharray( $h_biaya );
                            $biaya_per_prodi=$d_biaya['BIAYA'];
                        }else{
                            $biaya_per_prodi=0;
                        }
                            
                        $q = "INSERT INTO calonmahasiswa
                            (ID,
                            NAMA,
                            TAHUN,
                            GELOMBANG,
                            PILIHAN,
                            TEMPATLAHIR,
                            TANGGALLAHIR,
                            KELAMIN,
                            STATUSNIKAH,
                            AGAMA,
                            ALAMAT,
                            TELEPON,
                            HP,
                            WN,
                            ASALSMA,
                            NAMAAYAH,
                            NAMAIBU,
                            ALAMATORTU,
                            PRODI1,
                            BIAYA,
                            EMAIL,
                            PASSWORD,
                            TANGGALDAFTAR,
                            PASSWORD2,
                            UPDATERBANK,
                            TANGGALUPDATEBANK,
                            STATUS,
                            TAHUNLULUSSMA,
                            PENDIDIKAN,
                            ALAMATIBU,
                            TELEPONAYAH,
                            TELEPONIBU,
                            KOTA,
                            PROVINSI,
                            KTP,
                            STATUSBARU,
                            KELURAHAN,
                            KECAMATAN,
                            STATUSISIBIODATA,
                            STATUSPILIHPRODI,
                            JASALMAMATER,
                            REFERAL,
                            DAPATINFO)
                        VALUES 
                            ('{$nimbaru}',
                            '".strtoupper( $namacalonmhs )."',
                            '{$tahuna}',
                            '{$gelombang}',
                            '{$idpilihan}',
                            '{$data['tempat']}',
                            '{$data['thn']}-{$data['bln']}-{$data['tgl']}',
                            '{$data['kelamin']}',
                            '{$data['statusnikah']}',
                            '{$data['agama']}',
                            '{$data['alamat']}',
                            '{$data['telepon']}',
                            '{$data['hp']}',
                            '{$data['wn']}',
                            '{$data['asal']}',                            
                            '{$data['namaayah']}',
                            '{$data['namaibu']}',
                            '{$data['alamatortu']}',
                            '{$idprodi1}',
                            '{$biaya_per_prodi}',
                            '{$data['email']}',
                            MD5('{$passwordacak}'),
                            NOW(),
                            '',
                            '{$nimbaru}',
                            CURDATE(),
                            '0',
                            '{$data['tahunlulussma']}',
                            '{$data['pendidikan']}',
                            '{$data['alamatibu']}',
                            '{$data['teleponayah']}',
                            '{$data['teleponibu']}',
                            '{$data['kota']}',
                            '{$data['provinsi']}',
                            '{$data['ktp']}',
                            '{$statusbaru}',
                            '{$data['KELURAHAN']}',
                            '{$data['KECAMATAN']}',
                            '1',
                            '1',
                            '{$data['baju']}',
                            '{$data['referal']}',
                            '{$data['infodaftarpmb']}')";
                            
							mysqli_query($koneksi,$q);
							
							$users = $users_bank;
							$ketlog = "Tambah Data Pendaftaran Calon Mahasiswa dengan ID={$nimbaru} dan Nama={$namacalonmhs} oleh Pendaftar";
							if ( 0 < sqlaffectedrows( $koneksi ) ) {
								if ( $ijazah != "" )
								{
									move_uploaded_file( $ijazah, "ijazah/{$nimbaru}" );
								}

								if ( $foto != "" )
								{
									move_uploaded_file( $foto, "foto/{$nimbaru}" );
								}
								
								buatlog( 63 );
								$dr = get_konfigpendaftaran( "PMB" );
								$dmail['subject'] = str_replace( "[IDCALONMAHASISWA]", "{$nimbaru}", html_entity_decode( $dr['SUBJEK'] ) );
								$dmail['subject'] = str_replace( "[NAMACALONMAHASISWA]", "{$data['nama']}", $dmail['subject'] );
								$dmail['subject'] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail['subject'] );
								$dmail['body'] = str_replace( "[IDCALONMAHASISWA]", "{$nimbaru}", html_entity_decode( $dr['ISI'] ) );
								$dmail['body'] = str_replace( "[NAMACALONMAHASISWA]", "{$namacalonmhs}", $dmail['body'] );
								$dmail['body'] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail['body'] );
								$dmail['to'] = $data['email'];
								$hasil = kirimemail_calonmahasiswa( $dmail );
								if ( $hasil == 1 )
								{
									$errmesgemail = "Username dan Password dikirim via email.<br>";
								}
								else
								{
									$errmesgemail = "Username dan Password tidak dikirim via email. {$hasil} <br>";
								}
								
								$errmesg = "Data Pendaftaran Calon Mahasiswa berhasil ditambah dengan ID {$nimbaru}.<br> {$errmesgemail} {$errmesgsms} Klik di <a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$nimbaru}&tahunupdate={$tahuna}&gelupdate={$gelombang}&pilihanupdate={$idpilihan}'>sini untuk Melihat dan Mencetak kuitansi pembayaran</a>.";
								
								$data = "";
								$id = "";
								$semester2 = $semesterawal = $ktp = $gelar = $jabatan = $pendidikan = $instansidosen = "";
							} else {
								$errmesg = "Data Pendaftaran Calon Mahasiswa tidak berhasil ditambah.";
							}
						}
                    }
                #}
            }
        }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
	$q = "SELECT 
        waktudaftarpmb.*, 
        DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM, 
        DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS, 
        IF (   CURDATE() >= waktudaftarpmb.TANGGALMULAI AND CURDATE() <= waktudaftarpmb.TANGGALSELESAI, 1, 0) AS STATUSONLINE 
        FROM waktudaftarpmb 
        ORDER BY tahun DESC 
        LIMIT 1";

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
        }
        else
        {
            if ( !$online )
            {
                $errmesg = "Maaf, pendaftaran dibuka pada tanggal {$tanggalmulai} s.d {$tanggalselesai}. Silakan melakukan pendaftaran pada tanggal tersebut. Terima kasih.";
            	printmesg($errmesg);

	    }else{
		$q="select GELOMBANG FROM waktudaftarpmb WHERE TANGGALSELESAI>=CURDATE() AND TANGGALMULAI<=CURDATE() AND TAHUN='$w[year]'";
		
		$h = mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi );
        if ( 0 < sqlnumrows( $h ) ) {
            $d = sqlfetcharray( $h );
        }
		$gelombang=$d['GELOMBANG'];
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        
        printjudulmenu( "Tambah Data Calon Mahasiswa (semua data harus terisi dengan benar)" );
        printmesg($errmesg);
        
        echo "
        <form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' onSubmit=\"return confirm('Lakukan penambahan data? Data yang telah ditambahkan tidak akan dapat dihapus.')\">
            <table style=\"width: 100%; border-collapse: collapse;\">"
                .createinputhidden( "pilihan", $pilihan, "" )
                .createinputhidden( "sessid", $_SESSION['token'], "" )
                .createinputhidden( "aksi", "tambah", "" )."
                    <tr class=\"judulform\">
                        <td colspan=2>
                            <b>DATA CALON MAHASISWA</b><hr>
                        </td>
                    </tr>
                    <tr class=\"judulform\">
                        <td data-label=\"Nama Calon Mahasiswa *\">Nama Calon Mahasiswa *</td>
                        <td>".createinputtext( "data[nama]", $data['nama'], " class=masukan  size=50" )." {$wajibdiisi} </td>
                    </tr>
                    <tr class=judulform>
                        <td>No KTP *</td>
                        <td>".createinputtext( "data[ktp]", $data['ktp'], " class=masukan  size=50" )." {$wajibdiisi} </td>
                    </tr>
                    <tr class=judulform>
                        <td>HP/Telepon Seluler *</td>
                        <td>".createinputtext( "data[hp]", $data['hp'], " class=masukan  size=50" )."  {$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>E-mail*</td>
                        <td>".createinputtext( "data[email]", $data['email'], " class=masukan  size=50" )." Disarankan mempunyai akun gmail </td>
                    </tr>
                    <tr>
                        <td>Tempat/Tanggal Lahir *</td>
                        <td>".createinputtext( "data[tempat]", $data['tempat'], " class=masukan  size=10" )." / ".createinputtanggal( "data", $data, " class=masukan" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Jenis Kelamin*</td>
                        <td>".createinputselect( "data[kelamin]", $arraykelamin, $data['kelamin'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Agama*</td>
                        <td>".createinputselect( "data[agama]", $arrayagama, $data['agama'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Status Nikah*</td>
                        <td>".createinputselect( "data[statusnikah]", $arraystatusnikah, $data['statusnikah'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Alamat*</td>
                        <td>".createinputtextarea( "data[alamat]", $data['alamat'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Kelurahan*</td>
                        <td>".createinputtext( "data[KELURAHAN]", $data['KELURAHAN'], " class=masukan  size=50" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Kecamatan*</td>
                        <td>".createinputtext( "", $arraykecamatan{$KECAMATAN}, "class=masukan  autocomplete=off size=30 id='inputStringKecamatan' onkeyup=\"lookupKecamatan(this.value,'','');\" \r\n" ).createinputhidden( "data[KECAMATAN]", $KECAMATAN, " class=masukan  size=20      id='inputStringDataKecamatan'" )."{$wajibdiisi} <div class=\"suggestionsBox\" id=\"suggestionsKecamatan\" style=\"display: none;\">           <div class=\"suggestionList\" id=\"autoSuggestionsListKecamatan\"></td>
                    </tr>
                    <tr class=judulform>
                        <td>Kota*</td>
                        <td>".createinputtext( "data[kota]", $data['kota'], " class=masukan  size=50" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Provinsi*</td>
                        <td>".createinputtext( "data[provinsi]", $data['provinsi'], " class=masukan  size=50" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Kewarganegaraan*</td>
                        <td>".createinputselect( "data[wn]", $arraywn, $data['wn'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Asal Perguruan Tinggi*</td>
                        <td>".createinputtext( "data[asal]", $data['asal'], " class=masukan  size=50" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Tahun Lulus*</td>
                        <td>".createinputtext( "data[tahunlulussma]", $data['tahunlulussma'], " class=masukan  size=4 maxlength=4" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Pas Foto*</td>
                        <td>{$fotosaatini}<input type=file name=foto class=masukan> Max. 1 MB (File png,jpg,jpeg) {$wajibdiisi} </td>
                    </tr>
                    <tr class=judulform>
                        <td>Ukuran Baju Almamater*</td>
                        <td>".createinputselect( "data[baju]", $arraybaju, $data['baju'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Informasi ini diperoleh dari*</td>
                        <td>".createinputselect( "data[infodaftarpmb]", $arrayinfodaftarpmb, $data['infodaftarpmb'], "", " class=masukan " )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Nama Referal</td>
                        <td>".createinputtext( "data[referal]", $data['referal'], " class=masukan size=20 maxlength=50" )." (Nama yang mereferensikan untuk melakukan pendaftaran)</td>
                    </tr>
                    <tr class=judulform>
                        <td colspan=2><b>DATA ORANG TUA</b><hr></td>
                    </tr>
                    <tr class=judulform>
                        <td>Nama Ayah*</td>
                        <td>".createinputtext( "data[namaayah]", $data['namaayah'], " class=masukan size=30" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Alamat Ayah*</td>
                        <td>".createinputtextarea( "data[alamatortu]", $data['alamatortu'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>No. Kontak Ayah*</td>
                        <td>".createinputtext( "data[teleponayah]", $data['teleponayah'], " class=masukan size=30" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Nama Ibu*</td>
                        <td>".createinputtext( "data[namaibu]", $data['namaibu'], " class=masukan size=30" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>Alamat Ibu*</td>
                        <td>".createinputtextarea( "data[alamatibu]", $data['alamatibu'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td>No. Kontak Ibu*</td>
                        <td>".createinputtext( "data[teleponibu]", $data['teleponibu'], " class=masukan size=30" )."{$wajibdiisi}</td>
                    </tr>
                    <tr class=judulform>
                        <td colspan=2><b>DATA PENDAFTARAN</b><hr></td>
                    </tr>
                    <tr class=judulform>
                        <td>Tanggal Pendaftaran*</td>
                        <td>{$w['mday']}-{$w['mon']}-{$w['year']} </td>
                    </tr>
                    <td>Tahun 	Daftar*</td>
                        <td>".createinputtext( "tahuna", $w['year'], " class=masukan size=4 readonly" )."</td>
                    </tr>
                    <tr class=judulform>
                        <td>Gelombang* {$tahuna}</td>";        
                        if ( $tahuna == "" ) {
                            $tahuna = $w['year'];
                        }
                        if ( $idpilihan == "" ) {
                            $idpilihan = $arraypilihan[$initidpilihan];
                        }
                echo "
                    <td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2 readonly" )."</td>
                </tr>
                <tr class=judulform>
                    <td>Pilihan</td>
                    <td>".createinputselect( "idpilihan", $arraypilihanpmb, $idpilihan, "", " class=masukan" )."</td>
                </tr>
                <tr class=judulform>
                    <td>Pilihan Program Studi 1</td>
                    <td>".createinputselect( "idprodi1", $arrayprodipmb, $idprodi1, "", " class=masukan" )."</td>
                </tr>
                <tr>
                    <td >Status Awal Mahasiswa Baru</td>
                    <td>".createinputselect( "statusbaru", $arraystatusmhsbaru, $d2['STPIDMSMHS'], "", " class=masukan" )."</td>
                </tr>
                <!--<tr class=judulform>\t<td>Catatan</td><td>".createinputtextarea( "data[catatan]", $data['catatan'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td></tr>-->";
                echo "
                <tr>
                    <td colspan=2>".IKONUPDATE48."
                        <input type=submit value='Tambah' class=masukan>
                        <input type=reset value='Reset' class=masukan>
                    </td>
                </tr>
            </table>
        </form>
        <script>form.id.focus();</script>";
	   }
	}
}
if ( $aksi == "tampilkan" )
{
    $aksi = "";
	$errmesg="";
	if($_POST['id']==""){
		$errmesg .="Nomor Test Harus Di Isi !";
	}else{
        include( "prosestampiloperatorbank.php" );
	}
}
if ( $aksi == "" ) {
    echo "
    <form name=form action=index.php method=post>
        <input type=hidden name=pilihan value='{$pilihan}'>
        <input type=hidden name=aksi value='tampilkan'> ".IKONCARI48."
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td>
                                <input type=checkbox name=iftgl value=1>"
                                .createinputtanggal( "tgl1", $tgl1, " class=masukan" )
                                ." s.d ".createinputtanggal( "tgl2", $tgl2, " class=masukan" )."
                                </td>
                        </tr>
                        <tr>
                            <td> Tahun Masuk </td>
                            <td>";
                            $waktu = getdate( );
                            echo "
                            <select name=tahunmasuk class=masukan> 
                                <option value=''>Semua</option>";
                            $i = 1900;
                            while ( $i <= $waktu['year'] + 5 ) {
                                $cek = "";
                                if ( $i == $waktu['year'] ) {
                                    $cek = "selected";
                                }
                                echo "<option value='{$i}' {$cek}>{$i}</option>";
                                ++$i;
                            }
                        echo "
                            </select>
                            </td>
                        </tr>
                        <tr class=judulform>
                            <td>Gelombang</td>
                            <td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>
                        </tr>
                        <tr>
                            <td>Pilihan</td>
                            <td><select class=masukan name=idpilihan><option value=''>Semua</option>";
                            foreach ( $arraypilihanpmb as $k => $v ) {
                                echo "<option value='{$k}'>{$v}</option>";
                            }
                            echo "</select></td>
                        </tr>
                        <tr class=judulform>
                            <td>ID/Nomor Tes </td>
                            <td>".createinputtext( "id", $id, " class=masukan  size=50" )."</td>
                        </tr>
                        <tr class=judulform>
                            <td>Nama</td>
                            <td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan=2> <input type=submit value='Tampilkan Data' class=masukan> </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    <script> form.id.focus();</script> ";	
}
?>
