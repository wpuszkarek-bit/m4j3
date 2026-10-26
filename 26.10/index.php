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
            <!-- Wymagane: Imię -->
            <div class="form-group">
                <label for="imie">Imię *</label>
                <input type="text" id="imie" name="imie" required minlength="2">
                <span class="error-msg" id="imieError"></span>
            </div>

            <!-- Wymagane: E-mail -->
            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="email" id="email" name="email" placeholder="jan@example.com" required>
                <span class="error-msg" id="emailError"></span>
            </div>

            <!-- Opcjonalne: Telefon -->
            <div class="form-group">
                <label for="telefon">Numer telefonu (9 cyfr)</label>
                <input type="tel" id="telefon" name="telefon" placeholder="123456789" maxlength="9">
                <span class="error-msg" id="telefonError"></span>
            </div>

            <!-- Wymagane: Hasło -->
            <div class="form-group">
                <label for="haslo">Hasło *</label>
                <div class="password-wrapper">
                    <input type="password" id="haslo" name="haslo" required minlength="6">
                    <button type="button" id="togglePasswordBtn" class="btn-toggle-pw">Pokaż</button>
                </div>
                <span class="error-msg" id="hasloError"></span>
            </div>

            <!-- Wymagane: Data kontaktu -->
            <div class="form-group">
                <label for="data_kontaktu">Preferowana data kontaktu *</label>
                <input type="date" id="data_kontaktu" name="data_kontaktu" required>
                <span class="error-msg" id="dataError"></span>
            </div>

            <div class="form-group">
                <label for="temat">Temat wiadomości</label>
                <select id="temat" name="temat">
                    <option value="Ogólne">Zapytanie ogólne</option>
                    <option value="Wsparcie">Wsparcie techniczne</option>
                    <option value="Współpraca">Współpraca</option>
                </select>
            </div>

            <!-- Wymagane: Wiadomość -->
            <div class="form-group">
                <label for="wiadomosc">Wiadomość *</label>
                <textarea id="wiadomosc" name="wiadomosc" rows="3" maxlength="200" required></textarea>
                <div class="char-counter">Pozostało znaków: <span id="charCount">200</span></div>
                <span class="error-msg" id="wiadomoscError"></span>
            </div>

            <!-- Wymagane: Zgoda -->
            <div class="form-group checkbox-group">
                <input type="checkbox" id="zgoda" name="zgoda" value="tak" required>
                <label for="zgoda">Akceptuję regulamin *</label>
                <span class="error-msg" id="zgodaError"></span>
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