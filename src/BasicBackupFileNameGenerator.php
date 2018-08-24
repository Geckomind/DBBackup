<?php

namespace LilyLabs\DBBackup;

use LilyLabs\DBBackup\Contracts\BackupFileNameGenerator;
use DateTime;

/**
 * Generates a filename for the backup file, in this case, the desired name
 * is as follows:
 * [db_name]_[year]-[month]-[day].sql
 *
 * @package LilyLabs\DBBackup
 * @author Abraham Chávez
 **/
class BasicBackupFileNameGenerator implements BackupFileNameGenerator
{
    private $db_name;
    private $date;

    public function __construct(string $db_name, DateTime $date)
    {
        $this->db_name = $db_name;
        $this->date = $date;
    }

    public function getName() : string
    {
        return "{$this->db_name}_{$this->date->format('Y-m-d')}.sql";
    }
} // END class BasicBackupFileNameGenerator