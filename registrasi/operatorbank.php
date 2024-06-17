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
        $valdata[] = cekvaliditastelp( "HP/Telepon Seluler", $data[hp], 64, false );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
            unset( $valdata );
        }
        else
        {
            $qlogout = "";
            if ( $iflogout == 1 )
            {
                $qlogout = ", STATUSLOGIN=0 ";
            }
            if ( trim( $data['password'] ) != "" )
            {
                $qpwd = "PASSWORD=PASSWORD('{$data['password']}'),";
            }
            $q = "\r\n\t\t\t\tUPDATE calonmahasiswa SET  \r\n\t\t\t\tNAMA='{$data['nama']}' ,\r\n\t\t\t\tHP='{$data['hp']}',\r\n\t\t\t\tEMAIL='{$data['email']}' ,\r\n\t\t\t\t      TANGGALUPDATEBANK=NOW(),\r\n      UPDATERBANK\t='{$users_bank}'\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            $ketlog = "Update data Pendaftaran Calon Mahasiswa dengan ID={$idupdate} dan Nama={$data['nama']}";
            $users = $users_bank;
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 64 );
                $errmesg = "";
                $errmesg .= "Data Pendaftaran Calon Mahasiswa berhasil diupdate <br>";
                $data = "";
            }
            else
            {
                $errmesg .= "Data Pendaftaran Calon Mahasiswa tidak diupdate <br>";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Pendaftaran Calon Mahasiswa", SIMPAN_DATA );
    }
    $aksi = "formupdate";
}
else if ( $aksi == "update" && $aksi2 == "Kirim Ulang Password" )
{
    $q = "SELECT \r\n\tcalonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR \r\n\tFROM calonmahasiswa  WHERE \r\n\tcalonmahasiswa.ID='{$idupdate}'\r\n\tAND  TAHUN='{$tahunupdate}' AND GELOMBANG='{$gelupdate}' AND\r\n\tPILIHAN='{$pilihanupdate}'\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    #cekhaktulis( $kodemenu, "bank" );
    printjudulmenu( "Update Data Pendaftaran Calon Mahasiswa" );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT calonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR FROM calonmahasiswa  WHERE calonmahasiswa.ID='{$idupdate}'\r\n\tAND  TAHUN='{$tahunupdate}' AND GELOMBANG='{$gelupdate}' AND\r\n\tPILIHAN='{$pilihanupdate}'\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d['TANGGALDAFTAR'] );
        $d['thn'] = $tmp[0];
        $d['tgl'] = $tmp[2];
        $d['bln'] = $tmp[1];
        echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "gelupdate", "{$gelupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." \r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Tahun Daftar</td>\r\n\t\t\t<td>{$d['TAHUN']} </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang</td> \r\n\t\t\t<td> {$d['GELOMBANG']} </td>\r\n\t\t</tr> \r\n<tr class=judulform>\r\n\t\t\t<td>Pilihan</td>\r\n\t\t\t<td>".$arraypilihanpmb[$d['PILIHAN']]." </td>\r\n\t\t</tr>\r\n        <tr class=judulform>\r\n\t\t\t<td>ID </td> \r\n\t\t\t<td>{$d['ID']} </td>\r\n\t\t</tr> ";
        if ( $d['COUNTERPASSWORD'] == 0 )
        {
            echo "\r\n      <!--   <tr class=judulform>\r\n\t\t\t<td>Password </td> \r\n\t\t\t<td>".str_rot13( $d['PASSWORD2']."y" )." </td>\r\n\t\t</tr> --> ";
        }
       echo "\t \r\n \r\n  \t<tr class=judulform>\r\n\t\t\t<td>Biaya Rp.</td>\r\n\t\t\t<td>".cetakuang( $d['BIAYA'] )." </td>\r\n\t\t</tr>\r\n\t \r\n \r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Nama Calon Mahasiswa *</td>\r\n\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t</tr> \r\n \r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>No HP</td>\r\n\t\t\t<td>{$d['HP']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>E-mail*</td>\r\n\t\t\t<td>{$d['EMAIL']}</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 1</td>\r\n\t\t\t<td>".$arrayprodidep[$d['PRODI1']]."</td>\r\n\t\t</tr>\r\n  \r\n \t\t\t<!--<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan> \r\n\t\t\t\t\t<br>\r\n\t\t\t\t\t{$d['UPDATERBANK']}, {$d['TANGGALUPDATEBANK']}\r\n\t\t\t\t</td>\r\n\t\t\t</tr>-->\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t\t<div align=center>\r\n\t\t\t<form method=post action=cetakform.php target=_blank>\r\n\t\t\t\t<input type=submit value='Cetak Form' class=masukan>\r\n        ".createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "gelupdate", "{$gelupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" )."\r\n\t\t\t</form>\r\n\t\t\t</div>\r\n\t\t\t\r\n\t\t";
  
	}
    else
    {
        $errmesg = "Data Calon Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == "POST" )
{
	#echo $_SESSION['token']."aaa".$_POST['sessid'];
    #if ( $_SESSION['token'] == $_POST['sessid'] )
    #{
		#echo "kkk";exit();
        #unset( $_SESSION['token'] );
		#echo $kodemenu;exit();
		#cekhaktulis( $kodemenu, "bank" );
        $jadwalada = false;
        $online = false;
        #$q = "SELECT \r\n     waktudaftarpmb.*,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,\r\n      IF (\r\n        CURDATE() >= waktudaftarpmb.TANGGALMULAI AND\r\n        CURDATE() <= waktudaftarpmb.TANGGALSELESAI,\r\n        1,\r\n        0\r\n      \r\n      ) AS STATUSONLINE\r\n       FROM waktudaftarpmb  WHERE  \r\n       waktudaftarpmb.GELOMBANG = '{$gelombang}' AND \r\n       waktudaftarpmb.TAHUN = '{$tahuna}'  \r\n      \r\n    ";
	$q = "SELECT \r\n     waktudaftarpmb.*,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,\r\n      IF (\r\n        CURDATE() >= waktudaftarpmb.TANGGALMULAI AND\r\n        CURDATE() <= waktudaftarpmb.TANGGALSELESAI,\r\n        1,\r\n        0\r\n      \r\n      ) AS STATUSONLINE\r\n       FROM waktudaftarpmb  ORDER BY tahun DESC LIMIT 1";

       
# echo $q;exit();
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
            }
            else
            {
                #if ( !is_pear_mail_installed() && !is_sms_gateway_installed() )
                #{
                #    $errmesg = "Maaf, modul Pear:Mail_mime  dan SMS Gateway tidak atau belum terinstall dengan benar. Silakan hubungi admin karena kedua modul ini dibutuhkan untuk mengirimkan password ke calon mahasiswa.";
                #}
                #else
                #{
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
                   #print_r($valdata).'<br>';
					$valdata = array_filter( $valdata, "filter_not_empty" );
					#print_r($valdata).'<br>';
                    if((isset($valdata)) && (count($valdata) >0))
					#if(count($valdata) <0)
                    {
                        $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
                        unset($valdata);
                    }
                    else
                    {
					#echo "PANJANG=".strlen($data[hp]);exit();
						#print_r($data).'<br>';exit();

						#print_r($_POST).'<br>';exit();
						#print_r($_FILES).'<br>';
						#$extention = end( explode('.', $_FILES["ijazah"]["name"]) );
						#echo $extention;exit();
						 /** extensi file yang tidak diupload */
						#$forbiden_ext = array('php','pl','jsp','asp','sh','cgi','html','css');
						
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
							#echo "kesini";exit();
							$errmesg .= "Email sudah terdaftar<br>";
						}
						elseif ( trim( $data['nama'] ) == "" )
						{
							#echo "kesini";exit();
							$errmesg .= "Nama Calon Mahasiswa harus diisi<br>";
						}
						elseif ( trim( $data['nisn'] ) == "" )
						{
							$errmesg .= "NISN harus diisi<br>";
						}
						elseif ( strlen($data['nisn'])<10)
						{
							$errmesg .= "NISN harus 10 angka<br>";
						}

						elseif ( trim( $data['ktp'] ) == "" )
						{
							$errmesg .= "No KTP harus diisi<br>";
						}
						elseif ( strlen($data['ktp'])<16)
						{
							$errmesg .= "No KTP harus 16 angka<br>";
						}
						elseif ( trim( $data['hp'] ) == "" || strlen($data['hp'])<10 )
						{
							$errmesg .= "HP / Telepon harus diisi<br>";
						}
						elseif ( trim( $data['email'] ) == "" )
						{
							$errmesg .= "Email harus diisi<br>";
						}
						elseif ( trim( $data['tempat'] ) == "" )
						{
							$errmesg .= "Tempat Lahir harus diisi<br>";
						}
						elseif ( trim( $data['alamat'] ) == "" )
						{
							$errmesg .= "Alamat harus diisi<br>";
						}
						elseif ( trim( $data['KELURAHAN'] ) == "" )
						{
							$errmesg .= "Kelurahan harus diisi<br>";
						}
						else if ( substr(trim($data['hp']),0,1) != "0" )
            					{
                					$errmesg = "Digit Pertama No HP harus angka 0";
            					}	
						elseif ( trim( $data['KECAMATAN'] ) == "" )
						{
							$errmesg .= "Kecamatan harus diisi<br>";
						}
						elseif ( trim( $data['kota'] ) == "" )
						{
							$errmesg .= "Kota harus diisi<br>";
						}
						elseif ( trim( $data['provinsi'] ) == "" )
						{
							$errmesg .= "Provinsi harus diisi<br>";
						}
						elseif ( trim( $data['asal'] ) == "" )
						{
							$errmesg .= "Asal Sekolah harus diisi<br>";
						}
						elseif ( trim( $data['tahunlulussma'] ) == "" )
						{
							$errmesg .= "Tahun Lulus harus diisi<br>";
						}
						elseif ( trim( $data['noijazah'] ) == "" )
						{
							$errmesg .= "No Ijazah / No Surat Kelulusan harus diisi<br>";
						}
						#if ($_FILES["ijazah"]["name"] == "" )
						elseif ($ijazah== "" )
						{
							$errmesg .= "File Ijazah harus diisi<br>";
						}
						elseif(in_array($ekstensi_ijazah, $ekstensi_ijazah_diperbolehkan) === false){
							
							$errmesg .= "File yang diperbolehkan hanya doc,docx atau pdf<br>";

						}
						elseif ($_FILES["ijazah"]["size"] > 1044070 )
						{
							$errmesg .= "File Ijazah maksimal 1 MB<br>";
						}
						elseif ($foto== "" )
						{
							$errmesg .= "File foto harus diisi<br>";
						}
						elseif(in_array($ekstensi, $ekstensi_diperbolehkan) === false){
							
							$errmesg .= "File Foto hanya png atau jpg<br>";

						}
						elseif ($_FILES["foto"]["size"] > 1044070 )
						{
							$errmesg .= "File Foto maksimal 1 MB<br>";
						}
						elseif ( trim( $data['jumlahun'] ) == "" )
						{
							$errmesg .= "Jumlah Nilai Ujian Nasional harus diisi<br>";
						}
						elseif ( trim( $data['jumlahuns'] ) == "" )
						{
							$errmesg .= "Jumlah Nilai Ujian Sekolah harus diisi<br>";
						}
						elseif ( trim( $data['pendidikan'] ) == "" )
						{
							$errmesg .= "Pendidikan Terakhir harus diisi<br>";
						}
						elseif ( trim( $data['baju'] ) == "" )
						{
							$errmesg .= "Ukuran Baju Almamater harus diisi<br>";
						}
						elseif ( trim( $data['infodaftarpmb'] ) == "" )
						{
							$errmesg .= "Informasi belum dpilih<br>";
						}						
						elseif ( trim( $data['namaayah'] ) == "" )
						{
							$errmesg .= "Nama Ayah harus diisi<br>";
						}
						elseif ( trim( $data['alamatortu'] ) == "" )
						{
							$errmesg .= "Alamat Ayah harus diisi<br>";
						}
						elseif ( trim( $data['teleponayah'] ) == "" )
						{
							$errmesg .= "Telepon Ayah harus diisi<br>";
						}
						elseif ( trim( $data['namaibu'] ) == "" )
						{
							$errmesg .= "Nama Ibu harus diisi<br>";
						}
						elseif ( trim( $data['alamatibu'] ) == "" )
						{
							$errmesg .= "Alamat Ibu harus diisi<br>";
						}
						elseif ( trim( $data['teleponibu'] ) == "" )
						{
							$errmesg .= "Telepon Ibu harus diisi<br>";
						}						
						else{
							$namacalonmhs=mysqli_real_escape_string($koneksi,$data['nama']);
							#if()
							#echo "lll";exit();
							$passwordacak = substr( md5( uniqid( rand( ), TRUE ) ), 0, 12 );
							#$nimbaru = substr( strtolower( str_replace( " ", "", $data['nama'] ) ), 1, 6 );
							$nimbaru = substr( strtolower( str_replace( " ", "", $namacalonmhs ) ), 1, 6 );
							$nimbaru .= substr( strtolower( str_replace( "-", "", $tglhariini ) ), 2, 6 );
							#echo $nimbaru.'<br>';
							$nimbaru .= substr( uniqid( rand( ), TRUE ), 0, 4 );
							#echo $nimbaru;
							#exit();
							//ambil id terakhir sesuai program studi dan angkatan di master mahasiswa
								#$lock1="LOCK TABLES prodi WRITE"
								/*$q = "SELECT IDNIM FROM prodi WHERE ID='{$idprodi1}'";
								#$q = "SELECT IDNIM FROM prodi WHERE ID='{$idprodi1}'";
							#	echo $q.'<br>';
								$hx = mysqli_query($koneksi,$q);
								$dx = sqlfetcharray( $hx );
								$idnim = $dx[IDNIM];
								$kodetahun = substr( $tahuna, 2, 2 );
								#$lockmahasiswa=;
								
								#mysql_query( "LOCK TABLES mahasiswa WRITE, calonmahasiswa WRITE", $koneksi );	
								#$q = "SELECT MAX(ID) AS MAXID FROM mahasiswa WHERE ANGKATAN='{$tahuna}' AND IDPRODI='{$idprodi1}'";
								#$q = "SELECT MAX(ID) AS MAXID FROM mahasiswa WHERE ANGKATAN='{$tahuna}' AND IDPRODI='{$idprodi1}'";
								$q="SELECT ID, MAX(ID) as MAXID
FROM
(
    SELECT ID, MAX(ID) as MAXID
    FROM mahasiswa where ANGKATAN='{$tahuna}' AND IDPRODI='{$idprodi1}' and ID LIKE '{$idnim}%'
    GROUP BY ID
    UNION ALL
    SELECT ID, MAX(ID) as MAXID
    FROM calonmahasiswa where TAHUN='{$tahuna}' AND PRODI1='{$idprodi1}' and ID LIKE '{$idnim}%'
    GROUP BY ID
) as subQuery 
GROUP BY ID
ORDER BY ID DESC LIMIT 1";
							#echo $q.'<br>';
								$hx = mysqli_query($koneksi,$q);
								$dx = sqlfetcharray( $hx );
								$nimterakhir = $dx[MAXID];
								$nimterakhir = addnol( substr( $nimterakhir, strlen( $nimterakhir ) - 3, 3 ) + 1, 3 );
								$nimbaru = $idnim.$kodetahun.$nimterakhir;*/
							#echo $nimbaru;
							#$q = "\r\n\t\t\tINSERT INTO calonmahasiswa \r\n      (ID,NAMA,TAHUN,GELOMBANG,PILIHAN, HP , BIAYA, TANGGALUPDATEBANK,UPDATERBANK,EMAIL,PASSWORD,TANGGALDAFTAR,PASSWORD2) \r\n\t\t\tVALUES ('{$idupdate}','".strtoupper( $namacalonmhs )."','{$tahuna}',\r\n      '{$gelombang}','{$idpilihan}','{$data['hp']}',\r\n      '{$data['biaya']}',  NOW(),'{$users_bank}','{$data['email']}',MD5('{$passwordacak}'),CURDATE(),'')\r\n\t\t";
							#echo $q;exit();
			
		$q_biaya = "SELECT BIAYA FROM waktudaftarpmb  WHERE TAHUN='$tahuna' AND GELOMBANG='$gelombang' AND PRODI='$idprodi1'";
    		$h_biaya = mysqli_query($koneksi,$q_biaya);
		if ( 0 < sqlnumrows( $h_biaya ) )
        	{
			$d_biaya = sqlfetcharray( $h_biaya );
			$biaya_per_prodi=$d_biaya['BIAYA'];
		}else{
			$biaya_per_prodi=0;
    		}
							#mysql_query( "LOCK TABLES mahasiswa WRITE, calonmahasiswa WRITE", $koneksi );	
							$q = "INSERT INTO calonmahasiswa \r\n      (ID,NAMA,TAHUN,GELOMBANG,PILIHAN, TEMPATLAHIR,TANGGALLAHIR,KELAMIN,STATUSNIKAH,AGAMA,ALAMAT,TELEPON,HP,WN,ASALSMA,NOIJAZAH,TANGGALIJAZAH,NILAIUN,NILAIUNS,NAMAAYAH,NAMAIBU,ALAMATORTU,PRODI1,BIAYA,EMAIL,PASSWORD,TANGGALDAFTAR,PASSWORD2, UPDATERBANK,TANGGALUPDATEBANK,STATUS,TAHUNLULUSSMA,PENDIDIKAN,ALAMATIBU,TELEPONAYAH,TELEPONIBU,KOTA,PROVINSI,KTP,STATUSBARU,KELURAHAN,KECAMATAN,STATUSISIBIODATA,STATUSPILIHPRODI,JASALMAMATER,REFERAL,DAPATINFO,NISN) \r\n\t\t\tVALUES ('{$nimbaru}','".strtoupper( $namacalonmhs )."','{$tahuna}',\r\n      '{$gelombang}','{$idpilihan}','{$data['tempat']}','{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}','{$data['statusnikah']}','{$data['agama']}','{$data['alamat']}','{$data['telepon']}','{$data['hp']}','{$data['wn']}','{$data['asal']}','{$data['noijazah']}','{$tglijazah['thn']}-{$tglijazah['bln']}-{$tglijazah['tgl']}','{$data['jumlahun']}','{$data['jumlahuns']}','{$data['namaayah']}','{$data['namaibu']}','{$data['alamatortu']}','{$idprodi1}',  '{$biaya_per_prodi}','{$data['email']}',MD5('{$passwordacak}'),NOW(),'','{$nimbaru}',CURDATE(),'0','{$data['tahunlulussma']}','{$data['pendidikan']}','{$data['alamatibu']}','{$data['teleponayah']}','{$data['teleponibu']}','{$data['kota']}','{$data['provinsi']}','{$data['ktp']}','{$statusbaru}','{$data['KELURAHAN']}','{$data['KECAMATAN']}','1','1','{$data['baju']}','{$data['referal']}','{$data['infodaftarpmb']}','{$data['nisn']}')";
							#echo $q.'<br>';
							#exit();

							#$q = "INSERT INTO calonmahasiswa (ID,NAMA,TAHUN,GELOMBANG,PILIHAN, HP , BIAYA, TANGGALUPDATEBANK,UPDATERBANK,EMAIL,PASSWORD,TANGGALDAFTAR,PASSWORD2,PRODI1)
							#SELECT MAX(ID)+1,'".strtoupper( $data[nama] )."','{$tahuna}',\r\n      '{$gelombang}','{$idpilihan}','{$data['hp']}',\r\n      '{$data['biaya']}',  NOW(),'{$users_bank}','{$data['email']}',MD5('{$passwordacak}'),CURDATE(),'','{$idprodi1}' FROM mahasiswa WHERE ANGKATAN='{$tahuna}' AND IDPRODI='{$idprodi1}'";
							
							#echo $q.'<br>';exit();
							mysqli_query($koneksi,$q);							
							#mysql_query( "UNLOCK TABLES mahasiswa", $koneksi );
							#echo $q;exit();
							
							$users = $users_bank;
							$ketlog = "Tambah Data Pendaftaran Calon Mahasiswa dengan ID={$nimbaru} dan Nama={$namacalonmhs} oleh Pendaftar";
							if ( 0 < sqlaffectedrows( $koneksi ) )
							{
								#mysql_query( "UNLOCK TABLES", $koneksi );
								
								
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
								$dmail['subject'] = str_replace( "[IDCALONMAHASISWA]", "{$nimbaru}", html_entity_decode( $dr[SUBJEK] ) );
								$dmail['subject'] = str_replace( "[NAMACALONMAHASISWA]", "{$data['nama']}", $dmail[subject] );
								$dmail['subject'] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[subject] );
								$dmail['body'] = str_replace( "[IDCALONMAHASISWA]", "{$nimbaru}", html_entity_decode( $dr[ISI] ) );
								$dmail['body'] = str_replace( "[NAMACALONMAHASISWA]", "{$namacalonmhs}", $dmail[body] );
								$dmail['body'] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[body] );
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
								
								
								
								#$errmesg = "Data Pendaftaran Calon Mahasiswa berhasil ditambah dengan ID {$idupdate}.<br> {$errmesgemail} {$errmesgsms} Klik di <a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$idupdate}&tahunupdate={$tahuna}&gelupdate={$gelombang}&pilihanupdate={$idpilihan}'>sini untuk Melihat dan mencetak Formulir</a>.";
								$errmesg = "Data Pendaftaran Calon Mahasiswa berhasil ditambah dengan ID {$nimbaru}.<br> {$errmesgemail} {$errmesgsms} Klik di <a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$nimbaru}&tahunupdate={$tahuna}&gelupdate={$gelombang}&pilihanupdate={$idpilihan}'>sini untuk Melihat dan Mencetak kuitansi pembayaran</a>.";
								
								$data = "";
								$id = "";
								$semester2 = $semesterawal = $ktp = $gelar = $jabatan = $pendidikan = $instansidosen = "";
							}
							else
							{
								$errmesg = "Data Pendaftaran Calon Mahasiswa tidak berhasil ditambah.";
							}
						}
                    }
                #}
            }
        }
    /*}
    else
    {
        $errmesg = token_err_mesg( "Pendaftaran Calon Mahasiswa", TAMBAH_DATA );
    }*/
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
	$q = "SELECT \r\n     waktudaftarpmb.*,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALMULAI,'%d-%m-%Y') AS TM,\r\n      DATE_FORMAT(waktudaftarpmb.TANGGALSELESAI,'%d-%m-%Y') AS TS,\r\n      IF (\r\n        CURDATE() >= waktudaftarpmb.TANGGALMULAI AND\r\n        CURDATE() <= waktudaftarpmb.TANGGALSELESAI,\r\n        1,\r\n        0\r\n      \r\n      ) AS STATUSONLINE\r\n       FROM waktudaftarpmb  ORDER BY tahun DESC LIMIT 1";

       
