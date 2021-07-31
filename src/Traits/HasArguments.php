<?php

namespace IsaEken\Strargs\Traits;

use Illuminate\Support\Str;
use IsaEken\Strargs\Helpers;

trait HasArguments
{
    /**
     * @var array $arguments
     */
    public array $arguments = [];

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        $arguments = [];
        foreach ($this->arguments as $key => $value) {
            $arguments[mb_strtolower($key)] = $value;
        }

        return $arguments;
    }

    /**
     * @inheritDoc
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasArgument(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->getArguments());
    }

    /**
     * @inheritDoc
     */
    public function getArgument(string $name): string|bool|int|float|null
    {
        if ($this->hasArgument($name)) {
            return $this->getArguments()[mb_strtolower($name)];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function setArgument(string $name, string|bool|int|float|null $value): self
    {
        $this->arguments[mb_strtolower($name)] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeArgument(string $name): self
    {
        if ($this->hasArgument($name)) {
            unset($this->arguments[mb_strtolower($name)]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function decodeArguments(): self
    {
        $arguments = [];
        $string = preg_replace('/--(.[a-z0-9]+)=((["\\\'])(.*?[^\\\\])\\3|([a-zA-Z0-9\\.]+))/', '', $this->getString());
        $string2 = '';

        foreach (Str::of($string)->explode(' ')->except(0) as $part) {
            if (! str_starts_with($part, '-')) {
                $string2 .= $part . ' ';
            }
        }

        preg_match_all("/(([\"'])(.*?[^\\\\])\\2+|([a-zA-Z0-9\\.]+))/", $string2, $arguments_array);

        foreach ($arguments_array[1] as $index => $value) {
            $arguments[$index] = Helpers::stringToValue($value);
        }

        return $this->setArguments($arguments);
    }

    /**
     * @inheritDoc
     */
    public function encodeArguments(): string
    {
        $arguments = '';
        foreach ($this->getArguments() as $value) {
            $arguments .= Helpers::valueToString($value) . ' ';
        }

        return mb_strlen($arguments) > 0 ? mb_substr($arguments, 0, -1) : '';
    }
}
