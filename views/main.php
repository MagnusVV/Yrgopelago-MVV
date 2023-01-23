<?php

try {
    $hotelDatabase = new PDO('sqlite:./app/database/hoteldatabase.db');
    $hotelDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hotelDatabase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed:';
    throw $e;
}


// php-calendar creator is called here. Resources from: https://packagist.org/packages/benhall14/php-calendar
use benhall14\phpCalendar\Calendar as Calendar;

// gives access to functions "maskBookedDates" and "styleCalendar" used below
require './app/hotelFunctions.php';

?>

<main>

    <!-- "ABOUT"-SECTION -->

    <section class="about">
        <p>Welcome! Between the volcanic embers dancing in the skies,
            the gigantic mosquitos, and tropical maladies you probably never heard of,
            we assure you'll get an experience you won't forget! Pack your best sunblocker
            (we are not joking), a good deal of fluid replacements and your biggest smile!
            No need to bring a travel insurance, because you surely won't need it!</p>
    </section>

    <!--ROOM-PREVIEWS -->

    <!-- Images and short info about rooms, and the calendar. -->
    <section class="room-previews">

        <div id="room-1" class="room">
            <div class="room-info">
                <h2>Rustic, the choice of the price conscious!</h2>
                <div class="room-image-container ">
                    <img class="room-image" src="assets/images/yente-van-eynde-OmcrNPadXR4-unsplash.jpg" />
                </div>
            </div>
            <section id="calendarForRoom_1">
                <?php
                $firstRoomCalendar = new Calendar;

                // Arrival_date and Departure_date is fetched as an associative array from database
                $firstRoomStmt = $hotelDatabase->query('SELECT Arrival_date,Departure_date FROM Room_1 ORDER BY Arrival_date');

                $firstRoomDates = $firstRoomStmt->fetchAll(PDO::FETCH_ASSOC);

                // array that will hold the calendarevents
                $firstRoomBookings = [];

                maskBookedDates($firstRoomBookings, $firstRoomDates, $firstRoomCalendar);

                styleCalendar($firstRoomCalendar);

                ?>
            </section>
        </div>
        <div id="room-2" class="room room-invisible">
            <div class="room-info">
                <h2>Tourist, the choice of the explorer!</h2>
                <div class="room-image-container "><img class="room-image" src="assets/images/pexels-carmen-cobo-1103808.jpg" alt="A badly cropped picture showing the outside from a window"></div>
            </div>
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
        </div>
        <div id="room-3" class="room room-invisible">
            <div class="room-info">
                <h2>Oh yes, baby! If you never feel like leaving your room!</h2>
                <div class="room-image-container "><img class="room-image" src="assets/images/days-inn.webp" alt="A less than tasteful hotel room"></div>
            </div>
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
        </div>

    </section>
    <div class="bottom-wrapper">

        <!--  BOOKING-FORM  -->
        <section class="booking-form">

            <h3>Book your stay here:</h3>
            <form action="./app/bookings.php" method="post">

                <!-- the HTML(HTML5) <input> "required" attribute is used in several forms, so mandatory fields can not be submitted while empty -->

                <!-- Value code from central bank goes here: -->
                <p>
                    <label for="transferCode">Input value-code</label><br>
                    <input type="text" name="transferCode" placeholder="$$" id="transferCode" required>
                </p>

                <!-- Customer name: -->
                <p>
                    <label for="transferCode">Your name</label><br>
                    <input type="text" name="customer" placeholder="Given or other" id="customer" required>
                </p>

                <!-- Select room -->
                <p>
                    <label for="roomSelect">Select room</label><br>
                    <select name="roomSelection" id="roomSelection">
                        <option id="roomSelect1" value="1">Rustic ($1/day)</option>
                        <option id="roomSelect2" value="2">Tourist ($2/day)</option>
                        <option id="roomSelect3" value="3">Oh yes, baby! ($3/day)</option>
                    </select>
                </p>

                <!-- Choose arrival date: -->
                <p>
                    <label for="arrivalDate">Arrival date</label><br>
                    <input type="date" name="arrivalDate" id="arrivalDate" min="2023-01-01" max="2023-01-31" required>
                </p>

                <!-- Choose departure date: -->
                <p>
                    <label for="departureDate">Departure date</label><br>
                    <input type="date" name="departureDate" id="departureDate" min="2023-01-01" max="2023-01-31" required>
                </p>

                <!-- Extras -->
                <p>
                    <label for="extras">Choose extra features, if desired<br>

                        <input type="checkbox" value="1" name="extrasFirst" id="extras"> First aid kit ($1/day)<br>
                        <input type="checkbox" value="2" name="extrasSecond" id="extras"> Priest ($2/day)<br>
                        <input type="checkbox" value="3" name="extrasThird" id="extras"> Products for nice and vivid dreams ($3/day)<br>

                    </label>
                </p>
                <br>

                <!-- Total cost -->
                <p>Total sum: <input type="text" size="3" name="totalCost" id="totalCost" value="" readonly />$</p>
                <br>

                <!-- Button for submitting booking values to app/bookings.php -->
                <p>
                    <button type="submit" class="submit-button">Voila!</button>
                </p>

            </form>

        </section>
        <!-- New section with a little flavor text and link to statistics -->
        <section class="booking-stats">
            <h2>Let's-a-go 'round the 'pelago</h2>
            <p> Our distinguished Magnus, owner of Terminal Hoteleiro,
                spent a month travelling around the yrgopelago.
                Have a look at his journey here!
            </p>
            <a class="stats-link" href="../statpage.php">To stats!</a>
        </section>
    </div>


</main>