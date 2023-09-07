![Volcano](https://media.giphy.com/media/r5gHt2TCIiHK0/giphy.gif)

# Yrgopelago, the final project in the PHP course
This was made over Christmas, between the first and second semester. The task was to create a simple hotel with three rooms and a booking calendar. The teacher constructed a central bank, which handled the payments (via API-keys) and the accounts for each hotel. The rooms needed to be bookable, while avoiding being double booked, and one should have the option to add some "extras" for an extra final cost. All of this should be handled by a unique SQLite-database for each hotel. It was required to be deployed, as we were supposed to have a contest between each hotel when the task was finished.

It was created mostly with PHP (with Guzzle for queries and POST requests), some HTML and CSS, and a chunk of JS (mostly to handle the live-update of the forms and the visibility of rooms choosen).

It it still up and running, albeit a bit damaged layout-wise after a couple of one.com-upgrades. Unfortunately it can't be booked anymore, since the "central bank"-API has been removed.

~~https://magnusvargvinter.se/yrgopelago/~~ (Not hosted there anymore. Currently looking for other PHP hosting solution)

# Ilha das mil pragas

Welcome! Between the volcanic embers dancing in the skies, the gigantic mosquitos, and tropical maladies you probably never heard of, we assure you'll get an experience you won't forget!

# Terminal Hoteleiro

Our fine hotel is your end station on our beautiful island. It has been for quite a few people!

# Instructions

Nothing special to mention, except that it uses the Guzzle package and the PHP-calendar package from benhall14.

# Code review

1. main.php:43-55 - This section could be made into a function with the room number as an argument so you don't have to rewrite it.
2. bookings.php:13-20 - This section could also be a function to save some time.
3. bookings.php:40-44 - This section could fit into the function createFetchBookedDatesQuery and return the final array so you have everyhting in one place in case.
4. hotelFunctions.php:38-42 - Remember that you can write what type the function returns (for example :int or :array) to make sure you get the correct type back.
5. hotelFunctions.php:52-52 - Don't forget to declare what type the agruments the function needs (saw that other functions had them so i think you maybe just forgot)
6. hoteldatabase.db: - The columns in the table are good and stores the important info but it could use a PIVOT table so you could see all reservations in one table.
7. style.css:62-62 - A very small detail but since everything is either percent or rem it is a bit inconsistent but of course not a huge issue.
8. hoteldatabase.db: - It could be a bit complicated in case you get more rooms or more features since you need to create a new table and add more columns but everything needed is in the database.
9. bookings.php:96-105 - A suggestion is to put all features in an array and use a foreach loop to get all the features that was choosen so the code becomes a bit shorter.
10. bookings.php:181-190 - Again could all be grouped together with the query and have everything in one place to make it esier to read.

Overal the code looked great i really had to look for nitpicks like in the css and there were some great solutions to problems I haven't thought of and the webbsite looks really good (I also like the little error comments) great work //Johanna
