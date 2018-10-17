<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Data\Account\CreditLimit;
use Iceproductionz\StreamQif\Row\Data\Account\Description;
use Iceproductionz\StreamQif\Row\Data\Account\Name;
use Iceproductionz\StreamQif\Row\Data\Account\StatementBalance\Amount;
use Iceproductionz\StreamQif\Row\Data\Account\StatementBalance\Date;
use Iceproductionz\StreamQif\Row\Data\Account\Type;
use Iceproductionz\StreamQif\Row\Data\DataInterface;

class Account
{
    private const VALUES = [
        'N' => Name::class,
        'T' => Type::class,
        'D' => Description::class,
        'L' => CreditLimit::class,
        '/' => Date::class,
        '$' => Amount::class
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
