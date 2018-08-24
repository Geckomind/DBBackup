<?php

namespace LilyLabs\DBBackup\Contracts;

interface BackupFile
{
    public function name() : string;
    public function basename() : string;
    public function dirname() : string;
    public function extension() : string;
    public function path() : string;
    public function move(string $destination) : BackupFile;
    public function copy(string $destination) : BackupFile;
}