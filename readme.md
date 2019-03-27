## About The Order Text Message Service

This project developed for send text message to customer who given an order. After given an order a text message is being sent to the customer as a confirmation of the order. With this message, the name of the restaurant and an estimated delivery time is send.

This project developed as a microservice using Laravel 5.8

### Installations:

##### Clone project from Github
``git clone https://github.com/FG-Developer/order-text-messages.git``

##### Copy .env file from example
``cp .env.example .env``

#### Running project via Docker
``docker-compose up -d``

#### The following codes must be run orderly in the Docker container after the Docker container is built.

``docker-compose exec app php artisan key:generate``

``docker-compose exec app php artisan config:cache``

``docker-compose exec app php artisan migrate``

``docker-compose exec app composer require laravel/nexmo-notification-channel``