# echo $q;exit();
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

		#$wajibdiisi = "<b style='font-size:8pt;'>Wajib Diisi</b>";
		$q="select GELOMBANG FROM waktudaftarpmb WHERE TANGGALSELESAI>=CURDATE() AND TANGGALMULAI<=CURDATE() AND TAHUN='$w[year]'";
		#echo $q;
		$h = mysqli_query($koneksi,$q);
        	echo mysqli_error($koneksi );
        	if ( 0 < sqlnumrows( $h ) )
        	{
            		$d = sqlfetcharray( $h );
        	}
		$gelombang=$d['GELOMBANG'];
    		$token = md5( uniqid( rand( ), TRUE ) );
		#echo $token.'<br>';
    		$_SESSION['token'] = $token;
		#echo $_SESSION['token'];
		#echo $kodemenu;
   	 	#cekhaktulis($kodemenu,"bank");
    		printjudulmenu( "Tambah Data Calon Mahasiswa (semua data harus terisi dengan benar)" );
    		printmesg($errmesg);
    		#echo "\r\n\t\t<form name=form action=index.php method=post onSubmit=\"return confirm('Lakukan penambahan data? Data yang telah ditambahkan tidak akan dapat dihapus.')\">\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."  \r\n    <tr class=judulform>\r\n\t\t\t<td>Tanggal Pendaftaran</td>\r\n\t\t\t<td>{$w['mday']}-{$w['mon']}-{$w['year']} </td>\r\n\t\t</tr> \t\t\t<td>Tahun Daftar</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $tahuna, " class=masukan " )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang {$tahuna}</td>";
    		echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' onSubmit=\"return confirm('Lakukan penambahan data? Data yang telah ditambahkan tidak akan dapat dihapus.')\">\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."  \r\n    <tr class=judulform>\r\n\t\t\t<td colspan=2><b>DATA CALON MAHASISWA</b><hr></td>\r\n\t\t</tr>\r\n\r\n  <tr class=judulform>\r\n\t\t\t<td>Nama Calon Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data['nama'], " class=masukan  size=50" )." {$wajibdiisi} </td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Nomor Induk Siswa Nasional *</td>\r\n\t\t\t<td>".createinputtext( "data[nisn]", $data['nisn'], " class=masukan  size=50 maxlength=10" )." {$wajibdiisi} </td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>No KTP *</td>\r\n\t\t\t<td>".createinputtext( "data[ktp]", $data[ktp], " class=masukan  size=50" )." {$wajibdiisi} </td>\r\n\t\t</tr>\r\n \r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>HP/Telepon Seluler *</td>\r\n\t\t\t<td>".createinputtext( "data[hp]", $data[hp], " class=masukan  size=50" )."  {$wajibdiisi}</td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>E-mail*</td>\r\n\t\t\t<td>".createinputtext( "data[email]", $data[email], " class=masukan  size=50" )." Disarankan mempunyai akun gmail </td></tr> ";
		echo "\r\n    <tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir *</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", $data['tempat'], " class=masukan  size=10" )." / ".createinputtanggal( "data", $data, " class=masukan" )."{$wajibdiisi}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin*</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $data['kelamin'], "", " class=masukan " )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Agama*</td>\r\n\t\t\t<td>".createinputselect( "data[agama]", $arrayagama, $data['agama'], "", " class=masukan " )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Nikah*</td>\r\n\t\t\t<td>".createinputselect( "data[statusnikah]", $arraystatusnikah, $data['statusnikah'], "", " class=masukan " )."</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat*</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data['alamat'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Kelurahan*</td>\r\n\t\t\t<td>".createinputtext( "data[KELURAHAN]", $data['KELURAHAN'], " class=masukan  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Kecamatan*</td>\r\n\t\t\t<td>".createinputtext( "", $arraykecamatan{$KECAMATAN}, "class=masukan  autocomplete=off size=30 id='inputStringKecamatan' onkeyup=\"lookupKecamatan(this.value,'','');\" \r\n\t" ).createinputhidden( "data[KECAMATAN]", $KECAMATAN, " class=masukan  size=20      id='inputStringDataKecamatan'" )."{$wajibdiisi} <div class=\"suggestionsBox\" id=\"suggestionsKecamatan\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsListKecamatan\">\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Kota*</td>\r\n\t\t\t<td>".createinputtext( "data[kota]", $data['kota'], " class=masukan  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Provinsi*</td>\r\n\t\t\t<td>".createinputtext( "data[provinsi]", $data['provinsi'], " class=masukan  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Kewarganegaraan*</td>\r\n\t\t\t<td>".createinputselect( "data[wn]", $arraywn, $data['wn'], "", " class=masukan " )."</td>\r\n\t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Asal Sekolah*</td>\r\n\t\t\t<td>".createinputtext( "data[asal]", $data['asal'], " class=masukan  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Tahun Lulus*</td>\r\n\t\t\t<td>".createinputtext( "data[tahunlulussma]", $data['tahunlulussma'], " class=masukan  size=4 maxlength=4" )."{$wajibdiisi}</td>\r\n\t\t</tr> \r\n\r\n\t\t\r\n\t\t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>No. Ijazah / No. Surat Kelulusan Sementara*</td>\r\n\t\t\t<td>".createinputtext( "data[noijazah]", $data['noijazah'], " class=masukan size=20" )."</td>\r\n\t\t</tr>\r\n    <tr >\r\n\t\t\t<td>Tanggal Ijazah*</td>\r\n\t\t\t<td>".createinputtanggal( "tglijazah", $tglijazah, " class=masukan" )."</td>\r\n\t\t</tr> 		<tr class=judulform>\r\n\t	<td>File Ijazah / Kelulusan sementara*</td>\r\n\t\t\t<td>\r\n\t\t\t{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=masukan> {$wajibdiisi} Max. 1 MB (File pdf,doc,docx)</td>\r\n\t\t</tr> \r\n\t\t\r\n\t\t\r\n   \t\t <tr class=judulform>\r\n\t\t\t<td>Jumlah Nilai Ujian Nasional*</td>\r\n\t\t\t<td>".createinputtext( "data[jumlahun]", $data['jumlahun'], " class=masukan size=2" )." (ganti koma dengan titik)</td></tr><tr class=judulform>\r\n\t\t\t<td>Jumlah Nilai Ujian Sekolah*</td>\r\n\t\t\t<td>".createinputtext( "data[jumlahuns]", $data['jumlahuns'], " class=masukan size=2" )."(ganti koma dengan titik)</td></tr><tr class=judulform><td width=250>Pendidikan Terakhir*</td><td>".createinputtext( "data[pendidikan]", $data['pendidikan'], " class=masukan size=20" )."</td></tr><tr class=judulform><td>Pas Foto*</td><td>\r\n\t\t\t{$fotosaatini}\r\n\t\t\t<input type=file name=foto class=masukan> Max. 1 MB (File png,jpg,jpeg) {$wajibdiisi} </td>\r\n\t\t</tr><tr class=judulform><td>Ukuran Baju Almamater*</td>\r\n\t\t\t<td>".createinputselect( "data[baju]", $arraybaju, $data['baju'], "", " class=masukan " )."</td>\r\n\t\t</tr><tr class=judulform><td>Informasi ini diperoleh dari*</td>\r\n\t\t\t<td>".createinputselect( "data[infodaftarpmb]", $arrayinfodaftarpmb, $data['infodaftarpmb'], "", " class=masukan " )."</td>\r\n\t\t</tr><tr class=judulform><td>Nama Referal</td>\r\n\t\t\t<td>".createinputtext( "data[referal]", $data['referal'], " class=masukan size=20 maxlength=50" )." (Nama yang mereferensikan untuk melakukan pendaftaran)</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td colspan=2><b>DATA ORANG TUA</b><hr></td>\r\n\t\t</tr>\r\n\r\n   \t<tr class=judulform>\r\n\t\t\t<td>Nama Ayah*</td>\r\n\t\t\t<td>".createinputtext( "data[namaayah]", $data['namaayah'], " class=masukan size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat Ayah*</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamatortu]", $data['alamatortu'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>\r\n\t\t</tr>  \r\n   \t<tr class=judulform>\r\n\t\t\t<td>No. Kontak Ayah*</td>\r\n\t\t\t<td>".createinputtext( "data[teleponayah]", $data['teleponayah'], " class=masukan size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n   \t<tr class=judulform>\r\n\t\t\t<td>Nama Ibu*</td>\r\n\t\t\t<td>".createinputtext( "data[namaibu]", $data['namaibu'], " class=masukan size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat Ibu*</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamatibu]", $data['alamatibu'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td>\r\n\t\t</tr>  \r\n   \t<tr class=judulform>\r\n\t\t\t<td>No. Kontak Ibu*</td>\r\n\t\t\t<td>".createinputtext( "data[teleponibu]", $data['teleponibu'], " class=masukan size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n\r\n \r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><b>DATA PENDAFTARAN</b><hr></td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Tanggal Pendaftaran*</td>\r\n\t\t\t<td>{$w['mday']}-{$w['mon']}-{$w['year']} </td>		</tr> \t\t\t<td>Tahun 	Daftar*</td>\r\n\t\t\t<td>".createinputtext( "tahuna", $w['year'], " class=masukan size=4 readonly" )."</td>\r\n\t\t</tr> <tr class=judulform>\r\n\t\t\t<td>Gelombang* {$tahuna}</td>";
    		#if ( $gelombang == "" )
    		#{
     		#   $gelombang = 1;
    		#}
    
		if ( $tahuna == "" )
    		{
        		$tahuna = $w['year'];
    		}

    		if ( $idpilihan == "" )
    		{
        		$idpilihan = $arraypilihan[$initidpilihan];
    		}
    		echo "<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2 readonly" )."</td>\r\n\t\t</tr> \r\n<tr class=judulform>\r\n\t\t\t<td>Pilihan</td>\r\n\t\t\t<td>".createinputselect( "idpilihan", $arraypilihanpmb, $idpilihan, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n \t\t\r\n   <tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 1</td>\r\n\t\t\t<td>".createinputselect( "idprodi1", $arrayprodipmb, $idprodi1, "", " class=masukan" )."</td>\r\n\t\t</tr><tr>\r\n  <td >Status Awal Mahasiswa Baru</td>\r\n  <td >\r\n  ".createinputselect( "statusbaru", $arraystatusmhsbaru, $d2['STPIDMSMHS'], "", " class=masukan" )."\r\n  </td>\r\n</tr><!--<tr class=judulform>\r\n\t\t\t<td>Catatan</td><td>".createinputtextarea( "data[catatan]", $data['catatan'], " class=masukan  cols=50 rows=4" )."{$wajibdiisi}</td></tr>-->";
		echo "<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form><script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
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
if ( $aksi == "" )
{
    #printjudulmenu( "Cetak Kuitansi ", "bantuan" );
    #printhelp( trim( $arrayhelp[caridosen] ), "bantuan" );
    #printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table><tr><td>\r\n    <table  >\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pendaftaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <input type=checkbox name=iftgl value=1>\r\n            ".createinputtanggal( "tgl1", $tgl1, " class=masukan" )." s.d ".createinputtanggal( "tgl2", $tgl2, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\r\n\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Masuk\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahunmasuk class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu['year'] + 5 )
    {
        $cek = "";
        if ( $i == $waktu['year'] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Gelombang</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."\r\n  \t\t\t</td>\r\n\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tPilihan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idpilihan>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraypilihanpmb as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr> \t\t\r\n      <tr class=judulform>\r\n\t\t\t<td>ID/Nomor Tes </td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=50" )."\r\n  \t\t\t</td>\r\n\t\t</tr>\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Nama</td>\r\n\t\t\t<td>".createinputtext( "nama", $nama, " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n\r\n \r\n      </table> \r\n      <table>\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan Data' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
	
}
?>
