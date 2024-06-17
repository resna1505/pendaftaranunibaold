<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/


function http_build_query_for_curl( $arrays, $new = array( ), $prefix = null )
{
    if ( is_object( $arrays ) )
    {
        $arrays = get_object_vars( $arrays );
    }
    foreach ( $arrays as $key => $value )
    {
        $k = isset( $prefix ) ? $prefix."[".$key."]" : $key;
        if ( is_array( $value ) || is_object( $value ) )
        {
            http_build_query_for_curl( $value, $new, $k );
        }
        else
        {
            $new[$k] = $value;
        }
    }
}

function sinkronisasi_pusaka( $jenis = "TAMBAH", $idmahasiswa, $tipe = 2 )
{
    global $koneksi;
    if ( $tipe == 2 )
    {
        $tabel = "mahasiswa";
    }
    else
    {
        $tabel = "dosen";
    }
    $hasil = 0 - 1;
    $urlpusaka = getaturan( "URLPUSAKA" );
    $postdata['KEY'] = ID_PROGRAM;
    if ( getaturan( "PUSAKA" ) == 1 && $urlpusaka != "" )
    {
        $postdata['tipe'] = $tipe;
        $postdata['jenis'] = $jenis;
        $postdata['idmahasiswa'] = $idmahasiswa;
        if ( $jenis == "HAPUS" )
        {
        }
        else if ( $jenis == "TAMBAH" || $jenis == "UPDATE" )
        {
            $q = "SELECT *  FROM {$tabel} WHERE ID='{$idmahasiswa}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $ds['NAMA'] = $d['NAMA'];
            if ( $d['KELAMIN'] == "L" )
            {
                $ds['JKELAMIN'] = 0;
            }
            else
            {
                $ds['JKELAMIN'] = 1;
            }
            $tmp = explode( "-", $d['TANGGAL'] );
            $ds['TTL'] = $d['TEMPAT'].","."{$tmp['2']}-{$tmp['1']}-{$tmp['0']}";
            $ds['ALAMAT'] = $d['ALAMAT'];
            $ds['TELEPON'] = $d['TELEPON'];
            $ds['HP'] = $d['HP'];
            $ds['EMAIL'] = $d['EMAIL'];
            $ds['STATUS'] = "normal";
            $ds['TIPEANGGOTA'] = 0;
            if ( $tipe == 2 )
            {
                $ds['JENIS'] = "Mahasiswa";
                $ds['NPM'] = $idmahasiswa;
                $ds['ALAMATORTU'] = $d['ALAMATAYAH'];
                $ds['TELEPONORTU'] = $d['NOAYAH'];
                $ds['ANGKATAN'] = $d['ANGKATAN'];
                $ds['IDPRODI'] = $d['IDPRODI'];
            }
            else
            {
                $ds['JENIS'] = "Dosen";
                $ds['IDPRODI'] = $d['IDDEPARTEMEN'];
            }
        }
        $postdata[ds] = $ds;
        http_build_query_for_curl( $postdata, $post );
        $ch = curl_init( );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
        curl_setopt( $ch, CURLOPT_URL, $urlpusaka."/sinkronisasi_sikad.php" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $hasil = curl_exec( $ch );
        if ( curl_errno( $ch ) )
        {
            $errorcurl = curl_error( $ch );
        }
        curl_close( $ch );
    }
    return $hasil;
}

function is_sms_gateway_installed( )
{
    global $koneksi;
    $q = "SELECT * FROM konfigsms LIMIT 0,1";
    $hx = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = sqlfetcharray( $hx );
        $headerSMS = strtoupper( trim( $dx[KODE] ) );
        $url = trim( $dx[URL] );
        $url = str_replace( basename( $url ), "prosessms_sikad.php", $url );
        $postfields = "ID_PROGRAM=".urlencode( ID_PROGRAM );
        $postfields .= "&TES=1";
        $ch = curl_init( );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
        curl_setopt( $ch, CURLOPT_URL, $url."?".$postfields );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $hasil = curl_exec( $ch );
        if ( curl_errno( $ch ) )
        {
            $errorcurl = curl_error( $ch );
        }
        curl_close( $ch );
        if ( $hasil == "1" )
        {
            return true;
        }
        return false;
    }
    return false;
}

function is_pear_mail_installed( )
{
    include_once( "Mail.php" );
    include_once( "Mail/mime.php" );
    if ( class_exists( "Mail_mime" ) )
    {
        return true;
    }
    return false;
}

function number_format_sikad( $number, $desimal = 0, $dec_point = ".", $tousan_sep = "," )
{
    return number_format( $number + 0, $desimal, $dec_point, $tousan_sep );
}

function isoperator( )
{
    global $jenisusers;
    if ( $jenisusers == 0 )
    {
        return true;
    }
    return false;
}

function iswali( )
{
    global $jenisusers;
    if ( $jenisusers == 3 )
    {
        return true;
    }
    return false;
}

function isdosen( )
{
    global $jenisusers;
    if ( $jenisusers == 1 )
    {
        return true;
    }
    return false;
}

function ismahasiswa( )
{
    global $jenisusers;
    if ( $jenisusers == 2 )
    {
        return true;
    }
    return false;
}

function issupervisor( $id )
{
    global $koneksi;
    $q = "SELECT JENIS FROM user WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    return $d['JENIS'];
}

function iscuti( $idmahasiswa, $semester )
{
    global $koneksi;
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM\t= '{$idmahasiswa}' AND STMHSTRLSM = 'C' AND THSMSTRLSM= '{$semester}' LIMIT 0,1 ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        return true;
    }
    return false;
}

function isadacuti( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT COUNT(*) AS JML FROM trlsm WHERE\r\n  NIMHSTRLSM='{$idmahasiswa}'  AND STMHSTRLSM='C' ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    return $cuti = $d['JML'] + 0;
}

function getsemesetermaksimummahasiswa( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT SEMESTERMAX FROM prodi,mahasiswa WHERE prodi.ID=mahasiswa.IDPRODI AND mahasiswa.ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $semestermahasiswa = $d['SEMESTERMAX'] + 0;
    return $semestermahasiswa;
}

function getsemesetermahasiswa( $idmahasiswa, $tahunajaran, $semester )
{
    global $koneksi;
    $q = "SELECT ANGKATAN FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $angkatan = $d['ANGKATAN'];
    $q = "SELECT SMAWLMSMHS FROM msmhs WHERE NIMHSMSMHS='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    $semesterawal = 1;
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $semesterawal = substr( $d['SMAWLMSMHS'], 4, 1 );
    }
    if ( $semesterawal == 1 )
    {
        $tambahansemester = 0;
    }
    else
    {
        $tambahansemester = 0 - 1;
    }
    $semestermahasiswa = ( $tahunajaran - 1 - $angkatan ) * 2 + $semester + $tambahansemester;
    return $semestermahasiswa;
}

function getstatusminimalpembayaranmahasiswa($idmahasiswa,$tahun,$semester,$jenis) {
  global $koneksi,$BIAYASKSKULIAH,$JENISKELAS;

      if ($JENISKELAS==1 && getaturan("BIAYAKEUANGAN")==1 ) {
            $qfield=" AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
      }  else {
            $qfield=" AND biayakomponen.JENISKELAS='' ";
      }

        if ($jenis=="UTS") {
          $field="UTS";
        } elseif ($jenis=="UAS") {
          $field="UAS";
        } elseif ($jenis=="KRS") {
          $field="KRS";
        }
        $lunas=0;
            /// DAPATKAN MINIMAL PEMBAYARAN
           		        $q="SELECT biayakomponen.IDKOMPONEN , biayakomponen.$field AS BATAS ,biayakomponen.BIAYA AS TOTAL,
           		      komponenpembayaran.JENIS,komponenpembayaran.NAMA
            		FROM komponenpembayaran,biayakomponen,mahasiswa
            		WHERE
            		  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND
            		  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND
            		  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND
            		  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
              		  mahasiswa.ID='$idmahasiswa'   $qfield
            			 
            		";               
            		
            		 #echo $q;
                   $ht=mysqli_query($koneksi,$q);
                   
                  if (sqlnumrows($ht)>0) {
                    while ($dt=sqlfetcharray($ht)) {
                       //echo $dt[IDKOMPONEN]." - ".$dt[UTS]."<br>";     
                            // Get beasiswa //
                            $qbeasiswa="SELECT DISKON FROM diskonbeasiswa WHERE IDKOMPONEN='$dt[IDKOMPONEN]' AND IDMAHASISWA='$idmahasiswa' ";


                       if ($dt[JENIS]==5 || $dt[JENIS]==4) { // BULANAN dan TIDAK TETAP, ABAIKAN  KECUALI ADA SPEK LAIN NANTI             
                        //$lunas++;
                       } elseif($dt[IDKOMPONEN]!=99) { // NORMAL, BUKAN BIAYA TAMBAHAN SKS 
                          // CARI TOTAL PEMBAYARAN
                          if ( $dt[JENIS]==0 ) { //0 = 1 x Awal Kuliah
                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]'";
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);
                            
                            // BEASISWA
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
                            
                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
                                                        
                          } else
                          if ( $dt[JENIS]==1 ) { //1 = 1 x Akhir Kuliah, tidak dicek
                          } else
                          if ( $dt[JENIS]==2 ) { //2 = Per Tahun Ajaran
                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' ";
                            $ht2=mysqli_query($koneksi,$q);
                            echo mysqli_error($koneksi);
                            $dt2=sqlfetcharray($ht2);


                            // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }


                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              #echo "apa";
							  $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
                          }  else
                          if ( $dt[JENIS]==3 ) { //2 = Per Semester
                              $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester'  ";
                            #echo $q;
							$ht2=mysqli_query($koneksi,$q);
                            $dt2=sqlfetcharray($ht2);

                            // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            //echo mysqli_error($koneksi);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }

                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
                          }
                       } /*elseif (0  /*SEMENTARA DITUTUP UNTUK 1 SEMESTER INI SAJA 
                       $dt[IDKOMPONEN]==99 && $jenis!="KRS"   ) {*/ //BIAYA TAMBAHAN SKS
					   elseif (0  /*SEMENTARA DITUTUP UNTUK 1 SEMESTER INI SAJA 
                       $dt[IDKOMPONEN]==99 && $jenis!="KRS"*/   ) {


                            $jumlahsks=getjumlahsks($idmahasiswa,$tahun,$semester);
                            $jumlahskswajib=getjumlahskswajib($idmahasiswa,$tahun,$semester);
                            $skslebih=0;
                            if ($jumlahsks>$jumlahskswajib) {
                               $skslebih=$jumlahsks-$jumlahskswajib;
                            }
 
                               $biayakomponen=$dt[TOTAL]+0;
                               if ($BIAYASKSKULIAH==1) {
                                  $dt[BATAS]=$jumlahsks*$biayakomponen;
                               } else {
                                  $dt[BATAS]=$skslebih*$biayakomponen;
                              }


                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]'   ";
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);
 
                             // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
 
                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang  $dt[BATAS]-$dt2[TOTAL] Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break; 

                            }


                       
                       } elseif ($dt[IDKOMPONEN]==98 && $jenis!="KRS") { //BIAYA TAMBAHAN SKS


                            $jumlahsks=getjumlahskssp($idmahasiswa,$tahun,$semester);
                            $jumlahskswajib=0;
                            $skslebih=0;
                            if ($jumlahsks>$jumlahskswajib) {
                               $skslebih=$jumlahsks-$jumlahskswajib;
                            }
 
                               $biayakomponen=$dt[TOTAL]+0;
                               if ($BIAYASKSKULIAH==1) {
                                  $dt[BATAS]=$jumlahsks*$biayakomponen;
                               } else {
                                  $dt[BATAS]=$skslebih*$biayakomponen;
                              }


                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]'   ";
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);


                             // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
 

                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;

                            }


                       
                       }                    }
                  
                  }
                  $arrayhasil[LUNAS]=$lunas;
                  $arrayhasil[STATUS]=$status;
                  return $arrayhasil;
  
}

