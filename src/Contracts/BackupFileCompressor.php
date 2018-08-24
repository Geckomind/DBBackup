<?php

namespace LilyLabs\DBBackup\Contracts;

use Exception;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

interface BackupFileCompressor
{
    public function compress(BackupFile $backupFile) : BackupFile;
}