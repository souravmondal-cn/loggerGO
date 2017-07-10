<?php

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/config.php';

use Application\Student;
use AopAnnotation\ApplicationAspectKernel;

// Initialize an application aspect container
$applicationAspectKernel = ApplicationAspectKernel::getInstance();
$applicationAspectKernel->init(array(
    'debug' => true,
    'cacheDir' => CACHE_DIR,
    'includePaths' => array(
        __DIR__ . '/src/Application/'
    )
));


$student = new Student();

$student->register(array(
    'name' => 'Sourav Mondal',
    'email' => 'souravm@capitalnumbers.com'
));

echo 'Initiated With -> ' . json_encode($student->getStudentDetails()) . PHP_EOL;

$student->updateStudentDetails(array(
    'name' => 'Sourav1 Mondal',
    'email' => 'souravm2@capitalnumbers.com'
));

echo 'Updated Details -> ' . json_encode($student->getStudentDetails()) . PHP_EOL;
