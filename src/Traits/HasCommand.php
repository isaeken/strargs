<?php

namespace IsaEken\Strargs\Traits;

use Illuminate\Support\Str;

trait HasCommand
{
    /**
     * @var string $command
     */
    public string $command = '';

    /**
     * @inheritDoc
     */
    public function getCommand(): string
    {
        return mb_strtolower($this->command);
    }

    /**
     * @inheritDoc
     */
    public function setCommand(string $command): self
    {
        $this->command = mb_strtolower($command);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function decodeCommand(): self
    {
        $this->setCommand(Str::of($this->getString())->explode(' ')->first());
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function encodeCommand(): string
    {
        return $this->getCommand();
    }
}
