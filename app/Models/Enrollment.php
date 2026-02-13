<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'is_completed',
        'enrolled_at',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'progress' => 'integer',
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function updateProgress(): void
    {
        $totalLessons = $this->course->lessons()->count();
        if ($totalLessons > 0) {
            $completedLessons = $this->user->lessonProgress()
                ->whereIn('lesson_id', $this->course->lessons()->pluck('id'))
                ->where('is_completed', true)
                ->count();
            
            $this->progress = round(($completedLessons / $totalLessons) * 100);
            
            if ($this->progress >= 100 && !$this->is_completed) {
                $this->is_completed = true;
                $this->completed_at = now();
            }
            
            $this->save();
        }
    }
}
