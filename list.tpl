<!DOCTYPE html>
<html>
    <head>
        <title>Spisak</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </head>
    <body>
        <br>
        <div class="clearfix">
            <a href="index.php" class="noprint"><button type="button" class="btn btn-default noprint" style="margin-left: 10px;"><span class="glyphicon glyphicon-chevron-left"></span> Nazad na pretragu</button></a>
            <div class="text-center" style="font-size: 36px;"><img src="style/logo.jpg" alt="" style="vertical-align: middle;">Spisak</div>
            <button type="button" class="btn btn-default pull-right noprint" style="margin-left: 10px; margin-right: 10px;" onClick="location.href = 'mailto:{$mejl}'"><span class="glyphicon glyphicon-send"></span> Pošaljite mejl svima</button>
            <button type="button" class="btn btn-default pull-right noprint" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> Odštampajte</button>
        </div>
        <br>
            <div class="table-responsive print" style="margin-left: 10px; margin-right: 10px;">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center;"><span class="glyphicon glyphicon-sort-by-order"></span> Rbr</th>
                            <th style="text-align: center;"><span class="glyphicon glyphicon-user"></span> Ime i prezime</th>
                            <th style="text-align: center;"><span class="glyphicon glyphicon-earphone"></span> Adresa</th>
                            <th style="text-align: center;"><span class="glyphicon glyphicon-envelope"></span> Mejl</th>
                            <th colspan="2" style="text-align: center;" class="noprint"><span class="glyphicon glyphicon-cog"></span> Opcije</th>
                        </tr>
                    </thead>
                    {$i=1}
                    {foreach $data as $entry}
                        <tbody>
                            <tr class="active">
                                <td>{$i++}</td>
                                <td><a href="{$SCRIPT_NAME}?action=view&amp;id={$entry[5]|escape}&amp;field=jedan">{$entry[0]|escape}</a></td>
                                <td>{$entry[2]|escape}</td>
                                <td><a href="{$SCRIPT_NAME}?action=napraviMejl&amp;mejl={$entry[3]|escape}">{$entry[3]|escape}</a></td>
                                <td class="noprint">
                                    <a href="{$SCRIPT_NAME}?action=delete&amp;del={$entry.rbr_one|escape}&amp;case=jedan"
                                       onclick='if (!confirm("Da li ste sigurni?"))
                                       return false;'><span class="glyphicon glyphicon-remove"></span> Izbriši</a>
                                </td>
                                <td class="noprint">
                                    <a href="{$SCRIPT_NAME}?action=edit&amp;edt={$entry.rbr_one|escape}&amp;case=jedan"><span class="glyphicon glyphicon-pencil"></span> Izmeni</a>
                                </td>
                            </tr>
                        </tbody>
                    {/foreach}
                </table>
            </div>
    </body>
</html>