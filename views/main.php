<main>

    <!-- "ABOUT"-SECTION -->

    <section class="about"></section>

    <!-- BOOKING-FORM & ROOM-PREVIEWS -->

    <section class="actions">

        <!-- the calendar -->
        <section class="calendar"></section>

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

                <!-- Select room -->
                <p>
                    <label for="roomSelect" class="">Select room</label><br>
                    <select name="roomSelect" id="roomSelect">
                        <option value="1">Rustic $1/day</option>
                        <option value="2">Tourist $2/day</option>
                        <option value="3">Oh yes, baby! $3/day</option>
                    </select>
                </p>

                <!-- Extras (in progress) -->
                <p>
                    <label for="extras" class="">Choose extra features, if desired<br>

                        <input type="checkbox" value="1" name="extrasFirst" id="extras" class=""> First extra feature, $1/day<br>
                        <input type="checkbox" value="2" name="extrasSecond" id="extras" class=""> Second extra feature, $2/day<br>
                        <input type="checkbox" value="3" name="extrasThird" id="extras" class=""> Third extra feature, $3/day<br>

                    </label>
                </p>

                <!-- Total cost -->
                <br>
                <p>Total sum: $</p>
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
