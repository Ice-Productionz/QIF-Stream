<?php declare(strict_types=1);

namespace IceproductionzTest\Integration\Stream\Qif;

use Iceproductionz\StreamQif\Adapter\AdapterInterface;
use Iceproductionz\StreamQif\Adapter\Investment;
use Iceproductionz\StreamQif\Qif;
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
use Iceproductionz\StreamQif\Row\Row;
use PHPUnit\Framework\TestCase;

class QifTest extends TestCase
{
    private $handle;

    private $adapter;

    public function setUp()
    {
        parent::setUp();

        $this->adapter = $this->createMock(AdapterInterface::class);
        $this->handle = tmpfile();
    }

    /**
     * Test Construction
     */
    public function testConstruction(): void
    {
        $sut = new Qif($this->handle, $this->adapter);

        $this->assertInstanceOf(Qif::class, $sut);
    }

    /**
     * @dataProvider provideData
     *
     * @param AdapterInterface $adapter
     * @param array            $rows
     */
    public function testReadAndWrite($adapter, $rows): void
    {
        $sut = new Qif(tmpfile(), new $adapter);

        $data = new Row($rows);

        $sut->write($data);
        $sut->rewind();
        $result = $sut->read();

        foreach ($result->all() as $i => $item) {
            $expectedObject = $rows[$i];
            $this->assertInstanceOf(\get_class($expectedObject), $item);
            $this->assertSame($item->getRaw(), $expectedObject->getRaw());
        }
    }

    public function provideData(): array
    {
        return [
            'investment adapter' => [
                Investment::class,
               [
                    new AccountForTransfer('AFT'),
                    new Action('Action'),
                    new AmountTransferred('AmountTransferred'),
                    new ClearedStatus('ClearedStatus'),
                    new Commission('Commision'),
                    new Date('Date'),
                    new InitialData('Value'),
                    new Memo('Memo'),
                    new Price('Price'),
                    new Quantity('Quantity'),
                    new Security('Security'),
                    new TransactionAmount('TransactionAmount')
                ],
            ],
            'memorized adapter' => [

            ],
            'normal adapter' => [

            ]
        ];
    }
}