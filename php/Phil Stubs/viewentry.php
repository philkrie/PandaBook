<?php

$q = array(
    array
    (
        'firstname' => 'Phil',
        'lastname' => 'Kriegel',
        'city' => 'beav',
        'state' => 'OR',
        'zip' => '97007'
    )
    );

$r = array(
    array
    (
        'firstname' => 'Greg',
        'lastname' => 'Mina',
        'city' => 'Colorado Springs',
        'state' => 'CO',
        'zip' => '97007'
    )
    );


if($_GET['id'] == '1')
  echo json_encode($q);
else
  echo json_encode($r);

exit();
?>