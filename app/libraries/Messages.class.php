<?php

require_once 'Database.class.php';

class Messages extends Database {
    public function addMessage ($user, $message, $senderType) {
        $query = "INSERT INTO messages (username, message, date, sender) VALUES (:username, :message, NOW(), :sender)";

        $stmt = $this->dbh->prepare($query);

        if ($stmt->execute(['username'=>$user, 'message'=>$message, 'sender'=>$senderType])) {
            return true;
        } else {
            return false;
        }
    }

    public function fetchMessages ($user, $showAll = false) {
        $limit = !$showAll ? "LIMIT 2" : "";
        $query = "SELECT message, date, sender FROM messages WHERE username = :username ORDER BY date DESC $limit";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['username'=>$user]);

        if ($result = $stmt->fetchAll()) {
            $sel = [];
            foreach($result as $r) {
                $msgs['date'] = $r['date'];
                $msgs['msg'] = $r['message'];
                $msgs['sender'] = $r['sender'];
                $sel[] = $msgs;
            }
    
        } else {
            $msgs['error'] = 'Failed to fetch messages';
            $sel[] = $msgs;
        }

        return $sel;

    }
}