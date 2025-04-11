<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StickyNote extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'content',
        'color'
    ];
    
    public static function availableColors(): array
    {
        return [
            '#ffeb3b' => 'Kuning',
            '#4fc3f7' => 'Biru',
            '#81c784' => 'Hijau',
            '#ff8a65' => 'Oranye',
            '#e57373' => 'Merah',
            '#ba68c8' => 'Ungu'
        ];
    }
}