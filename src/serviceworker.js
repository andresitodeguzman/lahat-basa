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
let assetsList = [
    '/manifest.json',
    '/',
    '/_index.js',
    '/app',
    '/app/order.php',
    '/app/_app.js',
    '/app/_order.js',
    '/authenticate/admin.php',
    '/authenticate/employee.php',
    '/authenticate/_scripts/admin.js',
    '/authenticate/_scripts/employee.js',
    '/employee',
    '/employee/_app.js',
    '/admin',
    '/admin/_api.js',
    '/admin/_global.js',
    '/admin/_init.js',
    '/admin/category.js',
    '/admin/customer.js',
    '/admin/employee.js',
    '/admin/fordelivery.js',
    '/admin/product.js',
    '/admin/salesreport.js',
    '/admin/self.js',
    '/assets/css/customstyle.css',
    '/assets/fonts/iconfont/material-icons.css',
    '/assets/fonts/iconfont/MaterialIcons-Regular.eot',
    '/assets/fonts/iconfont/MaterialIcons-Regular.ijmap',
    '/assets/fonts/iconfont/MaterialIcons-Regular.svg',
    '/assets/fonts/iconfont/MaterialIcons-Regular.ttf',
    '/assets/fonts/iconfont/MaterialIcons-Regular.woff',
    '/assets/fonts/iconfont/MaterialIcons-Regular.woff2',
    '/assets/images/heroimg2.jpg',
    '/assets/images/icon/icon-128x128.png',
    '/assets/images/icon/icon-144x144.png',
    '/assets/images/icon/icon-152x152.png',
    '/assets/images/icon/icon-192x192.png',
    '/assets/images/icon/icon-384x384.png',
    '/assets/images/icon/icon-512x512.png',
    '/assets/images/icon/icon-72x72.png',
    '/assets/images/icon/icon-96x96.png',
    '/assets/js/jquery-3.3.1.min.js',
    '/assets/materialize/css/materialize.min.css',
    '/assets/materialize/js/materialize.min.js'
];

// Install Event
self.addEventListener('install', event=>{
    // Open the cache
    event.waitUntil(caches.open(cn)
        .then(cache=>{
            // Fetch all the assets from the array
            return cache.addAll(assetsList);
        }).then(()=>{
            console.log("done caching");
        })
    );
});


// Fetch Event
self.addEventListener('fetch',event=>{
    event.respondWith(
        caches.open(cn).then(cache=>{
            return cache.match(event.request).then(response=>{
                return response || fetch(event.request);
            });
        })
    );
});

self.addEventListener('fetch', event=>{
    event.respondWith(
        caches.match(event.request)
            .then(response=>{
                //Fallback to network
                return response || fetch(event.request);
            })
            .catch(r=>{
                console.log(r);
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