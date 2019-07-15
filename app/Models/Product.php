<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property int price
 * @property string $image
 */
class Product extends Model
{

    protected $fillable = [
        '_id',
        'name',
        'price',
        'image'
    ];

    protected $keyType = 'string';
    protected $primaryKey = '_id';

    public $timestamps = false;
    public $incrementing = false;

}
