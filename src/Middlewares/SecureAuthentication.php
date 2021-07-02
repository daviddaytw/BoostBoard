<?php
namespace BoostBoard\Middlewares;

class SecureAuthentication {
    
    public function __construct()
    {
        $this->db = new \PDO('sqlite:data/board.db');
    }

    private function authenticate($username, $password)
    {
        $sth = $this->db->prepare('SELECT id, privilege FROM users WHERE username = ? AND password = ?');
        $sth->execute([$username, hash('sha256', $password)]);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if($result != false) 
        {
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $sth = $this->db->prepare('INSERT INTO sessions (userID, token) VALUES (?, ?)');
            $sth->execute([$result['id'], $token]);

            $_SESSION['token'] = $token;
            $_SESSION['privilege'] = $result['privilege'];
            return true;
        }
        return false;
    }

    private function verifySession($token)
    {
        $sth = $this->db->prepare('SELECT COUNT(*) FROM sessions WHERE token = ? ');
        $sth->execute([$token]);
        return $sth->fetchColumn() > 0;
    }

    public function __invoke($uri, $method, &$request)
    {
        if(isset($_SESSION['token']))
        {
            if($uri == '/logout' || !$this->verifySession($_SESSION['token']))
            {
                unset($_SESSION['token'], $_SESSION['privilege']);
            }
            else
            {
                return true;
            }
        }
        if($uri == '/login' && $method == 'POST')
        {
            if($this->authenticate($request->username, $request->password))
            {
                header('Location: /');
                return false;
            }
        }

        $loader = new \Twig\Loader\FilesystemLoader('theme');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('auth.twig');
        echo $template->render();
        return false;
    }
}