<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Customer extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public static $snakeAttributes = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'fax',
        'notes',
        'website',
        'discount',
        'taxable',
        'address',
        'active',
        'vat',
        'vat_number'
    ];

    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4();
        });
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'customer_id');
    }

    public function getAddressAttribute($value)
    {
        return json_decode($value, true);
    }

    public function siteManager()
    {
        return $this->hasOne(User::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
