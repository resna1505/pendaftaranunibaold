<?php
echo ";\nvar detik = "echo ";\nvar jamku = "echo ";\n\nvar n = new Date();\n//var lmenit = n.getMinutes();\nvar ldetik = n.getSeconds();\n//var ljam = n.getHours();\n\n\nfunction stopclock (){\n        if(timerRunning)\n                clearTimeout(timerID);\n        timerRunning = false;\n}\n\n\nfunction showtime () {\n        var now = new Date();\n//        var hours = now.getHours();\n //       var minutes = now.getMinutes();\n        var sec"echo "onds = now.getSeconds();\n\n			if (((seconds > ldetik) && (seconds!=0))||(seconds==0 && ldetik==59)) {\n				if (detik < 59) {\n					detik++;\n				} else {\n					detik=0;\n					if (menit < 59) {\n						menit ++;\n					} else {\n						menit=0;\n						if (jamku < 23)  {\n							jamku++;\n						} else {\n							jamku=0;\n						}\n					}\n				}\n				\n			}\n			ldetik=seconds;\n\n        var timeValue ;\n "echo "       timeValue = ((jamku < 10) ? "0" : "") + jamku;\n        timeValue += ((menit < 10) ? ":0" : ":") + menit;
echo "  <div id='utility'> ";
if ($jenisusers==0) {
   echo "[Obfuscated]0D 0A 20 20 3C 61 20 68 72 65 66 3D 27 ".$root."index.php?pilihan=berita'>Informasi</a> | \n  <a href='".$root."index.php?pilihan=forum'>Forum</a> | \n  <!-- <a href='".$root."pesan/index.php'>Pesan</a> -->\n  ";
}
echo "[Obfuscated]0D 0A 20 20 3C 2F 64 69 76 3E ";
Return (1);
?>

