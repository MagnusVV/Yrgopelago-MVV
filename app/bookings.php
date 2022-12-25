<?php

declare(strict_types=1);

if (isset($_POST['transferCode'])) {
    $transferCode = $_POST['transferCode'];
    echo $transferCode;
} elseif (!$_POST['transferCode']) {

    echo "Code is not set!";
};
