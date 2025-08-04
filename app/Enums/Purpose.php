<?php

namespace App\Enums;

enum Purpose: string
{
    case Buy = 'buy';
    case Sell = 'sell';
    case Rent = 'rent';
}