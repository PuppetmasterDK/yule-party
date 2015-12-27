<?php

require __DIR__ . '/../src/boot.php';

$router = new AltoRouter();

$mustache = new Mustache_Engine([
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../src/views'),
]);

// map homepage
$router->map( 'GET', '/', function() use($mustache) {
    $yuleparty = new \Lutzen\Models\YuleDate(\Carbon\Carbon::now());
    if ($yuleparty->isYulePartyStarted()) {
        $tpl = $mustache->loadTemplate('yuleparty');
    } else {
        $tpl = $mustache->loadTemplate('no-yuleparty');
    }

    $yulepartyDate = $yuleparty->getYulePartyDate();
    echo $tpl->render(array(
        'countdownDate' => $yulepartyDate->format("Y/m/d H:i:s"),
        'date' => $yulepartyDate->toDateTimeString(),
    ));
});

// map users details page
$router->map( 'GET', '/[i:year]/', function( $year ) {
    echo $year;
});
// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
/*
if (!empty($_GET['year']) && is_numeric($_GET['year'])) {
    $date = \Carbon\Carbon::create((int) $_GET['year']);
} else {
    $date =  \Carbon\Carbon::now();
}

$yuleparty = new \Lutzen\Models\YuleDate($date);
$mustache = new Mustache_Engine([
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../src/views'),
]);

if ($yuleparty->isYulePartyStarted()) {
    $tpl = $mustache->loadTemplate('yuleparty');
} else {
    $tpl = $mustache->loadTemplate('no-yuleparty');
}


echo $tpl->render(array('date' => $yuleparty->getYulePartyDate()->toDateTimeString()));
*/