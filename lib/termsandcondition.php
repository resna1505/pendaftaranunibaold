<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
#include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
$arrayukuranhalamanpdf['A4'] = "A4";
$arrayukuranhalamanpdf['Letter'] = "Letter";
$arrayukuranhalamanpdf['Legal'] = "Legal";
$arrayorientasipdf['P'] = "Potrait";
$arrayorientasipdf['L'] = "Landscape";
$q = "SELECT * FROM settingpdf WHERE ID=0";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $ukuran = $d['UKURAN'];
    $orientasi = $d['ORIENTASI'];
    $marginkiri = $d['MARGINKIRI'];
    $marginkanan = $d['MARGINKIRI'];
    $marginatas = $d['MARGINATAS'];
    $marginbawah = $d['MARGINBAWAH'];
}
echo "<script>
	$(function() {
		$('.button').click(function() {  
			location.href ='index.php?pilihan=tambahcalon'
			return false;  
		});  
	}); 
	</script>";
printjudulmenu( "SYARAT DAN KETENTUAN MAHASISWA DAN MAHASISWI UNIVERSITAS BATAM" );
echo "\r\n<div id='formterms' style='text-align:center;'>\r\n<form name='formterms' action='' >\r\n    <table width=600>SURAT KEPUTUSAN<br><br>
REKTOR UNIVERSITAS BATAM<br><br>
NOMOR: 050/Kep/ReklUniba/ll/2015<br><br>

TENTANG<br><br>

PERATURAN TATA TERTIB MAHASISWA<br>
 UNIVERSITAS BATAM<br><br>

REKTOR <br>
UNIVERSITAS BATAM<br><br>

Menimbang:<br>
1.	Bahwa untuk mengembangkan aktivitas dan membentuk mahasiswa intelektual yang berkualitas dan berkepribadian agamis, perlu diciptakan suasana kampus yang kondusif dan bemuansa akademik; <br>
2.	Bahwa untuk menanamkan kedisiplinan dan kejujuran menuju Universitas Batam yang berkualitas diperlukan peraturan tata tertib mahasiswa; <br>
3.	Bahwa untuk melaksanaan dan mewujudkan tujuan pada butir 1 dan 2 diatas, diperlukan Surat Keputusan Rektor <br><br>

Mengingat:<br>
1.	Undang-undang Nomor 20 Tahun 2003 Tentang Sistem Pendidikan NasionaI; <br>
2.	 Surat Keputusan Menteri Pendidikan dan Kebudayaan Republik Indonesia Nomor 155/U/1998 Tentang Organisasi Mahasiswa di Perguruan Tinggi; <br>
3.	Statuta Universitas Batam. <br><br>

Memperhatikan:<br>
1.	 Keputusan Rapat Senat Universitas Batam tanggal 27 Januari 2015; <br><br>

MEMUTUSKAN<br><br>

Menetapkan: <br><br>
KEPUTUSAN REKTOR UNIVERSITAS BATAM<br><br>

TENTANG<br><br>

PERATURAN TATA TERTIB MAHASISWA<br> 
UNIVERSITAS BATAM<br><br>

