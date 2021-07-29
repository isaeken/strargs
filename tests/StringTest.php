<?php

namespace IsaEken\Strargs\Tests;

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

    public function testOptions()
    {
        $strargs = (new Strargs('command -a -b'))->decode();

        $this->assertEquals($strargs->getOptions(), ['a', 'b']);

        $this->assertTrue($strargs->hasOption('a'));
        $this->assertFalse($strargs->hasOption('c'));

        $strargs->addOption('c');
        $this->assertTrue($strargs->hasOption('c'));

        $strargs->removeOption('c');
        $this->assertFalse($strargs->hasOption('c'));
    }

    public function testShortEnableDisable()
    {
        $strargs = new Strargs;
        $this->assertFalse($strargs->short);
        $strargs->enableShort();
        $this->assertTrue($strargs->short);
        $strargs->disableShort();
        $this->assertFalse($strargs->isShort());
        $strargs->setShort(true);
        $this->assertTrue($strargs->isShort());
    }

    public function testArguments()
    {
        $strargs = (new Strargs('command --null=null --boolean1=true --boolean2=false --int1=4 --int2=0 --float=1.4 --string1=text --string2="this is a text"'))->decode();

        $this->assertTrue($strargs->hasArgument('null'));
        $this->assertTrue($strargs->hasArgument('boolean1'));
        $this->assertTrue($strargs->hasArgument('string1'));
        $this->assertFalse($strargs->hasArgument('string3'));

        $strargs->setArgument('string3', 'testing');
        $this->assertTrue($strargs->hasArgument('string3'));
        $this->assertEquals('testing', $strargs->getArgument('string3'));

        $this->assertIsArray($strargs->getArguments());

        $strargs->removeArgument('string3');
        $this->assertFalse($strargs->hasArgument('string3'));

        $strargs->string3 = 'string3';
        $this->assertTrue($strargs->hasArgument('string3'));
        $this->assertEquals('string3', $strargs->string3);

        $this->assertEquals(null, $strargs->getArgument('null'));
        $this->assertEquals(true, $strargs->getArgument('boolean1'));
        $this->assertEquals(false, $strargs->getArgument('boolean2'));
        $this->assertEquals(4, $strargs->getArgument('int1'));
        $this->assertEquals(0, $strargs->getArgument('int2'));
        $this->assertEquals(1.4, $strargs->getArgument('float'));
        $this->assertEquals('text', $strargs->getArgument('string1'));
        $this->assertEquals('this is a text', $strargs->getArgument('string2'));
    }

    public function testShort()
    {
        $strargs = (new Strargs('command null true false 1 2 3.3 4.4 text "this is a text" -a -b'))->enableShort()->decode();

        $this->assertTrue($strargs->hasArgument(0));
        $this->assertTrue($strargs->hasArgument(8));
        $this->assertFalse($strargs->hasArgument(9));

        $this->assertTrue($strargs->hasOption('a'));
        $this->assertTrue($strargs->hasOption('b'));
        $this->assertFalse($strargs->hasOption('c'));

        $this->assertEquals(null, $strargs->getArgument(0));
        $this->assertEquals(true, $strargs->getArgument(1));
        $this->assertEquals(false, $strargs->getArgument(2));
        $this->assertEquals(1, $strargs->getArgument(3));
        $this->assertEquals(2, $strargs->getArgument(4));
        $this->assertEquals(3.3, $strargs->getArgument(5));
        $this->assertEquals(4.4, $strargs->getArgument(6));
        $this->assertEquals('text', $strargs->getArgument(7));
        $this->assertEquals('this is a text', $strargs->getArgument(8));
    }

    public function testEncode()
    {
        $command = 'command --boolean1=true --boolean2=false --integer1=0 --integer2=4 --float=2.2 --string="text" -a -b';
        $commandShort = 'command true false 0 4 2.2 "text" "this is a text" -a -b';

        $strargs = new Strargs;
        $strargs
            ->setCommand('command')
            ->addOption('a')
            ->addOption('b')
            ->setArgument('boolean1', true)
            ->setArgument('boolean2', false)
            ->setArgument('integer1', 0)
            ->setArgument('integer2', 4)
            ->setArgument('float', 2.2)
            ->setArgument('string', 'text')
        ;
        $this->assertEquals($strargs->encode(), $command);

        $strargs = new Strargs;
        $strargs
            ->enableShort()
            ->setCommand('command')
            ->addOption('a')
            ->addOption('b')
            ->setArgument(0, true)
            ->setArgument(1, false)
            ->setArgument(2, 0)
            ->setArgument(3, 4)
            ->setArgument(4, 2.2)
            ->setArgument(5, 'text')
            ->setArgument(6, 'this is a text')
        ;
        $this->assertEquals($strargs->encode(), $commandShort);
    }
}
