<?php
//connect database
$host='localhost';
$user='root';
$password='dbunicorn';
$dbName='informative_website';
$mysqli = new MySQLi($host,$user,$password,$dbName); 
if($mysqli -> connect_errno){
    die('DB connect error:' . $mysqli -> connect_error);
}
$mysqli->set_charset('UTF8'); 

$type = $_POST["type"];

if ($type=="visit") {
    $query = "SELECT * from visit";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $elements = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($elements);
}

if ($type=="purchase") {
    $query = "SELECT `date`, count(*) as 'purchase' from purchase group by `date`";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $elements = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($elements);
}

if ($type=="total_stay") {
    $query = "SELECT `date`, AVG(`stay_time`) as 'staytime' from staytime group by `date`";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $elements = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($elements);
}

if ($type=="purchase_stay") {
    $query = "SELECT `date`, AVG(`stay_time`) as 'staytime' from staytime WHERE `purchase`='true' group by `date`";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $elements = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($elements);
}

if ($type=="convert_ratio") {
    $query = "select purchase.date, purchase.a/visit.visits as 'convert' from (\n"

    . "(select date, count(*) a from purchase GROUP BY date) purchase,\n"

    . "(select date, visits from visit) visit\n"

    . ") WHERE purchase.date = visit.date";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $elements = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($elements);
}

if ($type=="purchase_info") {
    $limit = $_POST["limit"];
    $date = date("Y-m-d");
    if($limit!="all") {
        $query = "SELECT * from purchase WHERE date=? ORDER BY time DESC";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $date);
    } else {
        $query = "SELECT * from purchase ORDER BY date, time DESC";
        $stmt = $mysqli->prepare($query);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        echo 
        '<div class="order"> 
            <div class="row_between">
                <div class="purchase_info">
                    <div>Email:</div>
                    <div>'.$row["email"].'</div>
                </div>
                <div class="purchase_info">
                    <div>Name:</div>
                    <div>'.$row["name"].'</div>
                </div>
                <div class="purchase_info">
                    <div>Time on Site:</div>
                    <div>'.$row["time"].'</div>
                </div>
            </div>';
        if($row["comment"] != "") {
            echo 
            '<div class="purchase_info"  style="width:100%; margin-top:0.5em">
                <div>Comment:</div>
                <div class="comment">'.$row["comment"].'</div>
            </div>';
        }
        echo '</div>';
    }

    //$elements = $result->fetch_all(MYSQLI_ASSOC);
    //echo json_encode($elements);
}


$stmt->free_result();
$stmt->close();
$mysqli->close();
?>