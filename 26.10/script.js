document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm");
    const imieInput = document.getElementById("imie");
    const emailInput = document.getElementById("email");
    const telefonInput = document.getElementById("telefon");
    const hasloInput = document.getElementById("haslo");
    const dataInput = document.getElementById("data_kontaktu");
    const wiadomoscInput = document.getElementById("wiadomosc");
    const zgodaInput = document.getElementById("zgoda");

    const togglePasswordBtn = document.getElementById("togglePasswordBtn");
    const charCountDisplay = document.getElementById("charCount");
    const powitanieDisplay = document.getElementById("powitanie");

    const statSuccessDisplay = document.getElementById("statSuccess");
    const statErrorDisplay = document.getElementById("statError");

    const maxLength = 200;

    let successCount = parseInt(localStorage.getItem("formSuccessCount") || "0");
    let errorCount = parseInt(localStorage.getItem("formErrorCount") || "0");

    function updateStatsDisplay() {
        statSuccessDisplay.textContent = successCount;
        statErrorDisplay.textContent = errorCount;
    }
    updateStatsDisplay();

    togglePasswordBtn.addEventListener("click", () => {
        if (hasloInput.type === "password") {
            hasloInput.type = "text";
            togglePasswordBtn.textContent = "Ukryj";
        } else {
            hasloInput.type = "password";
            togglePasswordBtn.textContent = "Pokaż";
        }
    });

    imieInput.addEventListener("input", () => {
        const val = imieInput.value.trim();
        powitanieDisplay.textContent = val.length > 0 ? `Witaj, ${val}!` : "";
    });

    wiadomoscInput.addEventListener("input", () => {
        const remaining = maxLength - wiadomoscInput.value.length;
        charCountDisplay.textContent = remaining;
    });

    form.addEventListener("reset", () => {
        powitanieDisplay.textContent = "";
        charCountDisplay.textContent = maxLength;
        document.querySelectorAll(".error-msg").forEach(span => span.textContent = "");
        document.querySelectorAll(".input-invalid").forEach(el => el.classList.remove("input-invalid"));
    });

    function setFieldError(inputEl, errorEl, message) {
        if (message) {
            errorEl.textContent = message;
            inputEl.classList.add("input-invalid");
            return true;
        } else {
            errorEl.textContent = "";
            inputEl.classList.remove("input-invalid");
            return false;
        }
    }

    // GŁÓWNA WALIDACJA - Blokada wysyłki przy braku pól wymaganych
    form.addEventListener("submit", (e) => {
        let isFormInvalid = false;

        // 1. Wymagane: Imię
        const imieVal = imieInput.value.trim();
        if (imieVal === "") {
            isFormInvalid = setFieldError(imieInput, document.getElementById("imieError"), "To pole jest wymagane.") || isFormInvalid;
        } else if (imieVal.length < 2) {
            isFormInvalid = setFieldError(imieInput, document.getElementById("imieError"), "Imię musi mieć co najmniej 2 znaki.") || isFormInvalid;
        } else {
            setFieldError(imieInput, document.getElementById("imieError"), "");
        }

        // 2. Wymagane: E-mail
        if (emailInput.value.trim() === "") {
            isFormInvalid = setFieldError(emailInput, document.getElementById("emailError"), "To pole jest wymagane.") || isFormInvalid;
        } else if (!emailInput.checkValidity()) {
            isFormInvalid = setFieldError(emailInput, document.getElementById("emailError"), "Wprowadź poprawny adres e-mail.") || isFormInvalid;
        } else {
            setFieldError(emailInput, document.getElementById("emailError"), "");
        }

        // 3. Opcjonalne: Telefon (sprawdzamy format tylko jeśli podano)
        const telefonVal = telefonInput.value.trim();
        if (telefonVal.length > 0 && !/^\d{9}$/.test(telefonVal)) {
            isFormInvalid = setFieldError(telefonInput, document.getElementById("telefonError"), "Numer telefonu musi składać się z 9 cyfr.") || isFormInvalid;
        } else {
            setFieldError(telefonInput, document.getElementById("telefonError"), "");
        }

        // 4. Wymagane: Hasło
        if (hasloInput.value === "") {
            isFormInvalid = setFieldError(hasloInput, document.getElementById("hasloError"), "To pole jest wymagane.") || isFormInvalid;
        } else if (hasloInput.value.length < 6) {
            isFormInvalid = setFieldError(hasloInput, document.getElementById("hasloError"), "Hasło musi mieć co najmniej 6 znaków.") || isFormInvalid;
        } else {
            setFieldError(hasloInput, document.getElementById("hasloError"), "");
        }

        // 5. Wymagane: Data
        if (!dataInput.value) {
            isFormInvalid = setFieldError(dataInput, document.getElementById("dataError"), "Wybierz datę kontaktu.") || isFormInvalid;
        } else {
            setFieldError(dataInput, document.getElementById("dataError"), "");
        }

        // 6. Wymagane: Wiadomość
        if (wiadomoscInput.value.trim() === "") {
            isFormInvalid = setFieldError(wiadomoscInput, document.getElementById("wiadomoscError"), "To pole jest wymagane.") || isFormInvalid;
        } else {
            setFieldError(wiadomoscInput, document.getElementById("wiadomoscError"), "");
        }

        // 7. Wymagane: Zgoda
        if (!zgodaInput.checked) {
            isFormInvalid = setFieldError(zgodaInput, document.getElementById("zgodaError"), "Wymagana jest akceptacja regulaminu.") || isFormInvalid;
        } else {
            setFieldError(zgodaInput, document.getElementById("zgodaError"), "");
        }

        // ZATRZYMANIE WYSYŁKI w przypadku błędów
        if (isFormInvalid) {
            e.preventDefault(); // Zablokuj wysłanie formularza do PHP
            errorCount++;
            localStorage.setItem("formErrorCount", errorCount);
            updateStatsDisplay();
        } else {
            successCount++;
            localStorage.setItem("formSuccessCount", successCount);
        }
    });
});