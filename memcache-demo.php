<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Services/DbConnector.php';

$dbConnector = new \Services\DbConnector();
$db = $dbConnector->connect();
//data generation part
$faker = Faker\Factory::create();

for ($i = 0; $i < 40000; $i++) {
    $emp_name = $faker->name;
    $emp_number = $faker->uuid;
    $emp_email = $faker->email;
    $sql_employee_insert = "INSERT INTO employees (emp_name, emp_email, emp_number) VALUES ('$emp_name','$emp_email', '$emp_number')";
    $db->query($sql_employee_insert);
}



//data fetching part
function get_all_employees($db) {
    $all_employees = array();
    $memcache = new Memcache();
    $memcache->addServer('localhost');
    $all_employees = $memcache->get('allEmployees');
    if (!$all_employees) {
        echo 'Getting data from db and generating cache' . PHP_EOL;
        $sql_fetch_all_employees = "SELECT * FROM employees";
        $all_employees_result = $db->query($sql_fetch_all_employees)->fetch_all(MYSQLI_ASSOC);
        foreach ($all_employees_result as $single_employee) {
            $all_employees[] = $single_employee['emp_name'];
        }
        $memcache->set('allEmployees', $all_employees);
        return $all_employees;
    }
    echo 'getting result from cache' . PHP_EOL;
    return $all_employees;
}
//calling the function
get_all_employees($db);


//deleting data from memcache
$memcache = new Memcache();
$memcache->addServer('localhost');
$memcache->delete('allEmployees');