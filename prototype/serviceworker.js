/**
 * Holy Child Montessori
 * 2018
 * 
 * ServiceWorker.js
 */

'use strict';

var cn = '1';
var cacheWhiteList = ['1'];
var assetsList = [
    "/offline.php",
    "/assets/imgs/icon-72x72.png",
    "/assets/imgs/icon-96x96.png",
    "/assets/imgs/icon-128x128.png",
    "/assets/imgs/icon-144x144.png",
    "/assets/imgs/icon-152x152.png",
    "/assets/imgs/icon-192x192.png",
    "/assets/imgs/icon-384x384.png",
    "/assets/imgs/icon-512x512.png"
];

// Install Event
self.addEventListener('install',(event)=>{
    // Open the Cache
    event.waitUntil(caches.open(cn)
        .then((cache)=>{
            // Fetch All Assets
            return cache.addAll(assetsList);
        })
    );

});

// Fetch Event
self.addEventListener('fetch', (event)=>{
    event.respondWith(
      // Try the cache
      caches.match(event.request).then((response)=>{

        // Fall back to network
        return response || fetch(event.request);

    }).catch(()=>{

        let method = event.request.method;

            if(method !== 'POST'){
                return caches.match('/offline.php');
            }

        })
    );
});

// Remove Old Caches
self.addEventListener('activate', (event)=>{
    event.waitUntil(
        caches.keys().then((keyList)=>{
            return Promise.all(keyList.map((key)=>{
                if(cacheWhiteList.indexOf(key) === -1){
                    return caches.delete(key);
                }
            }));
        })
    );
});