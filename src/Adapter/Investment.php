<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Data\DataInterface;
use Iceproductionz\StreamQif\Row\Data\Investment\AccountForTransfer;
use Iceproductionz\StreamQif\Row\Data\Investment\Action;
use Iceproductionz\StreamQif\Row\Data\Investment\AmountTransferred;
use Iceproductionz\StreamQif\Row\Data\Investment\ClearedStatus;
use Iceproductionz\StreamQif\Row\Data\Investment\Commission;
use Iceproductionz\StreamQif\Row\Data\Investment\Date;
use Iceproductionz\StreamQif\Row\Data\Investment\InitialData;
use Iceproductionz\StreamQif\Row\Data\Investment\Memo;
use Iceproductionz\StreamQif\Row\Data\Investment\Price;
use Iceproductionz\StreamQif\Row\Data\Investment\Quantity;
use Iceproductionz\StreamQif\Row\Data\Investment\Security;
use Iceproductionz\StreamQif\Row\Data\Investment\TransactionAmount;

class Investment implements AdapterInterface
{
    private const VALUES = [
        'C' => ClearedStatus::class,
        'D' => Date::class,
        'I' => Price::class,
        'L' => AccountForTransfer::class,
        'M' => Memo::class,
        'N' => Action::class,
        'O' => Commission::class,
        'P' => InitialData::class,
        'Q' => Quantity::class,
        'T' => TransactionAmount::class,
        'Y' => Security::class,
        '$' => AmountTransferred::class,
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
            $arg0 = substr($line, 2, -1);
            $className = static::VALUES[$initialCharacters];
            return new $className($arg0);
        }

        $initialCharacter = $line[0];
        if (isset(static::VALUES[$initialCharacter])) {
            $arg0 = substr($line, 1, -1);
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