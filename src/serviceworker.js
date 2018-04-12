/**
 * All Wet
 * 2018
 * 
 * Service Worker
 *
 * Patterned from https://github.com/hcmedutech/website
 */

'use strict';

let cn = '1';
let cacheWhiteList = ['1'];
let assetsList = [];

// Install Event
self.addEventListener('install', event=>{
    // Open the cache
    event.waitUntil(caches.open(cn)
        .then(cache=>{
            // Fetch all the assets from the array
            return cache.addAll(assetsList);
        })
    );
});


// Fetch Event
self.addEventListener('fetch', event=>{
    event.respondWith(
        caches.match(event.request)
            .then(response=>{
                //Fallback to network
                return response || fetch(event.request);
            })
            .catch(()=>{
                let method = event.request.method;

                if(method !== POST){
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