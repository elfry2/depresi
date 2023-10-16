<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentSymptomScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'from',
        'to',
    ];

    function rule() {
        return $this->belongsTo(Rule::class);
    }
}
