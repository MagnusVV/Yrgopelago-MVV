<?php

try {
    $hotelDatabase = new PDO('sqlite:./app/database/hoteldatabase.db');
    $hotelDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hotelDatabase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed:';
    throw $e;
}

?>

<main>

    <!-- "ABOUT"-SECTION -->

    <section class="about"></section>

    <!-- BOOKING-FORM & ROOM-PREVIEWS -->

    <section class="actions">

        <!-- the calendars -->
        <section class="calendar">
            <?php

            /* php-calendar creator is called here. Resources from: https://packagist.org/packages/benhall14/php-calendar */

            use benhall14\phpCalendar\Calendar as Calendar;

            /* function that style and set parameters to calendar */

            function styleCalendar($calendarVarName)
            {
                $calendarVarName->stylesheet();

                $calendarVarName->useMondayStartingDate();

                $calendarVarName->useFullDayNames();

                echo $calendarVarName->draw(date('2023-01-01'), 'orange');
            }

            /* function creates an array which, when input in the calendar "addEvents"-function, is used by that function to mask (change color) on booked dates */
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

                /* output array is used in the calendar function */
                $calendar->addEvents($bookedDatesArray);
            };

            ?>
            <section id="calendarForRoom_1">
                <?php
                $firstRoomCalendar = new Calendar;

                /* Arrival_date and Departure_date is fetched as an associative array from database */
                $firstRoomStmt = $hotelDatabase->query('SELECT Arrival_date,Departure_date FROM Room_1 ORDER BY Arrival_date');

                $firstRoomDates = $firstRoomStmt->fetchAll(PDO::FETCH_ASSOC);

                /* array that will hold the calendarevents */
                $firstRoomBookings = [];

                maskBookedDates($firstRoomBookings, $firstRoomDates, $firstRoomCalendar);

                styleCalendar($firstRoomCalendar);

                ?>
            </section>
            <section id="calendarForRoom_2">
                <?php
                $secondRoomCalendar = new Calendar;

                $secondRoomStmt = $hotelDatabase->query('SELECT Arrival_date,Departure_date FROM Room_2 ORDER BY Arrival_date');

                $secondRoomDates = $secondRoomStmt->fetchAll(PDO::FETCH_ASSOC);

                $secondRoomBookings = [];

                maskBookedDates($secondRoomBookings, $secondRoomDates, $secondRoomCalendar);

                styleCalendar($secondRoomCalendar);

                ?>
            </section>
            <section id="calendarForRoom_3">
                <?php
                $thirdRoomCalendar = new Calendar;

                $thirdRoomStmt = $hotelDatabase->query('SELECT Arrival_date,Departure_date FROM Room_3 ORDER BY Arrival_date');

                $thirdRoomDates = $thirdRoomStmt->fetchAll(PDO::FETCH_ASSOC);

                $thirdRoomBookings = [];

                maskBookedDates($thirdRoomBookings, $thirdRoomDates, $thirdRoomCalendar);

                styleCalendar($thirdRoomCalendar);

                ?>
            </section>
        </section>

        <!-- the booking-form  -->
        <section class="booking-form">

            <h3>Book your stay here:</h3>
            <form action="./app/bookings.php" method="post">

                <!-- the HTML(HTML5) <input> "required" attribute is used in several forms, so mandatory fields can not be submitted while empty -->

                <!-- Value code from central bank goes here: -->
                <p>
                    <label for="transferCode" class="">Input value-code</label><br>
                    <input type="text" name="transferCode" placeholder="$$" id="transferCode" class="" required>
                </p>

                <!-- Customer name: -->
                <p>
                    <label for="transferCode" class="">Your name</label><br>
                    <input type="text" name="customer" placeholder="Given or other" id="customer" class="" required>
                </p>

                <!-- Select room -->
                <p>
                    <label for="roomSelect" class="">Select room</label><br>
                    <select name="roomSelection" id="roomSelection">
                        <option id="roomSelect1" value="1">Rustic ($1/day)</option>
                        <option id="roomSelect2" value="2">Tourist ($2/day)</option>
                        <option id="roomSelect3" value="3">Oh yes, baby! ($3/day)</option>
                    </select>
                </p>

                <!-- Choose arrival date: -->
                <p>
                    <label for="arrivalDate" class="">Arrival date</label><br>
                    <input type="date" name="arrivalDate" id="arrivalDate" class="" min="2023-01-01" max="2023-01-31" required>
                </p>

                <!-- Choose departure date: -->
                <p>
                    <label for="departureDate" class="">Departure date</label><br>
                    <input type="date" name="departureDate" id="departureDate" class="" min="2023-01-01" max="2023-01-31" required>
                </p>

                <!-- Extras -->
                <p>
                    <label for="extras" class="">Choose extra features, if desired<br>

                        <input type="checkbox" value="1" name="extrasFirst" id="extras" class=""> First aid kit ($1/day)<br>
                        <input type="checkbox" value="2" name="extrasSecond" id="extras" class=""> Priest ($2/day)<br>
                        <input type="checkbox" value="3" name="extrasThird" id="extras" class=""> Products for nice and vivid dreams ($3/day)<br>

                    </label>
                </p>

                <!-- Total cost -->
                <br>
                <p>Total sum: <input type="text" size="3" name="totalCost" id="totalCost" value="" readonly />$</p>
                <br>

                <!-- Button for submitting booking values to app/bookings.php -->
                <p>
                    <button type="submit" class="submitButton">Voila!</button>
                </p>

            </form>

        </section>

        <!-- Images and short info about rooms -->
        <section class="room-previws">

            <div id="room-1"></div>
            <div id="room-2"></div>
            <div id="room-3"></div>

        </section>
    </section>

</main>
