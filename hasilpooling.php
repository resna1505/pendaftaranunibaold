<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "header.php" );
printhtml( );
echo "<center>";
if ( trim( $aksi ) == "Hasil" )
{
    $q = "SELECT COUNT(ID) AS HASIL FROM user WHERE ID!='superadmin' AND HASILPOOLING IS NOT NULL";
    $hasil = mysqli_query($koneksi,$q);
    $data = sqlfetcharray( $hasil );
    $total = $data[HASIL];
    if ( $total <= 0 )
    {
        printmesg( "Belum ada yang melakukan pemilihan terhadap jajak pendapat" );
    }
    else
    {
        $q = "SELECT PERTANYAAN,JENIS FROM pooling";
        $hasil = mysqli_query($koneksi,$q);
        $data = sqlfetcharray( $hasil );
        $pertanyaan = $data[PERTANYAAN];
        $jenispolling = $data[JENIS];
        $q = "SELECT ID,JAWABAN FROM jawabanpooling";
        $hasil = mysqli_query($koneksi,$q);
        while ( $data = sqlfetcharray( $hasil ) )
        {
            $q = "SELECT COUNT(HASILPOOLING) AS HASIL FROM user WHERE HASILPOOLING={$data['ID']} AND ID!='superadmin'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $hasiljawaban[$data[ID]] = $d[HASIL];
            $daftarjawaban[$data[ID]] = $data[JAWABAN];
        }
        printmesg( "Berikut ini adalah hasil sementara dari jajak pendapat dengan pertanyaan" );
        printmesg( "<b>{$pertanyaan}</b>" );
        echo " \r\n\t\t\t<table bgcolor=#eeeeff width=400 border=1 \r\n\t\t\t\tstyle='border-collapse:collapse;'>\r\n\t\t\t<tr valign=middle>\r\n\t\t\t<td align=center>\r\n\t\t\t\r\n\t\t\t<table   >\r\n\t\t\t<tr height=250 valign=bottom align=center>";
        $h = 0;
        settype( $h, "integer" );
        $c = "A";
        $ii = 0;
        $cc[$ii] = $c;
        foreach ( $daftarjawaban as $k => $v )
        {
            $hasil = $hasiljawaban[$k];
            $h = 250 * $hasiljawaban[$k] / $total;
            $persen = number_format_sikad( 100 * $hasil / $total, 1, 15, "." );
            settype( $h, "integer" );
            echo "\r\n\t\t\t\t<td width=50>\r\n\t\t\t\t\t<font style='font-size:8pt'><b>{$hasil}<br>({$persen}%)<b></font><br>\r\n\t\t\t\t\t";
            if ( 0 < $hasil )
            {
                echo "\r\n\t\t\t\t\t<table \r\n\t\t\t\t\t\tborder=1 \r\n\t\t\t\t\t\tstyle='border-collapse:collapse;'\r\n\t\t\t\t\t\tbgcolor=#000ff width=100%>\r\n\t\t\t\t\t\t<tr height={$h}>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t  &nbsp;\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
            }
            echo "\r\n\t\t\t\t\t<font style='font-size:11pt'><b> {$c}</b></font>\r\n\t\t\t\t</td>";
            $h = 0;
            $cc[$k] = $c;
            ++$c;
            ++$ii;
        }
        echo "\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\tTotal Responden: {$total}\r\n\t\t\t\r\n\t\t\t<br><br>\r\n\t\t\t\r\n\t\t\tKeterangan:<br>\r\n\t\t\t<table ><tr>\r\n\t\t\t";
        $c = "A";
        foreach ( $daftarjawaban as $k => $v )
        {
            echo "\r\n\t\t\t\t\r\n\t\t\t\t<td align=left>\r\n\t\t\t\t<b>{$c}</b>: {$v} \r\n\t\t\t\t</td>";
            ++$c;
        }
        echo "</tr></table> ";
        if ( $jenispolling == 1 )
        {
            $q = "SELECT ID,NAMA,HASILPOOLING FROM user \r\n\t\t\t\tWHERE ID!='superadmin' \r\n\t\t\t\tAND HASILPOOLING IS NOT NULL\r\n\t\t\t\tORDER BY ID";
            $hasil = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hasil ) )
            {
                echo "\r\n\t\t\t\t\t<p><table class=data>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>ID</td>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>Pilihan</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                $i = 0;
                while ( $data = sqlfetcharray( $hasil ) )
                {
                    ++$i;
                    $kelas = kelas( $i );
                    echo "\r\n\t\t\t\t\t\t\t<tr  {$kelas}>\r\n\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t<td>{$data['ID']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$data['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".$cc[$data[HASILPOOLING]]."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                }
            }
        }
        echo "\r\n</td></tr></table>\r\n";
    }
}
echo "<bR>\r\n<input class=tombol type=button value='Tutup halaman ini' onClick='window.close();'>\r\n</center>\r\n";
?>
