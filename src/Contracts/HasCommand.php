<?php


namespace IsaEken\Strargs\Contracts;


interface HasCommand
{
    /**
     * Get the command.
     *
     * @return string
     */
    public function getCommand(): string;

    /**
     * Set the command.
     *
     * @param string $command
     * @return self
     */
    public function setCommand(string $command): self;
}
