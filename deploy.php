cat > /home/killian/www/td3_killian_louise/deploy.php << 'EOF'
    <?php
    $secret = 'TD3_Killian_Louise';
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
    $payload = file_get_contents('php://input');

    if (!hash_equals('sha256=' . hash_hmac('sha256', $payload, $secret), $signature)) {
        http_response_code(403);
        die('Accès refusé');
    }
    $output = shell_exec('/home/killian/www/td3_killian_louise/deploy.sh 2>&1');
    file_put_contents('deploy.log', date('Y-m-d H:i:s') . "\n" . $output . "\n\n", FILE_APPEND);

    echo "OK: " . $output;
    ?>
    EOF