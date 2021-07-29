<?php


namespace IsaEken\Strargs\Contracts;


interface HasArguments
{
    /**
     * Check the argument is exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool;

    /**
     * Get the all arguments.
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Get the specific argument.
     *
     * @param string $name
     * @return string|bool|int|float|null
     */
    public function getArgument(string $name): string|bool|int|float|null;

    /**
     * Set the specific argument.
     *
     * @param string $name
     * @param string|bool|int|float $value
     * @return self
     */
    public function setArgument(string $name, string|bool|int|float $value): self;

    /**
     * Remove the specific argument.
     *
     * @param string $name
     * @return self
     */
    public function removeArgument(string $name): self;
}
