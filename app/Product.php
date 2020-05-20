<?php

namespace App;

use App\Traits\SearchAndSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SearchAndSort,SoftDeletes;

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
     * $columns
     *
     * @var array
     */
    public static $columns = [
        'name' => [
            'table_field' => 'name',
            'sortable' => true,
            'searchable' => true,
        ],
        'description' => [
            'table_field' => 'description',
            'sortable' => true,
            'searchable' => true,
        ]
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

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return parent::query();
    }
}
