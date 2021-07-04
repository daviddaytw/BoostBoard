<?php
namespace BoostBoard\Modules\UserManagement;

use BoostBoard\Core\BaseController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct(__DIR__);

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
            '/create', function (Request $request, Response &$response) {
                $sth = $this->db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
                $sth->execute([$request->params['username'], hash('sha256', $request->params['password']), $request->params['privilege']]);
                $response->setRedirect('/users');
            }, 'POST'
        );

        $this->addRoute(
            '/delete', function (Request $request, Response &$response) {
                $sth = $this->db->prepare('DELETE FROM users WHERE id = ?');
                $sth->execute([$request->params['id']]);
                $response->setRedirect('/users');
            }
        );

        $this->addRoute(
            '/clear-session', function (Request $request, Response &$response) {
                $sth = $this->db->prepare('DELETE FROM sessions WHERE userId = ?');
                $sth->execute([$request->params['id']]);
                $response->setRedirect('/users');
            }
        );

        $this->addRoute(
            '/update-password', function (Request $request) {
                $sth = $this->db->prepare('UPDATE users SET password=? WHERE id = ?');
                $sth->execute([hash('sha256', $request->params['password']), $request->params['id']]);
                return 'Password Updated';
            }, 'POST'
        );
    }
}
?>