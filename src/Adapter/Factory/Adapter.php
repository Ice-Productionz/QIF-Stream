<?php

namespace Iceproductionz\StreamQif\Adapter\Factory;

use Iceproductionz\StreamQif\Adapter\Account;
use Iceproductionz\StreamQif\Adapter\AdapterInterface;
use Iceproductionz\StreamQif\Adapter\CategoryList;
use Iceproductionz\StreamQif\Adapter\ClassList;
use Iceproductionz\StreamQif\Adapter\Investment;
use Iceproductionz\StreamQif\Adapter\Memorized;
use Iceproductionz\StreamQif\Adapter\Normal;
use Iceproductionz\StreamQif\Exception\InvalidValue;

class Adapter
{
    private const ADAPTERS = [
        '!Type:Bank'      => Normal::class,
        '!Type:Cash'      => Normal::class,
        '!Type:CCard'     => Normal::class,
        '!Type:Invst'     => Investment::class,
        '!Type:Oth A'     => Normal::class,
        '!Type:Oth L'     => Normal::class,
        '!Account'        => Account::class,
        '!Type:Cat'       => CategoryList::class,
        '!Type:Class'     => ClassList::class,
        '!Type:Memorized' => Memorized::class,

    ];

    /**
     * @param string $adapter
     *
     * @return AdapterInterface
     * @throws InvalidValue
     */
    public function makeAdapter(string $adapter): AdapterInterface
    {
        if (!isset(static::ADAPTERS[$adapter])) {
            throw new InvalidValue('$adapter not found');
        }

        $object = static::ADAPTERS[$adapter];

        return new $object;
    }
}