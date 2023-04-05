<?php

use UMA\DIC\Container;

require_once __DIR__ . '/../vendor/autoload.php';        //Подключается файл autoload.php из директории DIR/vendor/autoload.php

$settings = require __DIR__ . '/settings.php';       //Загружаются настройки из файла settings.php, который находится в директории DIR
$dependencies = require __DIR__ . '/dependencies.php';
$settings = array_merge($settings, $dependencies);

$container = new Container($settings);                //Создается новый экземпляр класса Container с передачей ему загруженных настроек.

return $container;

