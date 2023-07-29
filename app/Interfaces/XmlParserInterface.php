<?php

namespace App\Interfaces;

interface XmlParserInterface
{
    public function parse(?string $xmlString): array;
}