async function pobierzDane() {
  try {
    const response = await fetch('c.php');
    
    if (!response.ok) {
      throw new Error(`Błąd HTTP: ${response.status}`);
    }

    const dane = await response.json();
    wyrenderuj(dane);
  } catch (error) {
    console.error('Wystąpił błąd podczas pobierania danych:', error);
  }
}

function wyrenderuj(zadania) {
  const ul = document.querySelector('#lista');
  ul.innerHTML = '';
  zadania.forEach(item => {
    const li = document.createElement('li');
    li.textContent = item.tekst;
    if (item.wykonane) li.classList.add('wykonane');
    ul.appendChild(li);
  });
}