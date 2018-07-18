<?php

include('Lib/docopt.php');
include('Interpreter/Interpreter.php');
include('Interpreter/Loader.php');

$constants = ['{INPUT}', '{VI_USER}', '{VA_NAME}', '{VA_VERSION}', '{VA_AUTHOR}', '{VA_GENDER}', '{VA_USER}'];

$loader  = new Loader('src/VML');
$vml     = $loader->getVml()['neuron'];
$session = true;

echo PHP_EOL."Viki virtual assistant (0.1dev). Created by Nico Duitsmann.".PHP_EOL;
echo 'Type help to show help.'.PHP_EOL;

// TODO SplFixedArray -> http://php.net/manual/de/class.splfixedarray.php

while ( $session ) {
    echo PHP_EOL;
    $input = trim(readline("Ask viki> "));
    readline_add_history($input);

    $answer = parse_input($input, $vml, 'answer');
    $feeling = parse_input($input, $vml, 'feeling');
    $eval = parse_input($input, $vml, 'eval');
    
    // Try to format answer and eval
    $answer = const_format($input, $answer['output'], $answer['neuron'], '{INPUT}');
    $eval = const_format($input, $eval['output'], $eval['neuron'], '{INPUT}');

    echo "\033[1m\033[31m$answer\033[0m".PHP_EOL;

    if ( $eval != 'I have no answer for that.' ) {
        @eval($eval);
    }
    // echo "feeling : ".$feeling['output'].PHP_EOL;
}