<?php

require_once 'Database.class.php';

class Appointments extends Database {
    public function addAppointment ($date, $time) {
        $currentTime = time();

        $query = "INSERT INTO appointments (date, time, booking_time) VALUES (:date, :time, $currentTime)";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['date'=>$date, 'time'=>$time]);

        $query = "SELECT id FROM appointments WHERE id = LAST_INSERT_ID()";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result['id'];
    }

    public function addAppointmentNote ($appt_id, $message, $patientid, $senderType) {
        $query = "INSERT INTO messages (patient_id, message, date, sender, readreceipt) VALUES (:patientid, :message, NOW(), :sender, false)";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['patientid'=>$patientid, 'message'=>$message, 'sender'=>$senderType]);

        $query = "SELECT message_id FROM messages WHERE message_id = LAST_INSERT_ID()";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute();

        $messageAdded = $stmt->fetch();
        $messageAdded = $messageAdded['message_id'];

        // *** Update appointments with message id ***

        $query = "UPDATE appointments SET message_id = :msgid, patient_id = :ptid WHERE id = $appt_id";

        $stmt = $this->dbh->prepare($query);

        return $stmt->execute(['msgid'=>$messageAdded, 'ptid'=>$patientid]);
    }

    public function removeAppointment ($id) {
        $query = "DELETE FROM appointments WHERE id = $id";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute();
    }

    public function fetchAppointments ($user) {
        $query = "SELECT appointments.id, appointments.date, appointments.time, appointments.doctor_id, messages.message FROM appointments INNER JOIN messages ON appointments.message_id = messages.message_id WHERE appointments.patient_id = :ptid";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['ptid'=>$user]);

        $results = $stmt->fetch();

        return $results;
    }

    public function cancelAppointment ($id, $time) {
        $query = "DELETE FROM appointments WHERE id = :id AND time = :time";

        $stmt = $this->dbh->prepare($query);

        $stmt->execute(['id'=>$id, 'time'=>$time]);
    }

    public function checkTimes ($date) {

        $query = "SELECT id, time, booking_time FROM appointments WHERE date = :date";

        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['date'=>$date]);

        $result = $stmt->fetchAll();

        $times = [];
        foreach($result as $r) {
            $times[] = (object) ['time'=>$r['time'], 'bookedTime'=>$r['booking_time'], 'id'=>$r['id']];
            // $times[$r['time']] = $r['booked_times'];
        }
        return $times;
    }

    public function getAllAppointments ($doctorId) {
        $query = "SELECT appointments.id, appointments.date, appointments.time, appointments.accepted, appointments.patient_id, messages.message FROM appointments INNER JOIN messages ON appointments.message_id = messages.message_id WHERE doctor_id = :doctorid OR accepted IS NULL";

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