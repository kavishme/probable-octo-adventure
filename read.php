<html>
<head>

</head>
<body>

<?php

// If user goes to url index.php?roomid=1
// I have assumed a test.db exists with table house having attribute as roomid, temperature and light

/**
 * PDO SQLite initial code
 *
 * Using phpLiteAdmin to admin SQLite3 and SQLite2 database : inclibs/util/sqlite3.db, inclibs/util/sqlite2.db
**/

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('test.db');
    }

    function __destruct()
    {
        $this->close();
    }
}
$db = new MyDB();

if(!$db){
    echo '<h2>' + $db->lastErrorMsg() + '</h2>';

} else {
    //echo "Opened database successfully\n";

    $roomid = 0;
    if (isset($_GET['roomid']))
    {
        $roomid = $_GET['roomid'];
    }

    $stmt = $db->prepare('SELECT temperature FROM house WHERE roomid=:id');
    $stmt->bindValue(':id', $roomid, SQLITE3_INTEGER);

    $result = $stmt->execute();
    //var_dump($result->fetchArray());

    $row = $result->fetchArray()[0];
    echo '<h2>' + $row['temperature'] + '</h2>';
}

?>
<body>
</html>
