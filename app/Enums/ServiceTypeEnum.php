<?php

namespace App\Enums;

enum ServiceTypeEnum: string
{
    case FEDEX_GROUND = 'FEDEX_GROUND';
    case STANDARD_OVERNIGHT = 'STANDARD_OVERNIGHT';
    case FEDEX_2_DAY = 'FEDEX_2_DAY';
    case FEDEX_EXPRESS_SAVER = 'FEDEX_EXPRESS_SAVER';
}
