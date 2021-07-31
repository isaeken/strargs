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
     * Set the all options.
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self;

    /**
     * Check the option is exists.
     *
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name): bool;

    /**
     * Get the specific option.
     *
     * @param string $name
     * @return string|bool|int|float|null
     */
    public function getOption(string $name): string|bool|int|float|null;

    /**
     * Set the specific option.
     *
     * @param string $name
     * @param string|bool|int|float|null $value
     * @return self
     */
    public function setOption(string $name, string|bool|int|float|null $value): self;

    /**
     * Remove the specific option.
     *
     * @param string $name
     * @return self
     */
    public function removeOption(string $name): self;

    /**
     * Decode the options.
     *
     * @return self
     */
    public function decodeOptions(): self;

    /**
     * Encode the options.
     *
     * @return string
     */
    public function encodeOptions(): string;
}
