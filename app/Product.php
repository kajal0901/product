<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    /**
     * Request mapper for product model.
     */
    public const REQUEST_MAPPER = [
        'name' => 'name',
        'price' => 'price',
        'description' => 'description',
    ];
    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'description',
    ];

    /**
     * Database field value
     * @param array $input
     * @param array $fields
     *
     * @return $this
     */
    public function store(array $input, array $fields = [])
    {
        foreach ($input as $inputKey => $inputValue) {
            if (isset(self::REQUEST_MAPPER[$inputKey])) {
                $fields[self::REQUEST_MAPPER[$inputKey]] = $inputValue;
            }
        }
        $this->fill($fields);
        return $this;
    }
}
