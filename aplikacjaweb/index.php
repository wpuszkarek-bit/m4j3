<?php
$errors = [];
$success = false;

$imie = '';
$email = '';
$wiadomosc = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = trim($_POST['imie'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $wiadomosc = trim($_POST['wiadomosc'] ?? '');

    // Walidacja PHP
    if (mb_strlen($imie) < 2) {
        $errors[] = "Imię musi mieć co najmniej 2 znaki.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Podaj poprawny adres e-mail.";
    }
    if (empty($wiadomosc) || mb_strlen($wiadomosc) > 200) {
        $errors[] = "Wiadomość jest wymagana i może mieć max 200 znaków.";
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz kontaktowy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Formularz kontaktowy</h1>

        <?php if ($success): ?>
            <div class="welcome-msg" style="display:block;">
                Dziękujemy <strong><?= htmlspecialchars($imie) ?></strong>! Twoja wiadomość została wysłana.
            </div>
        <?php else: ?>

            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form id="contactForm" action="" method="post" novalidate>
                <div class="form-group">
                    <label for="imie">Imię *</label>
                    <input type="text" id="imie" name="imie" required minlength="2" value="<?= htmlspecialchars($imie) ?>">
                    <span class="error-msg" id="imieError"></span>
                </div>

                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" placeholder="jan@example.com" required value="<?= htmlspecialchars($email) ?>">
                    <span class="error-msg" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="wiadomosc">Wiadomość *</label>
                    <textarea id="wiadomosc" name="wiadomosc" rows="3" maxlength="200" required><?= htmlspecialchars($wiadomosc) ?></textarea>
                    <div class="char-counter">Pozostało znaków: <span id="charCount">200</span></div>
                    <span class="error-msg" id="wiadomoscError"></span>
                </div>

                <div class="actions-group">
                    <button type="submit" id="submitBtn" class="btn-primary">Wyślij formularz</button>
                    <button type="reset" id="resetBtn" class="btn-reset">Wyczyść formularz</button>
                </div>
            </form>

        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>