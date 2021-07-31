<?php


namespace IsaEken\Strargs\Contracts;


interface HasFlags
{
    /**
     * Get the all flags.
     *
     * @return array
     */
    public function getFlags(): array;

    /**
     * Set the all flags.
     *
     * @param array $flags
     * @return self
     */
    public function setFlags(array $flags): self;

    /**
     * Check the flag is exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasFlag(string $name): bool;

    /**
     * Add a new flag.
     *
     * @param string $name
     * @return self
     */
    public function addFlag(string $name): self;

    /**
     * Remove the specific flag.
     *
     * @param string $name
     * @return self
     */
    public function removeFlag(string $name): self;

    /**
     * Decode the flags.
     *
     * @return self
     */
    public function decodeFlags(): self;

    /**
     * Encode the flags.
     *
     * @return string
     */
    public function encodeFlags(): string;
}
