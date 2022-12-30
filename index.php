<?php

declare(strict_types=1);

// this... supposedly autoloads needed stuff (dotenv, Guzzle, "calendar"?)

require __DIR__ . '/vendor/autoload.php';

//

// another autoload.php with (soon to have) database handling

require __DIR__ . '/app/autoload.php';

//

// the site's landing page

require __DIR__ . '/views/header.php';

require __DIR__ . '/views/main.php';

require __DIR__ . '/views/footer.php';

//
