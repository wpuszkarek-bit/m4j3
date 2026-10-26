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


        <form id="contactForm" action="odbierz.php" method="post" novalidate>
            <div class="form-group">
                <label for="imie">Imię *</label>
                <input type="text" id="imie" name="imie" required minlength="2">
                <span class="error-msg" id="imieError"></span>
            </div>

            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="email" id="email" name="email" placeholder="jan@example.com" required>
                <span class="error-msg" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="wiadomosc">Wiadomość *</label>
                <textarea id="wiadomosc" name="wiadomosc" rows="3" maxlength="200" required></textarea>
                <div class="char-counter">Pozostało znaków: <span id="charCount">200</span></div>
                <span class="error-msg" id="wiadomoscError"></span>
            </div>

            <div class="actions-group">
                <button type="submit" id="submitBtn" class="btn-primary">Wyślij formularz</button>
                <button type="reset" id="resetBtn" class="btn-reset">Wyczyść formularz</button>
            </div>
        </form>

        <div id="powitanie" class="welcome-msg"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>