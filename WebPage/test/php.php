<?php
require_once "../backend/aziende.php";

$output = get_annuncio(3);
print_r($output);
/*
$result = query_select(Table::Annunci, [Arg::Mansione, Arg::IdAnnuncio, Arg::DataScadenza], [Arg::Mansione], ['b']);
while ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}*/
?>