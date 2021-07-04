<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BonusCompleteList;

class Bonus extends Model
{
    use HasFactory;
    
    protected $table = "bonus";
    
    protected $fillable = [
        'completed_ride',
        'bonus_amount',
        'offer_starting_time',
        'offer_finishing_time',
        'type',
        'bonus_for'
    ];
    
    public function bonusCompletedList () {
        return $this->hasMany(BonusCompleteList::class, 'bonus_id');
    }
    
}