function getstatusminimalpembayaransppmahasiswa($idmahasiswa,$tahun,$semester,$jenis) {
  #echo 
  global $koneksi,$BIAYASKSKULIAH,$JENISKELAS;

      if ($JENISKELAS==1 && getaturan("BIAYAKEUANGAN")==1 ) {
            $qfield=" AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
      }  else {
            $qfield=" AND biayakomponen.JENISKELAS='' ";
      }

        if ($jenis=="UTS") {
          $field="UTS";
        } elseif ($jenis=="UAS") {
          $field="UAS";
        } elseif ($jenis=="KRS") {
          $field="KRS";
        }
        $lunas=0;
		#$bln_jalan=date('m');
		$thn_jalan=date('Y');
		
		//query untuk lampung
		//ambil waktu pembayaran untuk tiap jenis (KRS,UTS,UAS)
		
#$sqlgetwaktubayar="SELECT TANGGALMULAI,TANGGALSELESAI FROM waktukeuangan WHERE JENIS='$field' ORDER BY TAHUN DESC LIMIT 1";
		#echo $sqlgetwaktubayar;
#$querygetwaktubayar=mysql_query($sqlgetwaktubayar,$koneksi);
#		$datagetwaktubayar=sqlfetcharray($querygetwaktubayar);
		#echo $datagetwaktubayar;
//end query
            /// DAPATKAN MINIMAL PEMBAYARAN
           		    /*    $q="SELECT biayakomponen.IDKOMPONEN , biayakomponen.$field AS BATAS ,biayakomponen.BIAYA AS TOTAL,
           		      komponenpembayaran.JENIS,komponenpembayaran.NAMA
            		FROM komponenpembayaran,biayakomponen,mahasiswa
            		WHERE
            		  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND
            		  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND
            		  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND
            		  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
              		  mahasiswa.ID='$idmahasiswa' AND biayakomponen.IDKOMPONEN='002'  $qfield
            			 
            		";    */ 
					
					// query buat lampung
					
					/*    $q="SELECT biayakomponen.IDKOMPONEN , biayakomponen.$field AS BATAS ,biayakomponen.BIAYA AS TOTAL,
           		      komponenpembayaran.JENIS,komponenpembayaran.NAMA
            		FROM komponenpembayaran,biayakomponen,mahasiswa
            		WHERE
            		  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND
            		  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND
            		  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND
            		  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
              		  mahasiswa.ID='$idmahasiswa' AND biayakomponen.IDKOMPONEN='002'   $qfield
            			 
            		";*/

					//end query buat lampung

					// query buat batam
					
					$q="SELECT biayakomponen.IDKOMPONEN , biayakomponen.$field AS BATAS ,biayakomponen.BIAYA AS TOTAL,
           		      komponenpembayaran.JENIS,komponenpembayaran.NAMA
            		FROM komponenpembayaran,biayakomponen,mahasiswa
            		WHERE
            		  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND
            		  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND
            		  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND
            		  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND
              		  mahasiswa.ID='$idmahasiswa' $qfield
            			 
            		";

					//end query buat batam	
            		
            		#echo $q.'<br>';
                   $ht=mysqli_query($koneksi,$q);
                   
                  if (sqlnumrows($ht)>0) {
					#echo "mm";exit();
                    while ($dt=sqlfetcharray($ht)) {
                       //echo $dt[IDKOMPONEN]." - ".$dt[UTS]."<br>";     
                            // Get beasiswa //
                            $qbeasiswa="SELECT DISKON FROM diskonbeasiswa WHERE IDKOMPONEN='$dt[IDKOMPONEN]' AND IDMAHASISWA='$idmahasiswa' ";


                       if ($dt[JENIS]==5 || $dt[JENIS]==4) { // BULANAN dan TIDAK TETAP, ABAIKAN  KECUALI ADA SPEK LAIN NANTI       
						#echo "kesini";exit();
                        //$lunas++;
                       } elseif($dt[IDKOMPONEN]!=99) { // NORMAL, BUKAN BIAYA TAMBAHAN SKS 
                          // CARI TOTAL PEMBAYARAN
                          if ( $dt[JENIS]==0 ) { //0 = 1 x Awal Kuliah
                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]'";
							#echo "AAAA".$q.'<br>';
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);
                            
                            // BEASISWA
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
                            
                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
                                                        
                          } else
                          if ( $dt[JENIS]==1 ) { //1 = 1 x Akhir Kuliah, tidak dicek
                          } else
                          if ( $dt[JENIS]==2 ) { //2 = Per Tahun Ajaran
                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' ";
                            #echo $q;
							$ht2=mysqli_query($koneksi,$q);
                            echo mysqli_error($koneksi);
                            $dt2=sqlfetcharray($ht2);


                            // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              #$dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
							  if($dbeasiswa[DISKON]>100){
									#echo "lll";
									#$diskon_rp=$d[DISKON];
									#$diskon=0;
									$dt[BATAS]=$dt[BATAS]-$dbeasiswa[DISKON];
								}else{
								#echo "xxx";
									#$diskon=$d[DISKON];
									#$diskon_rp=0;
									$dt[BATAS]=$dt[BATAS]*(1-($dbeasiswa[DISKON]/100));
								}
                            }


                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              #echo "apa";
							  $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
                          }  else
                          if ( $dt[JENIS]==3 ) { //2 = Per Semester
                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester'  ";
                            #$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            #IDKOMPONEN='$dt[IDKOMPONEN]' AND YEAR(TANGGALBAYAR)='{$thn_jalan}' AND MONTH(TANGGALBAYAR)='{$bln_jalan}'";
                            #$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            #IDKOMPONEN='$dt[IDKOMPONEN]'";
                            #$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            #IDKOMPONEN='$dt[IDKOMPONEN]' AND YEAR(TANGGALBAYAR)='{$thn_jalan}'";
			// query untuk lampung
			#				$q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                         #   IDKOMPONEN='$dt[IDKOMPONEN]' AND TANGGALBAYAR>='$datagetwaktubayar[TANGGALMULAI]' ".
			#				"AND TANGGALBAYAR<='$datagetwaktubayar[TANGGALSELESAI]'";
                          //end query  
							#echo $q.'<br>';
							$ht2=mysqli_query($koneksi,$q);
                            $dt2=sqlfetcharray($ht2);

                            // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
							#$qbeasiswa=$qbeasiswa." AND YEAR(TANGGALUPDATE)='$thn_jalan' ";
							#$qbeasiswa=$qbeasiswa." AND YEAR(TANGGALUPDATE)='$thn_jalan' LIMIT 1";
			//query untuk lampung	
			#$qbeasiswa=$qbeasiswa." ORDER BY TANGGALUPDATE DESC LIMIT 1";
			//end query				
							#echo $qbeasiswa.'<br>';
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            //echo mysqli_error($koneksi);
							#echo "KK".$dt[BATAS].'<br>';$diskonbeasiswanya=1-($diskonnya/100);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
								if($dbeasiswa[DISKON]>100){
									#echo "lll";
									#$diskon_rp=$d[DISKON];
									#$diskon=0;
									$dt[BATAS]=$dt[BATAS]-$dbeasiswa[DISKON];
								}else{
								#echo "xxx";
									#$diskon=$d[DISKON];
									#$diskon_rp=0;
									$dt[BATAS]=$dt[BATAS]*(1-($dbeasiswa[DISKON]/100));
								}
                              #$dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
							#	echo $dt[BATAS]."mmm".$dt2[TOTAL]."bbb".$dt[BATAS]; 
                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;
                            }
							
							//cek lagi bulan jalan
							/*$qbulanjalan="SELECT TANGGALBAYAR FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND YEAR(TANGGALBAYAR)='{$thn_jalan}' ORDER BY TANGGALBAYAR DESC LIMIT 1";
                            
							#echo $qbulanjalan;
							$htbulanjalan2=mysql_query($qbulanjalan,$koneksi);
                            $dtbulanjalan2=sqlfetcharray($htbulanjalan2);
							#echo $dtbulanjalan2['TANGGALBAYAR'];
							list($Y,$m,$d)=explode("-",$dtbulanjalan2['TANGGALBAYAR']);
							#echo $m."lll".$bln_jalan;
							if($m<$bln_jalan){
								$lunas--;
							}*/
                          }
						} #elseif (0  /*SEMENTARA DITUTUP UNTUK 1 SEMESTER INI SAJA $dt[IDKOMPONEN]==99 && $jenis!="KRS"  */ )
						#elseif ($dt[IDKOMPONEN]==99 && $jenis!="KRS")
						elseif ($dt[IDKOMPONEN]==99)						
						{ //BIAYA TAMBAHAN SKS


                            $jumlahsks=getjumlahsks($idmahasiswa,$tahun,$semester);
                            $jumlahskswajib=getjumlahskswajib($idmahasiswa,$tahun,$semester);
                            $skslebih=0;
							#echo $jumlahsks."DDDD".$jumlahskswajib;
                            if ($jumlahsks>$jumlahskswajib) {
                               $skslebih=$jumlahsks-$jumlahskswajib;
                            }
								#echo $BIAYASKSKULIAH.'<br>';
                               $biayakomponen=$dt[TOTAL]+0;
                               if ($BIAYASKSKULIAH==1) {
                                  $dt[BATAS]=$jumlahsks*$biayakomponen;
                               } else {
								#	echo "lolo";
								#echo $skslebih."KKKK".$biayakomponen;
								 $dt[BATAS]=$skslebih*$biayakomponen;
                              }


                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]' AND TAHUNAJARAN='$tahun' AND SEMESTER='$semester'  ";
							#echo $q.'<br>';
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);
 
                             // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
 
                            //$lunas++;
							#echo "l ".$dt[BATAS]." XXXX ".$dt2[TOTAL]." SSSS ".$dt[BATAS];
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              #$status.="$dt[NAMA] kurang  $dt[BATAS]-$dt2[TOTAL] Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
							  $status.="$dt[NAMA] kurang  Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break; 

                            }


                       
						}
						/*elseif ($dt[IDKOMPONEN]==98 && $jenis!="KRS") { //BIAYA TAMBAHAN SKS


                            $jumlahsks=getjumlahskssp($idmahasiswa,$tahun,$semester);
                            $jumlahskswajib=0;
                            $skslebih=0;
                            if ($jumlahsks>$jumlahskswajib) {
                               $skslebih=$jumlahsks-$jumlahskswajib;
                            }
 
                               $biayakomponen=$dt[TOTAL]+0;
                               if ($BIAYASKSKULIAH==1) {
                                  $dt[BATAS]=$jumlahsks*$biayakomponen;
                               } else {
                                  $dt[BATAS]=$skslebih*$biayakomponen;
                              }


                            $q="SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='$idmahasiswa' AND
                            IDKOMPONEN='$dt[IDKOMPONEN]'   ";
                            $ht2=mysqli_query($koneksi,$q);
                            
                            $dt2=sqlfetcharray($ht2);


                             // BEASISWA
                            $qbeasiswa=$qbeasiswa." AND TAHUN='$tahun' AND SEMESTER='$semester' "; 
                            $hbeasiswa=mysqli_query($koneksi,$qbeasiswa);
                            if (sqlnumrows($hbeasiswa)>0) {
                              $dbeasiswa=sqlfetcharray($hbeasiswa);
                              $dt[BATAS]=$dt[BATAS]*(100-$dbeasiswa[DISKON])/100;
                            }
 

                            //$lunas++;
                            if ($dt[BATAS]>0 && $dt2[TOTAL]<$dt[BATAS]) { // Tidak Lunas
                              $lunas--;
                              $status.="$dt[NAMA] kurang Rp. ".cetakuang($dt[BATAS]-$dt2[TOTAL])."<br>";
                              //break;

                            }


                       
						}*/                    
					}
                  
                  }
				  #else{
						#echo "lll";exit();
					#	$lunas=-1;
				  #}
                  $arrayhasil[LUNAS]=$lunas;
                  $arrayhasil[STATUS]=$status;
                  return $arrayhasil;
  
}

/*function getstatusminimalpembayaranmahasiswa( $idmahasiswa, $tahun, $semester, $jenis )
{
    global $koneksi;
    global $BIAYASKSKULIAH;
    global $JENISKELAS;
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $qfield = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
    }
    else
    {
        $qfield = " AND biayakomponen.JENISKELAS='' ";
    }
    if ( $jenis == "UTS" )
    {
        $field = "UTS";
    }
    else if ( $jenis == "UAS" )
    {
        $field = "UAS";
    }
    else if ( $jenis == "KRS" )
    {
        $field = "KRS";
    }
    $lunas = 0;
    $q = "SELECT biayakomponen.IDKOMPONEN , biayakomponen.{$field} AS BATAS ,biayakomponen.BIAYA AS TOTAL,komponenpembayaran.JENIS,komponenpembayaran.NAMA\r\n            \t\tFROM komponenpembayaran,biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n            \t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n              \t\t  mahasiswa.ID='{$idmahasiswa}'   {$qfield}\r\n            \t\t\t \r\n            \t\t";
	#echo $q;exit();
    $ht = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows($ht)){
		while ($dt = sqlfetcharray($ht))
		{
			$qbeasiswa = "SELECT DISKON FROM diskonbeasiswa WHERE IDKOMPONEN='{$dt['IDKOMPONEN']}' AND IDMAHASISWA='{$idmahasiswa}' ";
			if ( $dt[JENIS] == 5 || $dt[JENIS] == 4 )
			{
			}
			else if ( $dt[IDKOMPONEN] != 99 && $dt[IDKOMPONEN] != 98 )
			{
				if ( $dt[JENIS] == 0 )
				{
					$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\r\n IDKOMPONEN='{$dt['IDKOMPONEN']}'";
					$ht2 = mysqli_query($koneksi,$q);
					$dt2 = sqlfetcharray( $ht2 );
					$hbeasiswa = mysql_query( $qbeasiswa, $koneksi );
					if ( 0 < sqlnumrows( $hbeasiswa ) )
					{
						$dbeasiswa = sqlfetcharray( $hbeasiswa );
						$dt[BATAS] = $dt[BATAS] * ( 100 - $dbeasiswa[DISKON] ) / 100;
					}
					if ( 0 < $dt[BATAS] && $dt2[TOTAL] < $dt[BATAS] )
					{
						--$lunas;
						$status .= "{$dt['NAMA']} kurang Rp. ".cetakuang( $dt[BATAS] - $dt2[TOTAL] )."<br>";
					}
				}
				else if ( $dt[JENIS] == 1 )
				{
				}
				else if ( $dt[JENIS] == 2 )
				{
					$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\r\n                            IDKOMPONEN='{$dt['IDKOMPONEN']}' AND TAHUNAJARAN='{$tahun}' ";
					$ht2 = mysqli_query($koneksi,$q);
					echo mysql_error( );
					$dt2 = sqlfetcharray( $ht2 );
					$qbeasiswa = $qbeasiswa." AND TAHUN='{$tahun}' ";
					$hbeasiswa = mysql_query( $qbeasiswa, $koneksi );
					if ( 0 < sqlnumrows( $hbeasiswa ) )
					{
						$dbeasiswa = sqlfetcharray( $hbeasiswa );
						$dt[BATAS] = $dt[BATAS] * ( 100 - $dbeasiswa[DISKON] ) / 100;
					}
					if ( 0 < $dt[BATAS] && $dt2[TOTAL] < $dt[BATAS] )
					{
						--$lunas;
						$status .= "{$dt['NAMA']} kurang Rp. ".cetakuang( $dt[BATAS] - $dt2[TOTAL] )."<br>";
					}
				}
				else if ( $dt[JENIS] == 3 )
				{
					$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\r\n                            IDKOMPONEN='{$dt['IDKOMPONEN']}' AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}'  ";
					$ht2 = mysqli_query($koneksi,$q);
					$dt2 = sqlfetcharray( $ht2 );
					$qbeasiswa = $qbeasiswa." AND TAHUN='{$tahun}' AND SEMESTER='{$semester}' ";
					$hbeasiswa = mysql_query( $qbeasiswa, $koneksi );
					if ( 0 < sqlnumrows( $hbeasiswa ) )
					{
						$dbeasiswa = sqlfetcharray( $hbeasiswa );
						$dt[BATAS] = $dt[BATAS] * ( 100 - $dbeasiswa[DISKON] ) / 100;
					}
					if ( 0 < $dt[BATAS] && $dt2[TOTAL] < $dt[BATAS] )
					{
						--$lunas;
						$status .= "{$dt['NAMA']} kurang Rp. ".cetakuang( $dt[BATAS] - $dt2[TOTAL] )."<br>";
					}
				}
			}
			else if ( $dt[IDKOMPONEN] == 99 )
			{
				$jumlahsks = getjumlahsks( $idmahasiswa, $tahun, $semester );
				$jumlahskswajib = getjumlahskswajib( $idmahasiswa, $tahun, $semester );
				$skslebih = 0;
				if ( $jumlahskswajib < $jumlahsks )
				{
					$skslebih = $jumlahsks - $jumlahskswajib;
				}
				$biayakomponen = $dt[TOTAL] + 0;
				if ( $BIAYASKSKULIAH == 1 )
				{
					$dt[BATAS] = $jumlahsks * $biayakomponen;
				}
				else
				{
					$dt[BATAS] = $skslebih * $biayakomponen;
				}
				$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\r\n                            IDKOMPONEN='{$dt['IDKOMPONEN']}'  AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}'  ";
				$ht2 = mysqli_query($koneksi,$q);
				$dt2 = sqlfetcharray( $ht2 );
				$qbeasiswa = $qbeasiswa." AND TAHUN='{$tahun}' AND SEMESTER='{$semester}' ";
				$hbeasiswa = mysql_query( $qbeasiswa, $koneksi );
				if ( 0 < sqlnumrows( $hbeasiswa ) )
				{
					$dbeasiswa = sqlfetcharray( $hbeasiswa );
					$dt[BATAS] = $dt[BATAS] * ( 100 - $dbeasiswa[DISKON] ) / 100;
				}
				if ( 0 < $dt[BATAS] && $dt2[TOTAL] < $dt[BATAS] )
				{
					--$lunas;
					$status .= "{$dt['NAMA']} kurang   Rp. ".cetakuang( $dt[BATAS] - $dt2[TOTAL] )."<br>";
				}
			}
			else if ( $dt[IDKOMPONEN] == 98 )
			{
				$jumlahsks = getjumlahskssp( $idmahasiswa, $tahun, $semester );
				$jumlahskswajib = 0;
				$skslebih = 0;
				if ( $jumlahskswajib < $jumlahsks )
				{
					$skslebih = $jumlahsks - $jumlahskswajib;
				}
				$biayakomponen = $dt[TOTAL] + 0;
				if ( $BIAYASKSKULIAH == 1 )
				{
					$dt[BATAS] = $jumlahsks * $biayakomponen;
				}
				else
				{
					$dt[BATAS] = $skslebih * $biayakomponen;
				}
				$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND\r\n                            IDKOMPONEN='{$dt['IDKOMPONEN']}'  AND TAHUNAJARAN='{$tahun}' AND SEMESTER='{$semester}'  ";
				$ht2 = mysqli_query($koneksi,$q);
				$dt2 = sqlfetcharray( $ht2 );
				$qbeasiswa = $qbeasiswa." AND TAHUN='{$tahun}' AND SEMESTER='{$semester}' ";
				$hbeasiswa = mysql_query( $qbeasiswa, $koneksi );
				if ( 0 < sqlnumrows( $hbeasiswa ) )
				{
					$dbeasiswa = sqlfetcharray( $hbeasiswa );
					$dt[BATAS] = $dt[BATAS] * ( 100 - $dbeasiswa[DISKON] ) / 100;
				}
				if ( 0 < $dt[BATAS] && $dt2[TOTAL] < $dt[BATAS] )
				{
					--$lunas;
					$status .= "{$dt['NAMA']} kurang Rp. ".cetakuang( $dt[BATAS] - $dt2[TOTAL] )."<br>";
				}
			}
		}
	}
    $arrayhasil[LUNAS] = $lunas;
    $arrayhasil[STATUS] = $status;
    return $arrayhasil;
}*/

