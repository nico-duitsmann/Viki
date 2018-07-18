<?php

include('Core/Client.php');
include('Core/Lib/docopt.php');

$scriptName = basename(__FILE__); 

$doc = <<<DOC
Viki virtual assistant. Copyright (c) 2018 Nico Duitsmann.
Licensed under the GNU General Public License Version 3.

Usage:
    $scriptName [options]

Options:
    -h --help           Show this help and exit.
    -v --version        Show version and exit.
DOC;

$args = Docopt::handle($doc, array('version'=>'Naval Fate 2.0'));
// $client = new Client($doc);