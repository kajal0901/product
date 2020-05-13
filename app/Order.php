<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    /**
     * @var
     */
    protected $addOrder;
    /**
     *request mapper for cart model.
     */
    public const REQUEST_MAPPER = [
        'name' => 'name',
        'quantity' => 'quantity',
        'status' => 'status',
        'delivery_address' => 'delivery_address',
        'delivery_city' => 'delivery_city',
        'delivery_postcode' => 'delivery_postcode',
        'product_id' => 'product_id',
        'user_id' => 'user_id',
    ];

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var string
     */
    protected $primaryKey = 'p_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quantity','status','delivery_address','delivery_city','delivery_postcode','product_id','user_id'
    ];

    /**
     * @param array $input
     * @param array $fields
     *
     * @return $this
     */
    /**
     * @param array $input
     *
     * @return Order
     */
    public function store(array $input): Order
    {
        foreach ($input as $inputKey => $inputValue) {
            if (isset(self::REQUEST_MAPPER[$inputKey])) {
                $this->addOrder[self::REQUEST_MAPPER[$inputKey]] = $inputValue;
            }
        }
        $this->fill($this->addOrder);
        return $this;
    }
}
