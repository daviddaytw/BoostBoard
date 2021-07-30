<?php

namespace BoostBoard\Modules\UserManagement;

use PDO;
use BoostBoard\Core\AbstractController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class Controller extends AbstractController
{
    public function index(Request $req, Response $res, PDO $db): Response
    {
        $users = [];
        foreach ($db->query('SELECT * FROM users') as $row) {
            $sth = $db->prepare('SELECT createAt FROM sessions WHERE userId = ?');
            $sth->execute([$row['id']]);
            $row['lastLogin'] = $sth->fetchColumn();
            array_push($users, $row);
        }
        return $this->view('UserManagement/index.twig', ['users' => $users]);
    }

    public function create(Request $req, Response $res): Response
    {
        return $this->view('UserManagement/create.twig');
    }

    public function store(Request $req, Response $res, PDO $db): Response
    {
        $sth = $db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
        $sth->execute([
            $req->getParam('username'),
            hash('sha256', $req->getParam('password')),
            $req->getParam('privilege')
        ]);
        $res->setRedirect('/users');
        return $res;
    }

    public function delete(Request $req, Response $res, PDO $db): Response
    {
        $sth = $db->prepare('DELETE FROM users WHERE id = ?');
        $sth->execute([$req->getParam('id')]);
        $res->setRedirect('/users');
        return $res;
    }

    public function clearSession(Request $req, Response $res, PDO $db): Response
    {
        $sth = $db->prepare('DELETE FROM sessions WHERE userId = ?');
        $sth->execute([$req->getParam('id')]);
        $res->setRedirect('/users');
        return $res;
    }

    public function updatePassword(Request $req, Response $res, PDO $db): Response
    {
        $sth = $db->prepare('UPDATE users SET password=? WHERE id = ?');
        $sth->execute([hash('sha256', $req->getParam('password')), $req->getParam('id')]);
        $res->setPayload('Password Updated');
        return $res;
    }
}
