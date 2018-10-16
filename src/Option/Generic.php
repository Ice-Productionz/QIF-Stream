<?php

namespace Iceproductionz\StreamQif\Option;

class Generic implements OptionInterface
{
    /**
     * @return string
     */
    public function getLineEnding(): string
    {
        return "\r\n";
    }

    /**
     * @return string
     */
    public function getRowEnding(): string
    {
        return '^';
    }
}