async function fetchWithCache(url, ttlMs) {
  const cacheKey = `cache_${url}`;
  const now = Date.now();

  const cachedRaw = localStorage.getItem(cacheKey);
  let cachedData = null;
  
  if (cachedRaw) {
    try {
      cachedData = JSON.parse(cachedRaw);
    } catch (e) {
      console.warn("Błąd parsowania danych z cache, dane zostaną zignorowane.");
    }
  }

  if (cachedData && (now - cachedData.timestamp < ttlMs)) {
    return cachedData.payload;
  }

  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`Błąd HTTP! Status: ${response.status}`);
    }
    
    const payload = await response.json();

    const toCache = {
      timestamp: now,
      payload: payload
    };
    localStorage.setItem(cacheKey, JSON.stringify(toCache));

    return payload;
  } catch (error) {
    if (cachedData) {
      console.warn(
        `Błąd połączenia sieciowego (${error.message}). Zwracanie przestarzałego cache z ${new Date(cachedData.timestamp).toLocaleString()}`
      );
      return cachedData.payload;
    }
    
    // Brak sieci oraz brak jakiegokolwiek cache
    throw new Error(`Błąd sieci i brak danych w cache dla URL: ${url}`);
  }
}