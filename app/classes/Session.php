<?php

namespace cefet\SyncLab\classes;

use Exception;

class Session
{
    /** Set a session variable
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public static function set(string $index, mixed $value): void
    {
        $_SESSION[$index] = $value;
    }

    /** Check if a session variable exists
     * @param string $index
     * @return bool
     */
    public static function has(string $index): bool
    {
        return isset($_SESSION[$index]);
    }

    /** Get a session variable
     * @param string $index
     * @return mixed
     */
    public static function get(string $index){
        if(self::has($index)){
            return $_SESSION[$index];
        }
        return null;
    }

    /** Remove a session variable
     * @param string $index
     * @return void
     */
    public static function remove(string $index): void
    {
        if(self::has($index)){
            unset($_SESSION[$index]);
        }
    }

    /** Remove all session variables
     * @return void
     */
    public static function removeAll(): void
    {
        session_destroy();
    }

    /** Set a flash message
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public static function flash(string $index, $value): void
    {
        $_SESSION['__flash'][$index] = $value;
    }

    /** Get a flash message
     * @return mixed
     */
    public static function returnFlash(){
        if(isset($_SESSION['__flash']['error'])){
            $message = $_SESSION['__flash']['error'];
            self::removeFlash();
            return ['index' => 'error',
                    'message' => $message];
        }
        else if(isset($_SESSION['__flash']['message'])){
            $message = $_SESSION['__flash']['message'];
            self::removeFlash();
            return ['index' => 'message',
                'message' => $message];
        }
        return null;
    }

    /** Remove a flash message
     * @return void
     */
    public static function removeFlash(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET' && self::has('__flash')){
            unset($_SESSION['__flash']);
        }
    }

    /** Dump all session variables
     * @return void
     */
    public static function dump(){
        var_dump($_SESSION);
        die();
    }

    /** Return a flash message to be displayed
     * @return string|null
     */
    public static function messageFlash(): ?string
    {
        $message = self::returnFlash();

        if ($message !== null) {
            if ($message['index'] === 'error') {
                return "<p style='color:red'>" . htmlspecialchars($message['message']) . "</p>";
            } elseif ($message['index'] === 'message') {
                return "<p style='color:green'>" . htmlspecialchars($message['message']) . "</p>";
            }
        }

        return null;
    }

    /** Logout the user
     * @return void
     * @throws Exception
     */
    public static function logout()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Limpa todas as variáveis de sessão
            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            BdConnection::getInstance()->closeConnection();

            session_destroy();

        } catch (Exception $e) {
            throw new Exception("Erro ao realizar o logout: " . $e->getMessage());
        }
    }
}