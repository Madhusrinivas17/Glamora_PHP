<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Home page -> Glamora Landing Showcase
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'home']);

        // User Auth routes
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $builder->connect('/register', ['controller' => 'Users', 'action' => 'register']);
        $builder->connect('/register-admin', ['controller' => 'Users', 'action' => 'registerAdmin']);
        $builder->connect('/verify-otp', ['controller' => 'Users', 'action' => 'verifyOtp']);
        $builder->connect('/resend-otp', ['controller' => 'Users', 'action' => 'resendOtp']);
        $builder->connect('/profile', ['controller' => 'Users', 'action' => 'profile']);

        // Service Catalog & Favorites & Live Services
        $builder->connect('/services', ['controller' => 'Services', 'action' => 'index']);
        $builder->connect('/services/view/{id}', ['controller' => 'Services', 'action' => 'view'])->setPass(['id']);
        $builder->connect('/services/toggle-favorite', ['controller' => 'Services', 'action' => 'toggleFavorite']);
        $builder->connect('/favourites', ['controller' => 'Services', 'action' => 'favourites']);
        $builder->connect('/live-services', ['controller' => 'Services', 'action' => 'live']);

        // Appointments & Booking
        $builder->connect('/book', ['controller' => 'Appointments', 'action' => 'book']);
        $builder->connect('/my-appointments', ['controller' => 'Appointments', 'action' => 'myAppointments']);
        $builder->connect('/appointments/cancel/{id}', ['controller' => 'Appointments', 'action' => 'cancel'])->setPass(['id']);
        $builder->connect('/appointments/get-slots', ['controller' => 'Appointments', 'action' => 'getSlots']);

        // Offers, Reviews, Notifications
        $builder->connect('/offers', ['controller' => 'Offers', 'action' => 'index']);
        $builder->connect('/reviews/add', ['controller' => 'Reviews', 'action' => 'add']);
        $builder->connect('/reviews/edit/{id}', ['controller' => 'Reviews', 'action' => 'edit'])->setPass(['id']);
        $builder->connect('/reviews/delete/{id}', ['controller' => 'Reviews', 'action' => 'delete'])->setPass(['id']);
        $builder->connect('/notifications', ['controller' => 'Notifications', 'action' => 'index']);
        $builder->connect('/notifications/mark-read/{id}', ['controller' => 'Notifications', 'action' => 'markRead'])->setPass(['id']);

        $builder->fallbacks();
    });

    // Admin Routing Scope
    $routes->prefix('Admin', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->connect('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
        $builder->connect('/toggle-status', ['controller' => 'Dashboard', 'action' => 'toggleStatus']);
        $builder->connect('/reviews/delete/{id}', ['controller' => 'Reviews', 'action' => 'delete'])->setPass(['id']);
        
        $builder->fallbacks();
    });
};
