<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'count'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('count');
    }
}
