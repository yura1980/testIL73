<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
require 'vendor/autoload.php';

//константы подключения к базе данных
define('DB_HOST', 'localhost');
define('DB_USER', 'y80');
define('DB_PASS', '191980');
define('DB_NAME', 'y80_taxi');

//находим url
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$fval = array_shift($request);

//подключение к БД
function connect()
{
    $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);
    if (mysqli_connect_errno($connect)) {
        die("Failed to connect:" . mysqli_connect_error());
    }
    mysqli_set_charset($connect, "utf8");
    return $connect;
}

//расчет возраста по дате рождения
function getFullYears($birthdayDate) {
    $datetime = new DateTime($birthdayDate);
    $interval = $datetime->diff(new DateTime(date("Y-m-d")));
    return $interval->format("%Y");
}
$con = connect();
$policies = [];
$table = 'test_il73';
$sql = "select * from `$table` WHERE id = '" . $fval . "' LIMIT 1";

//собираем данные для шаблона
if ($result = mysqli_query($con, $sql)) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $policies[$i] = $row;
        $i++;
    }
} else {
    http_response_code(404);
}
mysqli_close($con);
///////////

$phpWord = new  \PhpOffice\PhpWord\PhpWord();
//загрузим файл шаблона
$document = $phpWord->loadTemplate('Template.docx'); //шаблон Template.docx
//заполнение данными файла шаблона
$document->setValue('d_fam', $policies[0]['fam']);
$document->setValue('d_name', $policies[0]['name']);
$document->setValue('d_otch', $policies[0]['otch']);
$document->setValue('d_pol', $policies[0]['pol']=='0'?'Мужской':'Женский');
$document->setValue('d_vzr', getFullYears($policies[0]['dr']));
$document->setValue('d_ves', $policies[0]['weight']);
$document->setValue('d_rost', $policies[0]['height']);
$document->setValue('d_id', $policies[0]['id']);

//сохраним файл
$document->saveAs('first.docx');
download_file('first.docx', 'first.docx');

//отправка фала пользователю
function download_file($file, $name) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $name);
    exit(readfile($file));
}
