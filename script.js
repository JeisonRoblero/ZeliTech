if('serviceWorker' in navigator){
    navigator.serviceWorker.register('./sw.js')
    .then(reg => console.log('SW',reg))
    .catch(err => console.warn('Error al tratar de registrar el sw',err))
}