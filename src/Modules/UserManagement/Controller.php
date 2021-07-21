<?php

namespace BoostBoard\Modules\UserManagement;

use PDO;
use BoostBoard\Core\AbstractController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class Controller extends AbstractController
{
    public function index(PDO $db)
    {
        $users = [];
        foreach ($db->query('SELECT * FROM users') as $row) {
            $sth = $db->prepare('SELECT createAt FROM sessions WHERE userId = ?');
            $sth->execute([$row['id']]);
            $row['lastLogin'] = $sth->fetchColumn();
            array_push($users, $row);
        }
        return $this->view('views/index.twig', ['users' => $users]);
    }

    public function create()
    {
        return $this->view('views/create.twig');
    }

    public function store(PDO $db, Request $request, Response &$response)
    {
        $sth = $db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
        $sth->execute([
            $request->params['username'],
            hash('sha256', $request->params['password']),
            $request->params['privilege']
        ]);
        $response->setRedirect('/users');
    }

    public function delete(PDO $db, Request $request, Response &$response)
    {
            $sth = $db->prepare('DELETE FROM users WHERE id = ?');
            $sth->execute([$request->params['id']]);
            $response->setRedirect('/users');
    }

    public function clearSession(PDO $db, Request $request, Response &$response)
    {
            $sth = $db->prepare('DELETE FROM sessions WHERE userId = ?');
            $sth->execute([$request->params['id']]);
            $response->setRedirect('/users');
    }

    public function updatePassword(PDO $db, Request $request)
    {
            $sth = $db->prepare('UPDATE users SET password=? WHERE id = ?');
            $sth->execute([hash('sha256', $request->params['password']), $request->params['id']]);
            return 'Password Updated';
    }
}
