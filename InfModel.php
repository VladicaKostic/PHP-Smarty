<?php

require 'PHPMailer-master/PHPMailerAutoload.php';

class InfModel {
    var $pdo = null;
    var $tpl = null;
    var $dbname = '';
    var $dbhost = '';
    var $dbpass = '';
    var $dbuser = '';
    var $dbtype = 'mysql';
    
    // constructor - connection to database and creation of an object
    function __construct() {
        try {
            $dsn = "{$this->dbtype}:host={$this->dbhost};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->dbuser, $this->dbpass,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            die();
        }
        
        $this->tpl = new InfModel_Smarty;
    }
    
    // display default page
    function display() {
        $this->tpl->display('index.tpl');
    }
    
    // get records from joining 3 tables
    function getRecordsA() {
        try {
            foreach ($this->pdo->query
                    ("select * from table_one as g inner join table_two as s on g.rbr_one = s.rbr_one"
                    . " inner join table_three as o on s.rbr_two=o.rbr_two where g.clo = 'da' order by s.rbr_two") as $row) {
                $rows[] = $row;
            }
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return $rows;
    }
    
    // get records by id
    function getRecordsClan($clan) {
        try {
            foreach ($this->pdo->query
                    ("select * from table_one as g inner join table_two as s on g.rbr_one = s.rbr_one "
                    . "where g.rbr_one = $clan") as $row) {
                $rows[] = $row;
            }
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return $rows;
    }
    
    // assign data from database to template file and display specific template
    function displayList($data = array(), $mejl = array()) {
        $this->tpl->assign('data', $data);
        $this->tpl->assign('mejl', $mejl);
        $this->tpl->display('list.tpl');
    }
    
    // display specific template depending on case
    function displayInsert($case) {
        if($case == 'jedan'){
        $this->tpl->display('insert.tpl');
        } else if($case == 'dva'){
        $this->tpl->display('insertOsn.tpl');
        } else if($case == 'tri'){
        $this->tpl->display('insertKontakti.tpl');
        } else if($case == 'cetiri'){
        $this->tpl->display('insertDelovodnik.tpl');
        }
    }
    
    /* insert data from template page into database depending on case
     * upload a file and write data into database
     */
    function insertRecord($record, $case) {
        if ($case == 'jedan'){
        try {
            $rh = $this->pdo->prepare("insert into table_one (ime_prezime, telefon, mejl, rbr_one) values (?,?,?,?)");
            $rh->execute(array($record['ime_prezime'], $record['telefon'],
                $record['mejl'], $record['rbr_one']));
            $th = $this->pdo->prepare("select rbr_one from table_one order by rbr_one desc limit 1");
            $th->execute();
            $result = $th->fetch(PDO::FETCH_ASSOC);
            print "Uspešno ste uneli podatak pod rednim brojem: ".$result['rbr_one'].".";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        } else if ($case == 'dva'){
            $filename = $_FILES['prilog']['name'];
            $destination = 'delovodnik/' . $filename;
            $file = $_FILES['prilog']['tmp_name'];
            /* $extension = pathinfo($filename, PATHINFO_EXTENSION);
             * $size = $_FILES['prilog']['size'];
             * to do: write code to check for extension and limit the file size
             */
        try {
            $rh = $this->pdo->prepare("insert into table_four (rbr_unosa, predmet, posiljalac, prilog) values (?,?,?,?)");
            $rh->execute(array($record['rbr_unosa'], $record['predmet'], $record['posiljalac'], $destination));
            $th = $this->pdo->prepare("select rbr, rbr_unosa from table_four order by rbr desc limit 1");
            $th->execute();
            $result = $th->fetch(PDO::FETCH_ASSOC);
            move_uploaded_file($file, $destination);
            print "Uspešno ste uneli zapis pod rednim brojem: ".$result['rbr_unosa'].".";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        }
    }
    
    // deleting specific data from database depending on case
    function deleteRecord($del, $case) {
        if($case == 'jedan'){
        try {
            $this->pdo->query("delete from table_one where rbr_one = $del");
            print "Uspešno ste izbrisali zapis.";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        } else if($case == 'dva'){
        try {
            $this->pdo->query("delete from table_two where rbr_two = $del");
            print "Uspešno ste izbrisali zapis.";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        }
    }
    
    /* get records from database, assign them to template and display
     * template for further editing by user
     */
    function displayRecord($edt, $case) {
        if ($case == 'jedan'){
        try {
            $rh = $this->pdo->prepare("select * from table_one where"
                    . " rbr_one = $edt");
            $rh->execute();
            $result = $rh->fetch(PDO::FETCH_ASSOC);
            $this->tpl->assign('result', $result);
            $this->tpl->assign('edt', $edt);
            $this->tpl->display('edit.tpl');
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        } else if ($case == 'dva'){
        try {
            $rh = $this->pdo->prepare("select * from table_two where"
                    . " rbr_two = $edt");
            $rh->execute();
            $result = $rh->fetch(PDO::FETCH_ASSOC);
            $this->tpl->assign('result', $result);
            $this->tpl->assign('edt', $edt);
            $this->tpl->display('editOkrug.tpl');
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        }
    }
    
    // update database
    function editRecord($record, $edt, $case) {
        if ($case == 'jedan'){
        try {
            $this->pdo->query("update table_one set ime_prezime = '".$record['ime_prezime']."',"
                    . "telefon = '".$record['telefon']."',"
                    . "mejl = '".$record['mejl']."',"
                    . "where rbr_one = '".$edt."'");
            print "Uspešno ste promenili podatke.";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        } else if ($case == 'dva'){
        try {
            $this->pdo->query("update table_two set naziv = '".$record['naziv']."',"
                    . "telefon = '".$record['telefon']."',"
                    . "mejl = '".$record['mejl']."',"
                    . "where rbr_okruga = '".$edt."'");
            print "Uspešno ste promenili podatke.";
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        }
    }
    
    // search through multiple tables and presenting results to the user
    function search($search, $field) {
        if ($field == "jedan"){
        try {
            foreach ($this->pdo->query("select rbr_one, ime_prezime, naziv from table_one as g inner join table_two as o on g.rbr_one = o.rbr_one"
                    . " inner join table_three as k on o.rbr_two = k.rbr_two where g.clan_go = 'da' AND (ime_prezime like '%".$search."%' OR g.telefon like '%".$search."%' OR g.mejl like '%".$search."%' OR g.adresa like '%".$search."%'"
                    . "OR naziv like '%".$search."%' OR nazivokruga like '%".$search."%')")as $row) {
                $rows[] = $row;
            }
            if (empty($rows)) {
                print "Nema podataka";
                $this->tpl->display('index.tpl');
            } else {
                $this->tpl->assign('search', $search);
                $this->tpl->assign('rows', $rows);
                $this->tpl->display('searchResult.tpl');
            }
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        return true;
        }
    }
    
    // function to prevent using unallowed characters when searching
    function checkSearch($search, $field) {
        if (preg_match_all("/^[a-zA-Z0-9ĐđŠšŽžČčĆć]+/", $_POST['search'])) {
            $this->search($search, $field);
        } else {
            print "Nedozvoljen unos!";
            $this->tpl->display('index.tpl');
        }
    }
    
    // processing xml bank statement
    function processingPayments($mesec) {
        $target_dir = "izvodi/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if (file_exists($target_file)) {
            echo "Greška, odabrani izvod je već obrađen.<br />";
            $uploadOk = 0;
        }
        
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Došlo je do greške, veličina fajla je prevelika.<br />";
            $uploadOk = 0;
        }
        
        if ($imageFileType != "xml") {
            echo "Vaš fajl nije obrađen. Dozvoljen je samo XML format.<br />";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo "Došlo je do greške, izvod nije obrađen.<br />";
            
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $xml = simplexml_load_file($target_file) or die("Error: Cannot create object");
                $izvod = (string) $xml->stmtnumber . ",";
                echo "Izvod: " . basename($_FILES["fileToUpload"]["name"]) . " sa rednim brojem " . $xml->stmtnumber . " je obrađen.<br />";
                for ($i = 0; $i < $xml->trnlist->stmttrn->count(); $i++) {
                    if ($xml->trnlist->stmttrn[$i]->benefit == 'credit') {
                        $racun = (string) $xml->trnlist->stmttrn[$i]->payeeaccountinfo->acctid;
                        $broj [$i] = $racun;
                        $uplata = (double) $xml->trnlist->stmttrn[$i]->trnamt;
                        $sh = $this->pdo->query("select br_racuna, br_racunadva, br_racunatri, br_racunacetiri, br_racuna_oo from table_five where br_racuna = '" . $racun . "' OR br_racunadva = '" . $racun . "' OR br_racunatri = '" . $racun . "' OR br_racunacetiri = '" . $racun . "' OR br_racuna_oo = '" . $racun . "'");
                        $sh->execute();
                        $resultshl = $sh->fetch(PDO::FETCH_ASSOC);
                        $resultsh = (string) $resultshl['br_racuna'];
                        $resultshdva = (string) $resultshl['br_racunadva'];
                        $resultshtri = (string) $resultshl['br_racunatri'];
                        $resultshcetiri = (string) $resultshl['br_racunacetiri'];
                        $resultshoo = (string) $resultshl['br_racuna_oo'];
                        if ($resultsh == $racun || $resultshdva == $racun || $resultshtri == $racun || $resultshcetiri == $racun || $resultshoo == $racun) {
                            try {
                                $rh = $this->pdo->query("select " . $mesec . " from table_five where br_racuna = '" . $racun . "' OR br_racunadva = '" . $racun . "' OR br_racunatri = '" . $racun . "' OR br_racunacetiri = '" . $racun . "' OR br_racuna_oo = '" . $racun . "'");
                                $rh->execute();
                                $resultsql = $rh->fetch(PDO::FETCH_ASSOC);
                                $result = (double) $resultsql[$mesec];
                                $uplatakon = $uplata + $result;

                                $oh = $this->pdo->query("select a.naziv from table_one as a inner join table_five as b on a.rbr_one = b.rbr_one where br_racuna = '" . $racun . "' OR br_racunadva = '" . $racun . "' OR br_racunatri = '" . $racun . "' OR br_racunacetiri = '" . $racun . "' OR br_racuna_oo = '" . $racun . "'");
                                $oh->execute();
                                $resultsqlo = $oh->fetch(PDO::FETCH_ASSOC);
                                $resulto = (string) $resultsqlo['naziv'];
                                $ph = $this->pdo->query("update table_five set " . $mesec . " = '" . $uplatakon . "' where br_racuna = '" . $racun . "' OR br_racunadva = '" . $racun . "' OR br_racunatri = '" . $racun . "' OR br_racunacetiri = '" . $racun . "' OR br_racuna_oo = '" . $racun . "'");
                                $ph->execute();

                                echo "Uplata uspešno uneta za " . $resulto . " sa računa br. " . $racun . " u iznosu od " . $uplata . " dinara za mesec " . $mesec . " 2021. godine.<br />";
                            } catch (PDOException $ex) {
                                print "Greška!: " . $ex->getMessage();
                                return false;
                            }
                        } else {
                            echo "Račun " . $racun . " ne postoji u našoj bazi podataka.<br />";
                        }
                    }
                }

                $izva = array_unique($broj);
                foreach ($izva as $valued) {
                    $rh = $this->pdo->query("select izvodi from table_five where br_racuna = '" . $valued . "' OR br_racunadva = '" . $valued . "' OR br_racunatri = '" . $valued . "' OR br_racunacetiri = '" . $valued . "' OR br_racuna_oo = '" . $valued . "'");
                    $rh->execute();
                    $resultsql = $rh->fetch(PDO::FETCH_ASSOC);
                    $resultw = (string) $resultsql['izvodi'];
                    $izvodiw = $resultw . $izvod;
                    $dh = $this->pdo->query("update table_five set izvodi = '" . $izvodiw . "' where br_racuna = '" . $valued . "' OR br_racunadva = '" . $valued . "' OR br_racunatri = '" . $valued . "' OR br_racunacetiri = '" . $valued . "' OR br_racuna_oo = '" . $valued . "'");
                    $dh->execute();
                }
            } else {
                echo "Izvinjavamo se, došlo je do greške prilikom učitavanja fajla.<br />";
            }
        }
        //$this->tpl->display('clanarina.tpl');       
    }
    
    /*changing word files with entry from page
     * for purpose of making many word files while preserving original template file
     */
    function poziviGo($noviDatumSastanka, $noviPrviRed, $noviDrugiRed, $noviTreciRed, $noviCetvrtiRed, $noviPetiRed, $noviSestiRed, $noviSedmiRed, $noviOsmiRed, $noviDevetiRed, $noviDesetiRed, $noviDatumPoziva){
        $nazivPoziva = array('dir/Poziv za sastanak jedan.docx', 'dir/Poziv za sastanak dva.docx',
            'dir/Poziv za sastanak tri.docx', 'dir/Poziv za sastanak cetiri.docx');
        
        $poziviTemplate = array('tempdir/Poziv za sastanak jedan.docx', 'tempdir/Poziv za sastanak dva.docx',
            'tempdir/Poziv za sastanak tri.docx', 'tempdir/Poziv za sastanak cetiri.docx');
        
        $stariDatumSastanka = "sastanak";
        $stariPrviRed = "prvatacka";
        $stariDrugiRed = "drugatacka";
        $stariTreciRed = "trecatacka";
        $stariCetvrtiRed = "cetvrtatacka";
        $stariPetiRed = "petatacka";
        $stariSestiRed = "sestatacka";
        $stariSedmiRed = "sedmatacka";
        $stariOsmiRed = "osmatacka";
        $stariDevetiRed = "devetatacka";
        $stariDesetiRed = "desetatacka";
        $stariDatumPoziva = "datum";

        for ($i=0;$i<4;$i++){
            $zip = new ZipArchive;
            
            if(!copy($poziviTemplate[$i], $nazivPoziva[$i])) {
                die("Could not copy '$poziviTemplate[$i]' to '$nazivPoziva[$i]'");
            }
            
            $wordDoc = $nazivPoziva[$i];
            $fileToModify = 'word/document.xml';

            if ($zip->open($wordDoc) === TRUE) {
                $oldContents = $zip->getFromName($fileToModify);
                $newContents = str_replace($stariDatumSastanka, $noviDatumSastanka, $oldContents);
                $newContentsa = str_replace($stariPrviRed, $noviPrviRed, $newContents);
                $newContentsb = str_replace($stariDrugiRed, $noviDrugiRed, $newContentsa);
                $newContentsc = str_replace($stariTreciRed, $noviTreciRed, $newContentsb);
                $newContentsd = str_replace($stariCetvrtiRed, $noviCetvrtiRed, $newContentsc);
                $newContentse = str_replace($stariPetiRed, $noviPetiRed, $newContentsd);
                $newContentsf = str_replace($stariSestiRed, $noviSestiRed, $newContentse);
                $newContentsg = str_replace($stariSedmiRed, $noviSedmiRed, $newContentsf);
                $newContentsh = str_replace($stariOsmiRed, $noviOsmiRed, $newContentsg);
                $newContentsi = str_replace($stariDevetiRed, $noviDevetiRed, $newContentsh);
                $newContentsj = str_replace($stariDesetiRed, $noviDesetiRed, $newContentsi);
                $newContentsk = str_replace($stariDatumPoziva, $noviDatumPoziva, $newContentsj);
                $zip->addFromString($fileToModify, $newContentsk);
                $return =$zip->close();
            if ($return==TRUE){
                echo "Poziv je kreiran.<br />";
            }
            } else {
                echo 'failed';
              }
        }
        echo '<br><a href="posaljiPozive/index.php" class="noprint"><button type="button" class="btn btn-default noprint" style="margin-left: 10px;"><span class="glyphicon glyphicon-chevron-left"></span> Aplikacija za slanje poziva</button></a>';
    }
    
    //sending automatic messages for successiful/unsuccessiful payments via email
    function autoMail($mesec){
        $datum = getdate();
        if ($datum['mday'] <= 5){
        try {
            foreach ($this->pdo->query
                    ("select ".$mesec.", o.mejl, s.naziv from table_five as g inner join table_one as s on g.rbr_one = s.rbr_one"
                    . " inner join table_three as o on g.rbr_one=o.rbr_one where sedo = 'da' and o.mejl != 'ne' and o.mejl != ''") as $row) {
                $rows[] = $row;
            }
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        for ($i = 0; $i < count($rows); $i++) {
            if ($rows[$i][$mesec] == '') {
                $mail = new PHPMailer;
                $mail->CharSet = 'UTF-8';
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = 'html';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = "nesto@gmail.com";
                $mail->Password = "";
                $mail->setFrom('nesto@gmail.com', 'Nesto');
                $mail->addReplyTo('nesto@gmail.com', 'Nesto');
                $mail->addAddress($rows[$i]['mejl']);
                set_time_limit(400);
                $mail->Body = 'Poštovani,<br /><br /><b>'
                        .$rows[$i]['naziv'].'</b> nema evidentiranu uplatu <b>za mesec '.$mesec.' '.$datum['year'].'. godine</b>.<br />'
                        . 'Molimo Vas da u najkraćem roku izmirite svoja dugovanja.<br /><br />'
                        . 'Obrada uplate izvršena: '.$datum['mday'].'.'.$datum['mon'].'.'.$datum['year'].'. godine.<br />'
                        . 'Za sve dodatne informacije možete nas kontaktirati.<br /><br />'
                        . 'Srdačan pozdrav,<br />'
                        . '------------------------------------------------------------------<br />';
                $mail->Subject = 'Obaveštenje o uplati';
                $mail->AltBody = '--';
                if (!$mail->send()) {
                    echo "Došlo je do greške: " . $mail->ErrorInfo;
                } else {
                    $j = $i+1;
                    echo '<p style="margin-left: 10px;">'.$j.'. '.$rows[$i]['naziv'].' nema uplatu za mesec '.$mesec.'. Mejl uspešno poslat na: '.$rows[$i]['mejl'].'.</p>';
                }
            } else {
                $mail = new PHPMailer;
                $mail->CharSet = 'UTF-8';
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = 'html';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = "nesto@gmail.com";
                $mail->Password = "";
                $mail->setFrom('nesto@gmail.com', 'Nesto');
                $mail->addReplyTo('nesto@gmail.com', 'Nesto');
                $mail->addAddress($rows[$i]['mejl']);
                set_time_limit(400);
                $mail->Body = 'Poštovani,<br />'
                        . 'Uspešno smo evidentirali uplatu '.$rows[$i]['naziv'].' za mesec '.$mesec.' '.$datum['year'].'. godine u iznosu od '.$rows[$i][$mesec].' dinara.<br />'
                        . 'Obrada uplate izvršena: '.$datum['mday'].'.'.$datum['mon'].'.'.$datum['year'].'. godine.<br />'
                        . 'Srdačan pozdrav.<br />'
                        . '------------------------------------------------------------------<br />';
                $mail->Subject = 'Obaveštenje o uplati';
                $mail->AltBody = '--';
                if (!$mail->send()) {
                    echo "Došlo je do greške: " . $mail->ErrorInfo;
                } else {
                    $j = $i+1;
                    echo '<p style="margin-left: 10px;">'.$j.'. '.$rows[$i]['naziv'].' ima uplatu za '.$mesec.' u iznosu od '.$rows[$i][$mesec].' dinara. Mejl uspešno poslat na: '.$rows[$i]['mejl'].'.</p>';
                }
            }
        }
        echo '<a href="index.php" class="btn btn-info" role="button" style="margin: 15px 0 0 10px;">Nazad</a><br>';
        return $rows;
    } else {
        echo 'Obaveštenja se šalju od 1. do 5. datuma u mesecu za prethodni mesec. Danas ne možete poslati obaveštenje jer je '.$datum['mday'].'.'.$datum['mon'].'.'.$datum['year'].'. godine.';
        $this->display();
    }
    }
    
    // function for getting all mails from database and preparing a string of mails
    function getAllMail($case){
        if ($case == 'jedan'){
            try {
                $rh = $this->pdo->prepare("select mejl from table_one where ango = 'da' and mejl != 'ne' and mejl != ''");
                $rh->execute();
                $result = $rh->fetchAll();
            } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
            }
            for ($i=0;$i<count($result);$i++){
            $resultString = $result[$i]['mejl'];
            $resultStringDva .= $resultString . ",";
            }
        $resultFin = rtrim($resultStringDva, ",");
        return $resultFin;
        } else if ($case == 'dva'){
            try {
                $rh = $this->pdo->prepare("select mejl from table_two where mejl != 'ne' and mejl != ''");
                $rh->execute();
                $result = $rh->fetchAll();
        } catch (PDOException $ex) {
            print "Greška!: " . $ex->getMessage();
            return false;
        }
        for ($i=0;$i<count($result);$i++){
            $resultString = $result[$i]['mejl'];
            $resultStringDva .= $resultString . ",";
        }
        $resultFin = rtrim($resultStringDva, ",");
        return $resultFin;
        }
    }
}
