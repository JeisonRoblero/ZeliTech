;
//asignando un nombre y versión al cache
const CACHE_NAME = 'v1_cache_zelitech',
 urlsToCache = [
     './',
     './images/cart.png',
     'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',
     'css/estilos.css',
     './style.css',
     './bootstrap/css/bootstrap.css',
     './fontawesome/css/all.css',
     './bootstrap/js/bootstrap.js',
     './fontawesome/js/all.js',
     './js/jquery-3.3.1.min.js',
     'http://unpkg.com/sweetalert/dist/sweetalert.min.js',
     'https://fonts.googleapis.com',
     'https://fonts.gstatic.com',
     'https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap',
     'https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js',
     'https://cdn.lordicon.com/gmzxduhd.json',
     'https://cdn.lordicon.com/dnoiydox.json',
     'https://cdn.lordicon.com/qrbokoyz.json',
     'https://cdn.lordicon.com/puvaffet.json',
     'https://cdn.lordicon.com/lywgqtim.json',
     'https://cdn.lordicon.com/dxjqoygy.json',
     'https://cdn.lordicon.com/slkvcfos.json',
     'https://cdn.lordicon.com/dqkyqxlp.json',
     'https://cdn.lordicon.com/dxjqoygy.json',
     'https://cdn.lordicon.com/lywgqtim.json',
     'https://cdn.lordicon.com/nxaaasqe.json',
     'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
     './script.js',
     './js/app.js',
     './images/icono/icon_1024.png',
     './images/icono/icon_512.png',
     './images/icono/icon_384.png',
     './images/icono/icon_256.png',
     './images/icono/icon_192.png',
     './images/icono/icon_128.png',
     './images/icono/icon_96.png',
     './images/icono/icon_64.png',
     './images/icono/icon_32.png',
     './images/icono/icon_16.png',
     'https://www.zeli.cf/',
     'https://www.zeli.cf/?p=principal',
     'https://www.zeli.cf/?p=productos',
     'https://www.zeli.cf/?p=ofertas',
     'https://www.zeli.cf/?p=registrarse',
     'https://www.zeli.cf/?p=login',
     'https://www.zeli.cf/bienvenida',
     'https://www.zeli.cf/?p=carrito',
     'https://www.zeli.cf/?p=miscompras',
     'https://www.zeli.cf/?p=perfil',
     'https://www.zeli.cf/?p=factura',
     'https://www.zeli.cf/?p=checkout#pay',
     'https://zeli.cf/?utm_source=web_app_manifest',
     
 ]

 
//Almacenando en cahé los activos estáticos
self.addEventListener('install', e => {
    e.waitUntil(
      caches.open(CACHE_NAME)
        .then(cache => {
          return cache.addAll(urlsToCache)
            .then(() => self.skipWaiting())
        })
        .catch(err => console.log('Falló registro de cache', err))
    )
})
  
//Cuando se instala el SW, se activa y busca los recursos para que 
//pueda funcionar sin conexión a internet
self.addEventListener('activate', e => {
    const cacheWhitelist = [CACHE_NAME]
  
    e.waitUntil(
      caches.keys()
        .then(cacheNames => {
          return Promise.all(
            cacheNames.map(cacheName => {
              //Eliminamos lo que ya no se necesita en cache
              if (cacheWhitelist.indexOf(cacheName) === -1) {
                return caches.delete(cacheName)
              }
            })
          )
        })
        // Le indica al SW activar el cache actual
        .then(() => self.clients.claim())
    )
})
  

//cuando el navegador recupera una url, actualiza la información almacenada
self.addEventListener('fetch', e => {
    //Da respuesta ya sea con el objeto en caché o continua buscando la url real
    e.respondWith(
      caches.match(e.request)
        .then(res => {
          if (res) {
            //recuperando del cache
            return res
          }
          //recuperando de la petición a la url
          return fetch(e.request)
        })
    )
})