<?php
$inputWordlist = "gr_utf8.txt";

$greekToGreek = [
    'ντ' => ['d'],
    'αυ' => ['av', 'au', 'ab'],
    'αύ' => ['av', 'au', 'ab'],
    'Αύ' => ['av', 'au', 'ab'],
    'Αυ' => ['av', 'au', 'ab'],
    'ευ' => ['ev', 'eb'],
    'εύ' => ['ev', 'eb'],
    'Ευ' => ['ev', 'eb'],
    'Εύ' => ['ev', 'eb'],
    'ου' => ['ou', 'u'],
    'ού' => ['ou', 'u'],
    'Ου' => ['ou', 'u'],
    'Ού' => ['ou', 'u'],
    'μπ' => ['mp', 'b', 'mb'],
    'Μπ' => ['mp', 'b', 'mb'],
    'ή' => ['i'],
    'η' => ['i'],
    'Η' => ['i'],
    'Ή' => ['i'],

];


if (!file_exists($inputWordlist)) {
    printLine($inputWordlist . "does not exist");
    die(1);
}
function printLine($text = "")
{
    print $text . "\n";
}

if (!function_exists('mb_str_split')) {
    //this function comes at php 7.4
    function mb_str_split($string, $split_length = 1, $encoding = null)
    {
        if (null !== $string && !\is_scalar($string) && !(\is_object($string) && \method_exists($string, '__toString'))) {
            trigger_error('mb_str_split() expects parameter 1 to be string, ' . \gettype($string) . ' given', E_USER_WARNING);

            return null;
        }

        if (1 > $split_length = (int)$split_length) {
            trigger_error('The length of each segment must be greater than zero', E_USER_WARNING);

            return false;
        }

        if (null === $encoding) {
            $encoding = mb_internal_encoding();
        }

        if ('UTF-8' === $encoding || \in_array(strtoupper($encoding), array('UTF-8', 'UTF8'), true)) {
            return preg_split("/(.{{$split_length}})/u", $string, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        }

        $result = array();
        $length = mb_strlen($string, $encoding);

        for ($i = 0; $i < $length; $i += $split_length) {
            $result[] = mb_substr($string, $i, $split_length, $encoding);
        }

        return $result;
    }
}


$taE = ['h', 'i', 'y', 'oi', 'ei', 'e'];
$taESimple = ['h', 'i', 'y', 'e'];
$taO = ['o', 'w'];

$subFromGreek = [
    'α' => ['a'],
    'ά' => ['a'],
    'Α' => ['a'],
    'Ά' => ['a'],
    'β' => ['b'],
    'Β' => ['b'],
    'γ' => ['g'],
    'Γ' => ['g'],
    'δ' => ['d'],
    'Δ' => ['d'],
    'ε' => ['e'],
    'έ' => ['e'],
    'Ε' => ['e'],
    'Έ' => ['e'],
    'ζ' => ['z'],
    'Ζ' => ['z'],
    'ή' => ['h'],
    'η' => ['h'],
    'Η' => ['h'],
    'Ή' => ['h'],
    'Θ' => ['8'],
    'θ' => ['8'],
    'ι' => ['i'],
    'ί' => ['i'],
    'ΐ' => ['i'],
    'ϊ' => ['i'],
    'Ϊ' => ['i'],
    'Ί' => ['i'],
    'Ι' => ['i'],
    'κ' => ['k'],
    'Κ' => ['k'],
    'λ' => ['l'],
    'Λ' => ['l'],
    'Μ' => ['m'],
    'μ' => ['m'],
    'ν' => ['n'],
    'Ν' => ['n'],
    'ξ' => ['3'],
    'Ξ' => ['3'],
    'ο' => ['o'],
    'ό' => ['o'],
    'Ο' => ['o'],
    'Ό' => ['o'],
    'π' => ['p'],
    'Π' => ['p'],
    'ρ' => ['r'],
    'Ρ' => ['r'],
    'σ' => ['s'],
    'Σ' => ['s'],
    'ς' => ['s'],
    'τ' => ['t'],
    'Τ' => ['t'],
    'υ' => ['i'],
    'ϋ' => ['i'],
    'ύ' => ['i'],
    'ΰ' => ['i'],
    'Ύ' => ['i'],
    'Ϋ' => ['i'],
    'Υ' => ['i'],
    'φ' => ['f'],
    'Φ' => ['f'],
    'χ' => ['x'],
    'Χ' => ['x'],
    'ψ' => ['4'],
    'Ψ' => ['4'],
    'ω' => ['o'],
    'ώ' => ['o'],
    'Ω' => ['o'],
    'Ώ' => ['o'],
];

$subFromGreeklish = [
    //'h' => ['i', 'y', 'e'],
    'b' => ['b', 'v'],
    //'d' => [ 'd'],
    'f' => ['f', 'ph'],
    '3' => ['ks', '3'],
    '4' => ['ps', '4'],
    'r' => ['r', 'p'],
    'x' => ['x', 'ch', 'h'],
    'i' => $taESimple,

    '8' => ['th', '8'],
    'y' => $taESimple,
    //'e' => $taESimple,
    'o' => $taO,
    'w' => $taO,

];

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

$db = new LevelDB("db", $options, $readoptions, $writeoptions);


$file = $inputWordlist;

$lines = file($file);
$results = [];
foreach ($lines as &$line) {
    $line = trim($line);
    foreach ($greekToGreek as $key => $values) {
        if (mb_strpos($line, $key) !== false) {
            foreach ($values as $value) {
                $newWord = $line;
                $newWord = mb_ereg_replace($key, $value, $newWord);

                $results[$newWord] = '';
            }
        }
    }
    $results[$line] = '';
}
printLine(count($lines));
printLine(count($results));
foreach ($results as $line => $val) {
    $line = trim($line);
    foreach ($greekToGreek as $key => $values) {
        if (mb_strpos($line, $key) !== false) {
            foreach ($values as $value) {
                $newWord = $line;
                $newWord = mb_ereg_replace($key, $value, $newWord);

                $results[$newWord] = '';
            }
        }
    }
    $results[$line] = '';
}
printLine(count($lines));
printLine(count($results));

foreach ($results as $line => $val) {

    $lineArray = mb_str_split($line);

    $newWord = $line;

    foreach ($lineArray as $ch) {

        if (!isset($subFromGreek[$ch])) {
//            if (mb_detect_encoding($ch, 'ASCII', true)) {
//                printLine($ch);
//                die("Unknown");
//            }
        } else {
            foreach ($subFromGreek[$ch] as $value) {
                $newWord = mb_ereg_replace($ch, $value, $newWord);
            }
        }
    }
    $results[$newWord] = '';
}

printLine(count($lines));
printLine(count($results));
foreach ($results as $line => $val) {
    $newWord = mb_ereg_replace('ei', 'i', $line);
    $results[$newWord] = '';
    $newWord = mb_ereg_replace('ai', 'e', $line);
    $results[$newWord] = '';
    $newWord = mb_ereg_replace('oi', 'i', $line);
    $results[$newWord] = '';
}

printLine(count($lines));
printLine(count($results));
printLine("Start Iterations");
$counter = 0;


$replaceIndex = $subFromGreeklish;

foreach ($results as $line => $val) {
    $counter++;
    if ($counter++ % 100000 == 0) {
        gc_collect_cycles();
    }
    $lineArray = mb_str_split($line);

    $index = 0;
    foreach ($lineArray as $ch) {


        if (!isset($replaceIndex[$ch])) {
            //printLine($ch);
        } else {
            foreach ($replaceIndex[$ch] as $value) {
                if ($ch != $value) {

                    $newWord = substr($line, 0, $index) . $value . substr($line, $index + 1, mb_strlen($line));
//                        if ($i >= 1) {
//                            printLine("Replacing " . $ch . ' with ' . $value);
//                            printLine($line);
//                            printLine($newWord);
//                        }
                    //$results[$newWord] = '';
                    $db->put($newWord, '');
                }
            }
        }
        $index++;
    }

}
unset($results);
$it = new LevelDBIterator($db);
// Loop in iterator style
$count = 0;
foreach ($it as $key => $value) {
    //echo "{$key} => {$value}\n";
    $count++;
}


printLine("-1 - " . $count);


for ($i = 0; $i < 8; $i++) {

    $replaceIndex = $subFromGreeklish;
    $it = new LevelDBIterator($db);

    foreach ($it as $line => $val) {
        $counter++;
        if ($counter++ % 100000 == 0) {
            gc_collect_cycles();
        }
        $lineArray = mb_str_split($line);

        $index = 0;
        foreach ($lineArray as $ch) {


            if (!isset($replaceIndex[$ch])) {
                //printLine($ch);
            } else {
                foreach ($replaceIndex[$ch] as $value) {
                    if ($ch != $value) {

                        $newWord = substr($line, 0, $index) . $value . substr($line, $index + 1, mb_strlen($line));


                        $db->put($newWord, '');
                    }
                }
            }
            $index++;
        }

    }
    $it = new LevelDBIterator($db);
// Loop in iterator style
    $count = 0;
    foreach ($it as $key => $value) {
        //echo "{$key} => {$value}\n";
        $count++;
    }
    printLine("$i - " . $count);
    outputHashmap($db);
}
outputHashmap($db);
die;
function outputHashmap($db)
{
    $it = new LevelDBIterator($db);
    $outputFile = gzopen('output.gz', 'w');
    foreach ($it as $key => $value) {
        gzwrite($outputFile, $key . "\n");
    }
    gzclose($outputFile);
}