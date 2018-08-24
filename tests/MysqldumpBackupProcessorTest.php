<?php

namespace LilyLabs\DBBackup\Tests;

use PHPUnit\Framework\TestCase;

use LilyLabs\DBBackup\BasicBackupFileNameGenerator;
use LilyLabs\DBBackup\MysqldumpBackupProcessor;
use DateTime;


class MysqldumpBackupProcessorTest extends TestCase
{
    /**
     * @covers LilyLabs\DBBackup\MysqldumpBackupProcessor::getFilePath
     * @covers LilyLabs\DBBackup\MysqldumpBackupProcessor::__construct
     */
    public function test_backup_file_generation()
    {
        $db_name = "nexus3";
        $date = new DateTime('now');
        
        $backup_processor = new MysqldumpBackupProcessor(
            $db_name,
            new BasicBackupFileNameGenerator($db_name, $date)
        );
        $backup_file = $backup_processor->execute();
        
        $this->assertTrue($backup_file->exists());
    }

    /**
     * @covers LilyLabs\DBBackup\MysqldumpBackupProcessor::getFilePath
     * @covers LilyLabs\DBBackup\MysqldumpBackupProcessor::__construct
     * @expectedException Exception
     **/
    public function test_exception_on_non_existent_database()
    {
        $db_name = "non_existent_db";
        $date = new DateTime('now');
        
        $backup_processor = new MysqldumpBackupProcessor(
            $db_name,
            new BasicBackupFileNameGenerator($db_name, $date)
        );
        $backup_file = $backup_processor->execute();
    }
}
