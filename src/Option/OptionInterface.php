<?php

namespace Iceproductionz\StreamQif\Option;

interface OptionInterface
{
    public function getLineEnding(): string;

    public function getRowEnding(): string;
}