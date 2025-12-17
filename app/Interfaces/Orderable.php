<?php

namespace App\Interfaces;

interface Orderable
{
    public function calculateTotal(): float;
    public function canBeCancelled(): bool;
    public function markAsCompleted(): void;
    public function markAsCancelled(): void;
}