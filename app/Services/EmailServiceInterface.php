<?php

namespace App\Services;

interface EmailServiceInterface
{
    public function send(string $to, string $subject, string $content);
}
