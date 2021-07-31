<?php

namespace IsaEken\Strargs\Traits;

use Illuminate\Support\Str;
use IsaEken\Strargs\Enums\VerboseLevel;

trait HasVerbose
{
    /**
     * @var string $verbose
     */
    public string $verbose = VerboseLevel::NORMAL;

    /**
     * @inheritDoc
     */
    public function getVerbose(): string
    {
        return $this->verbose;
    }

    /**
     * @inheritDoc
     */
    public function setVerbose(string $verbose): self
    {
        $this->verbose = $verbose;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function decodeVerbose(): self
    {
        $verbose = VerboseLevel::NORMAL;
        foreach (Str::of($this->getString())->explode(' ') as $part) {
            if ($part == '-q' || $part == '--quiet') {
                $verbose = VerboseLevel::QUIET;
            }
            else if ($part == '-v') {
                $verbose = VerboseLevel::VERBOSE;
            }
            else if ($part == '-vv') {
                $verbose = VerboseLevel::VERY_VERBOSE;
            }
            else if ($part == '-vvv') {
                $verbose = VerboseLevel::DEBUG;
            }
        }

        return $this->setVerbose($verbose);
    }

    /**
     * @return string
     */
    public function encodeVerbose(): string
    {
        if ($this->getVerbose() == VerboseLevel::DEBUG) {
            return '-vvv';
        }
        else if ($this->getVerbose() == VerboseLevel::VERY_VERBOSE) {
            return '-vv';
        }
        else if ($this->getVerbose() == VerboseLevel::VERBOSE) {
            return '-v';
        }
        else if ($this->getVerbose() == VerboseLevel::QUIET) {
            return '-q';
        }

        return '';
    }
}
