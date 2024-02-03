<?php
session_start();
require('inpro/db.php');

$response = array('hasUpdates' => false);
$show_notify = "";

if (isset($_SESSION['lastModified'])) {
    if ($_SESSION['lastModified'] != $_SESSION['lastModifiedBefore']) {
        $response = array('hasUpdates' => true);  // Set to true if there are updates
    }

    $latestUpdate = $_SESSION['lastModified'];
    $queryAll = "SELECT * FROM gates_info WHERE last_modified = '$latestUpdate'";
    $stmtAll = $pdo->prepare($queryAll);
    $stmtAll->execute();
    $latestTimestampInfo = $stmtAll->fetch(PDO::FETCH_ASSOC);

    if ($latestTimestampInfo["status"] == 'opened') {
        $show_notify .= $latestTimestampInfo["gate"] . " تم فتح";
    } elseif ($latestTimestampInfo["status"] == 'closed') {
        $show_notify .= $latestTimestampInfo["gate"] . " تم اغلاق";
    }

    if ($response['hasUpdates'] == true) {
        $response['show_notify'] = $show_notify;
        $response['gateName'] = $latestTimestampInfo["gate"];
        $response['gateStatus'] = $latestTimestampInfo["status"];

        // Return the session check response when there are updates
        // echo json_encode($response);
        // exit; // Stop execution to avoid overwriting with the next json_encode
    }
}

// Fetch information for all gates
$query = "SELECT * FROM gates_info";
$stmt = $pdo->prepare($query);
$stmt->execute();
$allGatesInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Accumulate information for all gates in the response
foreach ($allGatesInfo as $gateInfo) {
    $response[str_replace(' ', '', $gateInfo['gate'])] = $gateInfo['status'];
}

// Return the updated response including information for all gates
echo json_encode($response);

sleep(5);

$_SESSION['lastModified'] = $_SESSION['lastModifiedBefore'];
?>
