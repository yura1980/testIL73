<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

// connect to the mysql database
$link = mysqli_connect('localhost', 'y80', '191980', 'y80_taxi');
mysqli_set_charset($link, 'utf8');

// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
$fval = array_shift($request);//+1;
$fval2 = array_shift($request);//+2;
$fval3 = array_shift($request);//+3;
$fval4 = array_shift($request);//+4;

// create SQL based on HTTP method
switch ($method) {
    case 'GET':
        if ($table == "test_il73") {
			    $sql = "select * from `$table`" . ($fval ? " WHERE id=" . $fval : '');
        } else {
			    $sql = "select * from `$table`" . ($fval ? " WHERE id=" . $fval : '');
        }
        break;
    case 'PUT':
        break;
    case 'POST':
        if ($table == "test_il73") {
            $fam = $input['fam'];
            $name = $input['name'];
            $otch = $input['otch'];
            $pol = $input['pol'];
            $dr = $input['dr'];
            $weight = $input['weight'];
			      $height = $input['height'];
            $sql = "insert into test_il73 (fam,name,otch,pol,dr,weight,height) " .
                "values('" . $fam . "','" . $name . "','" . $otch . "','" . $pol . "','" . $dr . "','" . $weight . "','" . $height . "')";
        }
        break;
    case 'DELETE':
        $sql = "delete `$table` where id=$fval";
        break;
}

// excecute SQL statement
$result = mysqli_query($link, $sql);

// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error());
}

// print results, insert id or affected row count
if ($method == 'GET') {
    if (mysqli_num_rows($result) > 1) echo '[';
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        echo ($i > 0 ? ',' : '') . json_encode(mysqli_fetch_object($result));
    }
    if (mysqli_num_rows($result) > 1) echo ']';
} elseif ($method == 'POST') {
    echo mysqli_insert_id($link);
} else {
    echo mysqli_affected_rows($link);
}

// close mysql connection
mysqli_close($link);

?>

