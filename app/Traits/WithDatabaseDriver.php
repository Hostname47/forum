<?php

namespace App\Traits;

trait WithDatabaseDriver
{
    /**
     * @var string
     */
    private $driver;

    public function __construct()
    {
        $this->driver = config("database.default");
    }

    public function databaseDriverIs(string $driver): bool
    {
        return $this->driver === $driver;
    }
}