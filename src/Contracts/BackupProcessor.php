<?php

namespace LilyLabs\DBBackup\Contracts;

interface BackupProcessor
{
    public function execute() : BackupFile;
}