BAB l<br>
KETENTUAN UMUM<br><br>
Pasal 1<br>
Dalam peraturan ini yang dimaksud dengan: <br>
1.	Universitas Batam, selanjutnya disebut UNIBA adalah Perguruan Tinggi yang mengemban amanat menyelenggarakan pendidikan untuk membentuk manusia yang berakhlak mulia; <br>
2.	Tata tertib adalah seperangkat aturan yang mengatur kewajiban, hak, kedudukan, dan aktivitas mahasiswa; <br>
3.	Disiplin adalah segala bentuk sikap dan perilaku mahasiswa yang mematuhi ketentuan-ketentuan yang berlaku; <br>
4.	Aktivitas adalah segala kegiatan mahasiswa yang bersifat akademik dan non akademik; <br>
5.	Mahasiswa adalah seluruh peserta didik yang terdaftar di PST Uniba; <br>
6.	Kampus meliputi segala fasilitas dengan segenap lingkungan fusik dan non fusik; Sanksi adalah hukuman akademik dan atau administratif yang dijatuhkan kepada mahasiswa atas pelanggaran ketentuan dalam surat keputusan ini; <br>
7.	Pelanggaran adalah segala bentuk perbuatan yang bertentangan dengan ketentuan yang berlaku dalam surat keputusan ini; <br>
8.	Larangan adalah segala perbuatan yang tidak boleh dilakukan oleh mahasiswa; Kejahatan adalah setiap perbuatan yang dilakukan mahasiswa baik sendiri maupun bersama yang ditentukan dalam Kitab Undang-undang Hukum Pidana<br> maupun peraturan lain yang berlaku di Indonesia; <br>
9.	Keputusan yang mempunyai kekuatan hukum tetap adalah putusan yang dijatuhkan oleh hakim yang sudah tidak mempunyai upaya hukum lagi; <br>
10.	Pejabat yang bewvenang adalah pejabat yang mempunyai wewenang menjatuhkan sanksi, terdiri dari Rektor dan atau Dekan. <br><br>
BAB II<br>
ORGANISASI MAHASISWA<br><br>
Pasal 2<br>
1.	Untuk meningkatkan penalaran, minat, bakat dan kesejahteraan mahasiswa perlu dibentuk organisasi kemahasiswaan; <br>
2.	Organisasi kemahasiswaan diselenggarakan dari, oleh, dan untuk mahasiswa; <br>
3.	Organisasi kemahasiswaan yang merupakan perwakilan mahasiswa disebut Badan Eksekutif Mahasiswa (BEM) sebagai organisasi pelaksana; <br>
4.	Kegiatan keilmuan, penalaran, minat, kesenian dan kesejahteraan mahasiswa tingkat universitas secara khusus dilaksanakan oleh unit kegiatan mahasiswa; <br>
5.	Kegiatan mahasiswa tingkat fakultas ditekankan pada pengembangan keilmuan dan penalaran; <br>
6.	Kegiatan kemahasiswaan tingkat program studi dilaksanakan oleh himpunan mahasiswa program studi dikhususkan pada pengembangan profesi keilmuan; <br>
7.	 Organisasi kemahasiswaan tingkat universitas bertanggung jawab kepada Rektor dan organisasi kemahasiswaan tingkat Fakultas bertanggung jawab kepada Dekan; <br><br>

BAB Ill <br>
KEWAJlBAN DAN HAK MAHASISWA<br><br>
Pasal 3 Mahasiswa memiliki kewajiban sebagai berikut:<br> 
1.	Melakukan registrasi dan herregistrasi pada tiap awal semester dan tahun akademik sebagaimana ketentuan UNlBA;<br> 
2.	Melakukan konsultasi kepada pembimbing akademik; <br>
3.	Mengikuti perkuliahan dan menjalankan tugas-tugas sebagai mahasiswa;<br> 
4.	Mengikuti ujian sesuai dengan ketentuan yang berlaku; <br>
5.	Menyusun tugas akhir dan atau karya ilmiah sesuai dengan ketentuan yang berlaku;<br> 
6.	Melakukan yudisium semester dan yudisium akhir; <br>
7.	ikut memelihara sarana, dan prasarana di Iingkungan kampus; <br>
8.	Menjaga wibawa dan nama baik almamater; <br>
9.	Menjaga dan mengembangkan nilai-nilai budaya nasional;<br><br> 

