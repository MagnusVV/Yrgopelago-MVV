<?php


// isset-block for checking and creating variables from booking-field in index.php.

// transferCode: Check if string is empty:

if (isset($_POST['transferCode']) && !empty($_POST['transferCode'])) {
    $transferCode = htmlspecialchars($_POST['transferCode'], ENT_QUOTES);
    echo $transferCode . '<br>';

    // Message if code is invalid or empty:

} else {
    echo 'Field "transferCode" either empty or wrong code used. Please return and try again. <br>';
}


// customer: Check if string is empty:

if (isset($_POST['customer']) && !empty($_POST['customer'])) {
    $customer = htmlspecialchars($_POST['customer'], ENT_QUOTES);
    echo $customer . '<br>';

    // Message if name is empty:

} else {
    echo 'Field "Your name" empty. Please return and fill out your name. <br>';
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
} else {
    echo 'Either or both dates have not been chosen. Please return and check. <br>';
}


// extras: List all selected:

$extrasNames = array('First aid kit', 'Priest', 'Products for nice and vivid dreams');

if (isset($_POST['extrasFirst'])) {
    $extrasFirst = (int)htmlspecialchars($_POST['extrasFirst'], FILTER_SANITIZE_NUMBER_INT);

    echo $extrasNames[$extrasFirst - 1] . '<br>';
}

if (isset($_POST['extrasSecond'])) {
    $extrasSecond = (int)htmlspecialchars($_POST['extrasSecond'], FILTER_SANITIZE_NUMBER_INT);

    echo $extrasNames[$extrasSecond - 1] . '<br>';
}

if (isset($_POST['extrasThird'])) {
    $extrasThird = (int)htmlspecialchars($_POST['extrasThird'], FILTER_SANITIZE_NUMBER_INT);

    echo $extrasNames[$extrasThird - 1] . '<br>';
}

// total cost with room, extras, no. of days:

if (isset($_POST['totalCost'])) {
    $totalCost = (int)filter_var($_POST['totalCost'], FILTER_SANITIZE_NUMBER_INT);

    echo $totalCost . '<br>';
}



// $name = htmlspecialchars($name, ENT_QUOTES);
