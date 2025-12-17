<?php

namespace App\Services;

use App\Models\User;
use App\Models\Part;
use App\Exceptions\PartNotFoundException;

class AdminUser extends User
{
    public function createPart(array $data): Part
    {
        if (!$this->canManageParts()) {
            throw new \Exception('Unauthorized action');
        }

        return Part::create($data);
    }

    public function updatePart(int $partId, array $data): Part
    {
        if (!$this->canManageParts()) {
            throw new \Exception('Unauthorized action');
        }

        $part = Part::find($partId);
        
        if (!$part) {
            throw new PartNotFoundException("Part with ID {$partId} not found");
        }

        $part->update($data);
        return $part;
    }

    public function deletePart(int $partId): bool
    {
        if (!$this->canManageParts()) {
            throw new \Exception('Unauthorized action');
        }

        $part = Part::find($partId);
        
        if (!$part) {
            throw new PartNotFoundException("Part with ID {$partId} not found");
        }

        return $part->delete();
    }

    public function getAllOrders()
    {
        if (!$this->canManageParts()) {
            throw new \Exception('Unauthorized action');
        }

        return \App\Models\Order::with(['user', 'part'])->latest()->get();
    }
}