Pasal 4<br>
Mahasiswa memiliki hak sebagai berikut:<br> 
1.	Menggunakan kebebasan akademik secara bertanggung jawab untuk menuntut dan mengkaji “mu sesuai dengan ketentuan yang berlaku; <br>
2.	Mempero|eh pembelajaran, pengajaran, bimbingan, infonnasi ilmiah, dan Iayanan sebaik-baiknya untuk kemajuan stud'mya; <br>
3.	Mengembangkan penalaran dan keiimuan, minat dan kegemaran sesuai kemampuannya; <br>
4.	Memanfaatkan fasimas yang dimiliki UNIBA dengan sebaik-baiknya sesuai ketentuan yang berlaku;<br> 
5.	Mengikuti kegiatan ekstra kurikuler sesuai ketentuan yang berlaku; <br>
6.	Pindah ke perguruan tinggi Iain, atau ke program studi Iain di UNlBA; <br>
7.	Mengaiukan cuti studi sesuai dengan ketentuan yang berlaku; <br>
8.	Melaksanakan aktivitas di dalam kampus atas izin pimpinan. <br><br>

BAB IV<br>
 SANKSI<br><br>

Pasal 5<br>
Mahasiswa yang terbukti melanggar ketentuan dikenakan sanksi sesuai dengan tingkat pelanggaran yang dilakukan. Jenis sanksi yang dapat dikenakan antara lain:<br> 
1.	Diberi teguran secara lisan atau tertulis; <br>
2.	Dikenai larangan mengikuti kuliah dan atau ujian;<br> 
3.	Dikenai sanksi tidak lulus dan atau dibatalkan mengikuti mata kuliah tertentu; <br>
4.	Tidak dapat diusulkan sebagai calon mahasiswa berprestasi, dan atau penerima beasiswa tertentu; <br>
5.	Mengganti kerugian baik dalam bentuk barang atau dalam bentuk uang dalam jumlah tertentu;<br>
6.	Dikenai skorsing atau diberhentikan sebagai mahasiswa untuk sementara, selama-lamanya 2 (dua) semester;<br> 
7.	Dikeluarkan sebagai mahasiswa. <br><br>

Pasal 6<br>
Penjatuhan sanksi sebagaimana dalam ketentuan pasal 5 tersebut dapat dilakukan secara alternatif dan atau kumulatif.<br><br> 
Pasal 7<br>
Pengulangan pelanggaran akan dikenakan sanksi setingkat lebih tinggi dan atau sanksi maksimal. <br><br>

BAB V <br>
LARANGAN<br><br>

Pasal 8<br>
Mahasiswa dilarang:<br>
1.	Mengambil milik UNIBA atau Iembaga kemahasiswaan secara tidak sah;<br>
2.	Memaksa dengan ancaman atau kekerasan baik langsung atau tidak langsung untuk mengganggu atau menggagalkan: <br>
a)	Aktivitas civitas akademika dan tamu dalam wilayah UNIBA; <br>
b)	Penggunaan fasilitas yang dikelola oleh UNIBA; <br>
c)	 Jalan masuk atau jalan keluar wilayah yang dikelola oleh UNIBA.<br> 
3.	Memaksa atau meneror pejabat, dosen, kalyawan atau sesame mahasiswa baik secara langsung maupun tidak langsung untuk tujuan tertentu;<br> 
4.	Menghasut atau membantu orang lain untuk ikut dalam suatu kegiatan yang mengganggu atau merusak fungsi dan tugas UNIBA; <br>
5.	Membawa, menyimpan atau menggunakan suatu benda atau barang yang patut disadari dan atau melakukan tindakan yang dapat membahayakan diri sendiri dan atau orang lain; <br>
6.	Tidak bersedia mempertanggung jawabkan keuangan dan kegiatan kemahasiswaaan menurut peraturan yang berlaku di UNIBA; <br>
7.	Melakukan pencemaran nama baik almamater atau melakukan perbuatan yang tidak menyenangkan civitas akademika; <br>
8.	Melakukan perbuatan yang disadari atau setidak-tidaknya diketahui sebagai perbuatan curang dan atau perbuatan tercela lainnya;<br> 
9.	Melakukan tindakan di dalam maupun di Iuar kampus yang dilarang menurut peraturan perundang-undangan yang berlaku di Indonesia; <br>
10.	Menggunakan pakaian yang disadari atau setidak-tidaknya diketahui melanggar norma-norma kesopanan, dan kesusilaan; <br>
11.	Tinggal di kampus Iayaknya indekost (tidur, menjemur pakaian, memasak, dan sebagainya); <br>
12.	Melakukan kegiatan politik praktis baik secara langsung maupun tidak langsung; <br>
13.	Melanggar ketentuan sebagaimana dalam ayat 1 s.d.12 yang dapat dikenakan sanksi secara alternatif atau kumulatif.<br><br> 

