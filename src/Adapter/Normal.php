<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Data\DataInterface;
use Iceproductionz\StreamQif\Row\Data\Normal\Address;
use Iceproductionz\StreamQif\Row\Data\Normal\Amount;
use Iceproductionz\StreamQif\Row\Data\Normal\Category;
use Iceproductionz\StreamQif\Row\Data\Normal\CategorySplit;
use Iceproductionz\StreamQif\Row\Data\Normal\ClearedStatus;
use Iceproductionz\StreamQif\Row\Data\Normal\AmountSplit;
use Iceproductionz\StreamQif\Row\Data\Normal\Date;
use Iceproductionz\StreamQif\Row\Data\Normal\Memo;
use Iceproductionz\StreamQif\Row\Data\Normal\MemoSplit;
use Iceproductionz\StreamQif\Row\Data\Normal\Payee;
use Iceproductionz\StreamQif\Row\Data\Normal\ReferenceNumber;

class Normal implements AdapterInterface
{
    private const VALUES = [
        'A' => Address::class,
        'C' => ClearedStatus::class,
        'D' => Date::class,
        'E' => MemoSplit::class,
        'L' => Category::class,
        'M' => Memo::class,
        'N' => ReferenceNumber::class,
        'P' => Payee::class,
        'S' => CategorySplit::class,
        'T' => Amount::class,
        '$' => AmountSplit::class,
    ];

    /**
     * Convert a line to a data object
     *
     * @param string $line
     *
     * @return DataInterface
     * @throws NotSupported
     */
    public function fromStream(string $line): DataInterface
    {
        $initialCharacters = substr($line, 0, 2);
        if (isset(static::VALUES[$initialCharacters])) {
            $arg0 = substr($line, 2);
            $className = static::VALUES[$initialCharacters];
            return new $className($arg0);
        }

        $initialCharacter = $line[0];
        if (isset(static::VALUES[$initialCharacter])) {
            $arg0 = substr($line, 1);
            $className = static::VALUES[$initialCharacter];
            return new $className($arg0);
        }

        throw new NotSupported('Unable to convert line to a data object: ' . $line);
    }

    /**
     * Prep data object for streaming
     *
     * @param DataInterface $data
     *
     * @return string
     * @throws NotSupported
     */
    public function toStream(DataInterface $data): string
    {
        foreach (static::VALUES as $key => $value) {
            if ($data instanceof $value) {
                return $key . $data->getRaw() ."\r\n";
            }
        }

        throw new NotSupported('Unable to convert data object to stream value');
    }
}