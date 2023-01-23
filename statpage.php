<?php

declare(strict_types=1);


require __DIR__ . '/views/header.php';


// Error when trying to require any of the functions files. Pasting code block instead.
try {
    $hotelDatabase = new PDO('sqlite:./app/database/hoteldatabase.db');
    $hotelDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hotelDatabase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed:';
    throw $e;
}

// Query for fetching the total income of the hotel for all three rooms.
$totalIncomeQuery = ' SELECT SUM(R1+R2+R3) AS total_income 
FROM (SELECT SUM(Total_cost) as R1 FROM Room_1) 
INNER JOIN (SELECT SUM(Total_cost) as R2 FROM Room_2) 
INNER JOIN (SELECT SUM(Total_cost) as R3 FROM Room_3)
';
$stmt = $hotelDatabase->prepare($totalIncomeQuery);
$stmt->execute();
$totalIncome = $stmt->fetch();

//Query for fetching total amount of bookings from the three rooms.
$totalBookingsQuery = 'SELECT SUM(room1+room2+room3) as total_bookings 
from (SELECT COUNT(booking_id) as room1 FROM Room_1)
INNER JOIN (SELECT COUNT(Booking_id) as room2 FROM Room_2)
INNER JOIN (SELECT COUNT(Booking_id) as room3 FROM Room_3);
';
$stmt = $hotelDatabase->prepare($totalBookingsQuery);
$stmt->execute();
$totalBookings = $stmt->fetch();

//Query for fetching the used features, sort the returned array in descending order, in order to echo the correct response.
$totalFeaturesQuery = 'SELECT SUM(r1f1+r2f1+r3f1) as "First Aid Kit", SUM(r1f2+r2f2+r3f2) as "Priest", SUM(r3f1+r3f2+r3f3) as "Vivid dream products"
FROM (SELECT SUM(Extra_feature_1) as r1f1, SUM(Extra_feature_2) as r1f2, SUM(Extra_Feature_3) as r1f3 from Room_1)
INNER JOIN (SELECT SUM(Extra_feature_1) as r2f1, SUM(Extra_feature_2) as r2f2, SUM(Extra_feature_3) as r2f3 from Room_2)
INNER JOIN (SELECT SUM(Extra_feature_1) as r3f1, SUM(Extra_feature_2) as r3f2, SUM(Extra_feature_3) as r3f3 from Room_3);
';
$stmt = $hotelDatabase->prepare($totalFeaturesQuery);
$stmt->execute();
$totalFeatures = $stmt->fetch();
arsort($totalFeatures);


//Fetch the logbook.json file and decode it to an associative array.
$logbookEvents = file_get_contents('logbook.json');
$logbookEvents = json_decode($logbookEvents, true);
?>

<!-- html to introduce new section -->
<h2 class="stat-page-h2">Magnus' travels.</h2>
<section class="visits-wrapper">

    <?php foreach ($logbookEvents as $logbookEvent) : ?>
        <div class="visit">
            <p><?= "Island: " . $logbookEvent['island']; ?> </p>
            <p><?= "Hotel: " . $logbookEvent['hotel'] . ", a " . $logbookEvent['stars'] . " star hotel." ?></p>
            <p><?= "Date of arrival: " . $logbookEvent['arrival_date'] ?> </p>
            <p><?= "Date of departure: " . $logbookEvent['departure_date']; ?> </p>
            <?php if ((!empty($logbookEvent['features']))) : ?>
                <p> <?= "Treated himself to: " . $logbookEvent['features'][0]['name'] . " which cost " . $logbookEvent['features'][0]['cost'] . " dollars."; ?></p>
            <?php endif ?>
            <p class="visit-total-cost"> <?= "Total cost of visit: " . $logbookEvent['total_cost']; ?></p>
        </div>
    <?php endforeach; ?>
</section>


<section class="hotel-stats">
    <h2 class="stat-page-h2">Hotel Statistics: January</h2>
    <p>
        <?=
        "During January our hotel made "
            . $totalIncome['total_income']
            . " dollars. Our three rooms saw a total of "
            . $totalBookings['total_bookings']
            . " reservations which comes around to a "
            . $totalIncome['total_income'] / $totalBookings['total_bookings']
            . " dollar average including extra features. Our most wanted feature was "
            . key($totalFeatures)
            . " which was ordered "
            . current($totalFeatures)
            . " times.";
        ?>
    </p>
    <div class="stats-box"></div>
</section>

<?php require __DIR__ . '/views/footer.php';
