<?php
// Zadanie 11. Tablica i foreach
$technologie = ["HTML", "CSS", "JavaScript", "PHP", "MySQL"];

echo "<ul>\n";
foreach ($technologie as $tech) {
    echo "  <li>" . htmlspecialchars($tech) . "</li>\n";
}
echo "</ul>\n";


// Zadanie 12. Tablice asocjacyjne
$produkty = [
    ["id" => 1, "nazwa" => "Myszka", "cena" => 49.99, "dostepny" => true],
    ["id" => 2, "nazwa" => "Klawiatura", "cena" => 120.50, "dostepny" => false],
    ["id" => 3, "nazwa" => "Monitor", "cena" => 899.00, "dostepny" => true],
    ["id" => 4, "nazwa" => "Słuchawki", "cena" => 150.00, "dostepny" => true]
];

foreach ($produkty as $produkt) {
    $status = $produkt['dostepny'] ? "Dostępny" : "Niedostępny";
    $cenaFormatowana = number_format($produkt['cena'], 2, ',', ' ');
    
    echo "ID: " . $produkt['id'] 
        . " | Nazwa: " . htmlspecialchars($produkt['nazwa']) 
        . " | Cena: " . $cenaFormatowana . " zł" 
        . " | Status: " . $status . "<br>\n";
}


// Zadanie 13. Filtrowanie w PHP
$dostepneProdukty = array_filter($produkty, function($p) {
    return $p['dostepny'] === true;
});

$liczbaDostepnych = count($dostepneProdukty);
echo "<p>Liczba dostępnych produktów: " . $liczbaDostepnych . "</p>\n";


// Zadanie 14. Formularz POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nazwa_zadania"])) {
    $nazwaZadania = trim($_POST["nazwa_zadania"]);

    if (!empty($nazwaZadania)) {
        echo "<p>Dodano zadanie: " . htmlspecialchars($nazwaZadania) . "</p>\n";
    } else {
        echo "<p>Nazwa zadania nie może być pusta!</p>\n";
    }
}


// Zadanie 15. Sesja
session_start();

// Obsługa sytuacji, gdy zapis jeszcze nie istnieje w sesji
if (!isset($_SESSION['zadania'])) {
    $_SESSION['zadania'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nowe_zadanie"])) {
    $tekst = trim($_POST["nowe_zadanie"]);
    if (!empty($tekst)) {
        $_SESSION['zadania'][] = $tekst;
    }
}


// Zadanie 16. JSON
// Uwaga: Poniższe nagłówki i json_encode powinny znajdować się w osobnym pliku API (np. api.php)
header('Content-Type: application/json; charset=utf-8');

$daneDojoSON = [
    "status" => "success",
    "data" => $produkty
];

echo json_encode($daneDojoSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>