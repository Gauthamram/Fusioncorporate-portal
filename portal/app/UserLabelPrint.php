<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\UserScope;
use Carbon\Carbon;

class UserLabelPrint extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id','type', 'raw_data', 'printed', 'user_id', 'quantity', 'creator'
    ];

    /**
     * Get the user label print updated at field.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
    	return Carbon::parse($value)->toDayDateTimeString();
    }

    /**
     * Scope print.
     *
     * @param  string  $query
     * @return string
     */
    public function scopePrint($query)
    {
        return $query->where('printed','0');
    }

    /**
     * Scope of type.
     *
     * @param  string  $query
     * @return string
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type','like',$type.'%');
    }    
    /**
     * Scope Archived.
     *
     * @param  string  $query
     * @return string
     */
    public function scopeArchived($query)
    {
        return $query->where('printed','1')->whereNotIn('order_id',['1234567','7654321']);
    } 

    /**
     * Scope Archived.
     *
     * @param  string  $query
     * @return string
     */
    public function scopeMonthOld($query)
    {
        $today = new Carbon();
        $start = $today->subMonth()->format('Y-m-d');
        return $query->where('created_at', '<=', $start);
    } 

}
