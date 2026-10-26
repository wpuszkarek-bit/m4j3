<?php
// Ustawienie nagłówka odpowiedzi na format JSON
header("Content-Type: application/json; charset=UTF-8");

// Zezwolenie tylko na żądania POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => "error",
        "message" => "Nieprawidłowa metoda żądania."
    ]);
    exit;
}

// Odbiór i oczyszczenie danych
$imie = trim($_POST["imie"] ?? "");
$email = trim($_POST["email"] ?? "");
$wiadomosc = trim($_POST["wiadomosc"] ?? "");

$errors = [];

// Walidacja po stronie PHP
if (empty($imie) || mb_strlen($imie) < 2) {
    $errors[] = "Imię musi zawierać co najmniej 2 znaki.";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Wprowadź poprawny adres e-mail.";
}

if (empty($wiadomosc)) {
    $errors[] = "Treść wiadomości nie może być pusta.";
}

// Jeśli nie ma błędów, zapisujemy dane do pliku JSON
if (empty($errors)) {
    $file = 'wiadomosci.json';

    // 1. Pobierz dotychczasowe dane z pliku (jeśli plik istnieje)
    $currentData = [];
    if (file_exists($file)) {
        $jsonContent = file_get_contents($file);
        $currentData = json_decode($jsonContent, true) ?? [];
    }

    // 2. Przygotuj nowy wpis z datą
    $newEntry = [
        "id" => uniqid(),
        "imie" => $imie,
        "email" => $email,
        "wiadomosc" => $wiadomosc,
        "data_dodania" => date("Y-m-d H:i:s")
    ];

    // 3. Dodaj nowy wpis do tablicy
    $currentData[] = $newEntry;

    // 4. Zapisz zaktualizowaną tablicę z powrotem do pliku JSON
    if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode([
            "status" => "success",
            "message" => "Dziękujemy, " . htmlspecialchars($imie, ENT_QUOTES, "UTF-8") . "! Wiadomość została zapisana."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Błąd podczas zapisu do pliku."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => implode(" ", $errors)
    ]);
}
?>