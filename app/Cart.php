<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{

    use SoftDeletes;

    /**
     *request mapper for cart model.
     */
    public const REQUEST_MAPPER = [
        'name' => 'name',
        'quantity' => 'quantity',
        'product_id' => 'product_id',
    ];

    /**
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity','product_id'
    ];

    /**
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
