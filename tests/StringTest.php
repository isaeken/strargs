<?php

namespace IsaEken\Strargs\Tests;

use IsaEken\Strargs\Enums\VerboseLevel;
use IsaEken\Strargs\Strargs;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    public function testCommands()
    {
        $strargs = (new Strargs)->setCommand('command');
        $this->assertEquals('command', $strargs->getCommand());

        $strargs = (new Strargs('command'))->decode();
        $this->assertEquals('command', $strargs->getCommand());

        $strargs = (new Strargs)->decode();
        $this->assertEquals('', $strargs->getCommand());

        $strargs = (new Strargs('command'))->decode();
        $this->assertEquals('command', $strargs->getCommand());

        $strargs = (new Strargs('command arguments ...'))->decode();
        $this->assertEquals('command', $strargs->getCommand());
    }

    public function testArguments()
    {
        $strargs = (new Strargs('command argument1 argument2'))->decode();

        $this->assertEquals(['argument1', 'argument2'], $strargs->getArguments());

        $this->assertTrue($strargs->hasArgument(0));
        $this->assertFalse($strargs->hasArgument(2));

        $strargs->setArgument(2, 'argument3');
        $this->assertTrue($strargs->hasArgument(2));

        $this->assertEquals('argument3', $strargs->getArgument(2));
        $strargs->removeArgument(2);

        $this->assertFalse($strargs->hasArgument(2));

        $strargs
            ->setArgument(2, 'string')
            ->setArgument(3, 4)
            ->setArgument(4, 4.4)
            ->setArgument(5, true)
            ->setArgument(6, false)
            ->setArgument(7, [1, 2])
            ->setArgument(8, (object) ['key' => 'value'])
            ->setArgument(9, null)
            ->setString('command ' . $strargs->encodeArguments());

        $strargs->decodeArguments();

        $this->assertEquals('string', $strargs->getArgument(2));
        $this->assertEquals(4, $strargs->getArgument(3));
        $this->assertEquals(4.4, $strargs->getArgument(4));
        $this->assertEquals(true, $strargs->getArgument(5));
        $this->assertEquals(false, $strargs->getArgument(6));
        $this->assertEquals([1, 2], $strargs->getArgument(7));
        $this->assertEquals($strargs->getArgument(8), (object) ['key' => 'value']);
        $this->assertEquals(null, $strargs->getArgument(9));
    }

    public function testOptions()
    {
        $text = '--null=null --bool1=true --bool2=false --int=1 --float=2.2 --string1=string --string2="second string" --array="[1,2]" --json="{\"key\":\"value\"}" --arr[]="first" --arr[]="second"';
        $strargs = (new Strargs('command ' . $text))->decode();

        $this->assertTrue($strargs->hasOption('null'));
        $this->assertFalse($strargs->hasOption('null2'));

        $strargs->setOption('null2', null);
        $this->assertTrue($strargs->hasOption('null2'));

        $strargs->removeOption('null2');
        $this->assertFalse($strargs->hasOption('null2'));

        $this->assertEquals(null, $strargs->getOption('null'));
        $this->assertEquals(true, $strargs->getOption('bool1'));
        $this->assertEquals(false, $strargs->getOption('bool2'));
        $this->assertEquals(1, $strargs->getOption('int'));
        $this->assertEquals(2.2, $strargs->getOption('float'));
        $this->assertEquals('string', $strargs->getOption('string1'));
        $this->assertEquals('second string', $strargs->getOption('string2'));
        $this->assertEquals([1, 2], $strargs->getOption('array'));
        $this->assertEquals((object) ['key' => 'value'], $strargs->getOption('json'));
        $this->assertEquals(['first', 'second'], $strargs->getOption('arr'));
        $this->assertEquals('--null=null --bool1=true --bool2=false --int=1 --float=2.2 --string1="string" --string2="second string" --array[]=1 --array[]=2 --json="{\"key\":\"value\"}" --arr[]="first" --arr[]="second"', $strargs->encodeOptions());
    }

    public function testVerbose()
    {
        $this->assertEquals(VerboseLevel::NORMAL, (new Strargs('command'))->decode()->getVerbose());
        $this->assertEquals(VerboseLevel::QUIET, (new Strargs('command -q'))->decode()->getVerbose());
        $this->assertEquals(VerboseLevel::QUIET, (new Strargs('command --quiet'))->decode()->getVerbose());
        $this->assertEquals(VerboseLevel::VERBOSE, (new Strargs('command -v'))->decode()->getVerbose());
        $this->assertEquals(VerboseLevel::VERY_VERBOSE, (new Strargs('command -vv'))->decode()->getVerbose());
        $this->assertEquals(VerboseLevel::DEBUG, (new Strargs('command -vvv'))->decode()->getVerbose());
    }

    public function testFlags()
    {
        $strargs = new Strargs('command -a -b -c --abc');
        $strargs->decode();

        $this->assertTrue($strargs->hasFlag('a'));
        $this->assertTrue($strargs->hasFlag('b'));
        $this->assertTrue($strargs->hasFlag('c'));

        $strargs->removeFlag('c');
        $this->assertFalse($strargs->hasFlag('c'));

        $strargs->addFlag('c');
        $this->assertTrue($strargs->hasFlag('c'));

        $this->assertTrue($strargs->hasFlag('abc'));
        $strargs->removeFlag('abc');
        $this->assertFalse($strargs->hasFlag('abc'));
        $strargs->addFlag('abc');
        $this->assertTrue($strargs->hasFlag('abc'));

        $this->assertEquals('-a -b -c --abc', $strargs->encodeFlags());
    }
}
