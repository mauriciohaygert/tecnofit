<?php

if ($envFile = fopen(__DIR__ . "/../.env", "r")) {
    while (($env = fgets($envFile)) !== false) {
        putenv(trim($env));
    }
    fclose($envFile);
}