BAB VI <br>
PEMALSUAN<br><br>
Pasal 9<br>
1.	Dengan sengaja \"memalsukan surat keterangan dan atau rekomendasi dari pejabat, dosen atau karyawan untuk kepentingan pribadi dan atau orang Iain yang dapat merugikan UNIBA,<br> dikenakan sanksi skorsing selama-lamanya 2 (dua) semester\"; <br>
2.	Dengan sengaja secara langsung atau tidak langsung memalsukan, atau menyalahgunakan surat atau penjiplakan karya ilmiah atau bukti-bukti lain untuk kepentingan pribadi <br>dan atau orang Iain di dalam maupun di Iuar Iingkungan kampus dikenakan sanksi skorsing selama-lamanya 2 (dua) semester. <br><br>

Pasal 10<br>
1.	Dengan sengaja memalsukan kartu atau tanda bukti ujian untuk kepentingan pribadi dan atau orang lain guna mengikuti ujian dikenakan sanksi skorsing selama-lamanya 2 (dua) semester;<br>
2.	Dengan sengaja memalsukan tanda tangan pejabat atau dosen atau stempel yang sah berlaku di Iingkungan UNIBA untuk kepentingan pribadi dan atau orang lain dikenakan sanksi setinggi-tingginya diberhentikan sebagai mahasiswa; <br>
3.	Dengan sengaja merubah atau mengganti mata kuliah yang ditempuh sebagian atau seluruhnya, dikenakan sanksi pembatalan seluruh mata kuliah tersebut atau, skorsing 1 (satu) semester; <br>
4.	Dengan sengaja melakukan atau beken‘a sama dengan orang lain untuk membah sebagian atau seturuh transkrip nilai atau bukti catatan nilai sehingga berbeda dengan aslinya dikenakan sanksi pembatatan <br>seluruh niIai mata kuliah yang bersangkutan dan atau sanksi setinggi-tingginya diberhentikan sebagai mahasiswa. <br><br>

Pasal 11<br>
1.	Dengan sengaja meminta atau menyuruh orang Iain menggantikan kedudukannya sebagai peserta ujian dengan memalsukan seluruh atau sebagian dari bukti-bukti sebagai peserta ujian, dikenakan sanksi pembatalan <br>hasil ujian mata kulian pada semester itu dan atau sanksi skorsing selama-Iamanya 2 (dua) semester; <br>
2.	Dengan sengaja bertindak selaku pengganti (Joki) dalam ujian dari seseorang mahasiswa atau calon mahasiswa baik di dalam maupun di luar UNIBA dikenakan sanksi skorsing selama-Iamanya 2 (dua) semester;<br> <br>

BAB VII <br>
PENCURIAN DAN PERUSAKAN<br><br>

Pasal 12<br>
1.	Setiap mahasiswa yang terlibat langsung atau tidak langsung mencuri atau merampas harta benda milik UNIBA atau milik orang lain di dalam atau di luar kampus <br>dikenakan sanksi setinggi-tingginya diberhentikan sebagai mahasiswa dan atau mengganti barang yang dicuri atau mengganti dengan uang senilai barang yang dicuri; <br>
2.	Setiap mahasiswa yang terlibat langsung atau tidak langsung merusak atau menghancurkan hatta benda milik UNIBA atau milik orang Iain di dalam atau di luar kampus sehingga benda itu menjadi rusak. atau tidak bertungsi lagi<br> dtkonakan sanksi setinggi-tingginya diberhentikan sebagai mahasiswa dan atau mengganti barang yang dirusak atau mengganti dengan uang senilai barang yang dirusak. <br><br>

BAB VIII <br>
PEMERASAN DAN PENGANCAMAN<br><br>

