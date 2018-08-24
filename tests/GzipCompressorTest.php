<?php

namespace LilyLabs\DBBackup\Tests;

use PHPUnit\Framework\TestCase;

use LilyLabs\DBBackup\BasicBackupFileNameGenerator;
use LilyLabs\DBBackup\DBBackupFile;
use LilyLabs\DBBackup\GzipCompressor;

class GzipCompressorTest extends TestCase
{
    public function test_compress_a_backup_file()
    {
        $path = "./tests/test_db.sql";
        touch($path);

        $backup_file = new DBBackupFile($path);
        $compressor = new GzipCompressor();
        $compressed_backup_file = $compressor->compress($backup_file);
        $this->assertTrue($compressed_backup_file->exists());
        $this->assertEquals($compressed_backup_file->extension(), 'gz');
        unlink($compressed_backup_file->path());
    }

    /**
     * @expectedException Exception
     **/
    public function test_for_some_reason_the_backupfile_is_not_available()
    {
        $path = "./tests/test2_db.sql";
        touch($path);

        $backup_file = new DBBackupFile($path);
        unlink($path);
        $compressor = new GzipCompressor();
        $compressed_backup_file = $compressor->compress($backup_file);
    }
}