function getjumlahskssp( $idmahasiswa, $tahunajaran, $semester )
{
    global $koneksi;
    $q = "SELECT SUM(SKSMAKUL) AS TOTAL FROM\r\n               pengambilanmksp\r\n               WHERE \r\n               IDMAHASISWA='{$idmahasiswa}' AND\r\n               TAHUN='{$tahunajaran}' AND\r\n               SEMESTER='{$semester}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $d[TOTAL] + 0;
    return $hasil;
}

function getjumlahsks( $idmahasiswa, $tahunajaran, $semester )
{
    global $koneksi;
    $q = "SELECT SUM(SKSMAKUL) AS TOTAL FROM\r\n               pengambilanmk\r\n               WHERE \r\n               IDMAHASISWA='{$idmahasiswa}' AND\r\n               TAHUN='{$tahunajaran}' AND\r\n               SEMESTER='{$semester}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $d[TOTAL] + 0;
    return $hasil;
}

function getjumlahskswajib( $idmahasiswa, $tahunajaran, $semester )
{
    global $koneksi;
    $semestermahasiswa = getsemesetermahasiswa( $idmahasiswa, $tahunajaran, $semester ) + 0;
    $semestermaksimum = getsemesetermaksimummahasiswa( $idmahasiswa ) + 0;
    if ( $semestermaksimum < $semestermahasiswa )
    {
        $semestermahasiswa = $semestermahasiswa % $semestermaksimum;
    }
    #echo "SELECT  tbkmk.SKSMKTBKMK AS SKS FROM mspst,tbkmk,mahasiswa WHERE mahasiswa.IDPRODI=mspst.IDX AND mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND mspst.KDPTIMSPST=tbkmk.KDPTITBKMK AND tbkmk.THSMSTBKMK='".( $tahunajaran - 1 ) ."{$semester}' AND  tbkmk.STKMKTBKMK='A'  AND  mahasiswa.ID='{$idmahasiswa}' AND tbkmk.SEMESTBKMK = {$semestermahasiswa} ";
	$q = ( "SELECT  tbkmk.SKSMKTBKMK AS SKS \r\n            \t\tFROM mspst,tbkmk,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=mspst.IDX AND\r\n            \t\t  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n            \t\t  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n            \t\t  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK AND\r\n            \t\t  tbkmk.THSMSTBKMK='".( $tahunajaran - 1 ) )."{$semester}' AND\r\n            \t\t  tbkmk.STKMKTBKMK='A'  AND\r\n            \t\t  mahasiswa.ID='{$idmahasiswa}' AND\r\n            \t\t  tbkmk.SEMESTBKMK = {$semestermahasiswa}\r\n            \t\t\t \r\n            \t\t";
    $h = mysqli_query($koneksi,$q);
    $hasil = 0;
	if( 0 < sqlnumrows($h)){
		while ($d = sqlfetcharray($h)) 
		{
			$hasil += $d[SKS];
		}
	}
    return $hasil;
}

function pengingatbackup( $userid )
{
    global $koneksi;
    global $tingkataksesusers;
    //print_r('<p />');
    //print_r($tingkataksesusers);
    //exit();
    if ( $tingkataksesusers['A'] == "T" || $tingkataksesusers['A'] == "B" )
    {
        $hari = getaturan( "PENGINGATBACKUP" );
        if ( 0 < $hari )
        {
            $q = "SELECT DATE_ADD(PENGINGATBACKUP, INTERVAL {$hari} DAY) <= CURDATE() AS STATUS, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL {$hari} DAY),'%d-%m-%Y')  AS NEXTREMINDER\r\n    \r\n    \r\n    FROM user WHERE ID='{$userid}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            if ( $d[STATUS] == 1 )
            {
                echo "\r\n        <script>\r\n            jQuery(document).ready(function () { \r\n                \$.colorbox({html:'<div align=center>    <h1>Pengingat Untuk Membackup Data</h1><br><p>Segala sesuatu bisa terjadi, kerusakan hardware, kehilangan hardware, kerusakan software, dan sebagainya sehingga menyebabkan data program SIKAD ini menjadi hilang atau tidak benar. <br>Untuk itu, silakan membackup data program SIKAD secara berkala. <br>Kami akan mengingatkan Anda untuk membackup data kembali pada tanggal {$d['NEXTREMINDER']}<br>Terima kasih.</p></div>'});\r\n            });\r\n        </script>     \r\n        \r\n         ";
                $q = "UPDATE user SET PENGINGATBACKUP=CURDATE() WHERE ID='{$userid} '";
                mysqli_query($koneksi,$q);
            }
        }
    }
}

function pengingatpassword( $userid, $jenis )
{
    global $koneksi;
    $hari = getaturan( "PENGINGATPASSWORD" );
    if ( 0 < $hari )
    {
        $tabel = "user";
        if ( $jenis == 0 )
        {
            $tabel = "user";
        }
        else if ( $jenis == 1 )
        {
            $tabel = "dosen";
        }
        else if ( $jenis == 2 )
        {
            $tabel = "mahasiswa";
        }
        $q = "SELECT DATE_ADD(PENGINGATPASSWORD, INTERVAL {$hari} DAY) <= CURDATE() AS STATUS, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL {$hari} DAY),'%d-%m-%Y')  AS NEXTREMINDER\r\n    \r\n    \r\n    FROM {$tabel} WHERE ID='{$userid}'";
 
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        if ( $d[STATUS] == 1 )
        {
            echo "\r\n        <script>\r\n            jQuery(document).ready(function () { \r\n                \$.colorbox({html:'<div align=center><h1>Pengingat Untuk Mengganti Password</h1><br><p>Untuk alasan keamanan, silakan mengganti password Anda secara berkala. <br>Kami akan mengingatkan Anda untuk mengganti password kembali pada tanggal {$d['NEXTREMINDER']}<br>Terima kasih.</p></dev>'});\r\n            });\r\n        </script>     \r\n        \r\n         ";
            $q = "UPDATE {$tabel} SET PENGINGATPASSWORD=CURDATE() WHERE ID='{$userid} '";
            mysqli_query($koneksi,$q);
            return 1;
        }
    }
    return 0;
}

function session_register_sikad( $var )
{
    $_SESSION["{$var}"] = "";
}

function mysql_db_query_sikad( $basisdata, $query, $con = "" )
{
    global $koneksi;
    if ( $con == "" )
    {
        $con = $koneksi;
    }
    mysql_select_db( $basisdata, $con );
    $hasil = mysql_query( $query, $con );
    return $hasil;
}

function split_sikad( $pattern, $string )
{
    return preg_split( "#".$pattern."#", $string );
}

function session_unregister_sikad( $var )
{
    unset( $_SESSION["{$var}"] );
}

function session_is_registered_sikad( $var )
{
    return isset( $_SESSION[$var] );
}

function set_magic_quotes_runtime_sikad( $value )
{
    if ( version_compare( PHP_VERSION, "5.3.0", "<" ) )
    {
        set_magic_quotes_runtime_sikad( $value );
    }
}

function eregi_replace_sikad( $pattern, $strreplace, $string, $delimiter = "" )
{
    $del = $delimiter;
    if ( $delimiter == "" )
    {
        $del = "#";
    }
    return preg_replace( "{$del}".$pattern.$del."i", $strreplace, $string );
}

function ereg_replace_sikad( $pattern, $strreplace, $string, $delimiter = "" )
{
    $del = $delimiter;
    if ( $delimiter == "" )
    {
        $del = "#";
    }
    return preg_replace( $del.$pattern.$del, $strreplace, $string );
}

function eregi_sikad( $pattern, $string, $delimiter = "" )
{
    $del = $delimiter;
    if ( $delimiter == "" )
    {
        $del = "#";
    }
    return preg_match( $del.$pattern.$del, $string );
}

function ereg_sikad( $pattern, $string, $delimiter = "" )
{
    $del = $delimiter;
    if ( $delimiter == "" )
    {
        $del = "#";
    }
    return preg_match( $del.$pattern.$del, $string );
}

function get_konfigpendaftaran( $id )
{
    global $koneksi;
    $q = "SELECT * FROM konfigpendaftaran WHERE ID='{$id}' LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    else
    {
        $d[SUBJEK] = "Informasi Pendaftaran Calon Mahasiswa!";
        $d[ISI] = "Halo, ini password baru Anda,\n\nID : [IDCALONMAHASISWA] ([NAMACALONMAHASISWA]) \nPassword : [PASSWORDBARU]\r\n                  \r\n                  Operator : {$users}\r\n                  Waktu : ".date( "Y-m-d H:i:s" );
    }
    return $d;
}

function get_konfigpengumumanpmb( $id )
{
    global $koneksi;
    $q = "SELECT * FROM konfigpengumumanpmb WHERE ID='{$id}' LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    else
    {
        $d[SUBJEK] = "Pengumuman Kelulusan Calon Mahasiswa!";
        $d[ISI2] = $d[ISI] = "Yth [IDCALONMAHASISWA] ([NAMACALONMAHASISWA]) \nAnda [STATUSLULUS] pada Progeram Studi [PILIHANPRODI] Fakultas [PILIHANFAKULTAS]\r\n    \r\n                  Waktu : ".date( "Y-m-d H:i:s" );
    }
    return $d;
}

function getwaktuujianpmb( $tahunmasuk, $fakultas, $gelombang )
{
    global $koneksi;
    $waktu = 0;
    $q = "SELECT * FROM waktuujianpmb_tahunfakultasgelombang WHERE\r\n  TAHUN='{$tahunmasuk}' AND FAKULTAS='{$fakultas}' AND GELOMBANG='{$gelombang}' ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $waktu = $d[WAKTUUJIAN];
    }
    else
    {
        $q = "SELECT * FROM waktuujianpmb_tahunfakultas WHERE\r\n      TAHUN='{$tahunmasuk}' AND FAKULTAS='{$fakultas}'  ";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $waktu = $d[WAKTUUJIAN];
        }
        else
        {
            $q = "SELECT * FROM waktuujianpmb_tahun  WHERE\r\n          TAHUN='{$tahunmasuk}'  ";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $waktu = $d[WAKTUUJIAN];
            }
        }
    }
    return $waktu;
}

/*function getarrayangkatan( $tipe = "", $addnumber = 0, $tahunawal = "" )
{
    global $koneksi;
    if ( $tipe == "" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE ANGKATAN >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT ANGKATAN FROM mahasiswa {$qfield} ORDER BY ANGKATAN ";
    }
    else if ( $tipe == "K" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE SUBSTRING(THSMSTBKMK,1,4)+1 >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT SUBSTRING(THSMSTBKMK,1,4)+1 AS ANGKATAN FROM tbkmk {$qfield} ORDER BY ANGKATAN ";
    }
    else if ( $tipe == "P" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE TAHUN >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT TAHUN AS ANGKATAN FROM dosenpengajar {$qfield} ORDER BY ANGKATAN ";
    }
    else if ( $tipe == "R" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE TAHUN >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT TAHUN AS ANGKATAN FROM pengambilanmk {$qfield} ORDER BY ANGKATAN ";
    }
    else if ( $tipe == "WP" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE TAHUN >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT TAHUN AS ANGKATAN FROM waktukrsprodi {$qfield} ORDER BY ANGKATAN ";
    }
    else if ( $tipe == "A" )
    {
        if ( $tahunawal != "" )
        {
            $qfield = "WHERE ANGKATAN >='{$tahunawal}'";
        }
        $q = "SELECT DISTINCT ANGKATAN   FROM mahasiswa WHERE STATUS='L' {$qfield} ORDER BY ANGKATAN ";
    }
    $h = mysqli_query($koneksi,$q);
    $hasil[] = "";
    if ( 0 < sqlnumrows( $h ) )
    {
        unset( $hasil );
        while ( $d = sqlfetcharray( $h ) )
        {
            $hasil[$d[ANGKATAN]] = $d[ANGKATAN];
            $last = $d[ANGKATAN];
        }
        if ( 0 < $addnumber )
        {
            $i = $last + 1;
            while ( $i <= $last + $addnumber )
            {
                $hasil[$i] = $i;
                ++$i;
            }
        }
    }
    return $hasil;
}*/

function getarrayangkatan($tipe="",$addnumber=0) {
  global $koneksi;
  
  if ($tipe=="") {
    $q="SELECT DISTINCT ANGKATAN FROM mahasiswa ORDER BY ANGKATAN";
  } elseif ($tipe=="K") { // Kurikulum
    $q="SELECT DISTINCT SUBSTRING(THSMSTBKMK,1,4)+1 AS ANGKATAN FROM tbkmk ORDER BY ANGKATAN ";
  } elseif ($tipe=="P") { // Dosen Pengajara
    $q="SELECT DISTINCT TAHUN AS ANGKATAN FROM dosenpengajar ORDER BY ANGKATAN ";
  } elseif ($tipe=="R") { // KRS
    $q="SELECT DISTINCT TAHUN AS ANGKATAN FROM pengambilanmk ORDER BY ANGKATAN ";
  } elseif ($tipe=="WP") { // Waktu KRS Prodi
    $q="SELECT DISTINCT TAHUN AS ANGKATAN FROM waktukrsprodi ORDER BY ANGKATAN ";
  } elseif ($tipe=="A") { // ALUMNI
      $q="SELECT DISTINCT ANGKATAN   FROM mahasiswa WHERE STATUS='L' ORDER BY ANGKATAN ";
  }
  #echo $q;exit();
  $h=mysqli_query($koneksi,$q);
  #echo $h;exit();
  $hasil[]="";
  if (sqlnumrows($h)>0) {
    unset($hasil);
    while ($d=sqlfetcharray($h)) {
      $hasil[$d[ANGKATAN]]=$d[ANGKATAN];
      $last=$d[ANGKATAN];
    }
    
    if ($addnumber >0) {
      for ($i=$last+1; $i<=$last+$addnumber;$i++) {
        $hasil[$i]=$i;
      
      }
    }
  }
  return $hasil;
}


function get_resetpassword( $id )
{
    global $koneksi;
    $q = "SELECT * FROM konfigresetpassword WHERE ID='{$id}' LIMIT 0,1";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    else
    {
        $d[SUBJEK] = "Password Baru Calon Mahasiswa!";
        $d[ISI] = "Halo, ini password baru Anda,\n\nID : [IDCALONMAHASISWA] ([NAMACALONMAHASISWA]) \nPassword : [PASSWORDBARU]\r\n                  \r\n                  Operator : {$users}\r\n                  Waktu : ".date( "Y-m-d H:i:s" );
    }
    return $d;
}

