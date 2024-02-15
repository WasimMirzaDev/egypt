<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exchange_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'currency',
        'rate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */


    /**
     * Define the validation rules.
     *
     * @var array
     */


    /**
     * Get the admin user who created the exchange rate.
     */
    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Perform any additional operations when creating a new exchange rate.
     */
}
