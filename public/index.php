<?php

$loader = require __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

use App\Kernel;

$kernel = new Kernel(false, false);
$kernel->run();
