## Running The Project for Development

This project is built by using Laravel, SQLite and Vue to create web services APIs, webpage, and storing user requests in database.
```
composer intall

npm install

php artisan migrate

// in case that we want to generate data for past 2 years (optional)
php artisan db:seed

php -S localhost:8000 -t public
```

##### Listing of URL available:
- http://localhost:8000/stats
- http://localhost:8000/prime
- http://localhost:8000/even
- http://localhost:8000/client-requests

##### Demo
<img src="https://i.imgur.com/TcqYSNt.png" />

<br/><br/>

developed by apichai.densamut@gmail.com (Chai)