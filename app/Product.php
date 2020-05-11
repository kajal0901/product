<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $addProduct;

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
     * @param array $input
     *
     * @return Product
     */
    public function store(array $input): Product
    {
        foreach ($input as $inputKey => $inputValue) {
            if (isset(self::REQUEST_MAPPER[$inputKey])) {
                $this->addProduct[self::REQUEST_MAPPER[$inputKey]] = $inputValue;
            }
        }
        $this->fill($this->addProduct);
        return $this;
    }
}
