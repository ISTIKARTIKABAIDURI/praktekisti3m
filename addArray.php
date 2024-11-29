<?php

$hari = ["senin", "selasa"];

print_r($hari);
echo "</br>";
$hari[] = "rabu"; //menambah elemen pada urutan terakhir array
print_r($hari);
echo"</br>";
$hari[3] = "kamis"; //menambah elemen pada index yang kita tentukan.
                    //jika index sudah terisi, maka elemen lama akan
                    //diganti dengan elemen baru.
print_r($hari);

?>