<?php

namespace BoostBoard\Modules\UserManagement;

use PDO;
use BoostBoard\Core\AbstractController;

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
        return $this->view('UserManagement/index.twig', ['users' => $users]);
    }

    public function create()
    {
        return $this->view('UserManagement/create.twig');
    }

    public function store(PDO $db)
    {
        $sth = $db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
        $sth->execute([
            $this->getParam('username'),
            hash('sha256', $this->getParam('password')),
            $this->getParam('privilege')
        ]);
        $this->response->setRedirect('/users');
    }

    public function delete(PDO $db)
    {
        $sth = $db->prepare('DELETE FROM users WHERE id = ?');
        $sth->execute([$this->getParam('id')]);
        $this->response->setRedirect('/users');
    }

    public function clearSession(PDO $db)
    {
        $sth = $db->prepare('DELETE FROM sessions WHERE userId = ?');
        $sth->execute([$this->getParam('id')]);
        $this->response->setRedirect('/users');
    }

    public function updatePassword(PDO $db)
    {
        $sth = $db->prepare('UPDATE users SET password=? WHERE id = ?');
        $sth->execute([hash('sha256', $this->getParam('password')), $this->getParam('id')]);
        return 'Password Updated';
    }
}
