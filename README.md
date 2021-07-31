# StrArgs

> Advanced CLI Command Parser

---

````php
<?php

$strargs = new \IsaEken\Strargs\Strargs('command "my name is" "isa eken" --details="{\"age\": 19, \"gender\": \"Male\"}" --friends[]=\"Nur\" -vvv');

$strargs->getArgument(0); // "my name is"
$strargs->getArgument(1); // "isa eken"
$strargs->getOption('details'); // (object) ["age" => 19, "gender" => "Male"]
$strargs->getOption('friends'); // ['Nur']
$strargs->getVerbose(); // "debug"
````

---

## Installation

You can install using composer.

````bash
composer require isaeken/strargs
````

---

## Usage

### Creating Command Using PHP

````php
$strargs = new \IsaEken\Strargs\Strargs;
$strargs->setCommand('/usr/bin/php');
$strargs->setArgument(0, '/var/www/html');
$strargs->setOption('action', 'serve');
$strargs->setOption('post', $_POST);
$strargs->addFlag('local');
$strargs->setVerbose(\IsaEken\Strargs\Enums\VerboseLevel::VERY_VERBOSE);

$strargs->encode(); // /usr/bin/php "/var/www/html" --action="serve" --local -vv
````

### Parse Command From String

````php
$strargs = new \IsaEken\Strargs\Strargs('command arg1 arg2 --json1="{\"key\":\"value\"}" --json2="[\"asd\"]" --arr1[]="item1" --arr1[]="item2" --arr1[]=10 --arr2[]="item" --opt=1 --opt2="value" -a -b -c --ab --tr --try');

// Call this method first.
$strargs->decode(); 

$strargs->getArgument(0); // arg1
$strargs->getArgument(1); // arg2
$strargs->getOption('json1'); // (object) ['key' => 'value']
$strargs->getOption('arr1'); // ['item1', 'item2', 10]
$strargs->getVerbose(); // normal
$strargs->hasFlag('try'); // true
$strargs->hasFlag('c'); // true
$strargs->hasFlag('d'); // false
````

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
