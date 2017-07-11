<?php

namespace Application;

use Exception;

class Student {

    protected $name = '';
    protected $email = '';

    public function register($studentDetails) {
        $this->name = $studentDetails['name'];
        $this->email = $studentDetails['email'];
        return array(
            'name' => $this->name,
            'email' => $this->email
        );
    }

    public function getStudentDetails() {
        return array(
            'name' => $this->name,
            'email' => $this->email
        );
    }

    public function updateStudentDetails($updatedData) {
        $this->name = $updatedData['name'];
        $this->email = $updatedData['email'];
        return array(
            'name' => $this->name,
            'email' => $this->email
        );
    }

    private function isValidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

}
