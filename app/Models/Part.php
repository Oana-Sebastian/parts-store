<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'stock',
        'category',
        'manufacturer',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    public function isInStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }

    public function decreaseStock(int $quantity): void
    {
        $this->stock -= $quantity;
        $this->save();
    }

    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
        $this->save();
    }
}