<?php
// Your shell script
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Ratchet\App;

    $memcache = new Memcache;
    $memcache->connect('localhost', 11211);

    $session = new SessionProvider(
        new MyApp
      , new Handler\MemcacheSessionHandler($memcache)
    );

    $server = new App('localhost');
    $server->route('/intercambio_de_perfiles/index/dashboard', $session);
    $server->run();