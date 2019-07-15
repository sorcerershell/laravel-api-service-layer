## Laravel API with Service Layer

### How to Run the test
```
$ php ./vendor/bin/phpunit -c phpunit.xml 
```

### How to Run the server
```
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
``` 

### How to test using Curl
1. Get All Products 
```
curl http://localhost:8000/api/product
```

2. Create New Product
```
curl -H "Content-Type: application/json" -X POST http://localhost:8000/api/product --data '{"_id":"607f191e810c19729de860ea","name":"Product 1","price":"100000","image":"http://s3-ap-southeast-1.amazonaws.com/s3.irvinsaltedegg.com/engineering-test/images/product-1.jpg"}'
```

3. Get Specific Product
```
curl http://localhost:8000/api/product/607f191e810c19729de860ea
```

4. Update Specific Product
```
curl -H "Content-Type: application/json" -X PUT http://localhost:8000/api/product/607f191e810c19729de860ea --data '{"_id":"607f191e810c19729de860ea","name":"Product 10","price":"900","image":"http://s3-ap-southeast-1.amazonaws.com/s3.irvinsaltedegg.com/engineering-test/images/product-1.jpg"}'
```
5. Delete Product
```
curl -X DELETE http://localhost:8000/api/product/607f191e810c19729de860ea
```


