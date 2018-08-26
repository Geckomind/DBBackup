<?php

namespace LilyLabs\DBBackup;

use LilyLabs\DBBackup\Contracts\BackupFileNameGenerator;
use LilyLabs\DBBackup\Contracts\BackupProcessor;
use LilyLabs\DBBackup\Contracts\BackupFile;
use Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Ejecuta mysqldump para respaldar la base de datos indicada con ayuda de
 * symfony/process 
 * 
 * @package LilyLabs\DBBackup
 * @author Abraham Chávez
 */
class MysqlDumpBackupProcessor implements BackupProcessor
{
    private $db_name;
    private $backupFilenameGenerator;


    function __construct(string $db_name, BackupFileNameGenerator $backupFilenameGenerator)
    {
        $this->db_name = $db_name;
        $this->backupFilenameGenerator = $backupFilenameGenerator;
    }

   	public function execute() : BackupFile
    {
    	$filepath = $this->getFilePath();
        $process = new Process("mysqldump --login-path=local {$this->db_name} --single-transaction > {$filepath}");
        try {
            $process->mustRun();
            return new DBBackupFile($filepath);
        } catch (ProcessFailedException $exception) {
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            throw new Exception($process->getErrorOutput());
        }
    }

    private function getFilePath() : string
    {
    	return sys_get_temp_dir()."/{$this->backupFilenameGenerator->getName()}";
    }
}