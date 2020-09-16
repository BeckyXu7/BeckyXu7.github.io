<?php
require "uq/auth.php";
auth_require();
$authResult = auth_get_payload();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Administrator Page</title>
	<link href="https://fonts.googleapis.com/css?family=Bitter|PT+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="data.css" />
</head>

<body>
	<button id="back">
        <a href="index.html">Back</a>
    </button>
    <div class="row">
        <div>
            <h2 class="big_title">The Number of Visits Per Day</h2>
            <div id="visit_chart" class="graph"></div>
        </div>
        <div>
            <h2 class="big_title">The Number of Orders Per Day</h2>
             <div id="purchase_chart" class="graph"></div>
        </div>
    </div>
    
    <div id="convert">
        <h2 class="big_title">The Convert Ratio between Visits and Orders</h2>
        <div id="convert_chart" class="graph"></div>
    </div>

    <div class="row">
        <div>
            <h2 class="big_title">Average Time On Site of All Vistors</h2>
            <div id="stay_chart" class="graph"></div>
        </div>
        <div>
            <h2 class="big_title">Average Time On Site of Buyers</h2>
	        <div id="purchase_stay_chart" class="graph"></div>
        </div>
    </div>
    
    <h2 class="big_title">Purchase History</h2>
    <div class="row">
        <button class="timeDone" type="button" onclick="displaytPurchase('day')">Today</button>
        <button class="timeDone" type="button" onclick="displaytPurchase('all')">All</button>
    </div>
    <div id="purchaseHistory">
        <div class="order"> 
            <div class='row'>
                <div class="purchase_info">
                    <div>Email:</div>
                    <div></div>
                </div>
                <div class="purchase_info">
                    <div>Name:</div>
                    <div></div>
                </div>
                <div class="purchase_info">
                    <div>Time:</div>
                    <div></div>
                </div>
            </div>
            <div class="purchase_info">
                <div>Comment:</div>
                <div class="comment"></div>
            </div>
        </div>
    </div>
	
    
    <script src="core.js"></script>
    <script src="charts.js"></script>
    <script src="themes/animated.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="data.js"></script>
</body>

</html>