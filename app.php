<?php

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/config.php';

use Application\Student;
use AopAnnotation\ApplicationAspectKernel;
use Faker\Factory;

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
$faker = Factory::create();

//getting dummy data with faker
$fakerStudentName = $faker->name();
$fakerStudentEmail = $faker->email();

$newStudentDetails = $student->register(array(
    'name' => $fakerStudentName,
    'email' => $fakerStudentEmail
));

$newlyRegisterId = $newStudentDetails['id'];
echo 'Initiated With -> ' . json_encode($student->getStudentDetails($newlyRegisterId)) . PHP_EOL;

//generating dummy data with faker for updation
$fakerUpdatedStudentName = $faker->name();
$fakerUpdatedStudentEmail = $faker->email();

$student->updateStudentDetails(array(
    'id' => $newlyRegisterId,
    'name' => $fakerUpdatedStudentName,
    'email' => $fakerUpdatedStudentEmail
));

echo 'Updated Details -> ' . json_encode($student->getStudentDetails($newlyRegisterId)) . PHP_EOL;