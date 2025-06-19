<?php
/**
 * Skripta spaja na MySQL, kreira tablicu i ubacuje 100 redaka
 * s nasumičnim stringom (10 znakova) i nasumičnim deseteroznamenkastim brojem.
 *
 * Prije pokretanja prilagodite postavke pristupa bazi (server, korisnik, lozinka, baza).
 */

$servername = "localhost";   // adresa MySQL servera
$username   = "user";        // korisničko ime
$password   = "password";    // lozinka
$dbname     = "baza";     // naziv baze

// 1) Povezivanje na MySQL bazu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Greška pri spajanju: " . $conn->connect_error);
}


// 3) Kreiranje tablice (ako ne postoji)
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS sample_data (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` CHAR(10) NOT NULL,
    `value` BIGINT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($sqlCreateTable)) {
    die("Greška pri kreiranju tablice: " . $conn->error);
}

// 4) Priprema INSERT upita
$stmt = $conn->prepare("INSERT INTO sample_data (`name`, `value`) VALUES (?, ?)");
if (!$stmt) {
    die("Greška pri pripremi INSERT-a: " . $conn->error);
}

$stmt->bind_param("si", $name, $value);

// Funkcija za generiranje nasumičnog stringa zadane duljine
function random_string($length = 10) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return substr(str_shuffle(str_repeat($chars, (int)ceil($length / strlen($chars)))), 0, $length);
}

// 5) Ubacivanje 100 nasumičnih redaka
for ($i = 0; $i < 100; $i++) {
    $name  = random_string(10);                          // slučajni string od 10 znakova
    $value = random_int(1000000000, 9999999999);         // slučajni 10-znamenkasti broj

    if (!$stmt->execute()) {
        echo "Greška pri ubacivanju retka $i: " . $stmt->error . "\n";
    }
}

echo "Uspješno ubačeno 100 nasumičnih redaka!";

// 6) Zatvaranje resursa
$stmt->close();
$conn->close();
?>
