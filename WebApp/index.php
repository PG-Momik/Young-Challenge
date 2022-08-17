<?php


require_once '../API/Models/Sales.php';
$salesTable = new Sales('../DB');

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $page = $_GET['page'] ?? null;
        $pageDataSet = is_null($page) ? $salesTable->getAll() : $salesTable->getAll($page);
        loadView($salesTable, $pageDataSet);
        break;
    default:
        echo "Invalid Request";
        break;
}
?>
<?php
function showRow($row): void
{
    foreach ($row as $item) {
        echo "<td>$item</td>";
    }
}
?>

<?php
function loadView($salesTable, $pageDataSet): void
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
    <section class="px-5 py-2">
        <h1>Petroleum Report</h1>
        <hr>
<!--        Row1-->
        <div class="row justify-content-evenly">
            <!--        Total Sales-->
            <div class="col-lg-6">
                <h2>Total Sales <i class="fa-solid fa-sack-dollar"></i></h2>
                <?php
                $resultSet = $salesTable->getTotalSalesByProducts() ?>
                <table class="table table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Total Sale</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($resultSet as $row) {
                        echo "<tr>";
                        showRow($row);
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!--            Winners and Losers-->
            <div class="col-lg-4">
                <?php
                $resultSet = $salesTable->getWinners() ?>
                <!--                Winners-->
                <div class="row my-2">
                    <h2>Top Winners <i class="fa-solid fa-trophy"></i> </h2>
                    <table class="table  table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Sales</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($resultSet as $row) {
                            echo "<tr>";
                            showRow($row);
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                $resultSet = $salesTable->getLosers() ?>
                <!--                Losers-->
                <div class="row my-2">
                    <h2>Top Losers <i class="fa-solid fa-sad-tear"></i> </h2>
                    <table class="table  table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Sales</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($resultSet as $row) {
                            echo "<tr>";
                            showRow($row);
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--        Row2-->
        <div class="row justify-content-evenly">
            <!--            All Sales-->
            <div class="col-lg-6">
                <h2>All Sales <i class="fa-solid fa-bookmark"></i></h2>
                <?php
                    $max = $salesTable->getCountOfRecord();
                    $maxNoZero =  $salesTable->getCountOfRecord(true);
                ?>
                <h4>All entries: <?=$max?></h4>
                <h5>Entries greater than zero: <?=$maxNoZero?></h5>
                <div class="row justify-content-end">
                    <?php
                    $pageNo = ceil($max / 15);
                    ?>
                    <form action="">
                        Select Page:
                        <select name="page" id=""  style="padding: 4px">
                            <?php
                            for($i=1; $i<=$pageNo; $i++){
                                echo "<option>{$i}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-dark">
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </form>
                </div>
                <table class="table table-striped my-1" id="imp-table">
                    <?php
                    $resultSet = $salesTable->getAll() ?>
                    <thead class="table-dark">
                    <tr>
                        <th>Year</th>
                        <th>Country</th>
                        <th>Product</th>
                        <th>Sale</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pageDataSet as $row){
                        echo "<tr>";
                        showRow($row);
                        echo "</tr>";
                    }?>
                    </tbody>
                </table>
            </div>
            <!--            4 Year Average-->
            <div class="col-lg-4">
                <?php
                $years = array(
                    2007,
                    2010,
                    2011,
                    2014
                );
                $result_2007_2010 = $salesTable->getAverage($years[0], $years[1]);

                $result_2011_2014 = $salesTable->getAverage($years[2], $years[3]);
                ?>
                <h2>4 Year Average <i class="fa-solid fa-calendar"></i></h2>
                <table class="table table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Year</th>
                        <th>Product</th>
                        <th>Avg Sale</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $length = sizeof($result_2007_2010);
                    for ($i = 0; $i < $length; $i++) { ?>
                        <tr>
                            <td><?= $years[0] . "-" . $years[1] ?></td>
                            <?php
                            showRow($result_2007_2010[$i]); ?>
                        </tr>
                        <tr>
                            <td><?= $years[2] . "-" . $years[3] ?></td>
                            <?php
                            showRow($result_2011_2014[$i]); ?>
                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="assets/all.min.js"></script>
    <script>
        table = document.getElementsByTagName("table");
        for (let i = 0; i < table.length; i++) {
            table[i].addEventListener("mouseover", function () {
                table[i].classList.add("shadow-lg")
            })
            table[i].addEventListener("mouseout", function () {
                table[i].classList.remove("shadow-lg")
            })

        }
    </script>
    </body>
 </html>
<?php
}
?>