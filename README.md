[![Latest Stable Version on Packagist](https://poser.pugx.org/lily-labs/db-backup/v/stable)](https://packagist.org/packages/lily-labs/db-backup)
[![Build Status](https://img.shields.io/travis/lily-labs/db-backup/master.svg?style=flat-square)](https://travis-ci.org/lily-labs/db-backup)
[![Quality Score](https://img.shields.io/scrutinizer/g/lily-labs/db-backup.svg?style=flat-square)](https://scrutinizer-ci.com/g/lily-labs/db-backup)
[![Total Downloads](https://img.shields.io/packagist/dt/lily-labs/db-backup.svg?style=flat-square)](https://packagist.org/packages/lily-labs/db-backup)


DBBackup it's a library that provides classes to execute mysqldump to backup the given database, relocate the backup file in the local filesystem and compress the resulting backup file.

## Requirements

- PHP 7.1+
- MySQL client/server version 5.6.x
- Gzip on the server (only tested on unix)

## Installation

You can install the package via composer:

```bash
composer require lily-labs/db-backup
```

For the backup process to work, it requires that you pre-configure a local login for mysql on your server using `mysql_config_editor` as follows:

```bash
mysql_config_editor set --login-path=local --host=localhost --user=username --password
```

Your database password will be asked after entering the command.

You can se more information [here](https://stackoverflow.com/a/20854048)

## Usage

First create a `BackupFileNameGenerator`, this will generate the desire filename for the backup file, the default implementation `LilyLabs\DBBackup\BasicBackupFileNameGenerator` will generate a file name in this format: `"[database_name]_[year]-[month]-[day].sql"`

```php
use LilyLabs\DBBackup\BasicBackupFileNameGenerator;
use LilyLabs\DBBackup\MysqldumpBackupProcessor;

$db_name = "DBTest";
$date = new DateTime('now');
$filename_generator = new BasicBackupFileNameGenerator($db_name, $date);
$filename = $filename_generator->getName(); // DBTest_[year]-[month]-[day].sql

```

Now, create an instance of `LilyLabs\DBBackup\MysqldumpBackupProcessor` to execute the backup process

```php

$backup_processor = new MysqldumpBackupProcessor(
    $db_name,
    $filename_generator
);
$backup_file = $backup_processor->execute();
```

The returned object is an instance of `LilyLabs\DBBackup\DBBackupFile`, all backups are generated on the temp folder obtained by `sys_get_temp_dir()`, you can now move the file to your desired storage location.

```php
$moved_backup_file = $backup_file->move("/final/location/of/the/backup");
```

Finally, you can use the class `LilyLabs\DBBackup\GzipCompressor` to gzip the backupfile:

```php
$compressor = new \LilyLabs\DBBackup\GzipCompressor;
$compressed_backup_file = $compressor->compress($moved_backup_file);
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mindacj@gmail.com instead of using the issue tracker.

## Credits

- [Abraham Chávez](https://github.com/Geckomind)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
