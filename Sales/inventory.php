<?php
class Inventory
{
    private $items = [
        "item001" => ["stock" => 100],
        "item002" => ["stock" => 50]
    ];

    public function updateStock($itemID, $quantity)
    {
        if (!isset($this->items[$itemID])) {
            return [
                'status' => 'error',
                'message' => 'Item not found',
                'updatedStock' => null
            ];
        }

        // Reduce stock
        $this->items[$itemID]['stock'] -= $quantity;

        // Return response
        return [
            'status' => 'success',
            'message' => 'Stock updated successfully',
            'updatedStock' => $this->items[$itemID]['stock']
        ];
    }
}