Pasal 13<br>
1.	Setiap mahasiswa yang langsung atau tidak langsung memeras atau mongancam sesama mahasiswa atau orang Iain d1 IIngkungan atau dt luar kampus. dikenakan sanksi skorsing selama 1 (satu) semester; <br>
2.	Setiap mahasiswa yang memeras dan atau mengancam pejabat, dosen dan atau karyawan di dalam atau di luar kampus dikenakan sanksi selama-Iamanya 2 (dua) semester. <br><br>

BAB IX<br>
PENGANIAYAAN DAN PERKELAHIAN<br>

Pasal 14<br>
1.	Setiap mahasiswa yang menganiaya sesama mahasiswa atau orang Iain baik di dalam maupun di Iuar kampus dikenakan sanksi skorsing selama-Iamanya 2 (due) semester; <br>
2.	Setiap mahasiswa yang menganiaya pejabat, dosen dan atau karyawan di dalam maupun di Iuar kampus, dikenakan sanksi skorsing 2 (dua) semester atau setinggi-tingginya diberhentikan sebagai mahasiswa. <br>
3.	Setiap mahasiswa yang menganiaya sebagaimana diatur ayat 1 dan 2 yang mengakibatkan cacat, atau meninggal dunia, dikenakan sanksi diberhentikan sebagai mahasiswa dan atau memberi biaya pengobatan atau memberi santunan. <br><br>

Pasal 15<br>
1.	Setiap mahasiswa yang tertibat perkelahian di dalam kampus, dikenakan sanksi skorsing 1 (satu) semester;<br>
2.	Setiap mahasiswa yang terlibat perkelahian sebagaimana ayat 1, yang berakibat cacat atau mati dikenakan sanksi diberhentikan sebagai mahasiswa. <br><br>

BAB X<br>
MINUMAN KERAS, NARKOTIKA, DAN<br>
OBAT TERLARANG<br><br>

Pasal 16<br>
1.	Setiap mahasiswa yang memproduksi. menyimpan, membawa, mengedarkan, mengkonsumsi dan memiliki minuman keras, dikenakan sanksi skorsing 2 (dua) semester; <br>
2.	Setiap mahasiswa yang memproduksi, menyimpan. membawa. mengedarkan, mengkonsumsi dan memiliki narkoba. dikenakan sanksi diberhentikan sebagai mahasiswa. <br><br>

Pasal 17<br>
1.	Setiap mahasiswa yang bermabuk-mabukan di dalam kampus dikenakan sanksi skorsing 1 (satu) semester;<br> 
2.	Setiap mahasiswa yang bermabuk-mabukan dan mengakibatkan terganggunya proses: belajar mengajar atau mengakibatkan kerusakan atau mengakibatkan <br>
	penderitaan bagi orang Iain dikenakan sanksi setinggi-tingginya diberhentikan sebagai mahasiswa. <br><br>

BAB XI<br>
 PERBUATAN ASUSILA<br><br>

Pasal 18<br>
Setiap mahasiswa:<br> 
1.	Mengucapkan atau menulis kata-kata tidak senonoh di lingkungan kampus yang bertentangan dengan nilai kepatutan dan syariat Islam, dikenakan sanksi skorsing 1 (satu) semester;<br>
2.	 Melakukan perbuatan cabul atau pelecehan seksual di lingkungan kampus yang bertentangan dengan nilai kepatutan, dikenakan sanksi skorsing 2 (dua) semester, <br>
3.	Melakukan perbuatan zina di lingkungan kampus, dikenakan sanksi diberhentikan sebagai mahasiswa; <br>
4.	Melakukan perkosaan baik terlibat Iangsung atau tidak langsung terlibat di dalam atau di luar lingkungan kampus, dikenakan sanksi setinggi-tingginya diberhentikan sebagai mahasiswa; <br>
5.	 Memproduksi, menyimpan, menyebarkan dan mempertontonkan gambar, tulisan, barang, yang bersifat pornografi dan atau yang menjurus rasa kesusilaan, dikenakan sanksi skorsing 1 (satu) semester; <br>
6.	Mengadakan, mengikuti atau berperan serta dalam kegiatan perjudian dalam bentuk apapun di dalam kampus, dikenakan sanksi skorsing 2 (dua) semester dan atau setinggi-tingginya diberhentikan sebagai mahasiswa; <br><br>

