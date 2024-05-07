<?php

namespace BannerProject;

interface DataProviderInterface
{
    public function createOrUpdate(string $ipAddress, string $userAgent, string $pageUrl): void;
}
