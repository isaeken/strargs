<?php


namespace IsaEken\Strargs;


use Illuminate\Support\Str;
use IsaEken\Strargs\Contracts\HasArguments;
use IsaEken\Strargs\Contracts\HasCommand;
use IsaEken\Strargs\Contracts\HasFlags;
use IsaEken\Strargs\Contracts\HasOptions;
use IsaEken\Strargs\Contracts\HasVerbose;

class Strargs implements HasCommand, HasFlags, HasArguments, HasOptions, HasVerbose
{
    use Traits\HasCommand;
    use Traits\HasFlags;
    use Traits\HasArguments;
    use Traits\HasOptions;
    use Traits\HasVerbose;

    /**
     * Strargs constructor.
     *
     * @param string $string
     */
    public function __construct(public string $string = '')
    {
        // ...
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function setString(string $string): self
    {
        $this->string = $string;
        return $this;
    }

    /**
     * @return self
     */
    public function decode(): self
    {
        return $this
            ->decodeCommand()
            ->decodeArguments()
            ->decodeOptions()
            ->decodeFlags()
            ->decodeVerbose();
    }

    /**
     * @return string
     */
    public function encode(): string
    {
        $arguments = $this->encodeArguments();
        $options = $this->encodeOptions();
        $flags = $this->encodeFlags();
        $verbose = $this->encodeVerbose();

        $string = $this->getCommand();

        if (mb_strlen($arguments) > 0) {
            $string .= ' ' . $arguments;
        }

        if (mb_strlen($options) > 0) {
            $string .= ' ' . $options;
        }

        if (mb_strlen($flags) > 0) {
            $string .= ' ' . $flags;
        }

        if (mb_strlen($verbose) > 0) {
            $string .= ' ' . $verbose;
        }

        return $this->setString(trim($string))->getString();
    }
}
