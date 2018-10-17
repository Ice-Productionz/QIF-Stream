<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Data\Category\BudgetAmount;
use Iceproductionz\StreamQif\Row\Data\Category\Description;
use Iceproductionz\StreamQif\Row\Data\Category\ExpenseCategory;
use Iceproductionz\StreamQif\Row\Data\Category\IncomeCategory;
use Iceproductionz\StreamQif\Row\Data\Category\Name;
use Iceproductionz\StreamQif\Row\Data\Category\TaxRelated;
use Iceproductionz\StreamQif\Row\Data\Category\TaxSchedule;
use Iceproductionz\StreamQif\Row\Data\DataInterface;

class CategoryList implements AdapterInterface
{
    private const VALUES = [
        'N' => Name::class,
        'D' => Description::class,
        'T' => TaxRelated::class,
        'I' => IncomeCategory::class,
        'E' => ExpenseCategory::class,
        'B' => BudgetAmount::class,
        'R' => TaxSchedule::class,
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