<?php

namespace LilyLabs\DBBackup\Tests;

use PHPUnit\Framework\TestCase;

use LilyLabs\DBBackup\BasicBackupFileNameGenerator;
use DateTime;

class BackupFileNameGeneratorTest extends TestCase
{
    /** @test */
    public function test_basic_filename_generator()
    {
        $db_name = "DBTest";
        $date = new DateTime('now');
        $date_format = $date->format('Y-m-d');
        $filename_expected = "{$db_name}_{$date_format}.sql";
        $filename_generator = new BasicBackupFileNameGenerator($db_name, $date);
        $filename = $filename_generator->getName();
        $this->assertEquals($filename_expected, $filename);
    }
}
