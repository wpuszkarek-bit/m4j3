let tasks = window.INITIAL_TASKS || [];
let currentFilter = 'all';

// Elementy DOM
const todoList = document.getElementById('todo-list');
const taskForm = document.getElementById('add-task-form');
const taskInput = document.getElementById('task-input');
const filterButtons = document.querySelectorAll('.filter-btn');

// Renderowanie listy zadań
function renderTasks() {
    todoList.innerHTML = '';

    const filteredTasks = tasks.filter(task => {
        if (currentFilter === 'active') return !task.completed;
        if (currentFilter === 'completed') return task.completed;
        return true;
    });

    filteredTasks.forEach(task => {
        const li = document.createElement('li');
        li.className = `todo-item ${task.completed ? 'completed' : ''}`;

        // Checkbox stanu
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = task.completed;
        checkbox.addEventListener('change', () => toggleTask(task.id));

        // Treść zadania
        const span = document.createElement('span');
        span.textContent = task.title;
        span.addEventListener('click', () => toggleTask(task.id));

        // Przycisk usuwania
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-btn';
        deleteBtn.textContent = 'Usuń';
        deleteBtn.addEventListener('click', () => deleteTask(task.id));

        li.appendChild(checkbox);
        li.appendChild(span);
        li.appendChild(deleteBtn);

        todoList.appendChild(li);
    });
}

// Oznaczanie zadania jako wykonane / niewykonane
function toggleTask(id) {
    tasks = tasks.map(task => 
        task.id === id ? { ...task, completed: !task.completed } : task
    );
    renderTasks();
}

// Usuwanie zadania
function deleteTask(id) {
    tasks = tasks.filter(task => task.id !== id);
    renderTasks();
}

// Dodawanie nowego zadania
taskForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const title = taskInput.value.trim();

    if (title) {
        const newTask = {
            id: Date.now(),
            title: title,
            completed: false
        };
        tasks.push(newTask);
        taskInput.value = '';
        renderTasks();
    }
});

// Obsługa przycisków filtrowania
filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentFilter = btn.dataset.filter;
        renderTasks();
    });
});

// Pierwsze wyrenderowanie danych
document.addEventListener('DOMContentLoaded', renderTasks);