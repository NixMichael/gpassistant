<?php

class Database {
    private $dbHost = DBHOST;
    private $dbUser = DBUSER;
    private $dbPass = DBPASS;
    private $dbName = DBNAME;
    private $charset = CHARSET;
    private $dsn = '';
    private $dbh;

    public function __construct() {
        $dsn = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];
        
        try {
            $this->dbh = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function logIn ($email) {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function existingUser ($email, $username) {
        $query = "SELECT * FROM users WHERE email = :email OR name = :username";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['email'=>$email, 'username'=>$username]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function registerUser ($email, $username, $password) {
        $query = "INSERT INTO users (name, email, password) VALUES (:username, :email, :password)";
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

    public function fetchMessages ($username) {
        $query = "SELECT * from messages Where username = :username";

        $stmt = $this->dbh->prepare($query);
        return $stmt->execute(['username'=>$username]);
    }

    public function query () {
        $query = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['id'=>1]);

        while($row = $stmt->fetch()) {
            echo $row['name'];
        }
    }

    public function addAppointment ($day, $time, $note) {
        $query = "INSERT INTO appointments (day, time, note) VALUES (:day, :time, :note)";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['day'=>$day, 'time'=>$time, 'note'=>$note]);
    }

    public function checkTimes ($day) {
        // $query = "SELECT time FROM appointments WHERE day = :date";

        // $stmt = $this->dbh->prepare($query);
        // return $stmt->execute(['date' => $day]);

        $query = "SELECT time from appointments WHERE day = :date";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['date'=>$day]);

        $result = $stmt->fetchAll();

        $sel = [];
        foreach($result as $r) {
            $sel[] = $r['time'];
        }
        return $sel;
    }
}