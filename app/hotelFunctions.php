<?php

declare(strict_types=1);

// THE CALENDAR FUNCTIONS:

// function that style and set parameters to calendar
function styleCalendar($calendar)
{
    $calendar->stylesheet();

    $calendar->useMondayStartingDate();

    $calendar->useFullDayNames();

    echo $calendar->draw(date('2023-01-01'), 'orange');
}

// function creates an array which, when input in the calendar "addEvents"-function, is used by that function to mask (change color) on booked dates
function maskBookedDates($bookedDatesArray, $arrayFromDatabase, $calendar)
{
    foreach ($arrayFromDatabase as $dates) {
        $bookedDatesArray[] = [
            'start' => $dates['Arrival_date'],
            'end' => $dates['Departure_date'],
            'summary' => '',
            'mask' => true
        ];
    }

    // output array is used in this calendar function
    $calendar->addEvents($bookedDatesArray);
};

// THE BOOKING FUNCTIONS:

// this creates a query that fetches Arrival_date and Departure_date as an associative array from database. The query is modified depending on room choice:
function createFetchBookedDatesQuery(int $roomNr)
{
    return
        'SELECT Arrival_date,Departure_date FROM Room_' . $roomNr . ' ORDER BY Arrival_date';
};

// this creates a query for inserting all booking information into database.
function createBookingQuery(int $roomNr)
{
    return
        'INSERT INTO Room_' . $roomNr . ' (Guest_name, Payment_code, Arrival_date, Departure_date, Extra_feature_1, Extra_feature_2, Extra_feature_3, Total_cost) VALUES (:guest_name, :payment_code, :arrival_date, :departure_date, :extra_feature_1, :extra_feature_2, :extra_feature_3, :total_cost)';
};

// Creates a new array where every booked date is a separate value. Function inspired by: https://www.tutorialspoint.com/return-all-dates-between-two-dates-in-an-array-in-php
function createSeparateDaysArr($arrivalDate, $departureDate)
{
    $datesTotal = [];
    $current = strtotime($arrivalDate);
    $date2 = strtotime($departureDate);
    $stepVal = '+1 day';
    while ($current <= $date2) {
        $datesTotal[] = date('Y-m-d', $current);
        $current = strtotime($stepVal, $current);
    }
    return $datesTotal;
};

// Displays a window alert on error, and return the user to the index page.
function failMessage($failMessage)
{
    echo '<script>alert("' . $failMessage . '")</script>';
    // redirects back to main page:
    echo "<script>document.location = '../index.php'</script>";
    // remaining processes are killed, so a duplicate booking can not proceed.
    die();
};
