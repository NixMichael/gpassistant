<?php

require_once 'Database.class.php';

class Login extends Database {
    public function logIn ($email) {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function existingUser ($email, $username) {
        $query = "SELECT * FROM users WHERE email = :email OR username = :username";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email, 'username'=>$username]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function registerUser ($email, $username, $password) {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->dbh->prepare($query);
        return $stmt->execute(['username'=>$username, 'email'=>$email, 'password'=>$password]);
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