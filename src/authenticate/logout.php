<?php
/**
 * All Wet
 * 2018
 * 
 * Logout
 */

session_start();
session_destroy();
?>
<!Doctype html>
<html>
    <head>
        <script type="text/javascript">
            localStorage.clear();
            sessionStorage.clear();
            window.location.replace('/');
        </script>
    </head>
    <body>
        Please Wait...
    </body>
</html>