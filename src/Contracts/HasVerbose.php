<?php

namespace IsaEken\Strargs\Contracts;

interface HasVerbose
{
    /**
     * Get the verbosity level.
     *
     * @return string
     */
    public function getVerbose(): string;

    /**
     * Set the verbosity level.
     *
     * @param string $verbose
     * @return self
     */
    public function setVerbose(string $verbose): self;

    /**
     * Decode the verbose level.
     *
     * @return self
     */
    public function decodeVerbose(): self;

    /**
     * Encode the verbose level.
     *
     * @return string
     */
    public function encodeVerbose(): string;
}
