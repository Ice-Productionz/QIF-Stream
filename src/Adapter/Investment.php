<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Row\Data\DataInterface;
use Iceproductionz\StreamQif\Row\Data\Investment\Account;
use Iceproductionz\StreamQif\Row\Data\Investment\Action;
use Iceproductionz\StreamQif\Row\Data\Investment\Amount;
use Iceproductionz\StreamQif\Row\Data\Investment\Cleared;
use Iceproductionz\StreamQif\Row\Data\Investment\Commission;
use Iceproductionz\StreamQif\Row\Data\Investment\Date;
use Iceproductionz\StreamQif\Row\Data\Investment\Memo;
use Iceproductionz\StreamQif\Row\Data\Investment\Price;
use Iceproductionz\StreamQif\Row\Data\Investment\Quantity;
use Iceproductionz\StreamQif\Row\Data\Investment\Security;
use Iceproductionz\StreamQif\Row\Data\Investment\Transaction;

class Investment implements AdapterInterface
{
    private const VALUES = [
        'C' => Cleared::class,
        'D' => Date::class,
        'L' => Account::class,
        'M' => Memo::class,
        'N' => Action::class,
        'O' => Commission::class,
        'Q' => Quantity::class,
        'I' => Price::class,
        'T' => Transaction::class,
        'Y' => Security::class,
        '$' => Amount::class,


    ];

    public function fromStream(string $line): DataInterface
    {
        $initialCharacter = substr($line, 0, 1);

        if (isset(static::VALUES[$initialCharacter])) {
            $arg0 = substr($line, 1);
            $className = static::VALUES[$initialCharacter];
            return new $className($arg0);
        }
    }

    public function toStream($line)
    {
        // TODO: Implement toStream() method.
    }
}