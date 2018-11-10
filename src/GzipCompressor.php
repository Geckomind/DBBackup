<?php

namespace LilyLabs\DBBackup;

use LilyLabs\DBBackup\Contracts\BackupFileCompressor;
use LilyLabs\DBBackup\Contracts\BackupFile;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Exception;

/**
 * Compresses a backup file using Gzip
 * 
 * @package LilyLabs\DBBackup
 * @author Abraham Chávez
 */
class GzipCompressor implements BackupFileCompressor
{
    
    public function compress(BackupFile $backup_file) : BackupFile
    {
        $filepath = $backup_file->path();
        $process = new Process("gzip -f {$filepath}");
        try {
            $process->mustRun();
            return new DBBackupFile($backup_file->dirname()."/".$backup_file->basename().".gz");
        } catch (ProcessFailedException $exception) {
            throw new Exception($process->getErrorOutput());
        }
    }
}