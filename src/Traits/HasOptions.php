<?php

namespace IsaEken\Strargs\Traits;

use IsaEken\Strargs\Helpers;

trait HasOptions
{
    /**
     * @var array $options
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        $options = [];
        foreach ($this->options as $key => $value) {
            $options[mb_strtolower($key)] = $value;
        }

        return $options;
    }

    /**
     * @inheritDoc
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasOption(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->getOptions());
    }

    /**
     * @inheritDoc
     */
    public function getOption(string $name): string|bool|int|float|array|null
    {
        if ($this->hasOption($name)) {
            return $this->getOptions()[mb_strtolower($name)];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function setOption(string $name, string|bool|int|float|array|null $value): self
    {
        $this->options[mb_strtolower($name)] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeOption(string $name): self
    {
        if ($this->hasOption($name)) {
            unset($this->options[mb_strtolower($name)]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function decodeOptions(): self
    {
        $options = [];
        preg_match_all("/--(.[a-z0-9]+)=(([\"'])(.*?[^\\\\])\\3|([a-zA-Z0-9\\.]+))/", $this->getString(), $options_array);

        foreach ($options_array[1] as $index => $key) {
            $value = $options_array[2][$index];
            $options[mb_strtolower($key)] = Helpers::stringToValue($value);
        }

        $array_options = [];
        preg_match_all("/--(.[a-z0-9]+)\\[\\]=(([\"'])(.*?[^\\\\])\\3|([a-zA-Z0-9\\.]+))/", $this->getString(), $array_options_array);
        foreach ($array_options_array[1] as $index => $key) {
            $value = Helpers::stringToValue($array_options_array[2][$index]);

            if (!array_key_exists($key, $array_options)) {
                $array_options[$key] = [];
            }

            $array_options[$key][] = $value;
        }

        foreach ($array_options as $name => $array) {
            $options[$name] = $array;
        }

        return $this->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function encodeOptions(): string
    {
        $options = '';
        foreach ($this->getOptions() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $options .= '--' . $key . '[]=' . Helpers::valueToString($item) . ' ';
                }
            }
            else {
                $options .= '--' . $key . '=' . Helpers::valueToString($value) . ' ';
            }
        }

        return mb_strlen($options) > 0 ? mb_substr($options, 0, -1) : '';
    }
}
