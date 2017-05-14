<?php

$handle = fopen('log.txt', "w");

fwrite($handle, json_encode($_REQUEST));

fclose($handle);

echo 'Dados Recebidos';