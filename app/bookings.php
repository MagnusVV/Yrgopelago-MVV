<?php

try {
    $hotelDatabase = new PDO('sqlite:./database/hoteldatabase.db');
    $hotelDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hotelDatabase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed:';
    throw $e;
}

// gives access to functions "createFetchBookedDatesQuery" and "styleCalendar" used below
require __DIR__ . '/hotelFunctions.php';


// Isset-block for checking and creating variables from booking-form-field in index.php.

// room choice: selection confirmaton:
$roomNames = array('Rustic', 'Tourist', 'Oh yes, baby!');

if (isset($_POST['roomSelection'])) {
    $roomSelection = (int)htmlspecialchars($_POST['roomSelection'], FILTER_SANITIZE_NUMBER_INT);
}

// arrival and departure: Check if both dates are set, and if they are already occupied. If occupied, returns to starting page, gives a message and stops further processing on bookings.php:
if (isset($_POST['arrivalDate']) && isset($_POST['departureDate']) && !empty($_POST['arrivalDate']) && !empty($_POST['departureDate'])) {
    $arrivalDate = htmlspecialchars($_POST['arrivalDate']);
    $departureDate = htmlspecialchars($_POST['departureDate']);


    // Arrival_date and Departure_date is fetched as an associative array from database:
    $fetchBookedDatesQuery = createFetchBookedDatesQuery($roomSelection);

    $roomIsBookedCheckStmt = $hotelDatabase->query($fetchBookedDatesQuery);

    $roomIsBookedDates = $roomIsBookedCheckStmt->fetchAll(PDO::FETCH_ASSOC);

    // these arrays will hold all arrival- and departure dates:
    $arrivalDates = [];

    $departureDates = [];

    // the two arrays are populated with data from the associative array:
    foreach ($roomIsBookedDates as $dates) {

        $arrivalDates[] = $dates['Arrival_date'];
        $departureDates[] = $dates['Departure_date'];
    };

    // ceates a new array where every booked date is a separate value, separated by each booking:
    $allBookedDatesArr = [];

    for ($i = 0; $i < count($arrivalDates); $i++) {
        $allBookedDatesArr[] = createSeparateDaysArr($arrivalDates[$i], $departureDates[$i]);
    };

    // finally it's time to check if "$arrivalDate" and "$departureDate" are not already booked:
    foreach ($allBookedDatesArr as $dateChunks) {
        foreach ($dateChunks as $singleDates) {

            // creates array that holds all single days in current booking:
            $arrivalDepartureDateSpan = createSeparateDaysArr($arrivalDate, $departureDate);

            foreach ($arrivalDepartureDateSpan as $datesToCheck) {

                if ($datesToCheck === $singleDates) {
                    // alert message if picked dates hits or overlaps already booked dates:
                    $dateFailMessage = "You know, you can't just pick a date like you own the hotel, or something. We do have other guests in that room during, or part of, that period. Please try again.";

                    echo '<script>alert("' . $dateFailMessage . '")</script>';

                    // redirects back to main page:
                    echo "<script>document.location = '/../index.php'</script>";
                    // remaining processes are killed for good measure.
                    die();
                }
            };
        };
    };
}

// transferCode: Check if code given is set, not empty and valid:
if (isset($_POST['transferCode']) && !empty($_POST['transferCode'])) {
    $transferCode = htmlspecialchars(trim($_POST['transferCode'], ENT_QUOTES));

    if (strlen($transferCode) > 1) {
        $dateBaseWriteTest = "yes";
    } else {
        $dateBaseWriteTest = "no";
    }
}

// customer: Check if string is set and not empty:
if (isset($_POST['customer']) && !empty($_POST['customer'])) {
    $customer = htmlspecialchars(trim($_POST['customer'], ENT_QUOTES));
}

// extras: List all selected:
$extrasNames = array('First aid kit', 'Priest', 'Products for nice and vivid dreams');

// this array will hold the selected extras:
$selectedExtraFeatures = [];

if (isset($_POST['extrasFirst'])) {
    $extrasFirst = (int)htmlspecialchars($_POST['extrasFirst'], FILTER_SANITIZE_NUMBER_INT);

    // this variable will put "1" as a boolean value in database:
    $extrasFirstIsChoosen = 1;
    $selectedExtraFeatures[] = $extrasNames[$extrasFirst - 1];
} else {
    // this variable will put "0" as a boolean value in database:
    $extrasFirstIsChoosen = 0;
}

if (isset($_POST['extrasSecond'])) {
    $extrasSecond = (int)htmlspecialchars($_POST['extrasSecond'], FILTER_SANITIZE_NUMBER_INT);

    $extrasSecondIsChoosen = 1;
    $selectedExtraFeatures[] = $extrasNames[$extrasSecond - 1];
} else {
    $extrasSecondIsChoosen = 0;
}

if (isset($_POST['extrasThird'])) {
    $extrasThird = (int)htmlspecialchars($_POST['extrasThird'], FILTER_SANITIZE_NUMBER_INT);

    $extrasThirdIsChoosen = 1;
    $selectedExtraFeatures[] = $extrasNames[$extrasThird - 1];
} else {
    $extrasThirdIsChoosen = 0;
}

// total cost with room, extras, no. of days:
if (isset($_POST['totalCost'])) {
    $totalCost = (int)filter_var($_POST['totalCost'], FILTER_SANITIZE_NUMBER_INT);
}


// If transferCode is valid, put all variables in the database. The table is chosen depending on $roomSelection value.

//
// * (Logic for validation of code goes here) *
//

if ($dateBaseWriteTest === 'yes') {

    //query modified by room no:
    $bookingQuery = createBookingQuery($roomSelection);

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
} else {
    echo 'Catastrophic booking error!';
}

// ---
// JSON-response for succesful booking:

// the booking reponse before conversion:
$bookingResponse = [
    'Island' => 'Ilha das mil pragas',
    'The hotel' => 'Terminal Hoteleiro',
    'Your room choice' => $roomNames[$roomSelection - 1],
    'Arriving' => $arrivalDate,
    'Departing' => $departureDate, 'Total amount paid' => $totalCost . '$', 'No. of stars' => '☆☆',
    'Extra features selected' => $selectedExtraFeatures,
    'A (very) few words from the owner' => 'We are very much looking forward to your stay here. And remember, if you survive this visit to Ilha das mil pragas, you can survive anything!',
];


$jsonbookingResponse = json_encode($bookingResponse);

header('Content-Type: application/json');

echo $jsonbookingResponse;

/* Your hotel MUST give a response to every succesful booking. The response should be in json and MUST contain the following properties:
island
hotel
arrival_date
departure_date
total_cost
stars
features
additional_info. (This last property is where you can put in a personal greeting from your hotel, an image URL, link to a youtube video or whatever you like.)
 */
