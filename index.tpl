<!DOCTYPE html>
<html lang="en">
    <head>
        <title>INF Aplikacija</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="style/jquery-3.1.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body id="pocetna" data-spy="scroll" data-target=".logo" data-offset="60">
        <nav class="navbar">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#izvodi"><span class="glyphicon glyphicon-equalizer"></span> Obrada izvoda</a></li>
                    <li><a href="#uplate"><span class="glyphicon glyphicon-saved"></span> Uplate</a></li>
                    <li><a href="#pozivi"><span class="glyphicon glyphicon-compressed"></span> Kreiranje poziva</a></li>
                    <li><a href="#insert"><span class="glyphicon glyphicon-copy"></span> Unesite nove podatke</a></li>
                    <li><a href="#delovodnik"><span class="glyphicon glyphicon-list-alt"></span> Delovodnik</a></li>
                </ul>
            </div>
        </nav>
        <div class="jumbotron text-center">
            <img src="style/logo.jpg" alt="" class="logo"><h1>Inf App</h1>
            <p>Adresa, 11000 Beograd</p>
            <form class="form-inline" method="post" action="{$SCRIPT_NAME}?action=search">
                <input class="form-control" size="50" placeholder="Pretražite bazu" type="text" name="search" required>
                <select name="field" class="form-control">
                    <option value="jedan">Opcija 1</option>
                    <option value="dva">Opcija 2</option>
                    <option value="tri">Opcija 3</option>
                </select>
                <button type="submit" class="btn btn-primary" value="submit">Pretraži</button>
            </form>
        </div>
        <div id="services" class="container-fluid text-center">
            <div class="row slideanim1">
                <div class="col-sm-4">
                    <a href="{$SCRIPT_NAME}?action=aaa"><span class="glyphicon glyphicon-king logo-small"></span></a>
                    <h4>Spisak</h4>
                    <p>Informacije</p>
                </div>
                <div class="col-sm-4">
                    <a href="{$SCRIPT_NAME}?action=bro"><span class="glyphicon glyphicon-queen logo-small"></span></a>
                    <h4>Spisak 2</h4>
                    <p>Informacije 2</p>
                </div>
                <div class="col-sm-4">
                    <a href="{$SCRIPT_NAME}?action=spa"><span class="glyphicon glyphicon-bishop logo-small"></span></a>
                    <h4>Spisak 3</h4>
                    <p>Informacije 3</p>
                </div>
            </div>
            <br><br>
        </div>
        <div id="izvodi" class="container-fluid text-center">
            <div class="row">
                <div class="col-sm-8">
                    <br><h2>Obrada uplata sa izvoda iz banke</h2><br>
                    <form action="{$SCRIPT_NAME}?action=upload" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="sel1">Odaberite mesec i izvod za obradu:</label>
                            <select class="form-control" id="sel1" name="mesec" required>
                                <option>januar</option>
                                <option>februar</option>
                                <option>mart</option>
                                <option>april</option>
                                <option>maj</option>
                                <option>jun</option>
                                <option>jul</option>
                                <option>avgust</option>
                                <option>septembar</option>
                                <option>oktobar</option>
                                <option>novembar</option>
                                <option>decembar</option>
                            </select>
                        </div>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="btn btn-success">
                        <input type="submit" value="Obradi izvod" name="submit" class="btn btn-primary">
                    </form>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-indent-left logo slideanim" style="margin-top: 90px;"></span>
                </div>
            </div>
        </div>
        <div id="uplate" class="container-fluid text-center">
            <div class="row">
                <div class="col-sm-4">
                    <br><br><span class="glyphicon glyphicon-check logo slideanim" style="margin-top: 65px;"></span>
                </div>
                <div class="col-sm-8">
                    <br><h2>Uplate</h2><br>
                    <div class="col-sm-6">
                    <a href="{$SCRIPT_NAME}?action=uplate"><span class="glyphicon glyphicon-info-sign logo-small"></span><h4>PREGLED UPLATE</h4></a>
                    </div>
                    <div class="col-sm-6">
                    <span class="glyphicon glyphicon-retweet logo-small"></span><h4>Pošaljite obaveštenja o uplatama za mesec:</h4>
                    <form action="{$SCRIPT_NAME}?action=autoMail" method="post">
                        <div class="form-group">
                            <select class="form-control" id="selll" name="mesec" required>
                                <option>januar</option>
                                <option>februar</option>
                                <option>mart</option>
                                <option>april</option>
                                <option>maj</option>
                                <option>jun</option>
                                <option>jul</option>
                                <option>avgust</option>
                                <option>septembar</option>
                                <option>oktobar</option>
                                <option>novembar</option>
                                <option>decembar</option>
                            </select>
                        </div>
                        <input type="submit" value="Pošalji" name="submit" class="btn btn-primary">
                    </form>
                    <h5>*Obaveštenja mogu da se pošalju samo od 1. do 5. datuma u mesecu za prethodni mesec.</h5>
                    </div>
                </div>
            </div>
        </div>
        <div id="delovodnik" class="container-fluid text-center">
            <div class="row">
                <div class="col-sm-8">
                    <br><h2>Elektronska Delovodna knjiga</h2><br>
                    <div class="col-sm-6">
                    <a href="{$SCRIPT_NAME}?action=pregledDelovodnika"><span class="glyphicon glyphicon-eye-open logo-small"></span><h4>PREGLED DELOVODNE KNJIGE</h4></a>
                    </div>
                    <div class="col-sm-6">
                    <a href="{$SCRIPT_NAME}?action=insert&amp;case=cetiri"><span class="glyphicon glyphicon-save logo-small"></span><h4>NOVI UNOS</h4></a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-list-alt logo slideanim" style="margin-top: 90px;"></span>
                </div>
            </div>
        </div>
        <div id="pozivi" class="container-fluid">
            <div class="text-center">
                <br><h2>Kreiranje poziva</h2>
                <h4>Odaberite vrstu poziva i unesite tražene podatke</h4>
            </div>
            <div class="row slideanim">
                <div class="col-sm-4 col-xs-12">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <h1>Poziv 1</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="{$SCRIPT_NAME}?action=pozivi">
                                <div class="input-group">
                                    <span class="input-group-addon">Datum sastanka: </span>
                                    <input id="noviDatumSastanka" type="text" class="form-control" name="noviDatumSastanka" placeholder="петак, 20. јануар 2017. године у 12 часова">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviPrviRed" type="text" class="form-control" name="noviPrviRed" placeholder="1. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviDrugiRed" type="text" class="form-control" name="noviDrugiRed" placeholder="2. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviTreciRed" type="text" class="form-control" name="noviTreciRed" placeholder="3. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviCetvrtiRed" type="text" class="form-control" name="noviCetvrtiRed" placeholder="4. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviPetiRed" type="text" class="form-control" name="noviPetiRed" placeholder="5. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviSestiRed" type="text" class="form-control" name="noviSestiRed" placeholder="6. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviSedmiRed" type="text" class="form-control" name="noviSedmiRed" placeholder="7. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviOsmiRed" type="text" class="form-control" name="noviOsmiRed" placeholder="8. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviDevetiRed" type="text" class="form-control" name="noviDevetiRed" placeholder="9. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviDesetiRed" type="text" class="form-control" name="noviDesetiRed" placeholder="10. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Datum kreiranja poziva: </span>
                                    <input id="noviDatumPoziva" type="text" class="form-control" name="noviDatumPoziva" placeholder="У Нишу, 13. децембар 2016. године">
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" value="submit" class="btn btn-lg">Kreiraj</button>
                                </div>
                            </form>
                        </div>
                    </div>      
                </div>     
                <div class="col-sm-4 col-xs-12">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <h1>Poziv 2</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="{$SCRIPT_NAME}?action=pozividva">
                                <div class="input-group">
                                    <span class="input-group-addon">Datum sastanka: </span>
                                    <input id="noviDatumSastanka" type="text" class="form-control" name="noviDatumSastanka" placeholder="у петак, 23. децембра 2016. године у 12 часова">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviPrviRed" type="text" class="form-control" name="noviPrviRed" placeholder="1. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviDrugiRed" type="text" class="form-control" name="noviDrugiRed" placeholder="2. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviTreciRed" type="text" class="form-control" name="noviTreciRed" placeholder="3. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviCetvrtiRed" type="text" class="form-control" name="noviCetvrtiRed" placeholder="4. Тачка;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Tačka dnevnog reda: </span>
                                    <input id="noviPetiRed" type="text" class="form-control" name="noviPetiRed" placeholder="5. Тачка.">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Datum kreiranja poziva: </span>
                                    <input id="noviDatumPoziva" type="text" class="form-control" name="noviDatumPoziva" placeholder="Београд, 13. децембар 2016. године">
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" value="submit" class="btn btn-lg">Kreiraj</button>
                                </div>
                            </form>
                        </div>
                    </div>      
                </div>          
            </div>
        </div><br>
        <br><div id="insert" class="container-fluid text-center bg-grey">
            <h2>Unesite nove podatke</h2>
            <h4>Odaberite jednu od ponuđenih opcija</h4><br>
            <div class="row text-center slideanim">
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <a href="{$SCRIPT_NAME}?action=insert&amp;case=jedan"><span class="glyphicon glyphicon-user logo"></span></a><br>
                        <br><p><strong>Unesite novi podatak</strong></p>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <a href="{$SCRIPT_NAME}?action=insert&amp;case=dva"><span class="glyphicon glyphicon-home logo"></span></a><br>
                        <br><p><strong>Unesite novi podatak 2</strong></p>
                        <p></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="thumbnail">
                        <a href="{$SCRIPT_NAME}?action=insert&amp;case=tri"><span class="glyphicon glyphicon-link logo"></span></a><br>
                        <br><p><strong>Unesite nove kontakte</strong></p>
                    </div>
                </div>
            </div>
        </div><br>
        <footer class="container-fluid text-center">
            <a href="#pocetna" title="Na početak">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>	
        </footer>
    </body>
</html>