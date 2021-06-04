<?php

include "infSetup.php";

$infModel = new InfModel;
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

switch ($_action) {
    case 'index':
    default:
        $infModel->display();
        break;
    case 'search':
        $infModel->checkSearch($_POST['search'], $_POST['field']);
        break;
    case 'insert':
        $infModel->displayInsert($_GET['case']);
        break;
    case 'insertData':
        $infModel->insertRecord($_POST, $_GET['case']);
        $infModel->display();
        break;
    case 'aaa':
        $case = "jedan";
        $infModel->displayList($infModel->getRecordsA(), $infModel->getAllMail($case));
        break;
    case 'delete':
        $infModel->deleteRecord($_GET['del'], $_GET['case']);
        $infModel->display();
        break;
    case 'edit':
        $infModel->displayRecord($_GET['edt'], $_GET['case']);
        break;
    case 'editRecord':
        $infModel->editRecord($_POST, $_GET['edt'], $_GET['case']);
        $infModel->display();
        break;
    case 'upload':
        $infModel->processingPayments($_POST['mesec']);
        break;
     case 'gopozivi':
        $infModel->poziviGo($_POST['noviDatumSastanka'], $_POST['noviPrviRed'], $_POST['noviDrugiRed'], $_POST['noviTreciRed'], $_POST['noviCetvrtiRed'], $_POST['noviPetiRed'], $_POST['noviSestiRed'], $_POST['noviSedmiRed'], $_POST['noviOsmiRed'], $_POST['noviDevetiRed'], $_POST['noviDesetiRed'], $_POST['noviDatumPoziva']);
         break;
    case 'autoMail':
        $infModel->autoMail($_POST['mesec']);
        break;
}
