<?php

namespace LilyLabs\DBBackup;

use LilyLabs\DBBackup\Contracts\BackupFile;
use DateTime;
use Exception;

/**
 * Represents a database backup file generated
 *
 * @package LilyLabs\DBBackup
 * @author Abraham Chávez
 **/
class DBBackupFile implements BackupFile
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
        if (!$this->exists()) {
            throw new Exception("The specified file don't exists [{$this->path}]");
        }
    }

    public function exists() : bool
    {
        return file_exists($this->path);
    }

    public function name() : string
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function basename() : string
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }

    public function dirname() : string
    {
        return pathinfo($this->path, PATHINFO_DIRNAME);
    }

    public function extension() : string
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function path() : string
    {
        return $this->path;
    }

    public function move(string $destination) : BackupFile
    {
        if (!@rename($this->path, $destination)) {
            $error = error_get_last();
            $message = strip_tags($error['message']);
            throw new Exception("The backup file cannot be moved [{$message}]");
        }
        return new DBBackupFile($destination);
    }

    public function copy(string $destination) : BackupFile
    {
        if (!@copy($this->path, $destination)) {
            $error = error_get_last();
            $message = strip_tags($error['message']);
            throw new Exception("The backup file cannot be copied [{$message}]");
        } 
        return new DBBackupFile($destination);
    }
} // END class BasicBackupFileNameGenerator