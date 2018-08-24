<?php

namespace LilyLabs\DBBackup\Contracts;

interface BackupFileNameGenerator
{
    public function getName() : string;
}