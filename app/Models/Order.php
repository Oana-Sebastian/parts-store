<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Interfaces\Orderable;

class Order extends Model implements Orderable
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'part_id',
        'quantity',
        'total_price',
        'status',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    public function calculateTotal(): float
    {
        return $this->quantity * $this->part->price;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->save();
    }

    public function markAsCancelled(): void
    {
        $this->status = 'cancelled';
        $this->part->increaseStock($this->quantity);
        $this->save();
    }
}