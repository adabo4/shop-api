<?php

namespace App\Enums;

enum ProductType: string
{
    case HUMAN_MEDICINE = 'human_medicine';
    case VETERINARY_MEDICINE = 'veterinary_medicine';
    case MEDICAL_DEVICE = 'medical_device';
    case FOOD_SUPPLEMENT = 'food_supplement';
    case OTHER = 'other';
}
