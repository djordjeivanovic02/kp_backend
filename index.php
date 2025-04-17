<?php

require_once 'core/autoload.php';

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Validator\EmailValidator;
use Core\Validator\PasswordValidator;
use Core\Validator\MaxMindValidator;
use Core\UserRepository;
use Core\UserService;
use Core\Mailer;
use Core\EnvLoader;

EnvLoader::load(__DIR__ . '/.env');
session_start();

$request = new Request($_REQUEST, $_SERVER);
$response = new Response();

try {
    $db = new Database(
        EnvLoader::get('DB_HOST'),
        EnvLoader::get('DB_USER'),
        EnvLoader::get('DB_PASS'),
        EnvLoader::get('DB_NAME')
    );
    $userRepository = new UserRepository($db);
    $mailer = new Mailer();

    $validators = [
        new EmailValidator($userRepository),
        new MaxMindValidator(),
        new PasswordValidator(),
    ];

    $userService = new UserService($validators, $userRepository, $mailer);
    $user = $userService->register(
        $request->get('email'),
        $request->get('password'),
        $request->get('password2'),
        $request->getIp(),
    );
    $_SESSION['user_id'] = $user['id'];
    $response->json(['success' => true, 'userId' => $user['id']]);
} catch (Exception $e) {
    $response->json(['success' => false, 'error' => $e->getMessage()]);
}