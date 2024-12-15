<?php

namespace cefet\SyncLab\classes;

class Session
{
    public static function set(string $index, mixed $value): void
    {
        $_SESSION[$index] = $value;
    }

    public static function has(string $index): bool
    {
        return isset($_SESSION[$index]);
    }

    public static function get(string $index){
        if(self::has($index)){
            return $_SESSION[$index];
        }
        return null;
    }

    public static function remove(string $index): void
    {
        if(self::has($index)){
            unset($_SESSION[$index]);
        }
    }

    public static function removeAll(): void
    {
        session_destroy();
    }

    public static function flash(string $index, $value): void
    {
        $_SESSION['__flash'][$index] = $value;
    }

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

    public static function removeFlash(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET' && self::has('__flash')){
            unset($_SESSION['__flash']);
        }
    }

    public static function dump(){
        var_dump($_SESSION);
        die();
    }

    public static function messageFlash(): ?string
    {
        $message = \cefet\Adequa\classes\Session::returnFlash();

        // Verificar o índice e aplicar o estilo adequado
        if ($message !== null) {
            if ($message['index'] === 'error') {
                return "<p style='color:red'>" . htmlspecialchars($message['message']) . "</p>";
            } elseif ($message['index'] === 'message') {
                return "<p style='color:green'>" . htmlspecialchars($message['message']) . "</p>";
            }
        }

        return null;
    }
}