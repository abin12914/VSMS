<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Scope a query to only include active accounts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * The products that belong to the sale.
     */
    public function sales()
    {
        return $this->belongsToMany('App\Models\Sale', 'sale_product');
    }

    /**
     * The products that belong to the purchase.
     */
    public function purchases()
    {
        return $this->belongsToMany('App\Models\Purchase', 'purchase_product');
    }
}
