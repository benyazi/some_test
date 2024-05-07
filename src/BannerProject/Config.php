<?php

namespace BannerProject;

class Config
{
    public string $databaseHost;
    public string $databaseUser;
    public string $databasePassword;
    public string $databaseName;

    public function __construct()
    {
        $this->loadConfigFile();
        $this->databaseHost = getenv('DATABASE_HOST');
        $this->databaseUser = getenv('DATABASE_USER');
        $this->databasePassword = getenv('DATABASE_PASSWORD');
        $this->databaseName = getenv('DATABASE_NAME');
    }

    private function loadConfigFile(): void {
        $file = new \SplFileObject(__DIR__.'/../../.env');

        // Loop until we reach the end of the file.
        while (false === $file->eof()) {
            // Get the current line value, trim it and save by putenv.
            putenv(trim($file->fgets()));
        }
    }
}
