<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
$dependencies($app);

// Register middleware
$middleware = require __DIR__ . '/../src/middleware.php';
$middleware($app);

// Register routes Hakim
$routes_hakim = require __DIR__ . '/../src/routes/routes_hakim.php';
$routes_hakim($app);

// Register routes  Pengadilan
$routes_pengadilan = require __DIR__ . '/../src/routes/routes_pengadilan.php';
$routes_pengadilan($app);

// Register routes Pengacara
$routes_pengacara = require __DIR__ . '/../src/routes/routes_pengacara.php';
$routes_pengacara($app);

// Register routes Bukti
$routes_bukti = require __DIR__ . '/../src/routes/routes_bukti.php';
$routes_bukti($app);

// Register routes Jaksa
$routes_jaksa = require __DIR__ . '/../src/routes/routes_jaksa.php';
$routes_jaksa($app);

// Register routes Saksi
$routes_saksi = require __DIR__ . '/../src/routes/routes_saksi.php';
$routes_saksi($app);

// Register routes Penggugat
$routes_penggugat = require __DIR__ . '/../src/routes/routes_penggugat.php';
$routes_penggugat($app);

// Register routes Tergugat
$routes_tergugat = require __DIR__ . '/../src/routes/routes_tergugat.php';
$routes_tergugat($app);

// Register routes Banding
$routes_banding = require __DIR__ . '/../src/routes/routes_banding.php';
$routes_banding($app);

// Register routes Kasus
$routes_kasus = require __DIR__ . '/../src/routes/routes_kasus.php';
$routes_kasus($app);

// Register routes Sidang
$routes_sidang = require __DIR__ . '/../src/routes/routes_sidang.php';
$routes_sidang($app);

// Register route Login
$routes_login = require __DIR__ . '/../src/routes/routes_login.php';
$routes_login($app);

// Run app
$app->run();
