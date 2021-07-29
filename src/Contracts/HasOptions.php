<?php


namespace IsaEken\Strargs\Contracts;


interface HasOptions
{
    /**
     * Get the all options.
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Check the option is exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name): bool;

    /**
     * Add the new option.
     *
     * @param string $name
     * @return $this
     */
    public function addOption(string $name): self;

    /**
     * Remove the exists option.
     *
     * @param string $name
     * @return $this
     */
    public function removeOption(string $name): self;
}
