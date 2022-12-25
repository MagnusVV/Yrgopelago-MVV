<?php

declare(strict_types=1);

// this... supposedly autoloads needed stuff (dotenv, Guzzle, "calendar"?)

require './vendor/autoload.php';

//

// another autoload.php with (soon to have) database handling

require './app/autoload.php';

//

// the site's landing page

require './views/header.php';

require './views/main.php';

require './views/footer.php';

//
