//lors de l'installation
self.addEventListener('install', evt => {
    // console.log('install evt', evt);
})

//capture des events
self.addEventListener('fetch', evt => {
    if (evt.request.mode === 'navigate') {
        evt.respondWith((async () => {
            try {
                const preloadResponse = await evt.preloadResponse
                if (preloadResponse) {
                    return preloadResponse
                }

                return await fetch(evt.request)
            } catch (e) {
                return new Response("L'application est complètement pétée... Désolé.")
            }

        })())
    }
})