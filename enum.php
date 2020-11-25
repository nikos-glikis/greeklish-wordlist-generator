<?php
//Not really needed.
$options = array(
    'create_if_missing' => true,    // if the specified database didn't exist will create a new one
    'error_if_exists' => false,    // if the opened database exsits will throw exception
    'paranoid_checks' => false,
    'block_cache_size' => 800 * (2 << 20),
    'write_buffer_size' => 4 << 20,
    'block_size' => 4096,
    'max_open_files' => 10000,
    'block_restart_interval' => 16,
    'compression' => LEVELDB_SNAPPY_COMPRESSION,
    'comparator' => NULL,   // any callable parameter which returns 0, -1, 1
);
/* default readoptions */
$readoptions = array(
    'verify_check_sum' => false,
    'fill_cache' => true,
    'snapshot' => null
);

/* default write options */
$writeoptions = array(
    'sync' => false
);


$db = new LevelDB("completeDb", $options, $readoptions, $writeoptions);
$f = fopen('php://stdin', 'r');
while ($line = fgets($f)) {
    //echo $line;
    $line = trim($line);
    $db->put($line, '');
}

fclose($f);

//outputHashmap($db);
function outputHashmap($db)
{
    $it = new LevelDBIterator($db);
    $outputFile = gzopen('output_final.gz', 'w');
    foreach ($it as $key => $value) {
        gzwrite($outputFile, $key . "\n");
    }
    gzclose($outputFile);
}

?>