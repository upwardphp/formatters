<?php

namespace Upward\Formatters\Contracts;

interface Document
{
    public function validate(): void;

    public function format(): string;
}
