<?php

namespace App\Modules\Billing\Jobs;

use System\Database;

class InvoiceJob
{
    public static function markOverdue()
    {
        $db = Database::connect();

        $db->query("
            UPDATE invoices
            SET status = 'overdue'
            WHERE status = 'unpaid'
            AND due_date < CURDATE()
        ");
    }
}