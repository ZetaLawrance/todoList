<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'start_date',
        'due_date',
        'completed',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $appends = ['is_overdue', 'priority_badge', 'can_be_completed'];

    // Accessor untuk mengecek apakah tugas terlambat
    public function getIsOverdueAttribute()
    {
        return $this->due_date && !$this->completed && $this->due_date->isPast();
    }

    // Accessor untuk mendapatkan badge style berdasarkan prioritas
    public function getPriorityBadgeAttribute()
    {
        return [
            'tinggi' => 'danger',
            'sedang' => 'warning',
            'rendah' => 'info',
        ][$this->priority] ?? 'secondary';
    }

    // Accessor untuk mengecek apakah tugas dapat diselesaikan
    public function getCanBeCompletedAttribute()
    {
        return !$this->is_overdue || $this->completed;
    }
}