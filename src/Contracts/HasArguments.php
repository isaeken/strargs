<?php


namespace IsaEken\Strargs\Contracts;


interface HasArguments
{
    /**
     * Get the all arguments.
     *
     * @return array
     */
    public function getArguments(): array;

    /**
     * Set the all arguments.
     *
     * @param array $arguments
     * @return self
     */
    public function setArguments(array $arguments): self;

    /**
     * Check the argument is exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasArgument(string $name): bool;

    /**
     * Get the specific argument.
     *
     * @param string $name
     * @return string|bool|int|float|object|array|null
     */
    public function getArgument(string $name): string|bool|int|float|object|array|null;

    /**
     * Set the specific argument.
     *
     * @param string $name
     * @param string|bool|int|float|object|array|null $value
     * @return self
     */
    public function setArgument(string $name, string|bool|int|float|object|array|null $value): self;

    /**
     * Remove the specific argument.
     *
     * @param string $name
     * @return self
     */
    public function removeArgument(string $name): self;

    /**
     * Decode the arguments.
     *
     * @return self
     */
    public function decodeArguments(): self;

    /**
     * Encode the arguments.
     *
     * @return string
     */
    public function encodeArguments(): string;
}
