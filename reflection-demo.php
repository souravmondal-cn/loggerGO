<?php

require_once __DIR__ . '/src/Application/Student.php';

$student = new Application\Student();

$reflectionClass = new ReflectionClass('Application\Student');

echo 'get all the methods' . PHP_EOL;
print_r($reflectionClass->getMethods());

echo 'get a specific method' . PHP_EOL;
print_r($reflectionClass->getMethod('register'));

echo 'get class properties' . PHP_EOL;
print_r($reflectionClass->getProperties());

$reflectionMethod = new ReflectionMethod('Application\Student', 'register');

echo 'get params of the method' . PHP_EOL;
print_r($reflectionMethod->getParameters());

echo 'get return type of the method' . PHP_EOL;
print_r($reflectionMethod->getReturnType());

echo 'call the method' . PHP_EOL;
print_r($reflectionMethod->invokeArgs($student, [array(
        'name' => 'Sourav Mondal',
        'email' => 'souravm@capitalnumbers.com'
)]));


//for private methods
$reflectionMethod2 = new ReflectionMethod('Application\Student', 'isValidEmail');

$reflectionMethod2->setAccessible(true);

echo 'call the method' . PHP_EOL;
print_r($reflectionMethod2->invokeArgs($student, ['souravm@capitalnumbers.com']));

echo PHP_EOL;