function kirimemail_calonmahasiswa( $d )
{
    global $koneksi;
    #if ( !is_pear_mail_installed( ) )
    #{
    #    return "Modul Pear:Mail_mime tidak atau belum terinstall";
    #}
    include "lib/phpmail/class.phpmailer.php";
    $mail = new PHPMailer;			
    $q = "SELECT * FROM konfigsmtp WHERE ID='PMB'";
    $hs = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hs ) )
    {
        $ds = sqlfetcharray( $hs );
        /*require_once( "Mail.php" );
        require_once( "Mail/mime.php" );
        $from = "<".$ds[FROM].">";
        $to = "<".$d[to].">";
        $subject = $d[subject];
        $body = $d[body];
        $host = $ds[HOST];
        $port = $ds[PORT];
        $username = $ds[USERNAME];
        $password = $ds[PASSWORD];
        $headers = array(
            "From" => $from,
            "To" => $to,
            "Subject" => $subject
        );
        $crlf = "\n";
        $mime = new Mail_mime( $crlf );
        $mime->setTXTBody( strip_tags( $body ) );
        $mime->setHTMLBody( $body );
        $body = $mime->get( );
        $headers = $mime->headers( $headers );
        $smtp = Mail::factory( "smtp", array(
            "host" => $host,
            "port" => $port,
            "auth" => true,
            "username" => $username,
            "password" => $password
        ) );
        $mail = $smtp->send( $to, $headers, $body );
        if ( PEAR::iserror( $mail ) )
        {
            return $mail->getMessage( );
        }
        return 1;*/

	$mail->IsSMTP();
	$mail->SMTPSecure = 'ssl'; 
	//$mail->Host = "smtp.mail.yahoo.com"; //host masing2 provider email
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPDebug = 1;
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->Username = $ds['USERNAME']; //user email
	$mail->Password = $ds['PASSWORD']; //password email
	#$mail->Password = "1234"; //password email 
	$mail->SetFrom($ds['FROM'],"PMB Universitas Batam"); //set email pengirim
	$mail->Subject = $d['subject']; //subyek email
	$mail->AddAddress($d['to'],$d['to']);  //tujuan email
	$mail->MsgHTML($d['body']);
	if($mail->Send()) {
		#echo "Message has been sent";
		return 1;
	}	
	else {
		#echo "Failed to sending message";
		return 0;
    	}

    }
    return "Konfigurasi SMTP untuk PMB tidak ada.";
}

function get_file_extension( $file_name )
{
    return substr( strrchr( $file_name, "." ), 1 );
}

function getsemesterterakhir( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT * FROM pengambilanmk WHERE IDMAHASISWA='{$idmahasiswa}'  ORDER BY TAHUN DESC,SEMESTER DESC LIMIT 0,1";
    $hl = mysqli_query($koneksi,$q);
    unset( $d );
    if ( 0 < sqlnumrows( $hl ) )
    {
        $d = sqlfetcharray( $hl );
    }
    return $d;
}

function issudahlulus( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT NOIJATRLSM,NOBLANKO FROM trlsm WHERE NIMHSTRLSM='{$idmahasiswa}' AND STMHSTRLSM='L' ORDER BY THSMSTRLSM DESC";
    $hl = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hl ) )
    {
        return true;
    }
    return false;
}

function getjenisprodi( $idprodi )
{
    global $koneksi;
    $q = "SELECT JENIS FROM prodi WHERE  ID='{$idprodi}'";
    $hl = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hl ) )
    {
        $d = sqlfetcharray( $hl );
        return $d[JENIS];
    }
    return false;
}

function cetakpdf( $body, $style = "", $header = "", $footer = "" )
{
    include( "../mpdf/mpdf.php" );
    $settingpdf = getsettingpdf( );
    $mpdf = new mPDF( "", $settingpdf[UKURAN], 0, 0, $settingpdf[MARGINKIRI], $settingpdf[MARGINKANAN], $settingpdf[MARGINATAS], $settingpdf[MARGINBAWAH], 0, 0, $settingpdf[ORIENTASI] );
    $mpdf->AddPage( $settingpdf[ORIENTASI] );
    $mpdf->list_indent_first_level = 0;
    $mpdf->SetDisplayMode( "fullpage" );
    $mpdf->WriteHTML( $style, 1 );
    $mpdf->WriteHTML( $body );
    $mpdf->Output( );
    exit( );
}

function getsettingpdf( )
{
    global $koneksi;
    $q = "SELECT * FROM settingpdf WHERE ID=0";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        return $d;
    }
    return false;
}

function saldoakunsebelumtanggal( $idakun, $tanggal )
{
    global $koneksi;
    global $arraymub;
    global $arraymu;
    $q = "\r\n\t\tSELECT SUM(IF(JENISAKUN='D',JUMLAH,0))AS JML  \r\n\t\tFROM detilkeuangansgm,transkeuangan\r\n\t\tWHERE\r\n\t\ttranskeuangan.STATUS=1 AND\r\n\r\n\t\tdetilkeuangansgm.IDTRANS=transkeuangan.ID AND\r\n\t\tdetilkeuangansgm.JENIS=transkeuangan.JENIS AND\r\n\t\t \r\n\t\tIDAKUN='{$idakun}' AND\r\n\t\tTANGGAL < DATE_FORMAT('{$tanggal}','%Y-%m-%d')\r\n\t\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $debit = $d[JML];
    }
    $q = "\r\n\t\tSELECT SUM(IF(JENISAKUN='K',JUMLAH,0)) AS JML \r\n\t\tFROM detilkeuangansgm,transkeuangan\r\n\t\tWHERE\r\n\t\ttranskeuangan.STATUS=1 AND\r\n\t\tdetilkeuangansgm.IDTRANS=transkeuangan.ID AND\r\n\t\tdetilkeuangansgm.JENIS=transkeuangan.JENIS AND\r\n\t\t \r\n\t\tIDAKUN='{$idakun}' AND\r\n\t\tTANGGAL < DATE_FORMAT('{$tanggal}','%Y-%m-%d')\r\n\t\t \r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $kredit = $d[JML];
    }
    $saldo = $debit - $kredit;
    return $saldo;
}

function istgl_lebih( $tgl1, $tgl2 )
{
    if ( $tgl2[thn] < $tgl1[thn] )
    {
        return true;
    }
    if ( $tgl1[thn] < $tgl2[thn] )
    {
        return false;
    }
    if ( $tgl2[bln] < $tgl1[bln] )
    {
        return true;
    }
    if ( $tgl1[bln] < $tgl2[bln] )
    {
        return false;
    }
    if ( $tgl2[tgl] < $tgl1[tgl] )
    {
        return true;
    }
    if ( $tgl1[tgl] < $tgl2[tgl] )
    {
        return false;
    }
    return false;
}

function istgl_sama( $tgl1, $tgl2 )
{
    if ( $tgl1[thn] = $tgl2[thn] && $tgl1[bln] = $tgl2[bln] && $tgl1[tgl] = $tgl2[tgl] )
    {
        return true;
    }
    return false;
}

function istgl_kurang( $tgl1, $tgl2 )
{
    if ( !istgl_sama( $tgl1, $tgl2 ) && !istgl_lebih( $tgl1, $tgl2 ) )
    {
        return true;
    }
    return false;
}

function buatlogsgm( )
{
}

function is_akun_terpakai( $id )
{
    global $koneksi;
    global $arrayjumlah;
    $hasil = 0;
    $q = "SELECT TINGKAT FROM akun WHERE ID='{$id}' ";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    if ( $d[TINGKAT] == 1 )
    {
        if ( 0 < $arrayjumlah["{$id}"][JML] + 0 )
        {
            $hasil = 1;
        }
    }
    else
    {
        $q = "SELECT ID FROM akun WHERE SUBID='{$id}'";
        $h2 = mysqli_query($koneksi,$q);
        while ( 0 < sqlnumrows( $h2 ) && ( $d2 = sqlfetcharray( $h2 ) ) )
        {
            $hasil = is_akun_terpakai( $d2[ID] );
            if ( !( $hasil == 1 ) )
            {
                continue;
            }
            break;
            break;
        }
    }
    return $hasil;
}

function jumlahuangsblmtanggal( $tanggal, $status, $jenis )
{
    global $koneksi;
    if ( $status != "semua" )
    {
        $qstatus = " AND STATUS='{$status}' ";
        $jstatus = " Status = ".$arraystatusuang[$status].". ";
    }
    if ( $jenis != "semua" )
    {
        $qjenis = " AND JENIS='{$jenis}' ";
        $jjenis = " Jenis = ".$arraystatusjenisuang[$jenis].". ";
    }
    $q = "SELECT SUM(JUMLAH) AS M \r\n\t\t\t\tFROM keuangan \r\n\t\t\t\tWHERE\r\n\t\t\t\tJENISU='1' AND\r\n\t\t\t\tTANGGAL < '{$tanggal}'\r\n\t\t\t\t{$qstatus}\r\n\t\t\t\t{$qjenis}\r\n\t\t\t\t";
    $hs = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hs ) )
    {
        $d = sqlfetcharray( $hs );
        $masuk = $d[M];
    }
    else
    {
        $masuk = 0;
    }
    $q = "SELECT SUM(JUMLAH) AS M \r\n\t\t\t\tFROM keuangan \r\n\t\t\t\tWHERE\r\n\t\t\t\tJENISU='0' AND\r\n\t\t\t\tTANGGAL < '{$tanggal}'\r\n\t\t\t\t{$qstatus}\r\n\t\t\t\t{$qjenis}\r\n\t\t\t\t";
    $hs = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hs ) )
    {
        $d = sqlfetcharray( $hs );
        $keluar = $d[M];
    }
    else
    {
        $keluar = 0;
    }
    return $sisa = $masuk - $keluar;
}

function isadabawah( $id )
{
    global $koneksi;
    $q = "SELECT COUNT(ID) AS JML FROM akun WHERE SUBID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = false;
    if ( 0 < $d[JML] )
    {
        $hasil = true;
    }
    return $hasil;
}

function isadaatas( $id, $idbawah )
{
    global $koneksi;
    $hasil = false;
    $q = "SELECT SUBID FROM akun WHERE ID='{$idbawah}' ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    if ( $d[SUBID] != $id )
    {
        while ( $d[SUBID] != $id && $d[SUBID] != "" )
        {
            $q = "SELECT SUBID FROM akun WHERE ID='{$d['SUBID']}' ";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
            }
        }
        if ( $d[SUBID] == $id )
        {
            $hasil = true;
        }
    }
    else
    {
        $hasil = true;
    }
    return $hasil;
}

function getnamaakun( $id )
{
    global $koneksi;
    $q = "SELECT NAMA FROM akun WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[NAMA];
    }
    return $hasil;
}

function getakun( $id )
{
    global $koneksi;
    $q = "SELECT * FROM akun WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d;
    }
    return $hasil;
}

function getawalakun( $id )
{
    global $koneksi;
    $q = "SELECT AWAL,TGLAWAL FROM akun WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d;
    }
    return $hasil;
}

function getawalsubakun( $id, $tanggaldari )
{
    global $koneksi;
    $q = "SELECT SUM(AWAL) AS HASIL FROM akun WHERE SUBID='{$id}'\r\n\tAND TGLAWAL < '{$tanggaldari['thn']}-{$tanggaldari['bln']}-{$tanggaldari['tgl']}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $hasil;
}

function listakunneracaaktiva( &$list, $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "\t b.SUBUNTUKNERACA='1' AND ";
    if ( $jenistampilan == 1 )
    {
        $qx = "\t 1=0 AND ";
    }
    else if ( $jenistampilan == 2 )
    {
        $qx = "";
    }
    $q = "SELECT DISTINCT a.SUBID AS SB\r\n\t FROM akun as a, akun as b \r\n\t WHERE \r\n\t a.SUBID=b.ID AND\r\n    {$qx}\r\n\t a.TINGKAT='1' AND\r\n\t a.UNTUKNERACA='0' AND\r\n\t a.UNTUK='0'\r\n\t ORDER BY a.SUBID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			$list[$d[SB]][OK] = 1;
			$q = "SELECT ID,NAMA FROM akun WHERE SUBID='{$d['SB']}' AND TINGKAT=1 ";
			$h2 = mysqli_query($koneksi,$q);
			while ( !( 0 < sqlnumrows( $h2 ) ))
			{
				if($d2 = sqlfetcharray( $h2 )){
					unset( $list[$d2[ID]] );
				}
			}
		}
	}
    $q = "SELECT ID\r\n\t FROM akun \r\n\t WHERE \r\n\t \tUNTUKNERACA='1' OR\r\n\t\tUNTUK='1'\r\n\t ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows($h)){
		while ($d = sqlfetcharray( $h ))
		{
			unset( $list[$d[ID]] );
		}
	}
}

function listakunneracaekuitas( &$list, $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "\t b.SUBUNTUKNERACA='1' AND ";
    if ( $jenistampilan == 1 )
    {
        $qx = "\t 1=0 AND ";
    }
    else if ( $jenistampilan == 2 )
    {
        $qx = "";
    }
    $q = "SELECT DISTINCT a.SUBID AS SB\r\n\t FROM akun as a, akun as b \r\n\t WHERE \r\n\t a.SUBID=b.ID AND\r\n  {$qx}\t \r\n  a.TINGKAT='1' AND\r\n\t a.UNTUKNERACA='1' AND\r\n\t a.UNTUK='0'\r\n\t ORDER BY a.SUBID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			$list[$d[SB]][OK] = 1;
			$q = "SELECT ID FROM akun WHERE SUBID='{$d['SB']}'  AND TINGKAT=1 ";
			$h2 = mysqli_query($koneksi,$q);
			if(!( 0 < sqlnumrows( $h2 ))){
				while ( !( $d2 = sqlfetcharray( $h2 ) ) )
				{
					unset( $list[$d2[ID]] );
				}
			}
		}
	}
    $q = "SELECT ID\r\n\t FROM akun \r\n\t WHERE \r\n\t \tUNTUKNERACA='0' OR\r\n\t\tUNTUK='1'\r\n\t ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ( $d = sqlfetcharray( $h ) ) 
		{
			unset( $list[$d[ID]] );
		}
	}
}

function listakunrugilaba( &$list, $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $q = "SELECT DEBET,KREDIT FROM jenisjurnal WHERE ID='99999'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $debetlaba = $d[DEBET];
    }
    $qx = "\t b.SUBUNTUKNERACA='1' AND ";
    if ( $jenistampilan == 1 )
    {
        $qx = "\t 1=0 AND ";
    }
    else if ( $jenistampilan == 2 )
    {
        $qx = "";
    }
    $q = "SELECT DISTINCT a.SUBID AS SB\r\n\t FROM akun as a, akun as b \r\n\t WHERE \r\n\t a.SUBID=b.ID AND\r\n  {$qx}\t \r\n  a.TINGKAT='1' AND\r\n\t a.UNTUK='1'  \r\n\t ORDER BY a.SUBID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			$list[$d[SB]][OK] = 1;
			$q = "SELECT ID FROM akun WHERE SUBID='{$d['SB']}' AND TINGKAT=1 \t\tAND ID!='{$debetlaba}'\t\r\n";
			$h2 = mysqli_query($koneksi,$q);
			if(0 < sqlnumrows( $h2 )){
				while ( $d2 = sqlfetcharray( $h2 ))
				{
					
					unset( $list[$d2[ID]] );
				}
			}
		}
	}
    $q = "SELECT ID\r\n\t FROM akun \r\n\t WHERE \r\n\t \tUNTUK='0'\r\n\t ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
    if( 0 < sqlnumrows( $h )){
	
		while ($d = sqlfetcharray( $h ))
		{
			unset( $list[$d[ID]] );
		}
	}
}

