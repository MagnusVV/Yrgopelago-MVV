<?php

try {
    $hotelDatabase = new PDO('sqlite:./database/hoteldatabase.db');
} catch (PDOException $e) {
    echo 'Connection failed:' . $e->getMessage();
}


// Isset-block for checking and creating variables from booking-field in index.php.

// transferCode: Check if code given is set, not empty and valid:
if (isset($_POST['transferCode']) && !empty($_POST['transferCode'])) {
    $transferCode = htmlspecialchars(trim($_POST['transferCode'], ENT_QUOTES));

    echo $transferCode . '<br>';

    if (strlen($transferCode) > 1) {
        $dateBaseWriteTest = "yes";
        echo $dateBaseWriteTest . '<br>';
    } else {
        $dateBaseWriteTest = "no";
        echo $dateBaseWriteTest . '<br>';
    }
}

// customer: Check if string is set and not empty:
if (isset($_POST['customer']) && !empty($_POST['customer'])) {
    $customer = htmlspecialchars(trim($_POST['customer'], ENT_QUOTES));

    echo $customer . '<br>';
}

// room choice: selection confirmaton:
$roomNames = array('Rustic', 'Tourist', 'Oh yes, baby!');

if (isset($_POST['roomSelection'])) {
    $roomSelection = (int)htmlspecialchars($_POST['roomSelection'], FILTER_SANITIZE_NUMBER_INT);

    echo $roomNames[$roomSelection - 1] . '<br>';
}

// arrival and departure: Check if both dates are set:
if (isset($_POST['arrivalDate']) && isset($_POST['departureDate']) && !empty($_POST['arrivalDate']) && !empty($_POST['departureDate'])) {
    $arrivalDate = htmlspecialchars($_POST['arrivalDate']);
    $departureDate = htmlspecialchars($_POST['departureDate']);

    echo $arrivalDate . "<br>" . $departureDate . "<br>";
}

// extras: List all selected:
$extrasNames = array('First aid kit', 'Priest', 'Products for nice and vivid dreams');

if (isset($_POST['extrasFirst'])) {
    $extrasFirst = (int)htmlspecialchars($_POST['extrasFirst'], FILTER_SANITIZE_NUMBER_INT);

    $extrasFirstIsChoosen = 1;

    echo $extrasFirstIsChoosen . '<br>';
} else {
    $extrasFirstIsChoosen = 0;
    echo $extrasFirstIsChoosen . '<br>';
}

if (isset($_POST['extrasSecond'])) {
    $extrasSecond = (int)htmlspecialchars($_POST['extrasSecond'], FILTER_SANITIZE_NUMBER_INT);

    $extrasSecondIsChoosen = 1;

    echo $extrasSecondIsChoosen . '<br>';
} else {
    $extrasSecondIsChoosen = 0;
    echo $extrasSecondIsChoosen . '<br>';
}

if (isset($_POST['extrasThird'])) {
    $extrasThird = (int)htmlspecialchars($_POST['extrasThird'], FILTER_SANITIZE_NUMBER_INT);

    $extrasThirdIsChoosen = 1;

    echo $extrasThirdIsChoosen . '<br>';
} else {
    $extrasThirdIsChoosen = 0;
    echo $extrasThirdIsChoosen . '<br>';
}

// total cost with room, extras, no. of days:
if (isset($_POST['totalCost'])) {
    $totalCost = (int)filter_var($_POST['totalCost'], FILTER_SANITIZE_NUMBER_INT);

    echo $totalCost . '<br>';
}


// If transferCode is valid, put all variables in the database. The table is chosen depending on $roomSelesction value.

//
// (Logic for validation of code goes here)
//

if ($dateBaseWriteTest === 'yes') {

    function createBookinQuery(int $roomNr)
    {
        return
            'INSERT INTO Room_' . $roomNr . ' (Guest_name, Payment_code, Arrival_date, Departure_date, Extra_feature_1, Extra_feature_2, Extra_feature_3, Total_cost) VALUES (:guest_name, :payment_code, :arrival_date, :departure_date, :extra_feature_1, :extra_feature_2, :extra_feature_3, :total_cost)';
    };

    $bookingQuery = createBookinQuery($roomSelection);

    $insertIntoDb = $hotelDatabase->prepare($bookingQuery);

    $insertIntoDb->bindParam(':guest_name', $customer, PDO::PARAM_STR);
    $insertIntoDb->bindParam(':payment_code', $transferCode, PDO::PARAM_STR);
    $insertIntoDb->bindParam(':arrival_date', $arrivalDate, PDO::PARAM_STR);
    $insertIntoDb->bindParam(':departure_date', $departureDate, PDO::PARAM_STR);
    $insertIntoDb->bindParam(':extra_feature_1', $extrasFirstIsChoosen, PDO::PARAM_BOOL);
    $insertIntoDb->bindParam(':extra_feature_2', $extrasSecondIsChoosen, PDO::PARAM_BOOL);
    $insertIntoDb->bindParam(':extra_feature_3', $extrasThirdIsChoosen, PDO::PARAM_BOOL);
    $insertIntoDb->bindParam(':total_cost', $totalCost, PDO::PARAM_INT);

    $insertIntoDb->execute();

    echo 'jippi';
} else {
    echo 'skit';
}



// $name = htmlspecialchars($name, ENT_QUOTES);
