let CACHE_NAME = "v2";

// install event

self.addEventListener('install', function (e) {
    console.log("Installed...");
    // no files to be cached...
});

// activate event

self.addEventListener('activate', function (e) {
    console.log("Activated...");
    // delete old caches
    e.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cache) {
                    if (cache !== CACHE_NAME) {
                        console.log("Removing old caches");
                        return caches.delete(cache);
                    }
                })
            )
        })
    )
});

// fetch event

self.addEventListener('fetch', function (e) {
    console.log("Fetching...");
    e.respondWith(
        fetch(e.request)
            .catch(function () {
                caches.match(e.request);
            })
    );
})