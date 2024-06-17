<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "Isi Buku Tamu" )
{
    $mesg = "Maaf, Anda belum memasukkan Nama. \r\n\t\tNama harus diisi";
    if ( trim( $teleponb ) != "" && !isangka( $teleponb ) )
    {
        $mesg = "Maaf, Telepon harus diisi dengan format bilangan biasa.  \r\n\t\tContoh: 0222500514";
    }
    else if ( trim( $hpb ) != "" && !isangka( $hpb ) )
    {
        $mesg = "Maaf, HP harus diisi dengan format bilangan biasa.  \r\n\t\tContoh: 08156210995";
    }
    else if ( trim( $emailb ) != "" && !isemail( $emailb ) )
    {
        $mesg = "Maaf, Email harus diisi dengan format abc@namaserver.cde.  \r\n\t\tContoh: riki@suteki-tech.com";
    }
    else if ( trim( $tujuanb ) == "" )
    {
        $mesg = "Maaf, Anda belum memasukkan Tujuan. \r\n\t\tKomentar harus diisi";
    }
    else if ( trim( $komentarb ) == "" )
    {
        $mesg = "Maaf, Anda belum memasukkan Kesan / Pesan. \r\n\t\tKomentar harus diisi";
    }
    else
    {
        $h = mysql_query( "SELECT MAX(ID) AS JML FROM bukutamu", $koneksi );
        $d = sqlfetcharray( $h );
        $idbaru = $d[JML] + 1;
        $hpb = htmlspecialchars( $hpb );
        $namab = htmlspecialchars( $namab );
        $alamatb = htmlspecialchars( $alamatb );
        $teleponb = htmlspecialchars( $teleponb );
        $emailb = htmlspecialchars( $emailb );
        $tujuanb = htmlspecialchars( $tujuanb );
        $instansib = htmlspecialchars( $instansib );
        $komentarb = htmlspecialchars( $komentarb );
        $q = "INSERT INTO bukutamu VALUES('{$idbaru}',NOW(), '{$namab}',\r\n\t\t'{$alamatb}','{$teleponb}','{$hpb}','{$emailb}','{$instansib}','{$tujuanb}','{$komentarb}')";
        mysql_query( $q, $koneksi );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $mesg = "Terima kasih telah mengisi buku tamu";
            $hpb = $namab = $alamatb = $teleponb = $emailb = $tujuanb = $instansib = $komentarb = "";
        }
        else
        {
            $mesg = "Buku tamu gagal diisi";
        }
    }
    $aksi = "";
}
if ( $aksi == "lihat" )
{
    printjudulmenu( "Lihat Buku Tamu" );
    printmesg( $mesg );
    if ( $sort == "" )
    {
        $sort = "TANGGAL DESC";
    }
    if ( $hal == "" )
    {
        $hal = 1;
    }
    $q = "SELECT COUNT(ID) AS JML\r\n\tFROM bukutamu ";
    $h = mysql_query( $q, $koneksi );
    $d = sqlfetcharray( $h );
    $jml = $d[JML];
    $lastpage = floor( $jml / $maxdata );
    if ( 0 < $jml % $maxdata )
    {
        ++$lastpage;
    }
    settype( $lastpage, "integer" );
    $first = $maxdata * ( $hal - 1 );
    $limit = "LIMIT {$first},{$maxdata}";
    if ( 1 < $hal && 1 < $lastpage )
    {
        $prev = "<a href='index.php?aksi={$aksi}&pilihan={$pilihan}&sort={$sort}&hal=".( $hal - 1 )."'><< sebelumnya</a>";
    }
    if ( $hal < $lastpage && 1 < $lastpage )
    {
        $next = "<a href='index.php?aksi={$aksi}&pilihan={$pilihan}&sort={$sort}&hal=".( $hal + 1 )."'>berikutnya >></a>";
    }
    $navigasi = "\r\n\t<table class=form>\r\n\t\t<tr>\r\n\t\t\t<td align=left>\r\n\t\t\t\t{$prev}\r\n\t\t\t</td>\r\n\t\t\t<td align=center>\r\n\t\t\t</td>\r\n\t\t\t<td  >\r\n\t\t\t{$next}\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>";
    $q = "SELECT *\r\n\tFROM bukutamu \r\n\tWHERE 1=1\r\n\t\r\n\t{$where} \r\n\t{$qtanggal}\r\n\tORDER \r\n\tBY {$sort}\r\n\t{$limit}";
    $h = mysql_query( $q, $koneksi );
    if ( 0 < sqlnumrows( $h ) )
    {
        $href = "index.php?aksi={$aksi}&pilihan={$pilihan}&\r\n\t\t";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $sl = "";
            ++$i;
            echo "\r\n\t\t<p>\r\n\t\t<table class=data>\r\n\t\t\t<tr  {$kelas}>\r\n \t\t\t\t<td width=80  align=right><b>Tanggal</td>\r\n \t\t\t\t\t\t<td  >{$d['TANGGAL']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr   {$kelas}>\r\n \t\t\t\t<td    align=right><b>Nama</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</a></td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td    align=right><b>Alamat</td>\r\n\t\t\t\t\t\t<td>{$d['ALAMAT']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td  {$kelas} align=right><b>Telepon</td>\r\n\t\t\t\t\t\t<td>{$d['TELEPON']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td  {$kelas} align=right><b>HP</td>\r\n\t\t\t\t\t\t<td>{$d['HP']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td  {$kelas} align=right><b>Email</td>\r\n\t\t\t\t\t\t<td><a class=latarputih href='mailto:{$d['EMAIL']}'>{$d['EMAIL']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td   {$kelas} align=right><b>Instansi</td>\r\n\t\t\t\t\t\t<td>{$d['INSTANSI']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td   {$kelas} align=right><b>Tujuan</td>\r\n\t\t\t\t\t\t<td>{$d['TUJUAN']}</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr    {$kelas}>\r\n\t\t\t\t<td   {$kelas} align=right><b>Kesan / Pesan</td>\r\n\t\t\t\t\t\t<td>{$d['KOMENTAR']}</td>\r\n \t\t\t</tr>\r\n \t\t</table>\r\n \t\t</p>";
        }
        echo "{$navigasi}";
    }
    else
    {
        printmesg( "Data Buku Tamu  tidak ada" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "Isi Buku Tamu" );
    printmesg( $mesg );
    echo "\r\n\r\n\t\t\t<form name=form ENCTYPE=\"MULTIPART/FORM-DATA\" action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=idupdate value='{$idupdate}'>\r\n\t\t\t<table  class=data>\r\n <tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tNama\r\n\t</td>\r\n\t<td>\r\n\t\t<input class=masukan type=text size=45 name=namab value='{$namab}'>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tAlamat\r\n\t</td>\r\n\t<td>\r\n\t\t<textarea class=masukan cols=50 rows=5 name=alamatb>{$alamatb}</textarea>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tTelepon\r\n\t</td>\r\n\t<td>\r\n\t\t<input class=masukan type=text size=20 name=teleponb value='{$teleponb}'>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tHP\r\n\t</td>\r\n\t<td>\r\n\t\t<input class=masukan type=text size=20 name=hpb value='{$hpb}'>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tEmail\r\n\t</td>\r\n\t<td>\r\n\t\t<input class=masukan type=text size=20 name=emailb value='{$emailb}'>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tInstansi\r\n\t</td>\r\n\t<td>\r\n\t\t<input class=masukan type=text size=45 name=instansib value='{$instansib}'>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tTujuan Kunjungan\r\n\t</td>\r\n\t<td>\r\n\t\t<textarea class=masukan cols=50 rows=5 name=tujuanb>{$tujuanb}</textarea>\r\n\t</td>\r\n</tr>\r\n<tr class=datagenap>\r\n\t<td    class=isianjudul>\r\n\t\tKesan / Pesan\r\n\t</td>\r\n\t<td>\r\n\t\t<textarea class=masukan cols=50 rows=5 name=komentarb>{$komentarb}</textarea>\r\n\t</td>\r\n</tr>\r\n</table>\r\n<br>\r\n\t\t<input class=tombol type=submit name=aksi value='Isi Buku Tamu'>\r\n\t\t<input class=tombol type=reset>\r\n\t\t\t</form>\r\n\t\t\t";
}
?>
