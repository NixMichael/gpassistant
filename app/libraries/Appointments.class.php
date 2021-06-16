<?php

require_once 'Database.class.php';

class Appointments extends Database {
    public function addAppointment ($day, $time) {
        $query = "INSERT INTO appointments (day, time) VALUES (:day, :time)";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['day'=>$day, 'time'=>$time]);

        $query = "SELECT id FROM appointments WHERE id = LAST_INSERT_ID()";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result[0]['id'];
    }

    public function addAppointmentNote ($appt_id, $message, $patientid, $senderType) {
        $query = "INSERT INTO messages (patient_id, message, date, sender) VALUES (:patientid, :message, NOW(), :sender)";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['patientid'=>$patientid, 'message'=>$message, 'sender'=>$senderType]);

        $query = "SELECT message_id FROM messages WHERE message_id = LAST_INSERT_ID()";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute();

        $messageAdded = $stmt->fetch();
        $messageAdded = $messageAdded['message_id'];

        // **************

        $query = "UPDATE appointments SET notes = :msgid, username = :patient WHERE id = $appt_id";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['msgid'=>$messageAdded, 'patient'=>$patientid]);
    }

    public function removeAppointment ($day, $time) {
        $query = "DELETE FROM appointments WHERE day = :day AND time = :time";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['day'=>$day, 'time'=>$time]);
    }

    public function fetchAppointments ($user) {
        $query = "SELECT id, day, time, notes, doctor_id FROM appointments WHERE username = :username";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['username'=>$user]);

        $results = $stmt->fetchAll();

        return $results;
    }

    public function cancelAppointment ($id, $time) {
        $query = "DELETE FROM appointments WHERE id = :id AND time = :time";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['id'=>$id, 'time'=>$time]);
    }

    public function checkTimes ($day) {

        $query = "SELECT time FROM appointments WHERE day = :date";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['date'=>$day]);

        $result = $stmt->fetchAll();

        $sel = [];
        foreach($result as $r) {
            $sel[] = $r['time'];
        }
        return $sel;
    }

    public function getAllAppointments ($doctorId) {
        $query = "SELECT * FROM appointments WHERE doctor_id = :doctorid OR accepted IS NULL";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['doctorid'=>$doctorId]);

        $apptList = $stmt->fetchAll();

        return $apptList;
    }

    public function confirmAppointment ($apptId, $doctorId) {
        $query = "UPDATE appointments SET accepted = true, doctor_id = :doctor WHERE id = :id";

        $stmt = $this->dbh->prepare($query);

        if ($stmt->execute(['doctor'=>$doctorId, 'id'=>$apptId])) {
            return true;
        } else {
            return false;
        }
    }
}