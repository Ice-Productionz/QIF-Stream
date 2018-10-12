<?php

namespace Iceproductionz\StreamQif;

use Iceproductionz\Stream\StreamInterface;
use Iceproductionz\StreamQif\Adapter\AdapterInterface;
use Iceproductionz\StreamQif\Exception\InvalidType;
use Iceproductionz\StreamQif\Exception\NotSupported;
use Iceproductionz\StreamQif\Row\Row;

class Qif implements StreamInterface
{
    private $handle;
    /**
     * @var AdapterInterface
     */
    private $adapter;

    public function __construct($handle, AdapterInterface $adapter)
    {
        $this->handle = $handle;
        $this->adapter = $adapter;
    }

    /**
     * Returns whether or not the stream is readable.
     *
     * @return bool
     */
    public function isReadable(): bool
    {
        throw new NotSupported('This method is currently not supported');
    }

    /**
     * Read data from the stream.
     *
     * @param int $length Read up to $length bytes from the object and return
     *     them. Fewer than $length bytes may be returned if underlying stream
     *     call returns fewer bytes.
     *
     * @return mixed Returns the data read from the stream
     * @throws \RuntimeException if an error occurs.
     */
    public function read(int $length = 0): Row
    {
        $row = new Row([]);
        while ($this->eof() === false) {
            $line = fread($this->handle, $length);
            $row->addItem($this->adapter->fromStream($line));
        }
        return $row;
    }

    /**
     * Write data to the stream.
     *
     * @param Row $data
     *
     * @return bool Returns the number of bytes written to the stream.
     */
    public function write($data): bool
    {
        if (!$data instanceof Row) {
            throw new InvalidType('$data is not an instance of ' . Row::class);
        }

        foreach ($data->all() as $item) {
            fwrite($this->handle, $this->adapter->toStream($item));
        }
        fwrite($this->handle, '^' . "\r\n");

        return true;
    }

    /**
     * Returns whether or not the stream is writable.
     *
     * @return bool
     */
    public function isWritable(): bool
    {
        throw new NotSupported('This method is currently not supported');
    }

    /**
     * Seek to the beginning of the stream.
     *
     * If the stream is not seekable, this method will raise an exception;
     * otherwise, it will perform a seek(0).
     *
     * @see seek()
     * @link http://www.php.net/manual/en/function.fseek.php
     * @throws \RuntimeException on failure.
     */
    public function rewind(): void
    {
        rewind($this->handle);
    }

    /**
     * Returns the current position of the file read/write pointer
     *
     * @return int Position of the file pointer
     * @throws \RuntimeException on error.
     */
    public function tell(): int
    {
        return ftell($this->handle);
    }

    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof(): bool
    {
        return feof($this->handle);
    }

    /**
     * Closes the stream and any underlying resources.
     *
     * @return void
     */
    public function close(): void
    {
        fclose($this->handle);
    }
}