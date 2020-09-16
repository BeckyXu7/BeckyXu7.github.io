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

$date = date("Y-m-d");
$time = date("h:i:s");

if($type == "visit") {
    $sql = "SELECT `visits` FROM visit WHERE date=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $date);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        //CHECK WHETHER date EXIST
        if (isset($row)) {
            $visits = $row['visits'] + 1;
            $stmt->free_result();
            $sql = "UPDATE `visit` SET `visits`=? WHERE date=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $visits, $date);
            $stmt->execute();
        } else {
            $visits = 1;
            $stmt->free_result();
            $sql = "INSERT INTO `visit` (`date`, `visits`) values (?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $date, $visits);
            $stmt->execute();
        }
    }
}

if($type == "purchase") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];

    $sql = "INSERT INTO `purchase` (`email`, `name`, `comment`, `date`, `time`) values (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $email, $name, $comment, $date, $time);
    $stmt->execute();
}

if($type == "leave") {
    $staytime = round($_POST["staytime"]/1000);
    $purchase = $_POST["purchase"];

    $sql = "INSERT INTO `staytime` (`date`, `visit_time`, `stay_time`, `purchase`) values (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssis", $date, $time, $staytime, $purchase);
    $stmt->execute();
}
$stmt->close();
$mysqli->close();
?>