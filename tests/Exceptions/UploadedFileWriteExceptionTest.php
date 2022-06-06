<?php

namespace SertxuDeveloper\Media\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use SertxuDeveloper\Media\Exceptions\UploadedFileWriteException;

class UploadedFileWriteExceptionTest extends TestCase {

    /**
     * Check that the exception is correctly thrown when the temporary file cannot be written.
     *
     * @return void
     */
    public function test_cannot_write_temporary_file_message(): void {
        $exception = UploadedFileWriteException::cannotWriteTemporaryFile('/tmp/foo.bar');
        $this->assertEquals('Cannot write temporary file for `/tmp/foo.bar`', $exception->getMessage());
    }

    /**
     * Check that the exception is correctly thrown when the temporary file cannot be moved.
     *
     * @return void
     */
    public function test_cannot_move_temporary_file_message(): void {
        $exception = UploadedFileWriteException::cannotMoveTemporaryFile('/tmp/foo.bar', '/tmp/bar.foo');
        $this->assertInstanceOf(UploadedFileWriteException::class, $exception);
        $this->assertEquals("Cannot move temporary file from `/tmp/foo.bar` to `/tmp/bar.foo`", $exception->getMessage());
    }
}
