<?php

declare(strict_types=1);

require '../views/header.php';


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


// arrival and departure: Check if both dates are set:

if (isset($_POST['arrivalDate']) && isset($_POST['departureDate']) && !empty($_POST['arrivalDate']) && !empty($_POST['departureDate'])) {
    $arrivalDate = htmlspecialchars($_POST['arrivalDate']);
    $departureDate = htmlspecialchars($_POST['departureDate']);
    echo $arrivalDate . " — " . $departureDate . "<br>";
} else {
    echo 'Either or both dates have not been chosen. Please return and check. <br>';
}



// $name = htmlspecialchars($name, ENT_QUOTES);

require '../views/footer.php';
