<?php


namespace App\Http\Services;


class BaseService
{
    protected function processContent (string $content) {
        $stripContent = strip_tags($content);
        $trimContent = trim($stripContent);

        return $trimContent;
    }
}