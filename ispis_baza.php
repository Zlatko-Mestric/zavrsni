<?php
/**
 * list_data.php
 *
 * Skripta se spaja na MySQL bazu, dohvaća sve retke iz tablice `sample_data`
 * i ispisuje ih u preglednoj HTML tablici.
 *
 * Prilagodite pristupne podatke prije pokretanja.
 */

$servername = "localhost";   // adresa MySQL servera
$username   = "user";        // korisničko ime
$password   = "password";    // lozinka
$dbname     = "baza";     // naziv baze

// 1) Povezivanje na MySQL server i bazu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Greška pri spajanju: " . $conn->connect_error);
}

// 2) Izvrši SELECT upit
$sql  = "SELECT id, `name`, `value` FROM sample_data ORDER BY id";
$result = $conn->query($sql);
if (!$result) {
    die("Greška pri dohvaćanju podataka: " . $conn->error);
}

// 3) Generiranje HTML izlaza
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Popis podataka</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #fafafa; }
    </style>
</head>
<body>
    <h1>Podaci iz sample_data</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv (random string)</th>
                <th>Vrijednost (10-znamenkasti broj)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id'],    ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['name'],  ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['value'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p>Ukupno redaka: <?= $result->num_rows; ?></p>
</body>
</html>
<?php
// 4) Zatvaranje resursa
$result->free();
$conn->close();
?>
