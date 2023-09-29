<?php
require_once __DIR__ . './../../../vendor/autoload.php';
$settings = require_once __DIR__ . './settings.php';
require_once __DIR__ . './function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new mysqli("localhost", "root", "", "ICTISBD2");
    if ($db->connect_error) {
        die("Ошибка подключения к базе данных: " . $db->connect_error);
    }

    // Обработка данных заявки
    $start_date = $_POST["start-date"];
    $end_date = $_POST["end-date"]; 
    $file = $_FILES['file']['tmp_name']; 
    $filename = $_FILES['file']['name']; 
    $filename_only = basename($filename);
    $number_of_people = $_POST["number-of-people"];
    $message = "Начало командировки: " . $start_date . "\n";
    $message .= "Конец командировки: " . $end_date . "\n";
    $message .= "Количество людей: " . $number_of_people . "\n";


    // Перемещение загруженного файла в нужную директорию
    //$target_dir = "uploads/"; 
    //$target_file = $target_dir . basename($filename);
    //move_uploaded_file($file, $target_file);


    $insert_query = "INSERT INTO заявки (начало_командировки, конец_командировки, файл, количество_человек)
                     VALUES ('$start_date', '$end_date', '$filename_only', $number_of_people)";
    
    if ($db->query($insert_query) == TRUE) {
        $last_insert_id = $db->insert_id; 

        // Обработка данных о человеках
        for ($i = 0; $i < $number_of_people; $i++) {
            $name = $_POST["name-$i"];
            $position = $_POST["position-$i"];
            $department = $_POST["department-$i"];
            $email = $_POST["email-$i"];
            $phone = $_POST["phone-$i"];

            $message .= "\nДанные о человеке " . ($i + 1) . ":\n";
            $message .= "Имя: " . $name . "\n";
            $message .= "Должность: " . $position . "\n";
            $message .= "Кафедра: " . $department . "\n";
            $message .= "Email: " . $email . "\n";
            $message .= "Номер телефона: " . $phone . "\n";

            $insert_person_query = "INSERT INTO люди (заявка_id, ФИО, должность, кафедра, email, номер_телефона)
                                    VALUES ($last_insert_id, '$name', '$position', '$department', '$email', '$phone')";
            
            $db->query($insert_person_query);
        }

        // Отправка данных на почту
        $body = "$message";
        send_mail($settings['mail_settings_prod'], 'alis@sfedu.ru', 'заявка на командировку', $body, $file, $filename );

        header("Location: ../../pages/confirm.html");
        exit;
    } else {
        echo "Ошибка при вставке данных в базу данных: " . $db->error;
    }

    $db->close();
}
?>
