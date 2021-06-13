<?php

class Database {
    protected $dbHost = DBHOST;
    protected $dbUser = DBUSER;
    protected $dbPass = DBPASS;
    protected $dbName = DBNAME;
    protected $charset = CHARSET;
    protected $dsn = '';
    protected $dbh;

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

    // public function logIn ($email) {
    //     $query = "SELECT * FROM users WHERE email = :email";

    //     $stmt = $this->dbh->prepare($query);
    //     $stmt->execute(['email'=>$email]);
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $user;
    // }

    // public function existingUser ($email, $username) {
    //     $query = "SELECT * FROM users WHERE email = :email OR username = :username";

    //     $stmt = $this->dbh->prepare($query);
    //     $stmt->execute(['email'=>$email, 'username'=>$username]);
    //     $count = $stmt->rowCount();
    //     return $count;
    // }

    // public function registerUser ($email, $username, $password) {
    //     $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    //     $stmt = $this->dbh->prepare($query);
    //     return $stmt->execute(['username'=>$username, 'email'=>$email, 'password'=>$password]);
    // }

    // public function fetchUser ($email) {
    //     $query = "SELECT * FROM users WHERE email = :email";

    //     $stmt = $this->dbh->prepare($query);
    //     $stmt->execute(['email'=>$email]);
    //     while($row = $stmt->fetch()) {
    //         return $row['username'];
    //     }
    // }

    // DELETE THIS?

    public function query () {
        $query = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['id'=>1]);

        while($row = $stmt->fetch()) {
            echo $row['name'];
        }
    }

    // public function addAppointment ($day, $time) {
    //     $query = "INSERT INTO appointments (day, time) VALUES (:day, :time)";

    //     $stmt = $this->dbh->prepare($query);

    //     return $stmt->execute(['day'=>$day, 'time'=>$time]);
    // }

    // public function addAppointmentNote ($day, $time, $note, $patient) {
    //     $query = "UPDATE appointments SET notes = :note, username = :patient WHERE day = :day AND time = :time";

    //     $stmt = $this->dbh->prepare($query);

    //     return $stmt->execute(['day'=>$day, 'time'=>$time, 'note'=>$note, 'patient'=>$patient]);
    // }

    // public function removeAppointment ($day, $time) {
    //     $query = "DELETE FROM appointments WHERE day = :day AND time = :time";

    //     $stmt = $this->dbh->prepare($query);

    //     return $stmt->execute(['day'=>$day, 'time'=>$time]);
    // }

    // public function fetchAppointments ($user) {
    //     $query = "SELECT id, day, time, notes, doctor_id FROM appointments WHERE username = :username";

    //     $stmt = $this->dbh->prepare($query);

    //     $stmt->execute(['username'=>$user]);

    //     $results = $stmt->fetchAll();

    //     return $results;
    // }

    // public function cancelAppointment ($id, $time) {
    //     $query = "DELETE FROM appointments WHERE id = :id AND time = :time";

    //     $stmt = $this->dbh->prepare($query);

    //     $stmt->execute(['id'=>$id, 'time'=>$time]);
    // }

    // public function checkTimes ($day) {

    //     $query = "SELECT time FROM appointments WHERE day = :date";

    //     $stmt = $this->dbh->prepare($query);
    //     $stmt->execute(['date'=>$day]);

    //     $result = $stmt->fetchAll();

    //     $sel = [];
    //     foreach($result as $r) {
    //         $sel[] = $r['time'];
    //     }
    //     return $sel;
    // }

    // public function addMessage ($user, $message, $senderType) {
    //     $query = "INSERT INTO messages (username, message, date, sender) VALUES (:username, :message, NOW(), :sender)";

    //     $stmt = $this->dbh->prepare($query);

    //     if ($stmt->execute(['username'=>$user, 'message'=>$message, 'sender'=>$senderType])) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function fetchMessages ($user, $showAll = false) {
    //     $limit = !$showAll ? "LIMIT 2" : "";
    //     $query = "SELECT message, date, sender FROM messages WHERE username = :username ORDER BY date DESC $limit";
    //     $stmt = $this->dbh->prepare($query);
    //     $stmt->execute(['username'=>$user]);

    //     if ($result = $stmt->fetchAll()) {
    //         $sel = [];
    //         foreach($result as $r) {
    //             $msgs['date'] = $r['date'];
    //             $msgs['msg'] = $r['message'];
    //             $msgs['sender'] = $r['sender'];
    //             $sel[] = $msgs;
    //         }
    
    //     } else {
    //         $msgs['error'] = 'Failed to fetch messages';
    //         $sel[] = $msgs;
    //     }

    //     return $sel;

    // }
}