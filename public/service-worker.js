const CACHE_NAME = 'vidaqr-v1';

const STATIC_ASSETS = [
    '/',
    '/dashboard',
    '/manifest.json',
];

// Instalar service worker y cachear assets estáticos
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS))
    );
    self.skipWaiting();
});

// Limpiar caches viejos al activar
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
            )
        )
    );
    self.clients.claim();
});

// Estrategia: Network first, fallback a cache
self.addEventListener('fetch', event => {
    // Solo manejar requests GET
    if (event.request.method !== 'GET') return;

    // No interceptar requests de API o autenticación
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/api/') || url.pathname.startsWith('/login')) return;

    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Guardar copia en cache si es exitosa
                if (response.ok) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                }
                return response;
            })
            .catch(() => caches.match(event.request))
    );
});