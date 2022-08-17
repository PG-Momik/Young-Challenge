<?php


require_once '../API/Models/Sales.php';
$salesTable = new Sales('../DB');

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $page = $_GET['page'] ?? null;
        loadView($page);
        break;
    default:
        echo "Invalid Request";
        break;
}
?>


<?php
function loadView($page): void
{
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Young Challenge</title>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <link rel="stylesheet" href="assets/all.min.css">
    </head>
    <body>
        <?=$page?>
    </body>
 </html>
<?php
}
?>