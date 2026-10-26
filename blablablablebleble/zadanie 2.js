function debounce(fn, delay) {
  let timerId = null;
  return function (...args) {
    clearTimeout(timerId);
    timerId = setTimeout(() => {
      fn.apply(this, args);
    }, delay);
  };
}
const searchInput = document.getElementById('search-input');
const resultsList = document.getElementById('results-list');

let currentAbortController = null;

async function searchProducts(query) {
  if (!query.trim()) {
    resultsList.innerHTML = '';
    return;
  }

  if (currentAbortController) {
    currentAbortController.abort();
  }

  currentAbortController = new AbortController();
  const { signal } = currentAbortController;

  try {
    const response = await fetch(`/api/products?q=${encodeURIComponent(query)}`, { signal });
    if (!response.ok) throw new Error('Błąd podczas pobierania danych');
    
    const products = await response.json();
    renderProducts(products);
  } catch (error) {
    if (error.name === 'AbortError') {
      console.log('Poprzednie zapytanie zostało anulowane.');
    } else {
      console.error('Błąd wyszukiwania:', error);
    }
  }
}

function renderProducts(products) {
  resultsList.innerHTML = '';
  const fragment = document.createDocumentFragment();

  products.forEach(product => {
    const li = document.createElement('li');
    li.textContent = product.name;
    fragment.appendChild(li);
  });

  resultsList.appendChild(fragment);
}

const handleInput = debounce((e) => {
  searchProducts(e.target.value);
}, 400);

searchInput.addEventListener('input', handleInput);