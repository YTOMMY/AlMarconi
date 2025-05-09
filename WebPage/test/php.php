<?php
require_once "../backend/db.php";
require_once "../backend/account.php";
require_once "../backend/aziende.php";
require_once "../backend/studenti.php";

$result = update_account( 2, 'tassoni', ['telefono' => '543210', 'nome' => 'Angelo', 'cognome' => 'Depalo']);
echo $result;
/*
$output = get_annuncio(3);
print_r($output);
/*
$result = query_select(Table::Annunci, [Arg::Mansione, Arg::IdAnnuncio, Arg::DataScadenza], [Arg::Mansione], ['b']);
while ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}*/
?>