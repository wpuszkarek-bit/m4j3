<?php
// Logika Backend (PHP)
$showCard = false;
$errors = [];

$name = '';
$class = 'Wojownik';
$strength = 10;
$dexterity = 10;
$intelligence = 10;
$hp = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $class = $_POST['class'] ?? 'Wojownik';
    $strength = (int)($_POST['strength'] ?? 0);
    $dexterity = (int)($_POST['dexterity'] ?? 0);
    $intelligence = (int)($_POST['intelligence'] ?? 0);

    // Walidacja po stronie serwera
    if (empty($name)) {
        $errors[] = "Imię postaci nie może być puste.";
    }
    if (!in_array($class, ['Wojownik', 'Mag', 'Łotrzyk'])) {
        $errors[] = "Wybrano nieprawidłową klasę.";
    }
    if ($strength < 1 || $strength > 20 || $dexterity < 1 || $dexterity > 20 || $intelligence < 1 || $intelligence > 20) {
        $errors[] = "Wszystkie statystyki muszą mieścić się w przedziale 1–20.";
    }

    // Obliczenie HP według wzoru
    if (empty($errors)) {
        $hp = ($strength * 10) + ($dexterity * 2);
        $showCard = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta Postaci RPG</title>
    <style>
        /* Motyw RPG: Głęboki mrok, akcenty neonowe i stylistyka Fantasy/Cyberpunk */
        :root {
            --bg-color: #0b0c10;
            --card-bg: rgba(20, 24, 33, 0.95);
            --border-color: #45a29e;
            --text-color: #c5c6c7;
            --gold-accent: #f39c12;
            --wojownik-color: #ff3838;
            --mag-color: #00d8d6;
            --lotrzyk-color: #05c46b;
        }

        body {
            background: radial-gradient(circle at center, #1f2833 0%, #0b0c10 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column;
            gap: 25px;
            width: 100%;
            max-width: 480px;
        }

        .rpg-box {
            background-color: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 0 20px rgba(69, 162, 158, 0.2), inset 0 0 15px rgba(0,0,0,0.5);
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
            backdrop-filter: blur(5px);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            color: var(--gold-accent);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 1.6rem;
            text-shadow: 0 0 10px rgba(243, 156, 18, 0.4);
        }

        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        input, select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #2c3e50;
            background-color: #121824;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--gold-accent);
            box-shadow: 0 0 10px rgba(243, 156, 18, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: #0b0c10;
            font-weight: 800;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
        }

        .error-list {
            background-color: rgba(255, 56, 56, 0.15);
            border: 1px solid var(--wojownik-color);
            color: #ff4d4d;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.9rem;
        }

        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Układ statystyk Grid z efektami glow */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .stat-item {
            background-color: #121824;
            border: 1px solid #2c3e50;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-item span {
            font-size: 0.8rem;
            color: #8899a6;
            text-transform: uppercase;
        }

        .stat-item strong {
            display: block;
            font-size: 1.4rem;
            color: #fff;
            margin-top: 4px;
        }

        .stat-hp {
            grid-column: span 3;
            background: linear-gradient(135deg, rgba(255, 56, 56, 0.2) 0%, rgba(20, 24, 33, 0.8) 100%);
            border: 1px solid var(--wojownik-color);
            box-shadow: 0 0 15px rgba(255, 56, 56, 0.2);
        }

        .stat-hp strong {
            color: var(--wojownik-color);
            font-size: 1.8rem;
            text-shadow: 0 0 8px rgba(255, 56, 56, 0.5);
        }

        /* Dynamiczne obramowania JS z neonowym blaskiem */
        .border-wojownik { 
            border-color: var(--wojownik-color) !important; 
            box-shadow: 0 0 25px rgba(255, 56, 56, 0.45) !important;
        }
        .border-mag { 
            border-color: var(--mag-color) !important; 
            box-shadow: 0 0 25px rgba(0, 216, 214, 0.45) !important;
        }
        .border-lotrzyk { 
            border-color: var(--lotrzyk-color) !important; 
            box-shadow: 0 0 25px rgba(5, 196, 107, 0.45) !important;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Formularz -->
    <div class="rpg-box" id="form-box">
        <h2>Kreator Postaci</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Imię bohatera:</label>
                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">
            </div>

            <div class="form-group">
                <label for="class">Klasa postaci:</label>
                <select id="class" name="class" required>
                    <option value="Wojownik" <?= $class === 'Wojownik' ? 'selected' : '' ?>>Wojownik</option>
                    <option value="Mag" <?= $class === 'Mag' ? 'selected' : '' ?>>Mag</option>
                    <option value="Łotrzyk" <?= $class === 'Łotrzyk' ? 'selected' : '' ?>>Łotrzyk</option>
                </select>
            </div>

            <div class="form-group">
                <label for="strength">Siła (1–20):</label>
                <input type="number" id="strength" name="strength" min="1" max="20" required value="<?= htmlspecialchars($strength) ?>">
            </div>

            <div class="form-group">
                <label for="dexterity">Zręczność (1–20):</label>
                <input type="number" id="dexterity" name="dexterity" min="1" max="20" required value="<?= htmlspecialchars($dexterity) ?>">
            </div>

            <div class="form-group">
                <label for="intelligence">Inteligencja (1–20):</label>
                <input type="number" id="intelligence" name="intelligence" min="1" max="20" required value="<?= htmlspecialchars($intelligence) ?>">
            </div>

            <button type="submit">Generuj Kartę</button>
        </form>
    </div>

    <!-- Wyświetlenie karty postaci w PHP -->
    <?php if ($showCard): ?>
        <div class="rpg-box" id="card-box">
            <h2>Karta Postaci</h2>
            <p style="margin: 5px 0;"><strong>Imię:</strong> <?= htmlspecialchars($name) ?></p>
            <p style="margin: 5px 0;"><strong>Klasa:</strong> <?= htmlspecialchars($class) ?></p>

            <div class="stats-grid">
                <div class="stat-item">
                    <span>Siła</span>
                    <strong><?= $strength ?></strong>
                </div>
                <div class="stat-item">
                    <span>Zręczność</span>
                    <strong><?= $dexterity ?></strong>
                </div>
                <div class="stat-item">
                    <span>Inteligencja</span>
                    <strong><?= $intelligence ?></strong>
                </div>
                <div class="stat-item stat-hp">
                    <span>Punkty Życia (HP)</span>
                    <strong><?= $hp ?></strong>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Dynamiczna zmiana koloru akcentu (JavaScript) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classSelect = document.getElementById('class');
        const formBox = document.getElementById('form-box');

        function updateAccent() {
            const val = classSelect.value;
            formBox.classList.remove('border-wojownik', 'border-mag', 'border-lotrzyk');

            if (val === 'Wojownik') {
                formBox.classList.add('border-wojownik');
            } else if (val === 'Mag') {
                formBox.classList.add('border-mag');
            } else if (val === 'Łotrzyk') {
                formBox.classList.add('border-lotrzyk');
            }
        }

        classSelect.addEventListener('change', updateAccent);
        updateAccent(); // Wywołanie startowe
    });
</script>

</body>
</html>