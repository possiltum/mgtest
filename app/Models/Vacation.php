<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vacation extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'start',
        'stop',
        'fix',
    ];

    protected $casts = [
        'start' => 'date:Y-m-d',
        'stop' => 'date:Y-m-d',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function getStartAttribute($value)
    {
        return Carbon::parse($value)->format(config('app.date_format'));
    }

    public function getStopAttribute($value)
    {
        return Carbon::parse($value)->format(config('app.date_format'));
    }
}
