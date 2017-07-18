<?php

namespace Application;

//use Services\DbConnector;
use mysqli;
use AopAnnotation\Cacheable;
use Services\DbConnector;

class Student {

    private $dbConnection = null;

    public function __construct() {
        $dbConnector = new DbConnector();
        $this->dbConnection = $dbConnector->connect();
    }
    
    public function register($studentDetails) {
        $name = $studentDetails['name'];
        $email = $studentDetails['email'];
        $registered = $this->dbConnection->query(
            "INSERT INTO student ("
            . "name, email) "
            . "VALUES('$name', '$email')"
        );

        if ($registered) {
            return array(
                'id' => $this->dbConnection->insert_id,
                'name' => $name,
                'email' => $email
            );
        }
        return false;
    }

    /**
     * 
     * @Cacheable
     */
    public function getStudentDetails($studentId) {
        sleep(5);
        $studentDetails = $this->dbConnection->query(
            "SELECT * FROM student WHERE id = $studentId"
        )->fetch_array();
        if (!empty($studentDetails)) {
            return $studentDetails;
        }
        return 'no student details found';
    }

    public function updateStudentDetails($updatedData) {
        $studentId = $updatedData['id'];
        $name = $updatedData['name'];
        $email = $updatedData['email'];
        $updated = $this->dbConnection->query("UPDATE student "
            . "SET name='$name', email='$email' "
            . "WHERE id=$studentId"
        );

        if ($updated) {
            array(
                'name' => $name,
                'email' => $email
            );
        }
        return false;
    }

    private function isValidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

}
