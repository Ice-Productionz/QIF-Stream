<?php

namespace Iceproductionz\StreamQif\Adapter;

use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Data\DataInterface;
use Iceproductionz\StreamQif\Row\Data\Memorized\Address;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\CurrentLoanBalance;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\FirstPaymentDate;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\InterestRate;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\OriginalLoanAmount;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\PaymentsAlreadyMade;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\PeriodsPerYear;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amortization\TotalYearsOfLoan;
use Iceproductionz\StreamQif\Row\Data\Memorized\Amount;
use Iceproductionz\StreamQif\Row\Data\Memorized\CategoryInSplit;
use Iceproductionz\StreamQif\Row\Data\Memorized\CategoryTransfer;
use Iceproductionz\StreamQif\Row\Data\Memorized\CheckTransaction;
use Iceproductionz\StreamQif\Row\Data\Memorized\ClearedStatus;
use Iceproductionz\StreamQif\Row\Data\Memorized\CurrencyAmount;
use Iceproductionz\StreamQif\Row\Data\Memorized\DepositTransaction;
use Iceproductionz\StreamQif\Row\Data\Memorized\ElectronicPayeeTransaction;
use Iceproductionz\StreamQif\Row\Data\Memorized\InvestmentTransaction;
use Iceproductionz\StreamQif\Row\Data\Memorized\Memo;
use Iceproductionz\StreamQif\Row\Data\Memorized\MemoInSplit;
use Iceproductionz\StreamQif\Row\Data\Memorized\Payee;
use Iceproductionz\StreamQif\Row\Data\Memorized\PaymentTransaction;

class Memorized implements AdapterInterface
{
    private const VALUES = [
        'KC' => CheckTransaction::class,
        'KD' => DepositTransaction::class,
        'KP' => PaymentTransaction::class,
        'KI' => InvestmentTransaction::class,
        'KE' => ElectronicPayeeTransaction::class,
        'T'  => Amount::class,
        'C'  => ClearedStatus::class,
        'P'  => Payee::class,
        'M'  => Memo::class,
        'A'  => Address::class,
        'L'  => CategoryTransfer::class,
        'S'  => CategoryInSplit::class,
        'E'  => MemoInSplit::class,
        '$'  => CurrencyAmount::class,
        '1'  => FirstPaymentDate::class,
        '2'  => TotalYearsOfLoan::class,
        '3'  => PaymentsAlreadyMade::class,
        '4'  => PeriodsPerYear::class,
        '5'  => InterestRate::class,
        '6'  => CurrentLoanBalance::class,
        '7'  => OriginalLoanAmount::class
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