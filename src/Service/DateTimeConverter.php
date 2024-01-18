<?php

namespace App\Service;

class DateTimeConverter
{
    public function convertToString(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('d/m/Y');
    }
}
