<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dao/config.php';

// Enable CORS
Flight::before('start', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
});

// Services
require 'services/userService.php';
require 'services/cartService.php';
require 'services/categoriesService.php';
require 'services/contactUsService.php';
require 'services/orderDetailsService.php';
require 'services/wishlistService.php';
require 'services/productsService.php';
require 'services/ordersService.php';

// Register services
Flight::register('usersService', 'UsersService');
Flight::register('cartService', 'cartService');
Flight::register('categoriesService', 'categoriesService');
Flight::register('contactUsService', 'ContactUsService');
Flight::register('orderDetailsService', 'orderDetailsService');
Flight::register('wishlistService', 'wishlistService');
Flight::register('productsService', 'productsService');
Flight::register('ordersService', 'OrdersService');

// Routes
require_once 'routes/userRoutes.php';
require_once 'routes/categoriesRoutes.php';
require_once 'routes/contactUsRoutes.php';
require_once 'routes/productRoutes.php';
require_once 'routes/cartRoutes.php';
require_once 'routes/wishlistRoutes.php';
require_once 'routes/orderRoutes.php';

Flight::route('GET /connection-test', function(){
    try {
        $db = Database::connect();
        Flight::json(['status' => 'success', 'message' => 'Connected to webApp']);
    } catch (Exception $e) {
        Flight::halt(500, json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
            'details' => [
                'host' => 'localhost',
                'port' => '8889',
                'dbname' => 'webApp',
                'socket' => '/Applications/MAMP/tmp/mysql/mysql.sock'
            ]
        ]));
    }
});

// OpenAPI docs
Flight::route('GET /docs', function() {
    header('Content-Type: application/yaml');
    readfile('/docs/openapi.yaml');
});

// Base URL configuration for MAMP
Flight::set('flight.base_url', '/hexashop/backend/');

Flight::start();
?>