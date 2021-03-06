<?php

namespace Preferred\Domain\Audits\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @package Preferred\Domain\Audits\Entities
 *
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    const UPDATED_AT = null;
    protected static $unguarded = true;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];
}
