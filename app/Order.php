<?php

namespace App;

use App\Traits\SearchAndSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SearchAndSort,SoftDeletes;

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
     * $columns
     *
     * @var array
     */
    public static $columns = [
        'status' => [
            'table_field' => 'status',
            'sortable' => true,
            'searchable' => true,
        ],
        'name' => [
            'table_field' => 'name',
            'sortable' => true,
            'searchable' => true,
        ]
    ];

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var string
     */
    protected $primaryKey = 'o_id';
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

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return parent::query();
    }
}
