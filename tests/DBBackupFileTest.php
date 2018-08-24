<?php

namespace LilyLabs\DBBackup\Tests;

use PHPUnit\Framework\TestCase;

use LilyLabs\DBBackup\BasicBackupFileNameGenerator;
use LilyLabs\DBBackup\DBBackupFile;
use DateTime;
use Exception;

class DBBackupFileTest extends TestCase
{
    /** @test */
    public function test_basic_filename_generator()
    {
        $path = "./test_db.sql";
        touch($path);
        
        $backup_file = new DBBackupFile($path);
        
        $this->assertEquals($backup_file->basename(), basename($path));
        $this->assertEquals(
            $backup_file->name(),
            str_replace('.sql', '', basename($path))
        );
        $this->assertEquals($backup_file->path(), $path);
        $this->assertEquals($backup_file->dirname(), dirname($path));
        $this->assertEquals($backup_file->extension(), 'sql');
        unlink($backup_file->path());
    }

    /**
     * @expectedException Exception
     **/
    public function test_validates_existence_of_path_before_instantiate()
    {
        $path = "non/existent/path.sql";
        $backup_file = new DBBackupFile($path);
    }

    public function test_copy_backup_file()
    {
        $path = "./test.sql";
        touch($path);
        $backup_file = new DBBackupFile($path);
        $copied_backup_file = $backup_file->copy("./(2){$backup_file->basename()}");
        $this->assertTrue($copied_backup_file->exists());
        $this->assertTrue($backup_file->exists());
        unlink($copied_backup_file->path());
        unlink($backup_file->path());
    }

    /**
     * @expectedException Exception
     */
    public function test_exception_when_failed_to_copy_file()
    {
        try {
            $path = "./test2.sql";
            touch($path);
            $backup_file = new DBBackupFile($path);
            $backup_file->copy("none/exitent/folder/loco.sql");    
        } catch (Exception $e) {
            unlink($path);
            throw $e;
        }
        
    }

    public function test_move_backup_file()
    {
        $path = "./test3.sql";
        touch($path);
        $backup_file = new DBBackupFile($path);
        $moved_backup_file = $backup_file->move("./(3){$backup_file->basename()}");
        $this->assertTrue($moved_backup_file->exists());
        $this->assertTrue($backup_file->exists() == false);
        unlink($moved_backup_file->path());
    }

    /**
     * @expectedException Exception
     */
    public function test_exception_when_failed_to_move_file()
    {
        try {
            $path = "./test4.sql";
            touch($path);
            $backup_file = new DBBackupFile($path);
            $backup_file->move("non/exitent/folder/loco.sql");    
        } catch (Exception $e) {
            unlink($path);
            throw $e;
        }
    }
}
