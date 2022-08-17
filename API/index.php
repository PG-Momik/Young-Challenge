<?php

/*format : baseurl/entity/operation/optional
 *example: localhost/Challenge/API/getAll
 *      : localhost/Challenge/API/getAll/2
 *     : localhost/Challenge/API/average/2010-2017
*/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST, READ, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$url  =  $_SERVER['REQUEST_URI'];
$keys = explode('/', $url);
$entity = $keys[2];
$operation = $keys[3];

require_once 'Models/Sales.php';

switch ($_SERVER['REQUEST_METHOD']){
    case "GET":
        switch ($entity){
            case "sales":
                $salesTable = new Sales('../DB');
                switch ($operation){
                    case "all":
                        $page = 1;
                        if(isset($keys[4])){
                            $page = $keys[4];
                        }
                        $result  = $salesTable->getAll(page:$page);
                        echo json_encode($result);
                        break;
                    case "products":
                        $result  = $salesTable->getTotalSalesByProducts();
                        echo json_encode($result);
                        break;
                    case "winners":
                        $num = 3;
                        if(isset($keys[4])){
                            $num = $keys[4];
                        }
                        $result  = $salesTable->getWinners($num);
                        echo json_encode($result);
                        break;
                    case "losers":
                        $num = 3;
                        if(isset($keys[4])){
                            $num = $keys[4];
                        }
                        $result  = $salesTable->getLosers($num);
                        echo json_encode($result);
                        break;
                    case "average":
                        if(!isset($keys[4])){
                            echo json_encode(array("Invalid URL format."));
                            break;
                        }
                        $years = explode("-", $keys[4]);
                        $result  = $salesTable->getAverage($years[0], $years[1]);
                        echo json_encode($result);

                        break;
                    default:
                        echo json_encode(array("400 Invalid Operation."));
                }
                break;
            default:
                echo json_encode(array("Under construction"));
                break;
        }
        break;
    default:
        echo json_encode(array("Illegal Method."));
        break;
}
