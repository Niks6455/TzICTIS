
<?php

    $start_date = $_POST["start-date"];
    $end_date = $_POST["end-date"];
    $number_of_people = $_POST["number-of-people"];

$message = "Начало командировки: " . $start_date . "\n";
$message .= "Конец командировки: " . $end_date . "\n";
$message .= "Количество людей: " . $number_of_people . "\n";

// Добавляем данные о каждом человеке
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
}

echo $message;
error_log($message, 3, "log.txt");
?>