<?php

namespace App\Modules\Billing\Services;

use App\Modules\Billing\Models\Invoice;

class BillingService
{
    public static function createInvoice($clientId, $items, $dueDate)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $invoiceId = Invoice::create([
            'client_id' => $clientId,
            'total' => $total,
            'due_date' => $dueDate
        ]);

        foreach ($items as $item) {
            Invoice::addItem($invoiceId, $item);
        }

        return $invoiceId;
    }
}