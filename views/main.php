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

                <!-- Value code from central bank goes here: -->
                <p>
                    <label for="transferCode" class="">Input value-code</label><br>
                    <input type="text" name="transferCode" id="transferCode" class="">
                </p>

                <!-- Choose arrival date: -->
                <p>
                    <label for="arrivalDate" class="">Arrival date</label><br>
                    <input type="date" name="arrivalDate" id="arrivalDate" class="" min="2023-01-01" max="2023-01-31">
                </p>

                <!-- Choose departure date: -->
                <p>
                    <label for="departureDate" class="">Departure date</label><br>
                    <input type="date" name="departureDate" id="departureDate" class="" min="2023-01-01" max="2023-01-31">
                </p>

                <!-- Select room -->
                <p>
                    <label for="roomSelect" class="">Select room</label><br>
                    <select name="roomSelect" id="roomSelect">
                        <option value="1">Rustic</option>
                        <option value="2">Tourist</option>
                        <option value="3">Oh yes, baby!</option>
                    </select>
                </p>

                <!-- Extras (in progress) -->
                <p>
                    <label for="extras" class="">Choose extra features, if desired<br>

                        <input type="checkbox" name="extrasFirst" id="extras" class=""> First extra feature<br>
                        <input type="checkbox" name="extrasSecond" id="extras" class=""> Second extra feature<br>
                        <input type="checkbox" name="extrasThird" id="extras" class=""> Third extra feature<br>

                    </label>
                </p>

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
