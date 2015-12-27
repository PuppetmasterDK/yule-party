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
        'date' => $yulepartyDate->formatLocalized("%d. %B %Y kl. %H:%M"),
    ));
});

// map users details page
$router->map( 'GET', '/[i:year]/?', function( $year ) use($mustache) {
    $date = \Carbon\Carbon::create((int) $year);
    $yuleparty = new \Lutzen\Models\YuleDate($date);
    $tpl = $mustache->loadTemplate('historic-yuleparty');
    $yulepartyDate = $yuleparty->getYulePartyDate();
    echo $tpl->render(array(
        'future' => $year > date('Y') ? 'er': 'var',
        'year' => (int) $year,
        'date' => $yulepartyDate->formatLocalized("%d. %B kl. %H:%M"),
    ));
});
// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header( "Location: /");
}