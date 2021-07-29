<?php


namespace IsaEken\Strargs;


use Illuminate\Support\Str;
use IsaEken\Strargs\Contracts\HasArguments;
use IsaEken\Strargs\Contracts\HasCommand;
use IsaEken\Strargs\Contracts\HasOptions;

class Strargs implements HasCommand, HasArguments, HasOptions
{
    /**
     * @var string $command
     */
    public string $command = '';

    /**
     * @var array $arguments
     */
    public array $arguments = [];

    /**
     * @var array $options
     */
    public array $options = [];

    /**
     * @var bool $short
     */
    public bool $short = false;

    /**
     * Strargs constructor.
     *
     * @param string $string
     */
    public function __construct(
        public string $string = '',
    )
    {
        // ...
    }

    /**
     * @return $this
     */
    public function enableShort(): static
    {
        $this->short = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableShort(): static
    {
        $this->short = false;
        return $this;
    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function setShort(bool $enable = false): static
    {
        $this->short = $enable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShort(): bool
    {
        return $this->short;
    }

    /**
     * @inheritDoc
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @inheritDoc
     */
    public function setCommand(string $command): static
    {
        $this->command = mb_strtolower($command);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasArgument(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->arguments);
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @inheritDoc
     */
    public function getArgument(string $name): string|bool|int|float|null
    {
        if ($this->hasArgument($name)) {
            return $this->arguments[mb_strtolower($name)];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function setArgument(string $name, float|bool|int|string $value): static
    {
        $this->arguments[mb_strtolower($name)] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeArgument(string $name): static
    {
        if ($this->hasArgument($name)) {
            unset($this->arguments[mb_strtolower($name)]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function hasOption(string $name): bool
    {
        return in_array(mb_strtolower($name), $this->options);
    }

    /**
     * @inheritDoc
     */
    public function addOption(string $name): static
    {
        if (! $this->hasOption($name)) {
            $this->options[] = mb_strtolower($name);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeOption(string $name): static
    {
        if ($this->hasOption($name)) {
            if (($key = array_search(mb_strtolower($name), $this->options)) !== false) {
                unset($this->options[$key]);
            }
        }

        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($this->hasArgument($name)) {
            return $this->getArgument($name);
        }

        return $this->$name;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value): void
    {
        if (is_string($value) || is_bool($value) || is_int($value) || is_float($value)) {
            $this->setArgument($name, $value);
            return;
        }

        $this->$name = $value;
    }

    /**
     * @return $this
     */
    public function decode(): static
    {
        if (mb_strlen($this->string) < 1) {
            return $this;
        }

        $string = Str::of($this->string);
        $this->command = $string->explode(' ')->first();

        $arguments = [];
        $options = [];

        if ($this->short === true) {
            $string2 = '';
            foreach ($string->explode(' ')->except(0) as $part) {
                if (! str_starts_with($part, '-')) {
                    $string2 .= $part . ' ';
                }
            }

            preg_match_all("/(([\"'])(.*?[^\\\\])\\2+|([a-zA-Z0-9\\.]+))/", $string2, $arguments_array);

            foreach ($arguments_array[1] as $index => $value) {
                $arguments[$index] = Helpers::stringToValue($value);
            }
        }
        else {
            preg_match_all("/--(.[a-z0-9]+)=(([\"'])(.*?[^\\\\])\\3|([a-zA-Z0-9\\.]+))/", $string, $arguments_array);

            foreach ($arguments_array[1] as $index => $key) {
                $value = $arguments_array[2][$index];
                $arguments[mb_strtolower($key)] = Helpers::stringToValue($value);
            }
        }

        foreach ($string->explode(' ') as $part) {
            if (strlen($part) == 2 && str_starts_with($part, '-')) {
                $options[] = mb_strtolower(substr($part, 1));
            }
        }

        $this->options = $options;
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return string
     */
    public function encode(): string
    {
        $arguments = '';
        foreach ($this->getArguments() as $key => $value) {
            $value = Helpers::valueToString($value);

            if ($this->short === true) {
                $arguments .= $value . ' ';
            }
            else {
                $arguments .= '--' . $key . '=' . $value . ' ';
            }
        }

        $options = '';
        foreach ($this->getOptions() as $option) {
            $options .= '-' . $option . ' ';
        }

        return $this->string = Str::of(trim(sprintf(
            '%s %s %s',
            $this->command,
            $arguments,
            $options,
        )))->replace('  ', ' ')->__toString();
    }
}
