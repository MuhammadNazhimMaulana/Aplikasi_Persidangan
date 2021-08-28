<?php

use Slim\App;


return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    //middleware untuk validasi token JWT 
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "path" => ["/witness", "/proofs", "/meetings", "/litigants", "/defendants", "/cases"], /* or ["/api", "/admin"] */
        "secure" => false,
        "attribute" => "decoded_token_data",
        "secret" => "iniadalahkunciyangrahasia",
        "algorithm" => ["HS256"],
        "error" => function ($res, $args) {
            $data["status"] = "error";
            $data["message"] = $args["message"];
            return $res
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    ]));
};
