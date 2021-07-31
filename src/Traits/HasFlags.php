<?php

namespace IsaEken\Strargs\Traits;

use Illuminate\Support\Str;

trait HasFlags
{
    /**
     * @var array $flags
     */
    public array $flags = [];

    /**
     * @inheritDoc
     */
    public function getFlags(): array
    {
        $flags = [];
        foreach ($this->flags as $key => $flag) {
            $flags[$key] = mb_strtolower($flag);
        }

        return $flags;
    }

    /**
     * @inheritDoc
     */
    public function setFlags(array $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasFlag(string $name): bool
    {
        return in_array(mb_strtolower($name), $this->getFlags());
    }

    /**
     * @inheritDoc
     */
    public function addFlag(string $name): self
    {
        if (! $this->hasFlag($name)) {
            $this->flags[] = mb_strtolower($name);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeFlag(string $name): self
    {
        if ($this->hasFlag($name)) {
            $flags = $this->getFlags();
            unset($flags[array_search(mb_strtolower($name), $flags)]);
            $this->flags = $flags;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function decodeFlags(): self
    {
        $flags = [];
        foreach (Str::of($this->getString())->explode(' ') as $part) {
            if (strlen($part) == 2 && str_starts_with($part, '-')) {
                $flags[] = mb_strtolower(substr($part, 1));
            }
            else if (!str_contains($part, '=') && !str_contains($part, '"') && str_starts_with($part, '--')) {
                $flags[] = mb_strtolower(substr($part, 2));
            }
        }

        return $this->setFlags($flags);
    }

    /**
     * @inheritDoc
     */
    public function encodeFlags(): string
    {
        $flags = '';
        foreach ($this->getFlags() as $key => $value) {
            if (!($value == 'q' || $value == 'v' || $value == 'vv' || $value == 'vvv' || $value == 'quiet')) {
                $flags .= (mb_strlen($value) > 1 ? '--' : '-') . $value . ' ';
            }
        }

        return mb_strlen($flags) > 0 ? mb_substr($flags, 0, -1) : '';
    }
}