function listsubakun( $id, &$list, $s, $level, $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "SUBUNTUKNERACA,";
    if ( $jenistampilan == 1 )
    {
        $qx = "IF(TINGKAT=0,0,SUBUNTUKNERACA) AS SUBUNTUKNERACA, ";
    }
    else if ( $jenistampilan == 2 )
    {
        $qx = "IF(TINGKAT=0,1,SUBUNTUKNERACA) AS SUBUNTUKNERACA, ";
    }
    $q = "SELECT ID,NAMA,TINGKAT,KONTRAID,\r\n\t{$qx} UNTUKNERACA,UNTUK,UNTUKRUGILABA\r\n\t FROM akun \r\n\t WHERE SUBID='{$id}' ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			$list[$d[ID]][ID] = $d[ID];
			$list[$d[ID]][NAMA] = $d[NAMA];
			$list[$d[ID]][LEVEL] = $level;
			$list[$d[ID]][KONTRAID] = $d[KONTRAID];
			$list[$d[ID]][NAMAPANJANG2] = $s."{$br}".$d[NAMA];
			$list[$d[ID]][NAMAPANJANG] = $s." ".$d[ID]."{$br}".$d[NAMA];
			$list[$d[ID]][TINGKAT] = $d[TINGKAT];
			$list[$d[ID]][UNTUKNERACA] = $d[UNTUKNERACA];
			$list[$d[ID]][UNTUK] = $d[UNTUK];
			$list[$d[ID]][UNTUKRUGILABA] = $d[UNTUKRUGILABA];
			$list[$d[ID]][SUBUNTUKNERACA] = $d[SUBUNTUKNERACA];
			if ( $d[TINGKAT] == 0 )
			{
				listsubakun( $d[ID], $list, $s.$spasi, $level + 1, $jenistampilan );
			}
		}
	}
}

function listakun( $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "SUBUNTUKNERACA,";
    if ( $jenistampilan == 1 )
    {
        $qx = "IF(TINGKAT=0,0,SUBUNTUKNERACA) AS SUBUNTUKNERACA, ";
    }
    else if ( $jenistampilan == 2 )
    {
        $qx = "IF(TINGKAT=0,1,SUBUNTUKNERACA) AS SUBUNTUKNERACA, ";
    }
    $q = "SELECT ID,NAMA,TINGKAT,KONTRAID,\r\n\t{$qx} UNTUKNERACA,UNTUK,UNTUKRUGILABA \r\n\tFROM akun WHERE SUBID=''  ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray($h))
		{
			$slistakun[$d[ID]][ID] = $d[ID];
			$slistakun[$d[ID]][LEVEL] = 0;
			$slistakun[$d[ID]][NAMA] = $d[NAMA];
			$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
			$slistakun[$d[ID]][NAMAPANJANG2] = $br.$d[NAMA];
			$slistakun[$d[ID]][NAMAPANJANG] = $d[ID]."{$br}".$d[NAMA];
			$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
			$slistakun[$d[ID]][SUBUNTUKNERACA] = $d[SUBUNTUKNERACA];
			$slistakun[$d[ID]][TINGKAT] = $d[TINGKAT];
			$slistakun[$d[ID]][UNTUKNERACA] = $d[UNTUKNERACA];
			$slistakun[$d[ID]][UNTUK] = $d[UNTUK];
			$slistakun[$d[ID]][UNTUKRUGILABA] = $d[UNTUKRUGILABA];
			if ( $d[TINGKAT] == 0 )
			{
				listsubakun( $d[ID], $slistakun, $spasi, 1, $jenistampilan );
			}
		}
	}
    return $slistakun;
}

function listakunsyarat( $id, $id2 = "" )
{
    global $koneksi;
    global $spasi;
    global $br;
    if ( trim( $id ) != "" && trim( $id2 ) != "" )
    {
        $q2 = "(ID='{$id}' OR ID='{$id2}')";
    }
    else
    {
        $q2 = "(1=1)";
    }
    $q = "SELECT ID,NAMA,TINGKAT,KONTRAID,\r\n\tSUBUNTUKNERACA,UNTUKNERACA,UNTUK,UNTUKRUGILABA \r\n\tFROM akun WHERE {$q2} ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ( $d = sqlfetcharray( $h ))
		{
			$slistakun[$d[ID]][ID] = $d[ID];
			$slistakun[$d[ID]][LEVEL] = 0;
			$slistakun[$d[ID]][NAMA] = $d[NAMA];
			$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
			$slistakun[$d[ID]][NAMAPANJANG2] = $br.$d[NAMA];
			$slistakun[$d[ID]][NAMAPANJANG] = $d[ID]."{$br}".$d[NAMA];
			$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
			$slistakun[$d[ID]][SUBUNTUKNERACA] = $d[SUBUNTUKNERACA];
			$slistakun[$d[ID]][TINGKAT] = $d[TINGKAT];
			$slistakun[$d[ID]][UNTUKNERACA] = $d[UNTUKNERACA];
			$slistakun[$d[ID]][UNTUK] = $d[UNTUK];
			$slistakun[$d[ID]][UNTUKRUGILABA] = $d[UNTUKRUGILABA];
			if ( $d[TINGKAT] == 0 )
			{
				listsubakun( $d[ID], $slistakun, $spasi, 1 );
			}
		}
	}
    return $slistakun;
}

function periksaroot( )
{
    global $root;
    if ( !( $root == "../" ) )
    {
        $root = "./";
    }
}

function getnegara( $id )
{
    global $koneksi;
    $q = "SELECT  NMPROTBPRO,NMKABTBPRO \r\n  FROM tbpro WHERE CONCAT(KDPROTBPRO,KDKABTBPRO)\t\t='{$id}'";
    $h = mysqli_query($koneksi,$q);
    unset( $hasil );
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        if ( $d[NMKABTBPRO] != "" )
        {
            $hasil = $d[NMPROTBPRO]."/".$d[NMKABTBPRO];
        }
        else
        {
            $hasil = $d[NMPROTBPRO];
        }
    }
    return $hasil;
}

function set_last_aksi( $id, $jenis, $tipe = "" )
{
    global $koneksi;
    if ( $tipe == "" )
    {
        $tabel = "user";
        if ( $jenis == 0 )
        {
            $tabel = "user";
        }
        else if ( $jenis == 1 )
        {
            $tabel = "dosen";
        }
        else if ( $jenis == 2 )
        {
            $tabel = "mahasiswa";
        }
    }
    else if ( $tipe == "bank" )
    {
        $tabel = "bank";
    }
    else if ( $tipe == "pmb" )
    {
        $tabel = "calonmahasiswa";
    }
    $q = "UPDATE {$tabel} SET   LASTAKSI=NOW() WHERE ID='{$id}'";
    mysqli_query($koneksi,$q);
}

function set_status_login( $id, $jenis, $login = 1, $token = "", $tipe = "" )
{
    global $koneksi;
    $tabel = "user";
    $timelogout = "";
	#echo $login.'<br>';
    if ( $login != 1 )
    {
        $login = 0;
    }
    else if ( $jenis == 3 )
    {
        $timelogout = " ,LASTLOGIN2=NOW(),LASTAKSI2=NOW(),TOKEN2='{$token}'  ";
    }
    else
    {
        $timelogout = " ,LASTLOGIN=NOW(),LASTAKSI=NOW(),TOKEN='{$token}'  ";
    }
	#echo $timelogout;
    if ( $tipe == "" )
    {
        if ( $jenis == 0 )
        {
            $tabel = "user";
        }
        else if ( $jenis == 1 )
        {
            $tabel = "dosen";
        }
        else if ( $jenis == 2 || $jenis == 3 )
        {
            $tabel = "mahasiswa";
        }
    }
    else if ( $tipe == "bank" )
    {
        $tabel = "operatorbank";
    }
    else if ( $tipe == "pmb" )
    {
        $tabel = "calonmahasiswa";
    }
    if ( $jenis == 3 )
    {
        $q = "UPDATE {$tabel} SET STATUSLOGIN2='{$login}' {$timelogout} WHERE ID='{$id}'";
    }
    else
    {
        $q = "UPDATE {$tabel} SET STATUSLOGIN='{$login}' {$timelogout} WHERE ID='{$id}'";
    }
	#echo $q.'<br>';
    mysqli_query($koneksi,$q);
}

function is_sedang_login( $id, $jenis, $tipe = "" )
{
    global $koneksi;
    $d = status_login( $id, $jenis, $tipe );
	#print_r($d);exit();
    if ( $d[STATUSLOGIN] == 1 )
    {
        return true;
    }
	else{
		return false;
	}
}

function status_login( $id, $jenis, $tipe = "" )
{
    global $koneksi;
    if ( $tipe == "" )
    {
        $tabel = "user";
        if ( $jenis == 0 )
        {
            $tabel = "user";
        }
        else if ( $jenis == 1 )
        {
            $tabel = "dosen";
        }
        else if ( $jenis == 2 || $jenis == 3 )
        {
            $tabel = "mahasiswa";
        }
    }
    else if ( $tipe == "bank" )
    {
        $tabel = "operatorbank";
    }
    else if ( $tipe == "pmb" )
    {
        $tabel = "calonmahasiswa";
    }
    if ( $jenis == 3 )
    {
        $q = "SELECT STATUSLOGIN2 AS STATUSLOGIN, LASTLOGIN2 AS LASTLOGIN,\r\n      UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LASTLOGIN2) AS LAMALOGIN,\r\n      UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LASTAKSI2) AS LAMADIAM,\r\n      TOKEN2 AS TOKEN\r\n       FROM {$tabel} WHERE ID='{$id}'";
    }
    else
    {
        $q = "SELECT STATUSLOGIN,LASTLOGIN,\r\n      UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LASTLOGIN) AS LAMALOGIN,\r\n      UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LASTAKSI) AS LAMADIAM,\r\n      TOKEN\r\n       FROM {$tabel} WHERE ID='{$id}'";
    }
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        return $d;
    }
}

function isdosenpengajar( $iddosen, $idmakul, $tahun, $semester, $kelas, $idprodi, $sp = 0 )
{
    global $koneksi;
    $hasil = $hasil2 = 0;
    if ( $sp == 1 )
    {
        $tsp = "sp";
    }
    $q = "SELECT IDDOSEN \r\n  FROM dosenpengajar{$tsp}\r\n  WHERE \r\n  \r\n  IDPRODI='{$idprodi}'  AND \r\n  IDDOSEN='{$iddosen}'  AND \r\n  IDMAKUL='{$idmakul}' AND \r\n  TAHUN='{$tahun}' AND\r\n  SEMESTER='{$semester}' AND \r\n  KELAS='{$kelas}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        ++$hasil2;
    }
    $q = ( "SELECT THSMSTBKMK  \r\n  FROM tbkmk{$tsp},mspst\r\n  WHERE \r\n  \r\n  KDJENTBKMK=mspst.KDJENMSPST  AND \r\n  KDPSTTBKMK=mspst.KDPSTMSPST AND\r\n  mspst.IDX='{$idprodi}' AND\r\n  KDKMKTBKMK='{$idmakul}' AND \r\n  THSMSTBKMK=CONCAT('".( $tahun - 1 ) )."','{$semester}')  ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        ++$hasil2;
    }
    if ( $hasil2 == 2 )
    {
        $hasil = 1;
    }
    return $hasil;
}

function getwaktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate, $sp = 0 )
{
    global $koneksi;
    $hasil = 1;
    $settingprodi = 0;
    if ( $sp == 1 )
    {
        $tsp = "sp";
    }
    $q = "SELECT TANGGALSELESAI, IF(CURDATE()<=TANGGALSELESAI,1,0) AS STATUS\r\n  FROM waktunilaiprodi{$tsp} WHERE \r\n  TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}' AND PRODI='{$idprodiupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $settingprodi = 1;
        $d = sqlfetcharray( $h );
        $hasil = 0;
    }
    if ( $settingprodi == 0 && $hasil == 1 )
    {
        $q = "SELECT TANGGALSELESAI, IF(CURDATE()<=TANGGALSELESAI,1,0) AS STATUS\r\n    FROM waktunilai{$tsp} WHERE \r\n    TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            if ( $d[STATUS] == 0 )
            {
                $hasil = 0;
            }
        }
    }
    return $hasil;
}

function waktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate, $sp = 0 )
{
    global $koneksi;
    if ( $sp == 1 )
    {
        $tsp = "sp";
    }
    $q = "SELECT DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y' ) AS TGL\r\n  FROM waktunilaiprodi{$tsp} WHERE \r\n  TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}' AND PRODI='{$idprodiupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[TGL];
    }
    if ( $hasil == "" )
    {
        $q = "SELECT DATE_FORMAT(TANGGALSELESAI,'%d-%m-%Y' ) AS TGL\r\n    FROM waktunilai{$tsp} WHERE \r\n    TAHUN='{$tahunupdate}' AND SEMESTER='{$semesterupdate}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $hasil = $d[TGL];
        }
    }
    return $hasil;
}

function generaterandomcaptcha( $num = 3 )
{
    $hasil['rand'] = $rand = substr( uniqid( rand( ), TRUE ), 0, 3 );
    $hasil['token'] = $token = md5( $rand );
    if ( $num < 1 )
    {
        $num = 1;
    }
    $str = "";
    $bawah = ord( "a" );
    $atas = ord( "z" );
    $i = 0;
    while ( $i < $num )
    {
        if ( rand( 0, 1 ) )
        {
            $str .= chr( rand( $bawah, $atas ) );
        }
        else
        {
            $str .= rand( 0, 9 );
        }
        $i++;
    }
    $hasil['rand'] = $str;
    $hasil['token'] = $token = md5( strtolower( $str ) );
    return $hasil;
}

