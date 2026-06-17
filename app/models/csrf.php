<?php
/**
 * CSRF Token Module
 * 会话级 Token，每 30 分钟自动轮换
 */

// 自定义 Session Cookie 名称为 token，隐藏默认 PHPSESSID
session_name('token');

// 确保 session 已启动
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('CSRF_TOKEN_LIFETIME', 1800); // 30 分钟 = 1800 秒

/**
 * 生成随机 Token
 */
function csrf_generate(): string
{
    return bin2hex(random_bytes(32));
}

/**
 * 获取当前有效 CSRF Token
 * 若不存在或已过期则自动轮换
 */
function csrf_token(): string
{
    $now = time();

    if (
        empty($_SESSION['csrf_token']) ||
        empty($_SESSION['csrf_token_time']) ||
        ($now - $_SESSION['csrf_token_time']) > CSRF_TOKEN_LIFETIME
    ) {
        $_SESSION['csrf_token']      = csrf_generate();
        $_SESSION['csrf_token_time'] = $now;
    }

    return $_SESSION['csrf_token'];
}

/**
 * 输出隐藏 input 字段，供 POST 表单使用
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * 验证 CSRF Token
 * @param string|null $token 用户提交的 token（null 则自动从 $_POST / $_GET 获取）
 * @return bool 验证通过返回 true，否则 false
 */
function csrf_verify(?string $token = null): bool
{
    if ($token === null) {
        // 优先 POST，其次 GET
        if (isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        } elseif (isset($_GET['csrf_token'])) {
            $token = $_GET['csrf_token'];
        } else {
            return false;
        }
    }

    $stored = csrf_token(); // 获取当前有效 token

    if (!is_string($token) || $token === '') {
        return false;
    }

    return hash_equals($stored, $token);
}