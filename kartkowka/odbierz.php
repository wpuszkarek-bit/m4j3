<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imie = htmlspecialchars($_POST['name'] ?? '');
    $wiadomosc = htmlspecialchars($_POST['message'] ?? '');

if (!empty($imie)) {
    echo "<h2>Witaj, $imie!</h2>";
    echo "<p>Otrzymaliśmy Twoją wiadomość: <em>$wiadomosc</em></p>";
} else {
    echo "<p>Błąd: Nie wprowadzono imienia.</p>";
}
}
?>