function getmetadata( $d, $namavar = "contoh", $nilai = "", $readonly = "" )
{
    global $FOLDERFILE;
    if ( ereg_sikad( "varchar", $d[1] ) )
    {
        $tipe = 0;
        $tmp = explode( "(", $d[1] );
        $atribut2 = $atribut = str_replace( ")", "", $tmp[1] );
        if ( 25 < $atribut2 )
        {
            $atribut2 = 25;
        }
        $contohtampilan = "<input type=text name='{$namavar}' value='{$nilai}' size='{$atribut2}'  {$readonly}>";
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}' size='{$atribut2}'  {$readonly}>";
        $nilai2 = $nilai;
    }
    else if ( ereg_sikad( "int", $d[1] ) )
    {
        $tipe = 8;
        $tmp = explode( "(", $d[1] );
        $contohtampilan = "<input type=text name='{$namavar}' value='{$nilai}' size='20'  {$readonly}>";
        $contohpencarian = "\r\n              <input type=checkbox name='{$d['0']}' value='1'   {$readonly}>\r\n              <input type=text name='{$d['0']}1' value='{$nilai}' size='{$atribut2}'  {$readonly}> <= X <=\r\n              <input type=text name='{$d['0']}2' value='{$nilai}' size='{$atribut2}'  {$readonly}>\r\n              ";
        $nilai2 = $nilai;
    }
    else if ( ereg_sikad( "float", $d[1] ) )
    {
        $tipe = 9;
        $tmp = explode( "(", $d[1] );
        $atribut2 = $atribut = str_replace( ")", "", $tmp[1] );
        $contohtampilan = "<input type=text name='{$namavar}' value='{$nilai}' size='20'  {$readonly}>";
        $contohpencarian = "\r\n              <input type=checkbox name='{$d['0']}' value='1'   {$readonly}>\r\n              <input type=text name='{$d['0']}1' value='{$nilai}' size='{$atribut2}'  {$readonly}> <= X <=\r\n              <input type=text name='{$d['0']}2' value='{$nilai}' size='{$atribut2}'  {$readonly}>\r\n              ";
        $nilai2 = $nilai;
    }
    else if ( ereg_sikad( "tinytext", $d[1] ) && ( $d['Comment'] == "" || trim( $d['Comment'] ) == "CARI" ) )
    {
        $tipe = 1;
        $contohtampilan = "<textarea cols=30 rows=5 name='{$namavar}'  {$readonly}>{$nilai}</textarea>";
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}' size='{$atribut2}'  {$readonly}>";
        $nilai2 = $nilai;
    }
    else if ( ereg_sikad( "enum", $d[1] ) )
    {
        $tipe = 2;
        $tmp1 = explode( "enum", $d[1] );
        $tmp = trim( $tmp1[1], ")" );
        $tmp = trim( $tmp, "(" );
        $tmp = explode( ",", $tmp );
        $contohtampilan = "<select name='{$namavar}'>\r\n              <option value=''></option>\r\n              ";
        foreach ( $tmp as $v )
        {
            $atribut .= trim( $v, "'" ).",";
            $cek = "";
            if ( trim( $v, "'" ) == $nilai )
            {
                $cek = "selected";
            }
            $contohtampilan .= "<option  value={$v} {$cek}> ".trim( $v, "'" )."</option>";
        }
        $contohtampilan .= "</select>";
        $atribut = trim( $atribut, "," );
        $nilai2 = $nilai;
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}' size='{$atribut2}'  {$readonly}>";
    }
    else if ( ereg_sikad( "set", $d[1] ) )
    {
        $tipe = 3;
        $tmp1 = explode( "set", $d[1] );
        $tmp = trim( $tmp1[1], ")" );
        $tmp = trim( $tmp, "(" );
        $tmp = explode( ",", $tmp );
        $tmp2 = explode( ",", $nilai );
        foreach ( $tmp as $k => $v )
        {
            $atribut .= trim( $v, "'" ).",";
            $cek = "";
            if ( in_array( trim( $v, "'" ), $tmp2 ) )
            {
                $cek = "checked";
            }
            $contohtampilan .= "<input type=checkbox name='".$namavar."[{$k}]' value={$v} {$cek}>  ".trim( $v, "'" );
        }
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}' size='{$atribut2}'  {$readonly}>";
        $atribut = trim( $atribut, "," );
    }
    else if ( ereg_sikad( "date", $d[1] ) )
    {
        $tipe = 4;
        $atribut = "";
        $tmp = explode( "-", $nilai );
        $tmp2[tgl] = $tmp[2];
        $tmp2[bln] = $tmp[1];
        $tmp2[thn] = $tmp[0];
        $contohtampilan = createinputtanggal( "{$namavar}", $tmp2, "", "" );
        $contohpencarian = "\r\n              <input type=checkbox name='{$d['0']}' value='1'    {$readonly}> ".createinputtanggal( "{$d['0']}1", $tmp2, "", "" )." s.d ".createinputtanggal( "{$d['0']}2", $tmp2, "", "" )."";
    }
    else if ( ereg_sikad( "time", $d[1] ) )
    {
        $tipe = 5;
        $atribut = "";
        $tmp = explode( ":", $nilai );
        $tmp2[dtk] = $tmp[2];
        $tmp2[mnt] = $tmp[1];
        $tmp2[jam] = $tmp[0];
        $contohtampilan = createinputjam( "{$namavar}", $tmp2, "1", "" );
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}' size='8'  {$readonly}> Format: HH:MM:SS";
        $contohpencarian = "\r\n              <input type=checkbox name='{$d['0']}' value='1'    {$readonly}> ".createinputjam( "{$d['0']}1", $tmp2, "1", "" )." s.d ".createinputjam( "{$d['0']}2", $tmp2, "1", "" )."";
    }
    else if ( ereg_sikad( "tinytext", $d[1] ) && ereg_sikad( "FOTO", $d['Comment'] ) )
    {
        $tipe = 6;
        $contohtampilan = "\r\n              <input type=file name='{$namavar}' {$readonly}> <br>\r\n              <input type=checkbox name='hapus{$namavar}' value=1> Hapus\r\n              ";
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}'    {$readonly}>  ";
    }
    else if ( ereg_sikad( "tinytext", $d[1] ) && ereg_sikad( "FILE", $d['Comment'] ) )
    {
        $tipe = 7;
        $contohtampilan = "<input type=file name='{$namavar}' {$readonly}><br>\r\n              <input type=checkbox name='hapus{$namavar}' value=1> Hapus\r\n              ";
        $contohpencarian = "<input type=text name='{$d['0']}' value='{$nilai}'    {$readonly}>  ";
    }
    else if ( ereg_sikad( "tinytext", $d[1] ) && ereg_sikad( "PEMISAH", $d['Comment'] ) )
    {
        $tipe = 99;
        $contohtampilan = "<b>".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." ";
    }
    if ( ereg_sikad( "CARI", $d['Comment'] ) )
    {
        $hasil[cari] = 1;
    }
    $hasil[tipe] = $tipe;
    $hasil[atribut] = $atribut;
    $hasil[contohtampilan] = $contohtampilan;
    $hasil[contohpencarian] = $contohpencarian;
    $hasil[nilai] = $nilai2;
    return $hasil;
}

function getkomponendefault( )
{
    global $koneksi;
    $q = "SELECT * FROM komponendefault ORDER BY PERSEN DESC, NAMA";
    $h = mysqli_query($koneksi,$q);
    unset( $hasil );
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			$hasil[] = $d;
		}
	}
    return $hasil;
}

function get_deposit_mahasiswa( $id )
{
    global $koneksi;
    $hasil = 0;
    $q = "SELECT SUM(JUMLAH) AS HASIL1 FROM deposit WHERE IDMAHASISWA='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $d[HASIL1];
    $q = "SELECT SUM(JUMLAH) AS HASIL2 FROM pakaideposit WHERE IDMAHASISWA='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $hasil - $d[HASIL2];
    return $hasil;
}

function get_jumlah_cuti_mahasiswa( $id, $tahun, $semester )
{
    global $koneksi;
    $hasil = 0;
    $q = "SELECT COUNT(THSMSTRLSM) AS JML FROM trlsm WHERE NIMHSTRLSM='{$id}' AND\r\n  THSMSTRLSM <= CONCAT('{$tahun}','{$semester}') AND STMHSTRLSM='C'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[JML];
    }
    return $hasil;
}

function prepare_cuti_mahasiswa( $id, $tabel )
{
    return $qcuti;
}

function get_cuti_mahasiswa( $id )
{
    global $koneksi;
    $hasil = "";
    $q = "SELECT THSMSTRLSM FROM trlsm WHERE NIMHSTRLSM='{$id}' AND STMHSTRLSM='C' ORDER BY THSMSTRLSM";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray($h))
		{
			$hasil[] = $d[THSMSTRLSM];
		}
	}
    return $hasil;
}

function SortByKelompok( $a, $b )
{
    if ( $a['KDKELTBKMK'].".".$a['IDMAKUL'] == $b['KDKELTBKMK'].".".$b['IDMAKUL'] )
    {
        return 0;
    }
    return $a['KDKELTBKMK'].".".$a['IDMAKUL'] < $b['KDKELTBKMK'].".".$b['IDMAKUL'] ? 0 - 1 : 1;
}

function SortBySemester( $a, $b )
{
    if ( $a['SEMESTER'].".".$a['IDMAKUL'] == $b['SEMESTER'].".".$b['IDMAKUL'] )
    {
        return 0;
    }
    return $a['SEMESTER'].".".$a['IDMAKUL'] < $b['SEMESTER'].".".$b['IDMAKUL'] ? 0 - 1 : 1;
}

function SortByName( $a, $b )
{
    return strcmp( $a['NAMA'], $b['NAMA'] );
}

function SortBySemesterAndID( $a, $b )
{
    if ( $a['SEMESTER'].".".$a['IDMAKUL'] == $b['SEMESTER'] )
    {
        if ( $a['IDMAKUL'] == $b['IDMAKUL'] )
        {
            return 0;
        }
        if ( $a['IDMAKUL'] < $b['IDMAKUL'] )
        {
            return 0 - 1;
        }
        if ( $a['IDMAKUL'] == $b['IDMAKUL'] )
        {
            return 1;
        }
    }
    else if ( $a['SEMESTER'] < $b['SEMESTER'] )
    {
        return 0 - 1;
    }
    else if ( $b['SEMESTER'] < $a['SEMESTER'] )
    {
        return 1;
    }
}

function mstr( $value )
{
    if ( get_magic_quotes_gpc( ) )
    {
        $value = stripslashes( $value );
    }
    return mysql_real_escape_string( $value );
}

function anti_sql_injection( $input )
{
    $aforbidden = array( "insert", "select", "update", "delete", "truncate", "replace", "drop", " or ", ";", "#", "--", "=" );
    $breturn = true;
    foreach ( $aforbidden as $cforbidden )
    {
        if ( !strripos( $input, $cforbidden ) )
        {
            continue;
        }
        $breturn = false;
        break;
        break;
    }
    return $breturn;
}

function getprodimakul( $id )
{
    global $koneksi;
    echo $hasil = "";
    $q = "SELECT IDPRODI FROM \r\n  makul\r\n  WHERE \r\n  ID='{$id}' \r\n  ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[IDPRODI];
    }
    return $hasil;
}

function getnamamksp( $id, $tahunsem, $prodi, $sp = 0 )
{
    global $koneksi;
    $tsp = "sp";
    $hasil = "";
    $q = "SELECT NAKMKTBKMK NAMA FROM \r\n  tbkmk{$tsp} ,mspst\r\n  WHERE \r\n  KDKMKTBKMK='{$id}' AND\r\n  THSMSTBKMK='{$tahunsem}' AND\r\n  mspst.IDX='{$prodi}' AND\r\n  mspst.KDPSTMSPST=tbkmk{$tsp}.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk{$tsp}.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk{$tsp}.KDPTITBKMK  \r\n  ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[NAMA];
    }
    return $hasil;
}

function getdatamk( $id, $tahunsem, $prodi )
{
    global $koneksi;
    $hasil = "";
    $q = "SELECT tbkmk.*   FROM \r\n  tbkmk ,mspst\r\n  WHERE \r\n  KDKMKTBKMK='{$id}' AND\r\n  THSMSTBKMK='{$tahunsem}' AND\r\n  mspst.IDX='{$prodi}' AND\r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK  \r\n  ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d;
}

function getnamamk( $id, $tahunsem, $prodi )
{
    global $koneksi;
    $hasil = "";
    $q = "SELECT NAKMKTBKMK NAMA FROM \r\n  tbkmk ,mspst\r\n  WHERE \r\n  KDKMKTBKMK='{$id}' AND\r\n  THSMSTBKMK='{$tahunsem}' AND\r\n  mspst.IDX='{$prodi}' AND\r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK  \r\n  ";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $hasil = $d[NAMA];
    }
    return $hasil;
}

function getkelas( $id )
{
    global $koneksi;
    $hasil = "";
    $q = "SELECT FROM mahasiswa WHERE";
}

function getaturan( $id )
{
    global $koneksi;
    $q = "SELECT {$id} FROM aturan";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d[$id];
}

function ismahasiswaaktif( $idmahasiswa )
{
    global $koneksi;
    $q = "SELECT NAMA FROM mahasiswa WHERE ID='{$idmahasiswa}' AND STATUS='A'";
    $h = mysqli_query($koneksi,$q);
    $hasil = 0;
    if ( 0 < sqlnumrows( $h ) )
    {
        $hasil = 1;
    }
    return $hasil;
}

function isdataada( $id, $tabel )
{
    global $koneksi;
    $q = "SELECT COUNT(ID) AS JML  FROM {$tabel} WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    if ( 0 < $d[JML] )
    {
        return true;
    }
    return false;
}

function getrowfromtabelsyarat( $syarat, $field, $tabel )
{
    global $koneksi;
    $q = "SELECT {$field} FROM {$tabel} {$syarat}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d;
}

function getrowfromtabel( $id, $field, $tabel )
{
    global $koneksi;
    $q = "SELECT {$field} FROM {$tabel} WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d;
}

function getfieldfromtabel( $id, $field, $tabel )
{
    global $koneksi;
    $q = "SELECT {$field} FROM {$tabel} WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $nama = "";
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nama = $d[$field];
    }
    return $nama;
}

function getnamafromtabel( $id, $tabel )
{
    global $koneksi;
    $q = "SELECT NAMA FROM {$tabel} WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    $nama = "";
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nama = $d[NAMA];
    }
    return $nama;
}

function getnewidsyarat( $field, $tabel, $where )
{
    global $koneksi;
    $q = "SELECT MAX({$field})+1 AS IDBARU FROM {$tabel} {$where}";
    $h = mysqli_query($koneksi,$q);
    $idbaru = 0;
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $idbaru = $d[IDBARU] + 0;
    }
    return $idbaru;
}

function getnewid( $tabel )
{
    global $koneksi;
    $q = "SELECT MAX(ID)+1 AS IDBARU FROM {$tabel}";
    $h = mysqli_query($koneksi,$q);
    $idbaru = 0;
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $idbaru = $d[IDBARU];
    }
    return $idbaru;
}

function make_seed( )
{
    // seed with microseconds
	list($usec, $sec) = explode(' ', microtime());
	$hasil=(float) $sec + ((float) $usec * 100000);
	return $hasil;
	
}

function delgambartemp( )
{
    global $koneksi;
    $q = "SELECT NAMA FROM gambartemp WHERE TANGGAL < NOW()";
    $h = mysqli_query($koneksi,$q);
	if(0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			if ( @unlink( $d[NAMA] ) )
			{
				$q = "DELETE FROM gambartemp WHERE NAMA='{$d['NAMA']}'";
				mysqli_query($koneksi,$q);
			}
		}
	}
}

function getpembagiinteger( $x )
{
    if ( $x % 10 == 0 )
    {
        $pembagi = 10;
    }
    else if ( $x % 9 == 0 )
    {
        $pembagi = 9;
    }
    else if ( $x % 8 == 0 )
    {
        $pembagi = 8;
    }
    else if ( $x % 7 == 0 )
    {
        $pembagi = 7;
    }
    else if ( $x % 6 == 0 )
    {
        $pembagi = 6;
    }
    else if ( $x % 5 == 0 )
    {
        $pembagi = 5;
    }
    else if ( $x % 4 == 0 )
    {
        $pembagi = 4;
    }
    else if ( $x % 3 == 0 )
    {
        $pembagi = 3;
    }
    else if ( $x % 2 == 0 )
    {
        $pembagi = 2;
    }
    else if ( $$x % 1 == 0 )
    {
        $pembagi = 1;
    }
    return $pembagi;
}



