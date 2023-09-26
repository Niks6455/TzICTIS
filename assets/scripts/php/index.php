<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new mysqli("localhost", "root", "", "ICTISBD");

    if ($db->connect_error) {
        die("Ошибка подключения к базе данных: " . $db->connect_error);
    }

    // Обработка данных заявки
    $start_date = $_POST["start-date"];
    $end_date = $_POST["end-date"];
    $file = $_FILES["file"]["name"];
    $number_of_people = $_POST["number-of-people"];
    $message = "Начало командировки: " . $start_date . "\n";//сообщение для почты
    $message .= "Конец командировки: " . $end_date . "\n";//сообщение для почты
    $message .= "Количество людей: " . $number_of_people . "\n";//сообщение для почты

    // Вставляем данные заявки в таблицу заявок
    $insert_query = "INSERT INTO заявки (начало_командировки, конец_командировки, файл, количество_человек)
                     VALUES ('$start_date', '$end_date', '$file', $number_of_people)";
    
    if ($db->query($insert_query) === TRUE) {
        $last_insert_id = $db->insert_id; // Получаем ID последней вставленной записи

        // Обработка данных о человеках
        for ($i = 0; $i < $number_of_people; $i++) {
            $name = $_POST["name-$i"];
            $position = $_POST["position-$i"];
            $department = $_POST["department-$i"];
            $email = $_POST["email-$i"];
            $phone = $_POST["phone-$i"];

            $message .= "\nДанные о человеке " . ($i + 1) . ":\n";//сообщение для почты
            $message .= "Имя: " . $name . "\n";//сообщение для почты
            $message .= "Должность: " . $position . "\n";//сообщение для почты
            $message .= "Кафедра: " . $department . "\n";//сообщение для почты
            $message .= "Email: " . $email . "\n";//сообщение для почты
            $message .= "Номер телефона: " . $phone . "\n";//сообщение для почты

            // Вставляем данные о человеке в таблицу людей, связанную с заявкой
            $insert_person_query = "INSERT INTO люди (заявка_id, ФИО, должность, кафедра, email, номер_телефона)
                                    VALUES ($last_insert_id, '$name', '$position', '$department', '$email', '$phone')";
            
            $db->query($insert_person_query);
        }

        // Отправка данных на почту
        $to = "moodbok@gmail.com";
        $subject = "Заявка на командировку";
      

        $headers = "From: 7929189niks64@gmail.com" . "\r\n" .
            "Reply-To: 7929189niks64@gmail.com";
          
        error_log($message, 3, "log.txt");
        if (mail($to, $subject, $message, $headers)) {
            echo "Данные успешно отправлены на почту!";
        } else {
            echo "Ошибка при отправке данных на почту.";
        }

        header("Location: ../../pages/confirm.html");
        exit;
    } else {
        echo "Ошибка при вставке данных в базу данных: " . $db->error;
    }

    $db->close();
}
?>