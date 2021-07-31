<?php

require_once __DIR__ . '/vendor/autoload.php';

$args = new \IsaEken\Strargs\Strargs();
$args->setString('command arg1 arg2 --deneme="{\"asd\":\"qwe\"}" --deneme2="[\"asd\"]" --arr1[]="asd" --arr1[]="qwe" --arr1[]=23 --arr2[]="asd qwe" --opt=1 --opt2="asd qwe" -a -b -c --ab --qwe --asd');
//dd($args->decode());
$args->decode();
$args->setVerbose(\IsaEken\Strargs\Enums\VerboseLevel::DEBUG);
$args->encode();
//dd($args->encode());
dd($args->decode());