function creatediagrambatangpersen( $datatabel, $data, $datanx, $judul, $folder, $xx )
{
    $im = @ImageCreate( @$datatabel[panjang], @$datatabel[lebar] );
    if ( $judul[warna] == "" )
    {
        $datawarna[latartabel] = ImageColorAllocate( $im, 0, 0, 0 );
        $datawarna[latar] = ImageColorAllocate( $im, 255, 255, 255 );
        $datawarna[garis] = ImageColorAllocate( $im, 0, 0, 0 );
        $datawarna[tabel] = ImageColorAllocate( $im, 0, 0, 255 );
    }
    else
    {
        $datawarna[latar] = ImageColorAllocate( $im, $judul[warna][latar][R], $judul[warna][latar][G], $judul[warna][latar][B] );
        $datawarna[garis] = ImageColorAllocate( $im, $judul[warna][garis][R], $judul[warna][garis][G], $judul[warna][garis][B] );
        $datawarna[tabel] = ImageColorAllocate( $im, $judul[warna][tabel][R], $judul[warna][tabel][G], $judul[warna][tabel][B] );
        $datawarna[latartabel] = ImageColorAllocate( $im, $judul[warna][latartabel][R], $judul[warna][latartabel][G], $judul[warna][latartabel][B] );
    }
    $fjxheight = imagefontheight( $judul[x][font] );
    $fjxwidth = imagefontwidth( $judul[x][font] );
    $fjyheight = imagefontheight( $judul[y][font] );
    $fjywidth = imagefontwidth( $judul[y][font] );
    $fj1height = imagefontheight( $judul[1][font] );
    $fj1width = imagefontwidth( $judul[1][font] );
    $fj2height = imagefontheight( $judul[2][font] );
    $fj2width = imagefontwidth( $judul[2][font] );
    $fyheight = imagefontheight( $judul[ny][font] );
    $fywidth = imagefontwidth( $judul[ny][font] );
    $fxheight = imagefontheight( $judul[nx][font] );
    $fxwidth = imagefontwidth( $judul[nx][font] );
    $datax = array_keys( $data );
    $jarakx = ( $datatabel[maxx] - $datatabel[minx] ) / $datatabel[jmltitikx];
    $jaraky = ( $datatabel[maxy] - $datatabel[miny] ) / $datatabel[jmltitiky];
    $datatabel[xmax] = $datatabel[panjang] - $datatabel[jarakbingkai];
    $datatabel[ymax] = $datatabel[jarakbingkai];
    $xo = $datatabel[jarakbingkai];
    $yo = $datatabel[lebar] - $datatabel[jarakbingkai];
    imagefill( $im, 1, 1, $datawarna[latar] );
    imagerectangle( $im, $xo, $yo, $datatabel[xmax], $datatabel[ymax], $datawarna[latartabel] );
    $jx = $fjywidth * strlen( $judul[y][nama] ) / 2;
    $jy = $fjyheight;
    imagestringup( $im, $judul[y][font], $xo / 2 - $jy, $datatabel[lebar] / 2 + $jx, $judul[y][nama], $datawarna[garis] );
    $jx = $fjxwidth * strlen( $judul[x][nama] ) / 2;
    $jy = $fjxheight;
    imagestring( $im, $judul[x][font], $datatabel[panjang] / 2 - $jx, $datatabel[lebar] - $datatabel[jarakbingkai] / 2, $judul[x][nama], $datawarna[garis] );
    $jx = $fj2width * strlen( $judul[2][nama] ) / 2;
    $jyt = $jy = $fj2height;
    imagestring( $im, $judul[2][font], $datatabel[panjang] / 2 - $jx, $datatabel[jarakbingkai] / 2, $judul[2][nama], $datawarna[garis] );
    $jx = $fj1width * strlen( $judul[1][nama] ) / 2;
    $jy = $fj1height;
    imagestring( $im, $judul[1][font], $datatabel[panjang] / 2 - $jx, $datatabel[jarakbingkai] / 2 - $jy, $judul[1][nama], $datawarna[garis] );
    $ytmp = ( $yo - $datatabel[ymax] ) / $datatabel[jmltitiky];
    $xtmp = $xo;
    $i = 0;
    while ( $i <= $datatabel[jmltitiky] )
    {
        imagearc( $im, $xtmp, $yo - $ytmp * $i, 5, 5, 0, 360, $datawarna[garis] );
        $nilai = "".$i * $jaraky."";
        $jx = $fywidth * strlen( $nilai );
        $jy = $fywidth;
        imagestring( $im, $judul[ny][font], $xtmp - $jx - $jy, $yo - $ytmp * $i - $jy, $nilai, $datawarna[garis] );
        ++$i;
    }
    $xtmp = @( @$datatabel[xmax] - @$xo ) / ( @$datatabel[maxx] - @minx );
    $ytmp = @( @$yo - @$datatabel[ymax] ) / ( @$datatabel[maxy] - @miny );
    $xlama = $xo;
    $ylama = $yo;
    $ii = 0;
    foreach ( $data as $x => $y )
    {
        $xkiri = $xo + $xtmp * $x - $datatabel[jarakbatang];
        $xkanan = $xo + $xtmp * $x + $datatabel[jarakbatang];
        imagefilledrectangle( $im, $xkiri, $yo - $ytmp * $y, $xkanan, $yo, $datawarna[tabel] );
        if ( $datanx[$x] == "" && isset( $datanx[$x] ) )
        {
            $nilai = "".$x."";
        }
        else
        {
            $nilai = $datanx[$x];
        }
        $jx = $fxwidth * strlen( $nilai ) / 2;
        $jy = $fxwidth;
        if ( $ii % 2 == 0 )
        {
            $turun = 0;
        }
        else
        {
            $turun = $jy * 2;
        }
        imagestring( $im, $judul[nx][font], $xo + $xtmp * $x - $jx, $yo + $jy + $turun, $nilai, $datawarna[garis] );
        $natasy = cetakuang( $y * 100 / $datatabel[maxy] )."%";
        $jx = $fxwidth * strlen( $natasy ) / 2;
        $jy = $fxwidth;
        if ( $ii % 2 == 0 )
        {
            $turun = 0;
        }
        else
        {
            $turun = $jy * 2;
        }
        imagestring( $im, $judul[nx][font], $xo + $xtmp * $x - $jx, $yo - $ytmp * $y - $jy - $jy, $natasy, $datawarna[garis] );
        $xlama = $xo + $xtmp * $x;
        $ylama = $yo - $ytmp * $y;
        ++$ii;
    }
    $xx = number_format_sikad( $xx + 0, 0, 0, 0 ).".png";
    ImagePNG( $im, "{$folder}".$xx );
    imagedestroy( $im );
    return $xx;
}


function creatediagrambatang( $datatabel, $data, $datanx, $judul, $folder, $xx )
{
    global $ombangambing;
    $im = @ImageCreate( @$datatabel[panjang], @$datatabel[lebar] );
    if ( $judul[warna] == "" )
    {
        $datawarna[latartabel] = ImageColorAllocate( $im, 0, 0, 0 );
        $datawarna[latar] = ImageColorAllocate( $im, 255, 255, 255 );
        $datawarna[garis] = ImageColorAllocate( $im, 0, 0, 0 );
        $datawarna[tabel] = ImageColorAllocate( $im, 0, 0, 255 );
    }
    else
    {
        $datawarna[latar] = ImageColorAllocate( $im, $judul[warna][latar][R], $judul[warna][latar][G], $judul[warna][latar][B] );
        $datawarna[garis] = ImageColorAllocate( $im, $judul[warna][garis][R], $judul[warna][garis][G], $judul[warna][garis][B] );
        $datawarna[tabel] = ImageColorAllocate( $im, $judul[warna][tabel][R], $judul[warna][tabel][G], $judul[warna][tabel][B] );
        $datawarna[latartabel] = ImageColorAllocate( $im, $judul[warna][latartabel][R], $judul[warna][latartabel][G], $judul[warna][latartabel][B] );
    }
    $fjxheight = imagefontheight( $judul[x][font] );
    $fjxwidth = imagefontwidth( $judul[x][font] );
    $fjyheight = imagefontheight( $judul[y][font] );
    $fjywidth = imagefontwidth( $judul[y][font] );
    $fj1height = imagefontheight( $judul[1][font] );
    $fj1width = imagefontwidth( $judul[1][font] );
    $fj2height = imagefontheight( $judul[2][font] );
    $fj2width = imagefontwidth( $judul[2][font] );
    $fyheight = imagefontheight( $judul[ny][font] );
    $fywidth = imagefontwidth( $judul[ny][font] );
    $fxheight = imagefontheight( $judul[nx][font] );
    $fxwidth = imagefontwidth( $judul[nx][font] );
    $datax = array_keys( $data );
    $jarakx = ( $datatabel[maxx] - $datatabel[minx] ) / $datatabel[jmltitikx];
    $jaraky = ( $datatabel[maxy] - $datatabel[miny] ) / $datatabel[jmltitiky];
    $datatabel[xmax] = $datatabel[panjang] - $datatabel[jarakbingkai];
    $datatabel[ymax] = $datatabel[jarakbingkai];
    $xo = $datatabel[jarakbingkai];
    $yo = $datatabel[lebar] - $datatabel[jarakbingkai];
    imagefill( $im, 1, 1, $datawarna[latar] );
    imagerectangle( $im, $xo, $yo, $datatabel[xmax], $datatabel[ymax], $datawarna[latartabel] );
    $jx = $fjywidth * strlen( $judul[y][nama] ) / 2;
    $jy = $fjyheight;
    imagestringup( $im, $judul[y][font], $xo / 2 - $jy, $datatabel[lebar] / 2 + $jx, $judul[y][nama], $datawarna[garis] );
    $jx = $fjxwidth * strlen( $judul[x][nama] ) / 2;
    $jy = $fjxheight;
    imagestring( $im, $judul[x][font], $datatabel[panjang] / 2 - $jx, $datatabel[lebar] - $datatabel[jarakbingkai] / 2, $judul[x][nama], $datawarna[garis] );
    $jx = $fj2width * strlen( $judul[2][nama] ) / 2;
    $jyt = $jy = $fj2height;
    imagestring( $im, $judul[2][font], $datatabel[panjang] / 2 - $jx, $datatabel[jarakbingkai] / 2, $judul[2][nama], $datawarna[garis] );
    $jx = $fj1width * strlen( $judul[1][nama] ) / 2;
    $jy = $fj1height;
    imagestring( $im, $judul[1][font], $datatabel[panjang] / 2 - $jx, $datatabel[jarakbingkai] / 2 - $jy, $judul[1][nama], $datawarna[garis] );
    $ytmp = ( $yo - $datatabel[ymax] ) / $datatabel[jmltitiky];
    $xtmp = $xo;
    $i = 0;
    while ( $i <= $datatabel[jmltitiky] )
    {
        imagearc( $im, $xtmp, $yo - $ytmp * $i, 5, 5, 0, 360, $datawarna[garis] );
        $nilai = "".$i * $jaraky."";
        $jx = $fywidth * strlen( $nilai );
        $jy = $fywidth;
        imagestring( $im, $judul[ny][font], $xtmp - $jx - $jy, $yo - $ytmp * $i - $jy, $nilai, $datawarna[garis] );
        ++$i;
    }
    $xtmp = @( @$datatabel[xmax] - @$xo ) / ( @$datatabel[maxx] - @minx );
    $ytmp = @( @$yo - @$datatabel[ymax] ) / ( @$datatabel[maxy] - @miny );
    $xlama = $xo;
    $ylama = $yo;
    $ii = 0;
    foreach ( $data as $x => $y )
    {
        $xkiri = $xo + $xtmp * $x - $datatabel[jarakbatang];
        $xkanan = $xo + $xtmp * $x + $datatabel[jarakbatang];
        imagefilledrectangle( $im, $xkiri, $yo - $ytmp * $y, $xkanan, $yo, $datawarna[tabel] );
        if ( $datanx[$x] == "" && isset( $datanx[$x] ) )
        {
            $nilai = "".$x."";
        }
        else
        {
            $nilai = $datanx[$x];
        }
        $jx = $fxwidth * strlen( $nilai ) / 2;
        $jy = $fxwidth;
        $turun = 0;
        if ( $ombangambing == "" )
        {
            if ( $ii % 2 == 0 )
            {
                $turun = 0;
            }
            else
            {
                $turun = $jy * 2;
            }
        }
        else
        {
            $turun = 0;
        }
        imagestring( $im, $judul[nx][font], $xo + $xtmp * $x - $jx, $yo + $jy + $turun, $nilai, $datawarna[garis] );
        $xlama = $xo + $xtmp * $x;
        $ylama = $yo - $ytmp * $y;
        ++$ii;
    }
    $xx = number_format_sikad( $xx + 0, 0, 0, 0 ).".png";
    ImagePNG( $im, "{$folder}".$xx );
    imagedestroy( $im );
    return $xx;
}