BAB XII<br> 
PENGHINAAN DAN PENCEMARAN NAMA BAIK<br><br>

Pasal 19<br>
1.	Setiap mahasiswa yang menghina dan atau mencemarkan nama baik sesama mahasiswa di dalam kampus dikenakan sanksi skorsing 1 (satu) semester; <br>
2.	 Setiap mahasiswa yang menghina dan atau mencemarkan nama baik pejabat, dosen, karyawan dan atau orang Iain di dalam kampus, dikenakan sanksi skorsing setinggi-tingginya 2 (dua) semester,<br>
3.	Tindakan sebagaimana tersebut ayat 1 den 2 adalah pelanggaran aduan. <br>

BAB XIII<br> 
ETIKA KEPRIBADIAN<br><br>

Pasal 20<br>
1.	Dalam rangka menertibkan cara berpenampilan di kalangan mahasiswa yang sesuai dengan citra, misi dan visi UNlBA, maka mahasiswa unluk mengikuti kegiatan proses belajar mengajar <br>baik di dalam maupun di luar kampus harus mematuhi ketentuan etika kepribadian; <br>
2.	Untuk mahasiswa laki-laki, mengatur rambutnya dengan rapi, tidak bertato, tidak mengenakan perhiasan (asesoris) sebagaimana dikenakan perempuan; tidak mengenakan sandal,<br> kaos oblong. dan atau pakaian yang kurang pantas dan tidak menutup aurat; <br>
3.	Untuk mahasiswa perempuan, dalam berpakaian menutup aurat dan cukup longgar, tidak transparan; tidak memakai make up dan perhiasan (asesoris) yang berlebihan, tidak memakai anting-anting atau giwang <br>atau sejenisnya di bagian hidung, bibir, dan atau pada bagian tubuh manapun selain pada bagian telinga; tidak mengenakan sandal, kaos oblong dan atau pakaian kurang pantas; <br>
4.	Barangsiapa melanggar ketentuan sebagaimana yang diatur dalam ayat (1), (2) dan (3) akan dikenakan sanksi: <br>
a.	Teguran secara Iisan, atau <br>
b.	Peringatan keras secara lisan, atau <br>
c.	Peringatan keras secara terlulis, atau <br>
d.	Tidak diperbolehkan mengikuti kuliah, ujian, konsultasi, praktikum dan melakukan kegiatan administrasi di kantor. <br><br>

BAB XIV <br>
TATA CARA DAN PROSEDUR PENJATUHAN SANKSI<br><br>

Pasal 21<br>
1.	Pencarian fakta, pemeriksaan, pembuktian dan pembuatan Berita Acara Pemeriksaan tentang adanya pelanggaran dan atau kejahatan oleh mahasiswa dilakukan oleh Tim Disiplin yang terdiri dari Rektor, Wakil Rektor,<br> Dekan dan Ketua Program Sltudi di lingkungan Universitas Batam; <br>
2.	Untuk kepentingan pemeriksaan dan pembuatan Berita Acara Pemeriksaan, Tim Disiplin berhak memanggil alau menghadirkan tersangka atau saksi melalui surat sebanyak-banyaknya 2 (dua) kali;<br>
3.	Pemanggilan tersangka diperlukan selain untuk memberikan keterangan juga pembelaan; <br>
4.	Apabila setelah dipanggil dengan surat resmi sebanyak maksimal dua kali dan selambat-lambatnya 7 (tujuh) huri sejak tanggal pengiriman surat panggilan terakhir tidak hadir dan tidak mangajukan pembelaan,<br> maka hak pembelaannya gugur dan pemeriksaan dapat dilanjutkan. <br>
5.	Hasil pemeriksaan yang tersusun dalam Berita Acara Perneriksaan besena rekornendasi sanksi diajukan kepada pejabat yang bewvenang; <br><br>

