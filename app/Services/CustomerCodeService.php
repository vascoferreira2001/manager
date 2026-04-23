<?php
namespace App\Services;

use App\Models\UserModel;

class CustomerCodeService
{
    protected UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function generate(): string
    {
        $year = date('Y');
        // Transacionalidade simples: obter último e +1
        $last = $this->userModel->getLastSequenceForYear($year);
        $seq = $last + 1;
        return sprintf('CUS-%s-%06d', $year, $seq);
    }
}
