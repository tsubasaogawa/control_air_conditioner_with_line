<?php

$json = file_get_contents('./secrets.json');
$secrets = json_decode($json, true);
$broker = $secrets['broker'];
$client = $secrets['client'];