BAB XV<br>
HAK PEMBELAAN MAHASISWA.<br><br>

Pasal 22<br>
1.	Mahasiswa yang menjadi tersangka berhak mengajukan pembelaan kepada Tim Disiplin;<br>
2.	Pembelaan sebagaimana dimaksudkan dalam ayat (1) di atas diajukan sendiri baik lisan maupun tertulis; <br>
3.	Sebelum mengajukan pembelaan tersangka dapat berkonsultasi dengan Iembaga bantuan hukum atau sejenisnya sebelum masa waktu pembelaan berakhir; <br>
4.	Mahasiswa yang karena tindakannya berada dalam tahanan Kepolisian, atau Kejaksaan, atau Pengadilan, Tim Disiplin cukup mengecek kebenaran penahanan dan tuduhan atasnya,<br> dan mahasiswa bersangkutan kehilangan hak seperti diatur dalam pasal ini; <br><br>

BAB XV1<br>
PENJATUHAN SANKSI<br><br>

Pasal 23<br>
1.	Dasar penjatuhan sanksi oleh pejabat yang berwenang adalah bukti dalam BAP beserta rekomendasi sanksi yang diajukan oleh Tim Disipln; <br>
2.	Jenis sanksi yang dapat dijatuhkan adalah jenis sanksi sebagaimana yang diatur dalam pasal 5 peraturan ini; <br>
3.	Sanksi yang dijatuhkan pengadilan terhadap mahasiswa yang karena aktivitas politiknya tidak dengan sendirinya berakibat dijatuhkan sanksi oleh UNIBA. <br><br>

BAB XVII<br>
PUTUSAN<br><br>

Pasal 24<br>
1.	Sanksi yang telah dijatuhkan pihak yang berwenang dituangkan dalam Surat Keputusan; <br>
2.	Surat Keputusan sekurang-kurangnya memuat tentang: <br>
a.	Identitas lengkap: nama, umur, fakultas atau program studi, nomor mahasiswa, jenis kelamin, aiamat; <br>
b.	Pertimbangan atau konsideran secara lengkap mengenai fakta dan alat bukti‘ pasal-pasal yang dilanggar, isi putusan, hari. tanggal, nama dan tanda tangan pejabat yang berwenang menjatuhkan sanksi; <br><br>

BAB XVIII<br>
KETENTUAN PERALIHAN DAN PENUTUP<br><br>

Pasal 25<br>
1.	Temadap kasus yang ada dan telah diputuskan sebelum peraturan Ini ditetapkan,masih tetap berIaku; <br>
2.	Segala peraturan yang ada dan tidak bertentangan dengan peraturan tata tenib mahasiswaini masihtetap berIaku;<br>
3.	Sanksi skorsing yang dijatuhkan sama dengan cuti akademik tanpa ijin; <br>
4.	Mahasiswa yang tidak mempertanggungjawabkan aktiwtas lembaga kemahasiswaan atauterlibat Iangsung atau tidak langsung dengan penyaIahgunaan keuangan lembaga Kemahasiswaan baik yang bersumber dari UNIBA<br> atau sumber Iain dikenakan sanksi penahanan ijazah sampai yang bersangkutan menyeIesaIkan pertanggungjawabannya dan atau dilaporkan kepada pihak yang berwajib; <br><br>

Pasal 26<br>
1.	Surat Keputusan Rektor ini berlaku sejak tanggal ditetapkan; <br>
2.	 Keputusan Ini akan ditinjau kembali jika terdapat kekeliruan. <br><br>

</td>\r\n                ";

echo " </tr>\r\n      <tr>\r\n        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>\r\n        <td>\r\n   <input type=submit name=submit class=button id=submit_btn  value='Setuju dengan Syarat dan Ketentuan diatas'>\r\n        </td>\r\n      </tr>    \r\n    </table>\r\n    \r\n</form>\r\n</div>\r\n";
?>
