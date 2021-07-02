<?php
namespace BoostBoard\Modules\UserManagement;

use BoostBoard\Core\BaseController;

class Controller extends BaseController
{
    public function __construct($config)
    {
        parent::__construct(__DIR__, $config);

        $this->addRoute(
            '/', function () {
                $users = [];
                foreach($this->db->query('SELECT * FROM users') as $row)
                {
                    $sth = $this->db->prepare('SELECT createAt FROM sessions WHERE userId = ?');
                    $sth->execute([$row['id']]);
                    $row['lastLogin'] = $sth->fetchColumn();
                    array_push($users, $row);
                }
                return $this->view('pages/index.twig', ['users' => $users]);
            }
        );

        $this->addRoute(
            '/create', function () {
                return $this->view('pages/create.twig');
            }
        );

        $this->addRoute(
            '/create', function ($request) {
                $sth = $this->db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
                $sth->execute([$request->username, hash('sha256', $request->password), $request->privilege]);
                header('Location: /users');
                return true;
            }, 'POST'
        );

        $this->addRoute(
            '/delete', function ($request) {
                $sth = $this->db->prepare('DELETE FROM users WHERE id = ?');
                $sth->execute([$request->id]);
                header('Location: /users');
                return true;
            }
        );

        $this->addRoute(
            '/clear-session', function ($request) {
                $sth = $this->db->prepare('DELETE FROM sessions WHERE userId = ?');
                $sth->execute([$request->id]);
                header('Location: /users');
                return true;
            }
        );

        $this->addRoute(
            '/update-password', function ($request) {
                $sth = $this->db->prepare('UPDATE users SET password=? WHERE id = ?');
                $sth->execute([hash('sha256', $request->password), $request->id]);
                return 'Password Updated';
            }, 'POST'
        );
    }
}
?>