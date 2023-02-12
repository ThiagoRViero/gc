<?php

namespace Thiagorviero\Gc\Controllers;

use Exception;
use Gc\Resources\Controller\Controller;
use Thiagorviero\Gc\Models\Ticket\Ticket;
use Thiagorviero\Gc\Models\User\Session;
use Thiagorviero\Gc\Models\User\User;

class TicketController extends Controller
{
    function __construct($action)
    {
        $this->data['ticketRef'] = new Ticket;
        $this->data['userRef'] = new User;
        parent::__construct($action);
    }
    function home()
    {
        Session::verifySession();
        header('Location: /panel');
    }

    function listTickets()
    {
        Session::verifySession();
        $this->data['allStatus'] = $this->data['ticketRef']->getAllStatus();
        $this->data['allUsers'] = $this->data['userRef']->listUserNames();

        $requestor = isset($_GET['requestor']) && $_GET['requestor'] != '' ? intval($_GET['requestor']) : null;
        $status = isset($_GET['status']) ? intval($_GET['status']) : 1;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $offset = ($page - 1) * $limit;

        $this->data['page'] = $page;
        $this->data['requestorSelected'] = intval($requestor);
        $this->data['statusSelected'] = intval($status);

        if (!array_search('4', $_SESSION['listAccess'])) {
            $requestor = intval($_SESSION['id']);
        }

        if ($status == null || $status == '') {
            $list = $this->data['ticketRef']->listTickets(user: $requestor, offset: $offset);
        } else {
            $list = $this->data['ticketRef']->listTickets(user: $requestor, status: intval($status), offset: $offset);
        }

        $this->data['tickets'] = $list['tickets'];
        $this->data['countTickets'] = $list['countTickets'];
        $this->data['numberOfPages'] = $list['numberOfPages'];

        $this->render('list_tickets', 'layout');
    }

    function getLayout()
    {
        Session::verifySession();
        return parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\..\src\Views\Layouts\layout.phtml';
    }
    function newTicket()
    {
        Session::verifySession();

        $this->data['tickets'] = $this->data['ticketRef']->listTickets();
        $this->render('new_ticket', 'layout');
    }

    function createTicket()
    {
        Session::verifySession();
        if (!isset($_POST['user']) && !isset($_POST['description'])) {
            echo "Não foram passadas as informações necessárias.";
            return;
        };
        if (strlen($_POST['description']) < 10) {
            echo "Por gentileza descreva melhor a sua solicitação: (A descrição deve ter no mínimo 10 caracteres)";
            return;
        }
        echo $this->data['ticketRef']->createTicket($_POST['user'], $_POST['description']);
    }
    function editTicket()
    {
        Session::verifySession();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $id = intval($_POST['id']);
                $attendant = intval($_POST['attendants']);
                $requestor = intval($_POST['requestor']);
                $status = intval($_POST['stat']);
            } catch (Exception $e) {
                $msg = "Os dados que deveriam ser númericos não são do tipo correto";
                echo $msg;
                return $msg;
            }

            if ($id == null || 0) {
                $msg =  "Informe o número do ticket";
                echo $msg;
                return $msg;
            }

            if ($attendant == null || 0 && array_search('4', $_SESSION['listAccess'])) {
                $attendant = $_SESSION['id'];
            }

            $error_message = null;

            if ($requestor == null || 0) {
                $error_message .= " solicitante";
            }

            if ($requestor == null || 0) {
                $error_message .= " estado";
            }

            $description = is_string($_POST['description']) ? $_POST['description'] : null;
            if ($description == null) {
                $error_message .= " descrição";
            }

            if (strlen($description) < 10) {
                $msg = "Por favor passe mais informações na descrição";
                echo $msg;
                return $msg;
            }

            $resolution = is_string($_POST['resolution']) && strlen($_POST['resolution']) > 0  ? $_POST['resolution'] : null;

            if (strlen($resolution) < 10 && $status == 2) {
                $msg = "A resposta não pode ser menor que 10 caracteres, passe mais informações sobre a resolução.";
                echo $msg;
                return $msg;
            }

            if ($error_message != null) {
                $error_message = "Não foi(ram) localizada(s) as seguintes informações:" . $error_message;
                echo $error_message;
                return $error_message;
            }

            echo $this->data['ticketRef']->editTicket($id, $requestor, $attendant, $description, $status, $resolution);
        } else {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;

            $this->data['allStatus'] = $this->data['ticketRef']->getAllStatus();
            $this->data['ticket'] = $this->data['ticketRef']->getTicket($id);

            if (!is_bool($this->data['ticket'])) {
                if ($_SESSION['id'] == $this->data['ticket']['ID_USUARIO'] || array_search('4', $_SESSION['listAccess'])) {
                    $this->render('edit_ticket', 'layout');
                } else {
                    header('Location: /panel');
                }
            }
        }
    }

    function saveEditTicket()
    {
    }
}
