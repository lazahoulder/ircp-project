<?php

namespace App\Constant;

class EntiteEmmeteursConstant
{
    const STATUS_INCOMPLET = 'incomplet';
    const STATUS_VALID = 'valide';
    const STATUS_EN_ATTENTE = 'en-attente';
    const STATUS_NOT_VALID = [
        self::STATUS_INCOMPLET,
        self::STATUS_EN_ATTENTE,
    ];
}
