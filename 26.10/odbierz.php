<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podsumowanie formularza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $imie = trim($_POST["imie"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $telefon = trim($_POST["telefon"] ?? "");
            $haslo = $_POST["haslo"] ?? "";
            $data_kontaktu = $_POST["data_kontaktu"] ?? "";
            $temat = $_POST["temat"] ?? "";
            $wiadomosc = trim($_POST["wiadomosc"] ?? "");
            $zgoda = $_POST["zgoda"] ?? "";

            $errors = [];

            // Walidacja pól wymaganych w PHP
            if (empty($imie) || strlen($imie) < 2) {
                $errors[] = "Pole 'Imię' jest wymagane i musi mieć min. 2 znaki.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Pole 'E-mail' jest wymagane i musi zawierać poprawny adres.";
            }

            if (!empty($telefon) && !preg_match("/^[0-9]{9}$/", $telefon)) {
                $errors[] = "Numer telefonu musi zawierać dokładnie 9 cyfr.";
            }

            if (empty($haslo) || strlen($haslo) < 6) {
                $errors[] = "Pole 'Hasło' jest wymagane i musi mieć min. 6 znaków.";
            }

            if (empty($data_kontaktu)) {
                $errors[] = "Pole 'Data kontaktu' jest wymagane.";
            }

            if (empty($wiadomosc)) {
                $errors[] = "Pole 'Wiadomość' jest wymagane.";
            }

            if ($zgoda !== "tak") {
                $errors[] = "Akceptacja regulaminu jest wymagana.";
            }

            // Wyświetlenie wyniku
            if (empty($errors)) {
                $safeImie = htmlspecialchars($imie, ENT_QUOTES, "UTF-8");
                $safeEmail = htmlspecialchars($email, ENT_QUOTES, "UTF-8");
                $safeTelefon = htmlspecialchars($telefon, ENT_QUOTES, "UTF-8");
                $safeData = htmlspecialchars($data_kontaktu, ENT_QUOTES, "UTF-8");
                $safeTemat = htmlspecialchars($temat, ENT_QUOTES, "UTF-8");
                $safeWiadomosc = htmlspecialchars($wiadomosc, ENT_QUOTES, "UTF-8");

                echo "<h2>Dziękujemy! Formularz przesłany pomyślnie.</h2>";
                echo "<table class='data-table'>";
                echo "<tr><th>Imię</th><td>{$safeImie}</td></tr>";
                echo "<tr><th>E-mail</th><td>{$safeEmail}</td></tr>";
                echo "<tr><th>Telefon</th><td>" . ($safeTelefon ?: "<em>brak</em>") . "</td></tr>";
                echo "<tr><th>Data kontaktu</th><td>{$safeData}</td></tr>";
                echo "<tr><th>Temat</th><td>{$safeTemat}</td></tr>";
                echo "<tr><th>Wiadomość</th><td>" . nl2br($safeWiadomosc) . "</td></tr>";
                echo "</table>";
            } else {
                echo "<h2>Nie można wysłać formularza. Błędy:</h2>";
                echo "<ul style='color: #d9534f; margin: 12px 0 20px 20px;'>";
                foreach ($errors as $error) {
                    echo "<li>" . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</li>";
                }
                echo "</ul>";
            }

            echo "<a href='index.php' class='btn-link'>Powrót do formularza</a>";
        } else {
            echo "<p>Nieprawidłowe wywołanie skryptu.</p>";
            echo "<a href='index.php' class='btn-link'>Powrót do formularza</a>";
        }
        ?>
    </div>

</body>
</html>