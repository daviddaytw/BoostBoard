<?php

namespace BoostBoard\Modules\Profile;

use PDO;
use BoostBoard\Core\AbstractController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class Controller extends AbstractController
{
    public function index(Request $req, Response $res, PDO $db): Response
    {
        $sth = $db->prepare('SELECT * FROM users WHERE id = ?');
        $sth->execute([$req->getUserId()]);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $this->view('Profile/index.twig', [
            'userData' => $result,
        ]);
    }

    public function update(Request $req, Response $res, PDO $db): Response
    {
        if ($req->getParam('password') == $req->getParam('confirmed_password')) {
            $sth = $db->prepare('UPDATE users SET password=? WHERE id = ?');
            $sth->execute([hash('sha256', $req->getParam('password')), $req->getUserId()]);

            $res->setRedirect('/profile');
        } else {
            $res->setPayload('Password do not match with confirmed.');
        }
        return $res;
    }
}
