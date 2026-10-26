document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm");
    const submitBtn = document.getElementById("submitBtn");
    const statusMessage = document.getElementById("statusMessage");

    const imieInput = document.getElementById("imie");
    const emailInput = document.getElementById("email");
    const wiadomoscInput = document.getElementById("wiadomosc");

    const imieError = document.getElementById("imieError");
    const emailError = document.getElementById("emailError");
    const wiadomoscError = document.getElementById("wiadomoscError");

    // Pomocnicza funkcja do sprawdzania i pokazania błędu
    function validateField(inputEl, errorEl, condition, message) {
        if (condition) {
            errorEl.textContent = message;
            inputEl.classList.add("input-invalid");
            return false;
        } else {
            errorEl.textContent = "";
            inputEl.classList.remove("input-invalid");
            return true;
        }
    }

    // Walidacja w czasie rzeczywistym
    [imieInput, emailInput, wiadomoscInput].forEach(element => {
        element.addEventListener("input", () => {
            validateInputs();
        });
    });

    function validateInputs() {
        const isImieValid = validateField(
            imieInput,
            imieError,
            imieInput.value.trim().length < 2,
            "Imię musi zawierać co najmniej 2 znaki."
        );

        const isEmailValid = validateField(
            emailInput,
            emailError,
            !emailInput.checkValidity() || emailInput.value.trim() === "",
            "Wprowadź poprawny adres e-mail."
        );

        const isWiadomoscValid = validateField(
            wiadomoscInput,
            wiadomoscError,
            wiadomoscInput.value.trim() === "",
            "Wiadomość nie może być pusta."
        );

        const isValid = isImieValid && isEmailValid && isWiadomoscValid;
        submitBtn.disabled = !isValid;
        return isValid;
    }

    // Wyczyszczenie błędów przy czyszczeniu formularza
    form.addEventListener("reset", () => {
        statusMessage.style.display = "none";
        statusMessage.className = "status-msg";
        [imieInput, emailInput, wiadomoscInput].forEach(el => el.classList.remove("input-invalid"));
        [imieError, emailError, wiadomoscError].forEach(el => el.textContent = "");
        setTimeout(() => { submitBtn.disabled = true; }, 10);
    });

    // Wysyłanie przez fetch()
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (!validateInputs()) return;

        submitBtn.disabled = true;
        submitBtn.textContent = "Wysyłanie...";
        statusMessage.style.display = "none";

        const formData = new FormData(form);

        try {
            const response = await fetch("odbierz.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (result.status === "success") {
                statusMessage.textContent = result.message;
                statusMessage.className = "status-msg success";
                form.reset();
            } else {
                statusMessage.textContent = result.message || "Wystąpił błąd podczas walidacji.";
                statusMessage.className = "status-msg error";
            }
        } catch (error) {
            statusMessage.textContent = "Nie udało się połączyć z serwerem.";
            statusMessage.className = "status-msg error";
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Wyślij wiadomość";
        }
    });

    // Początkowe zablokowanie przycisku
    validateInputs();
});