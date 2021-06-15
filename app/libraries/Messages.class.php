<?php

require_once 'Database.class.php';

class Messages extends Database {
    public function addMessage ($user, $message, $senderType) {
        $query = "INSERT INTO messages (patient_id, message, date, sender) VALUES (:patientid, :message, NOW(), :sender)";

        $stmt = $this->dbh->prepare($query);

        if ($stmt->execute(['patientid'=>$user, 'message'=>$message, 'sender'=>$senderType])) {
            return true;
        } else {
            return false;
        }
    }

    public function fetchMessages ($user, $showAll = false, $admin = false) {
        $limit = !$showAll ? "LIMIT 2" : "";

        if ($admin != 1) {
            $query = "SELECT * FROM messages WHERE patient_id = :patientid ORDER BY date DESC $limit";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute(['patientid'=>$user]);
        } else {
            $query = "SELECT * FROM messages WHERE sender = 'P' ORDER BY date DESC $limit";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
        }

        if ($result = $stmt->fetchAll()) {
            $sel = [];
            foreach($result as $r) {
                $msgs['msgid'] = $r['message_id'];
                $msgs['patientid'] = $r['patient_id'];
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

    public function fetchMessageStream ($patientid) {
        $query = "SELECT * FROM messages WHERE patient_id = :pid";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['pid'=>$patientid]);

        $result = $stmt->fetchAll();

        return $result;
    }
}