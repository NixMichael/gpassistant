<?php

require_once 'Database.class.php';

class Login extends Database {
    public function logIn ($email) {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetchAll();
        return $user;
    }

    public function existingUser ($patientId, $email, $username) {
        $query = "SELECT * FROM users WHERE patient_id = :patientid";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['patientid'=>$patientId]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function registerUser ($patientId, $email, $username, $password, $admin = false) {
        $query = "INSERT INTO users (patient_id, username, email, password, admin) VALUES (:patientid, :username, :email, :password, :admin)";
        $stmt = $this->dbh->prepare($query);
        return $stmt->execute(['patientid'=>$patientId, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'admin'=>$admin]);
    }

    public function fetchUser ($email) {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email]);
        while($row = $stmt->fetch()) {
            return $row['username'];
        }
    }
}