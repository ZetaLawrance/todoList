<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'description', 
        'priority',
        'start_date',
        'due_date',
        'completed'
    ];
    
    protected $casts = [
        'completed' => 'boolean',
        'start_date' => 'date',
        'due_date' => 'date',
    ];
    
    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'tinggi' => 'danger',
            'sedang' => 'warning',
            'rendah' => 'info',
            default => 'secondary',
        };
    }
    
    public function getIsOverdueAttribute()
    {
        if (!$this->due_date) {
            return false;
        }
        
        return !$this->completed && $this->due_date->isPast();
    }
    
    public function getCanBeCompletedAttribute()
    {
        // Jika sudah terlambat, tidak bisa diubah menjadi completed
        if ($this->is_overdue) {
            return false;
        }
        
        return true;
    }
}