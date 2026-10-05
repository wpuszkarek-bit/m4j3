// Zadanie 5. Dodawanie elementu
function dodajElement(tekst) {
  // Walidacja - zapobieganie dodawaniu pustych wartości
  if (!tekst || tekst.trim() === "") {
    return;
  }

  const ul = document.querySelector("#lista");
  const li = document.createElement("li");
  
  // Ustawienie tekstu
  li.textContent = tekst;

  // Przycisk "Usuń" potrzebny do Zadania 6
  const btnUsun = document.createElement("button");
  btnUsun.textContent = "Usuń";
  btnUsun.className = "btn-usun";
  li.appendChild(btnUsun);

  ul.appendChild(li);
}


// Zadanie 6 & Zadanie 7. Usuwanie przez delegację zdarzeń oraz przełączanie stanu
const lista = document.querySelector("#lista");

lista.addEventListener("click", (e) => {
  // Sprawdzenie, czy kliknięto przycisk "Usuń"
  if (e.target.classList.contains("btn-usun")) {
    e.stopPropagation(); // Zadanie 7: zatrzymanie propagacji, aby kliknięcie usuń nie zmieniało stanu
    const li = e.target.closest("li");
    if (li) {
      li.remove(); // Zadanie 6: usunięcie właściwego elementu li
    }
  } else {
    // Zadanie 7: przełączenie klasy .wykonane po kliknięciu w element listy
    const li = e.target.closest("li");
    if (li && lista.contains(li)) {
      li.classList.toggle("wykonane");
    }
  }
});


// Zadanie 8. Filtrowanie
let zadania = [
  { id: 1, nazwa: "Kupić mleko", wykonane: false },
  { id: 2, nazwa: "Nauczyć się JavaScript", wykonane: true },
  { id: 3, nazwa: "Zrobić zakupy", wykonane: false }
];

const inputSzukaj = document.querySelector("#szukaj");

inputSzukaj.addEventListener("input", (e) => {
  const fraza = e.target.value.toLowerCase();
  
  // Filtrowanie z wykorzystaniem filter(), includes() i toLowerCase()
  const przefiltrowane = zadania.filter(item => 
    item.nazwa.toLowerCase().includes(fraza)
  );

  renderujListe(przefiltrowane);
});


// Zadanie 9. Sortowanie
const btnAZ = document.querySelector("#btn-az");
const btnZA = document.querySelector("#btn-za");

btnAZ.addEventListener("click", () => {
  // Sortowanie A-Z za pomocą sort() i localeCompare()
  zadania.sort((a, b) => a.nazwa.localeCompare(b.nazwa));
  zapiszDoLocalStorage(zadania);
  renderujListe(zadania);
});

btnZA.addEventListener("click", () => {
  // Sortowanie Z-A za pomocą sort() i localeCompare()
  zadania.sort((a, b) => b.nazwa.localeCompare(a.nazwa));
  zapiszDoLocalStorage(zadania);
  renderujListe(zadania);
});


// Zadanie 10. localStorage
function zapiszDoLocalStorage(dane) {
  localStorage.setItem("zadania", JSON.stringify(dane));
}
function wczytajZLocalStorage() {
  const zapisaneDane = localStorage.getItem("zadania");
   // Obsługa sytuacji, gdy zapis jeszcze nie istnieje
  if (zapisaneDane !== null) {
    return JSON.parse(zapisaneDane);
  }
  return []; // Zwraca pustą tablicę w przypadku braku danych
}
// Inicjalizacja przy uruchomieniu strony
function inicjalizujAplikacje() {
  const wczytane = wczytajZLocalStorage();
  if (wczytane.length > 0) {
    zadania = wczytane;
  }
  renderujListe(zadania);
}
// Funkcja pomocnicza do renderowania listy w DOM
function renderujListe(listaZadan) {
  lista.innerHTML = "";
  listaZadan.forEach(task => {
    const li = document.createElement("li");
    li.textContent = task.nazwa + " ";
    if (task.wykonane) {
      li.classList.add("wykonane");
    }
    const btnUsun = document.createElement("button");
    btnUsun.textContent = "Usuń";
    btnUsun.className = "btn-usun";
    li.appendChild(btnUsun);

    lista.appendChild(li);
  });
}