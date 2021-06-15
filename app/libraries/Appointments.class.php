<?php

require_once 'Database.class.php';

class Appointments extends Database {
    public function addAppointment ($day, $time) {
        $query = "INSERT INTO appointments (day, time) VALUES (:day, :time)";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['day'=>$day, 'time'=>$time]);
    }

    public function addAppointmentNote ($day, $time, $note, $patient) {
        $query = "UPDATE appointments SET notes = :note, username = :patient WHERE day = :day AND time = :time";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['day'=>$day, 'time'=>$time, 'note'=>$note, 'patient'=>$patient]);
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
        $query = "SELECT * FROM appointments WHERE doctor_id = :doctorid OR accepted = false";

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