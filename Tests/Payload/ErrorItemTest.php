<?php

namespace Rollbar\Symfony\RollbarBundle\Tests\Payload;

use Rollbar\Symfony\RollbarBundle\Payload\ErrorItem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ErrorItemTest
 *
 * @package Rollbar\Symfony\RollbarBundle\Tests
 */
class ErrorItemTest extends KernelTestCase
{
    /**
     * Test invoke.
     *
     * @dataProvider generateInvoke
     *
     * @param int    $code
     * @param string $message
     * @param string $file
     * @param int    $line
     * @param string $mapped
     */
    public function testInvoke(int $code, string $message, string $file, int $line, string $mapped): void
    {
        $item = new ErrorItem();
        $data = $item($code, $message, $file, $line);

        $this->assertNotEmpty($data['exception']);
        $this->assertNotEmpty($data['frames']);

        $exception = $data['exception'];
        $this->assertEquals($mapped, $exception['class']);
        $this->assertStringContainsString($message, $exception['message']);

        $this->assertCount(1, $data['frames']);

        $frame = $data['frames'][0];
        $this->assertEquals($file, $frame['filename']);
        $this->assertEquals($line, $frame['lineno']);
    }

    /**
     * Data provider for testInvoke.
     *
     * @return array
     * @throws \Exception
     */
    public function generateInvoke(): array
    {
        return [
            [E_ERROR, 'Error message - ' . microtime(true), __FILE__, random_int(1, 100), 'E_ERROR'],
            [E_WARNING, 'Error message - ' . microtime(true), __FILE__, random_int(1, 100), 'E_WARNING'],
            [E_PARSE, 'Error message - ' . microtime(true), __FILE__, random_int(1, 100), 'E_PARSE'],
            [E_NOTICE, 'Error message - ' . microtime(true), __FILE__, random_int(1, 100), 'E_NOTICE'],
            [E_CORE_ERROR, 'Error message - ' . microtime(true), __FILE__, random_int(1, 100), 'E_CORE_ERROR'],
        ];
    }
}
