## About The Order Text Message Service

This project is developed for send text message to customer who given an order. After given an order a text message is being sent to the customer as a confirmation of the order. With this message, the name of the restaurant and an estimated delivery time is send.

This project is developed with Laravel 5.8. Also it can use as Microservice via Docker.

### Installations:

##### Clone project from Github
``git clone https://github.com/FG-Developer/order-text-messages.git``

Vue.js and Axios frameworks were used for the list of messages. For install these frameworks and other front-end dependencies the following commands must be run sequentially via npm.

``npm install``
``npm run production``

##### Copy .env file from example
``cp .env.example .env``

On this project was used Nexmo SMS Service for send message. That's why, for send message, Nexmo parameters must be define via ``.env`` file. Please change your Nexmo settings with the following parameters in ``.env`` file.

```
NEXMO_KEY=YOUR_NEXMO_KEY
NEXMO_SECRET=YOUR_NEXMO_SECRET
```

For run the project under the local machine, the following commands must be run sequentially.

```
php artisan key:generate
php artisan config:cache
php artisan migrate
```

This project can run under the Docker container. If you want to run it under the Docker Container you should run following commands after Docker up.

With the Docker up, some settings will be send to the Container these are Mysql, php-fpm and Nginx config files. These config files are under the ``docker`` folder. These files can be changeable according to your needs.

##### Running project via Docker
``docker-compose up -d``

***This container connects to Mysql server with Laravel's default settings.***

After run Docker, on the the ``.env`` file the ``DB_HOST`` parameter must be change as ``db`` for the mysql connection. The ``db`` is the name of MySQL container of Docker.

``docker-compose exec app nano .env``

##### The following codes must be run sequentially on the Docker Container after the Docker Container is built.

```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan migrate
```

After an order a text message is sent to the customer as a confirmation of the order. This message contains the name of the restaurant and an estimated delivery time. A text message is sent after the delivery of the meal again. This text message is delivered 90 minutes after the restaurant’s delivery time. That's why, Laravel's Queue mechanism was used in this project. The queue tries for sending a notification two times. If it can't send message, it's inserted to failed_jobs table as fail job.

So, the following code that is Laravel's Queue worker, must be run in the Docker Container after Docker run.
``docker-compose exec app php artisan queue:work``

If the custom Nginx virtual host won't be sent to the Docker Container, the application will running under the ``http://127.0.0.1`` url.

All messages can be viewed with this url.``BASE_URL/messages``. In this page the messages is received via API.

**This project runs API based.**
# API
## End Points

#### Note
application/json parameter have to sent to all post requests with header.

```
Accept: application/json
```

#### Order
This endpoint is used for receives a new order. First, the orders insert to database then the message is added to queue for send to customer.

**URL:** ``BASE_URL/api/order``

**METHOD:** ``POST``

**POST DATA:**
```
{
    restaurant_name: [RULES => 'required|min:2|max:100'],
    delivery_time: [RULES => required|lte:60|gte:5'],
    phone_number: [RULES => 'required|digits_between:10,20']
}
```
**SUCCESS RETURN**
```
{
    "status": 200,
    "msg": "Success"
}
```
**ERROR RETURN**
```
{
    "status": 500,
    "msg": "Internal Server Error"
}
```

#### Get Last 50 Sent Messages

``application/json`` parameter have to sent to all Post requests with Header.

**URL:** ``BASE_URL/api/last-sent-messages``

**METHOD:** ``GET``

**SUCCESS RETURN**
```
{
  "data": [
    {
      "id": 8,
      "restaurant_name": "Burger King",
      "delivery_time": 10,
      "phone_number": "444174716849",
      "message": "Burger King. Enjoy your meal! We are happy for delivered your order. If you give a vote to our restaurant, we will be happy :)",
      "status": 0,
      "status_msg": "",
      "created_at": "2019-03-30 22:05:49",
      "updated_at": "2019-03-30 22:08:59"
    }
  ]
}
```


#### Get Other Statuses Messages

This endpoint returns list of the last 24 hours messages that returned any other statuses. Also on this endpoint, we can search in the Restaurant Name, Customer Phone and Sent Message fields via ``q`` query string parameter.

**URL:** ``BASE_URL/api/messages?q=search_a_keyword``

**METHOD:** ``GET``

**SUCCESS RETURN**
```
{
  "data": [
    {
      "id": 8,
      "restaurant_name": "Burger King",
      "delivery_time": 10,
      "phone_number": "444174716849",
      "message": "Burger King. Enjoy your meal! We are happy for delivered your order. If you give a vote to our restaurant, we will be happy :)",
      "status": 29,
      "status_msg": "Non White-listed Destination - rejected",
      "created_at": "2019-03-30 22:05:49",
      "updated_at": "2019-03-30 22:08:59"
    },
    ...
  ]
}
```

For view the list of messages should use the following page.
``BASE_URL/messages``


#### Unit Tests
The tests are written with ``phpunit``. For running unit tests under the Docker Container, it is sufficient should run following command.
``docker-compose exec app vendor/phpunit/phpunit/phpunit``

Without Docker,
``vendor/phpunit/phpunit/phpunit``
