<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Services\TwoFactorService;

class ProfileController
{
    public function enable2FA()
    {
        session_start();

        $user = $_SESSION['user'];

        $tfa = new TwoFactorService();

        $secret = $tfa->generateSecret();
        $qr = $tfa->getQRCode($user['email'], $secret);

        $_SESSION['2fa_secret_temp'] = $secret;

        echo "<h3>Ativar 2FA</h3>";
        echo "<img src='$qr'>";
        echo "
            <form method='POST' action='/confirm-2fa'>
                <input name='code' placeholder='Código'>
                <button>Confirmar</button>
            </form>
        ";
    }

    public function confirm2FA()
    {
        session_start();

        $tfa = new TwoFactorService();

        $secret = $_SESSION['2fa_secret_temp'];

        if ($tfa->verify($secret, $_POST['code'])) {

            // guardar na BD
            $db = \System\Database::connect();

            $stmt = $db->prepare("
                UPDATE users 
                SET twofa_secret = ?, twofa_enabled = 1 
                WHERE id = ?
            ");

            $stmt->execute([$secret, $_SESSION['user']['id']]);

            echo "2FA ativado!";
        } else {
            echo "Código inválido";
        }
    }
}