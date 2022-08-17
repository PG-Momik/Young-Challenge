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
;
                        break;
                    case "winners":

                        break;
                    case "losers":
           
                        break;
                    case "average":

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
