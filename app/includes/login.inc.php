<?php

session_start();

require_once '../app/config.php';
// require_once '../app/libraries/Database.class.php';


define('DBNAME', 'gp_appt');
define('CHARSET', 'utf8mb4');

define('DBHOST', 'us-cdbr-east-04.cleardb.com');
define('DBUSER', 'b7fe4d33393ce4');
define('DBPASS', '918aad18');

class Database {
    private $dbHost = 'us-cdbr-east-04.cleardb.com';
    private $dbUser = 'b7fe4d33393ce4';
    private $dbPass = '918aad18';
    private $dbName = 'heroku_0c5f40e63f30201';
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
            return $row['name'];
        }
    }

    public function query () {
        $query = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['id'=>1]);

        while($row = $stmt->fetch()) {
            echo $row['name'];
        }
    }
}




$conn = new Database();

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = trim($email);
    $password = trim($password);

    if (!$email) {
        header('Location: /index.php?error=emptyemail');
        exit();
    }

    if (!$password) {
        header('Location: /index.php?error=emptypassword');
        exit();
    }

    // $user = $conn->logIn($email);

    if (password_verify($password, $user['password'])) {
        $_SESSION['useremail'] = $email;
        header('Location: /messages.php');
    } else {
        header('Location: /index.php?error=failedlogin');
    }
}