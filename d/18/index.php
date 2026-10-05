<?php
// Dane początkowe z serwera PHP
$initialTasks = [
    ["id" => 1, "title" => "Kupić mleko i pieczywo", "completed" => false],
    ["id" => 2, "title" => "Napisać kod aplikacji Todo", "completed" => true],
    ["id" => 3, "title" => "Przeczytać rozdział z podręcznika", "completed" => false]
];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Zadań - Todo App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="app-container">
        <h1>Lista Zadań</h1>

        <!-- Formularz dodawania nowego zadania -->
        <form id="add-task-form" class="task-form">
            <input type="text" id="task-input" placeholder="Wpisz treść zadania..." required>
            <button type="submit">Dodaj</button>
        </form>

        <!-- Przyciski filtrów -->
        <div class="filters">
            <button class="filter-btn active" data-filter="all">Wszystkie</button>
            <button class="filter-btn" data-filter="active">Do zrobienia</button>
            <button class="filter-btn" data-filter="completed">Wykonane</button>
        </div>

        <!-- Lista zadań -->
        <ul id="todo-list" class="todo-list"></ul>
    </div>

    <script>
        // Przekazanie danych początkowych z PHP do JS
        window.INITIAL_TASKS = <?php echo json_encode($initialTasks); ?>;
    </script>
    <script src="app.js"></script>
</body>
</html>