function cekhaktulis( $t, $tipe = "" )
{
	#echo $tipe;exit();
    global $tingkats,$tingkataksesusers,$tingkats_bank,$tingkats_pmb;
    #global $tingkataksesusers;
    #global $tingkats_bank;
    #global $tingkats_pmb;
	#echo $tingkats."".$tingkataksesusers."VVV".$tingkat_bank."LLLL".$tingkat_pmb;
	#echo $tingkataksesusers[$t];
    if ( $tipe == "" )
    {
		    
        if (session_is_registered_sikad( "tingkats" ) )
        {
			#echo "lll";
            if ( $tingkataksesusers[$t] != "T" )
            {
                exit( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
            }
        }
        else
        {
            exit( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
        }
    }
    else
    {
		#echo $tipe;
        
        if ( $tipe == "bank" )
        {
            if (session_is_registered_sikad( "tingkats_bank" ) )
            {
				if ($tingkataksesusers[$t]!="T") {

					die( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
				
				}
			}
            else
            {
                die( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
            }
        }
        else
        {
            if ( $tingkataksesusers[$t] != "T" && $tipe == "pmb" )
            {
                if ( session_is_registered_sikad( "tingkats_pmb" ) )
                {
                    if ( $tingkataksesusers[$t] != "T" )
                    {
                        die( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
                    }
                }
                else
                {
                    die( "<h1 align=center>Fasilitas ini tidak boleh Anda Akses</h1>" );
                }
            }
        }
    }
}

function printjudulmenukecilcetak( $judul )
{
    echo "\r\n\t<p>\r\n\t<table class=judulmenucetak>\r\n\t\t<tr align=left>\r\n\t\t\t<td>\r\n\t\t \r\n\t\t\t{$judul}\r\n\t \r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</p>\r\n\t";
}

function cetakdigitnol( $n, $d )
{
    $l = strlen( "".$n."" );
    $hasil = "";
    if ( $l < $d )
    {
        $i = 0;
        while ( $i < $d - $l )
        {
            $hasil .= "0";
            ++$i;
        }
        $hasil = $hasil."{$n}";
    }
    else
    {
        $hasil = "{$n}";
    }
    return $hasil;
}

function removedir( $dir )
{
    $dh = opendir( $dir );
    while ( $file = readdir( $dh ) )
    {
        if ( $file != "." && $file != ".." )
        {
            $fullpath = $dir."/".$file;
            if ( !is_dir( $fullpath ) )
            {
                @unlink( @$fullpath );
            }
            else
            {
                removedir( $fullpath );
            }
        }
    }
    closedir( $dh );
    if ( rmdir( $dir ) )
    {
        return true;
    }
    return false;
}

function idbaru( $tabel )
{
    global $koneksi;
    $q = "SELECT MAX(ID) AS IDBARU FROM {$tabel}";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $d[IDBARU];
    if ( $hasil == "" )
    {
        $hasil = 1;
    }
    else
    {
        $hasil = $hasil + 1;
    }
    return $hasil;
}

function cetakuang( $n, $cetakkosong = 1 )
{
    if ( $cetakkosong == 0 && trim( $n ) == "" )
    {
        return "";
    }
    return number_format_sikad( $n + 0, 0, ",", "." );
}

function cekisidatang( $id )
{
    global $koneksi;
    $q = "SELECT JAMDATANG FROM presensi WHERE IDUSER='{$id}' AND TANGGAL=NOW()";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    if ( trim( $d[JAMDATANG] ) != "" )
    {
        return true;
    }
    return false;
}

function cekisipulang( $id, $pindahhari )
{
    global $koneksi;
    $hpindah = 0;
    if ( $pindahhari == true )
    {
        $hpindah = 0 - 1;
    }
    $q = "SELECT JAMPULANG FROM presensi WHERE IDUSER='{$id}' AND \r\n\tTANGGAL=DATE_ADD(NOW(),INTERVAL {$hpindah} DAY)";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    if ( trim( $d[JAMPULANG] ) != "" )
    {
        return true;
    }
    return false;
}

function angkatoteks( $a, $sebutnol = 0 )
{
	global $angka;
   # $angka2 = $angka;
  # echo $a.'<br>'.$sebutnol.'AAA<br>'.$angka[$a].'BBB<br>';
   
   #if ($a==0) 
   if ( $angka[$a] != "" )
    {
        #if ( $sebutnol == 1 )
        #{
            $teks = $angka[$a];
        #}
    }
    else
    {
        #$teks = $angka[$a];
		#echo "LL".$teks;exit();
        if ( 11 < $a && $a < 20 )
        {
            $t1 = $a / 10;
            $t2 = $a % 10;
			$teks=$angka[$t2]." Belas ";	
           /* if ( 1 < $t1 )
            {
                $teks = $angka[$t1]." Belas ";
            }
            else
            {
                $teks = "Sebelas ";
            }*/
        }
        #else if ( 21 < $a && $a < 100 )
	elseif($a>=20 && $a<100)
        {
			#echo $a;exit();
            $t1 = floor( $a / 10 );
			#echo $t1;exit();
            $t2 = $a % 10;
		#$teks = $angka[$t1]." Puluh ".$angka[$t2];
		if($t2>0){
		
		 $teks = $angka[$t1]." Puluh ".$angka[$t2];

		}else{
		
		 $teks = $angka[$t1]." Puluh ";	
		}
            /*if ( 1 < $t1 )
            {
                $teks = $angka[$t1]." Puluh ";
            }
			else{
            
				$teks = "Sepuluh ";
				
			}
			 $teks .= angkatoteks( $t2 );*/
        }
        else if ( 100 < $a && $a < 1000 )
        {
            $t1 = floor( $a / 100 );
            $t2 = $a % 100;
            if ( 1 < $t1 )
            {
                $teks = $angka[$t1]." Ratus ";
            }
            else
            {
                $teks = "Seratus ";
            }
            $teks .= angkatoteks( $t2 );
        }
        else if ( 1000 < $a && $a < 1000000 )
        {
            $t1 = floor( $a / 1000 );
            $t2 = $a % 1000;
            if ( 1 < $t1 )
            {
                $teks = angkatoteks( $t1 )." Ribu ";
				#$teks = $angka[$t1]." Ribu ";
            }
            else
            {
                $teks = "Seribu ";
				#$teks .=angkatoteks($t2);
            }
            #$teks .= angkatoteks( $t2 );
			#$teks .= angkatoteks( $t2 );
        }
        else if ( 1000000 <= $a && $a < 1000000000 )
        {
            $t1 = floor( $a / 1000000 );
            $t2 = $a % 1000000;
			echo $t1.'XXX<br>'.$t2.'WWWW<br>';
            $teks = angkatoteks( $t1 )." Juta ";
            $teks .= angkatoteks( $t2 );
        }
        else if ( 1000000000.0 <= $a && $a < 1000000000000.0 )
        {
            $t1 = $a / 1000000000;
            $t1 = floor( $t1 );
            $t2 = $a - $t1 * 1000000000;
            $teks = angkatoteks( $t1 )." Milyar ";
            #$teks .= angkatoteks( $t2 );
        }
        else if ( 1000000000000.0 <= $a && $a < 1000000000000000.0 )
        {
            $t1 = $a / 1e+012;
            $t1 = floor( $t1 );
            $t2 = $a - $t1 * 1e+012;
            $teks = angkatoteks( $t1 )." Trilyun ";
            $teks .= angkatoteks( $t2 );
        }
        else if ( 1000000000000000.0 <= $a && $a < 1000000000000000000.0 )
        {
            $t1 = $a / 1e+015;
            $t1 = floor( $t1 );
            $t2 = $a - $t1 * 1e+015;
            $teks = angkatoteks( $t1 )." Bilyun ";
            $teks .= angkatoteks( $t2 );
        }
		
		#$teks .= angkatoteks( $t2 );
    }
    return $teks;
}

function getasal( )
{
    global $REMOTE_ADDR;
    return "{$REMOTE_ADDR}";
}

function imgsizeprop( $img, $w )
{
    if ( $w == "" )
    {
        $wi = 100;
    }
    else
    {
        $wi = $w;
    }
    $img = @getimagesize($img);
    $h1 = $img[1];
    $w1 = $img[0];
    $w2 = $wi;
    $h2 = $h1*@($w2/$w1);
    settype( $h2, "integer" );
    $i[0] = $w2;
    $i[1] = $h2;
    return $i;
}

function imgsizeproph( $img, $h )
{
    if ( $h == "" )
    {
        $hi = 100;
    }
    else
    {
        $hi = $h;
    }
    $img = @getimagesize($img);
    $h1 = $img[1];
    $w1 = $img[0];
    $h2 = $hi;
    $w2 = $w1*@($h2/$h1);
    settype( $w2, "integer" );
    $i[0] = $w2;
    $i[1] = $h2;
    return $i;
}

function cekuser( $t )
{
    global $tingkats;
    if ( session_is_registered_sikad( "tingkats" ) )
    {
        if ( $t == "" )
        {
        }
        else
        {
            $ok = false;
            $i = 0;
            while ( $i < strlen( $t ) )
            {
                if ( ereg_sikad( $t[$i], $tingkats ) )
                {
                    $ok = true;
                    break;
                }
                ++$i;
            }
            if ( !$ok )
            {
                exit( "<h1 align=center>X?!@&(%$^VTYEPO+_^</h1>" );
            }
        }
    }
    else
    {
        exit( "<h1 align=center>X?!@&(%$^VTYEPO+_^</h1>" );
    }
}

function cekjabatan( $j )
{
    global $jabatans;
    if ( session_is_registered_sikad( "jabatans" ) && $jabatans != $j )
    {
        exit( "<h1 align=center>X?!@&(%$^VTYEPO+_^</h1>" );
    }
}

function getfield( $field, $tabel, $syarat )
{
    global $koneksi;
    $q = "SELECT {$field} FROM {$tabel} {$syarat}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d[$field];
}

function getnama( $id )
{
    global $koneksi;
    $q = "SELECT NAMA FROM user WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d[NAMA];
}

function getnip( $id )
{
    global $koneksi;
    $q = "SELECT NIP FROM user WHERE ID='{$id}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    return $d[NIP];
}

function pf( $m )
{
    return "{$m}";
}

function printid( $id )
{
    return $id;
}

function jumlahpegawai( )
{
    global $koneksi;
    $query = "SELECT COUNT(ID) AS JML FROM user WHERE ID!='superadmin' AND STATUSKERJA='0'";
    $hasil = mysqli_query($koneksi,$query);
    $data = sqlfetcharray( $hasil );
    return $data[JML];
}

function jamtodetik( $j, $m, $d )
{
    return $j * 3600 + $m * 60 + $d;
}

function detiktojamlembur( $s )
{
    $tmp = $s;
    settype( $tmp, "integer" );
    $j = $tmp / 3600;
    settype( $j, "integer" );
    $tj = $tmp % 3600;
    settype( $tj, "integer" );
    $m = $tj / 60;
    settype( $m, "integer" );
    return "{$j}:{$m}:00";
}

function detiktojam( $s )
{
    $tmp = $s;
    settype( $tmp, "integer" );
    $j = $tmp / 3600;
    settype( $j, "integer" );
    return $j;
}

function islibur( )
{
    global $koneksi;
    $now = getdate( time( ) );
    $tgl = $now[year]."-".$now[mon]."-".$now[mday];
    $query = "SELECT COUNT(TGLLIBUR) AS JML FROM libur WHERE TGLLIBUR='{$tgl}'";
    $h = mysqli_query($koneksi,$query);
    $jnslibur = sqlfetcharray( $h );
    $jml = $jnslibur[JML];
    if ( $jml == 1 )
    {
        return true;
    }
    return false;
}

function isharilibur( $tgl, $bln, $thn )
{
    global $koneksi;
    $w = getdate( Mktime( 0, 0, 0, $bln, $tgl, $thn ) );
    $tgl = $w[year]."-".$w[mon]."-".$w[mday];
    $query = "SELECT COUNT(TGLLIBUR) AS JML FROM libur WHERE TGLLIBUR='{$tgl}'";
    $h = mysqli_query($koneksi,$query);
    $jnslibur = sqlfetcharray( $h );
    $jml = $jnslibur[JML];
    if ( $jml == 1 )
    {
        return true;
    }
    return false;
}

function printconfirmjs( $c )
{
    echo "onclick=\"return confirm('{$c}')\"";
}

function printman( $man )
{
    echo "\r\n\t<center>\r\n\t\t<table class=man  width=95% cellspacing=2 cellpadding=2 >\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t<font style='font-size:9px;font-family:Arial;' \r\n\t\t\t\t\t>{$man}</font>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t</center>";
}

function printmutiara( $man )
{
    echo "\r\n\t<center>\r\n\t\t<table width=100%>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t<font style='font-size:11pt;' color=#0055ff>{$man}</font>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t</center>";
}

function getpanggilan( $iduser )
{
    global $koneksi;
    $pgl = "";
    $query = "SELECT NAMA, KELAMIN, \r\n\t\t\t(YEAR(NOW())-YEAR(TGLLAHIR)) AS USIA\r\n\t\t\tFROM user WHERE ID = '{$iduser}' ";
    $hasil = mysqli_query($koneksi,$query);
    if ( sqlnumrows( $hasil ) == 1 )
    {
        $datauser = sqlfetcharray( $hasil );
        if ( $datauser[USIA] < 25 )
        {
            if ( $datauser[KELAMIN] == "L" )
            {
                $pgl = "Mas";
            }
            else
            {
                if ( $datauser[KELAMIN] == "P" )
                {
                    $pgl = "Mbak";
                }
            }
        }
        else if ( $datauser[KELAMIN] == "L" )
        {
            $pgl = "Bapak";
        }
        else if ( $datauser[KELAMIN] == "P" )
        {
            $pgl = "Ibu";
        }
    }
    if ( $pgl != "" )
    {
        $pgl = $pgl." ".$datauser[NAMA];
    }
    return $pgl;
}

function printadmin( )
{
    global $admin;
    global $namaadmin;
    echo "\r\n\t<table width=100% cellspacing=2 cellpadding=0 bgcolor=#22366>\r\n\t\t<tr valign=middle>\r\n\t\t\t<td>\r\n\t\t\t\t&nbsp;\r\n\t\t\t\t<font size=2>Anda login sebagai {$admin} ({$namaadmin})</font>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
}

function printuser( )
{
    global $user;
    global $namauser;
    echo "\r\n\t<table width=100% cellspacing=2 cellpadding=0 bgcolor=#22366>\r\n\t\t<tr valign=middle>\r\n\t\t\t<td>\r\n\t\t\t\t&nbsp;\r\n\t\t\t\t<font size=2>Anda login sebagai ".printid( $user )." ({$namauser})</font>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
}

function sqlnumrows( $hasil )
{
    return mysqli_num_rows( $hasil );
}

function doquery($koneksi,$query)
{
    $h = mysqli_query($koneksi,$query);
    return $h;
}

function sqlfetcharray( $hasil )
{
    return mysqli_fetch_array( $hasil );
}

function sqlaffectedrows( $koneksi )
{
    return mysqli_affected_rows( $koneksi );
}

function koneksiBD( )
{
    $konek = mysql_connect( $hostsql, $loginsql, $passwordsql );
    return $konek;
}

function isemail( $email )
{
    return ereg_sikad( "^[^@ \t]+@[^@ \t]+\\.[^@ \t]+", $email );
}

function isintegerpositif( $angka )
{
    return ereg_sikad( "^[0-9][0-9]*\$", $angka );
}

function isangka( $angka )
{
    return ereg_sikad( "^[0-9]+\$", $angka );
}

function istahun( $tahun )
{
    return isintegerpositif( $tahun ) && ereg_sikad( "[0-9]{4}", $tahun ) && 1900 < $tahun;
}

function iskabisat( $tahun )
{
    return $tahun % 100 != 0 && $tahun % 4 == 0 || $tahun % 100 == 0 && $tahun % 400 == 0;
}

function istanggal( $tanggal, $bulan, $tahun, $komentar )
{
    if ( !isintegerpositif( $tanggal ) )
    {
        return 0;
    }
    if ( !isintegerpositif( $bulan ) || ( 12 < $bulan || $bulan < 1 ) )
    {
        return 0;
    }
    if ( !isintegerpositif( $tahun ) || $tahun < 1900 )
    {
        return 0;
    }
    if ( $bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11 )
    {
        if ( 30 < $tanggal )
        {
            return 0;
        }
    }
    if ( $bulan == 2 )
    {
        return 0;
        return 1;
    }
    if ( 28 < $tanggal && !iskabisat( $tahun ) && 31 < $tanggal )
    {
        return 0;
    }
    return 1;
}

function isarraysama( $array1, $array2 )
{
    if ( count( $array1 ) != count( $array2 ) )
    {
        return false;
    }
    $sama = true;
    $i = 0;
    while ( $i < count( $array1 ) )
    {
        if ( $array[$i] != $array2[$i] )
        {
            $sama = false;
            break;
        }
        ++$i;
    }
    return $sama;
}

function hasilquerytoarray( $hasil, $i )
{
    while ( $row = sqlfetcharray( $hasil ) )
    {
        $hasil[] = $row[$i];
        echo "{$row[$i]}";
    }
    return $hasil;
}

function addnol( $nilai, $banyakdigit )
{
    $tmp = "";
    $d = $banyakdigit - 1;
    while ( 1 <= $d )
    {
        if ( 1 <= $nilai / pow( 10, $d ) )
        {
            break;
        }
        $tmp .= "0";
        --$d;
    }
    return "{$tmp}{$nilai}";
}

function locktabel( $daftartabel )
{
    global $koneksi;
    mysql_query( "LOCK TABLE {$daftartabel}", $koneksi );
}

function unlocktabel( )
{
    global $koneksi;
    mysql_query( "UNLOCK TABLE", $koneksi );
}

function getkode( )
{
    global $koneksi;
    $q = "SELECT PASSWORD(PASSWORD(DATE_FORMAT(NOW(),'%d%m%Y'))) AS HASIL";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    return $d['HASIL'];
}

$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$br = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
periksaroot( );
include_once( $root."array.php" );
include_once( $root."fungsitampilan.php" );
$tipelogin = 0;
$tipelogin = 1;
$namaserver = "server-pegawai";
?>
