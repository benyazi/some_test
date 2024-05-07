<?php

namespace BannerProject;

class ClientDataQuery {

    public function getVisitorData(): VisitorDataDto {
        $visitorDataDto = new VisitorDataDto();

        $visitorDataDto->ip = $this->getIpAddress();
        $visitorDataDto->userAgent = $this->getUserAgent();
        $visitorDataDto->pageUrl = $this->getPageUrl();

        return $visitorDataDto;
    }

    private function getIpAddress(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        return $ip;
    }

    private function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    private function getPageUrl(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? '';
    }

}
