<?php
$suma = 0;
for ($i = 0; $i < 10000; $i++) {
    $suma += rand(0, 100);
}
echo "Suma = $suma";
?>
