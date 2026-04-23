// exemplo simples no public/index.php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$webhook = new \App\Controllers\WebhookController();
$checkout = new \App\Controllers\CheckoutController();

if ($uri === '/webhook/stripe' && $method === 'POST') {
    $webhook->stripe();
    exit;
}
if ($uri === '/webhook/paypal' && $method === 'POST') {
    $webhook->paypal();
    exit;
}
if ($uri === '/checkout' && $method === 'POST') {
    $checkout->create();
    exit;
}
