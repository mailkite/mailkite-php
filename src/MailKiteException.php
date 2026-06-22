<?php

declare(strict_types=1);

namespace MailKite;

/** Thrown for any non-2xx response (or a transport failure). */
class MailKiteException extends \Exception
{
    public int $status;
    public $body;

    public function __construct(int $status, string $message, $body = null)
    {
        parent::__construct($message);
        $this->status = $status;
        $this->body = $body;
    }
}
