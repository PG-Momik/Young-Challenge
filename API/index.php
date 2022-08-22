<?php

/*format : baseurl/entity/operation/optional
 *example: localhost/API/getAll
 *      : localhost/API/getAll/2
 *     : localhost/API/average/2010-2017
*/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST, READ, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$url  =  $_SERVER['REQUEST_URI'];
$keys = explode('/', $url);

if(in_array("Challenge", $keys)){
    $entity = $keys[3]??"wrong";
    $operation = $keys[4]??"wrong";
    $options= $keys[5]??null;    
}else{
    $entity =$keys[2]??"wrong";
    $operation = $keys[3]??"wrong";
    $options= $keys[4]??null;
}

require_once 'Models/Sales.php';

switch ($_SERVER['REQUEST_METHOD']){
    case "GET":
        switch ($entity){
            case "sales":
                $salesTable = new Sales('../DB');
                switch ($operation){
                    case "all":
                        $page = 1;
                        if(!is_null($options)){
                            $page = $options;
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
                        if(!is_null($options)){
                            $num = $options;
                        }
                        $result  = $salesTable->getWinners($num);
                        echo json_encode($result);
                        break;
                    case "losers":
                        $num = 3;
                        if(!is_null($options)){
                            $num = $options;
                        }
                        $result  = $salesTable->getLosers($num);
                        echo json_encode($result);
                        break;
                    case "average":
                        if(is_null($options)){
                            echo json_encode(array("Invalid URL format."));
                            break;
                        }
                        $years = explode("-", $options);
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
