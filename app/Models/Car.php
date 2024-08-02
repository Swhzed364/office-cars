<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\FuncCall;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'comfort-level'
    ];

    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
}
