<?php

namespace App\Enums;

enum ApiMedicEndpoint: string
{
    case SYMPTOMS = 'symptoms';
    case DIAGNOSIS = 'diagnosis';
}