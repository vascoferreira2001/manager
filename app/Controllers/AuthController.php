<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Services\CustomerCodeService;
use App\Services\EncryptionService;
use Dotenv\Dotenv;

class AuthController
{
    protected UserModel $userModel;
    protected CustomerCodeService $codeService;
    protected EncryptionService $enc;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->codeService = new CustomerCodeService($this->userModel);

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
        $appKey = $_ENV['APP_KEY'] ?? '';
        $this->enc = new EncryptionService($appKey);
    }

    // POST /register
    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;

        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'email and password required']);
            return;
        }

        $customerCode = $this->codeService->generate();
        $passwordHash = password_hash($data['password'], PASSWORD_ARGON2ID);

        $nationalIdHash = null;
        $nationalIdEnc = null;
        $nationalIdIv = null;
        if (!empty($data['national_id'])) {
            $normalized = preg_replace('/\s+/', '', strtoupper($data['national_id']));
            $hmac = $this->enc->hmacForSearch($normalized);
            $enc = $this->enc->encrypt($normalized);
            $nationalIdHash = $hmac;
            $nationalIdEnc = $enc['enc'];
            $nationalIdIv = $enc['iv'];
        }

        try {
            $userId = $this->userModel->create([
                'customer_code' => $customerCode,
                'email' => $data['email'],
                'password_hash' => $passwordHash,
                'national_id_enc' => $nationalIdEnc,
                'national_id_iv' => $nationalIdIv,
                'national_id_hash' => $nationalIdHash,
                'role_id' => 3
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Could not create user', 'detail' => $e->getMessage()]);
            return;
        }

        http_response_code(201);
        echo json_encode(['id' => $userId, 'customer_code' => $customerCode]);
    }

    // POST /login
    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        if (empty($data['identifier']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'identifier and password required']);
            return;
        }

        $user = $this->userModel->findByEmailOrCustomerCode($data['identifier']);
        if (!$user || !password_verify($data['password'], $user['password_hash'])) {
            http_response_code(401);
            echo json_encode(['error' => 'invalid credentials']);
            return;
        }

        // Simples: retornar user info (no session JWT implementado aqui)
        unset($user['password_hash']);
        http_response_code(200);
        echo json_encode(['user' => $user]);
    }
}
