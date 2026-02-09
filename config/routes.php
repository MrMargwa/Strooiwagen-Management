<?php

use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\RoadController;
use League\Route\Router;

return function (Router $router) {

    // Home

    $router->get("/", [HomeController::class, "index"]);

    // Products

    $router->get("/products", [ProductController::class, "index"]);

    $router->get("/product/{id:number}", [ProductController::class, "show"]);

    $router->map(["GET", "POST"], "/product/new", [ProductController::class, "create"]);

    // Roads

    $router->get("/wegen", [RoadController::class, "index"]);
    $router->get("/wegen/{id:number}", [RoadController::class, "show"]);
    $router->map(["GET", "POST"], "/wegen/create", [RoadController::class, "create"]);
    $router->map(["GET", "POST"], "/wegen/{id:number}/edit", [RoadController::class, "edit"]);
    $router->get("/wegen/{id:number}/delete", [RoadController::class, "delete"]);

};
