<?php 
    require_once '../../app/config.php';
    require_once '../../app/libraries/Appointments.class.php';

    if (isset($_POST['apptid'])) {
        $conn = new Appointments();
        session_start();
        $doctorId = $_SESSION['username'];

        $appointmentId = $_POST['apptid'];

        if ($conn->confirmAppointment($appointmentId, $doctorId)) {
            header('Location: /appointments.php');
        } else {
            echo 'error';
        }
}

?>