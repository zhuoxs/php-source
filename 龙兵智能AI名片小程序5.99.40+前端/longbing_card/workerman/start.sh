php api.php stop
kill -9 $(lsof -i tcp:2345 -t)
php api.php start -d