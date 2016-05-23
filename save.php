<html>
<head>

</head>
<body>

<?php

// If user goes to url index.php?roomid=1&temperature=50&light=20
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
    $db->exec("CREATE TABLE IF NOT EXISTS house (roomid INTEGER, temperature INTEGER, light INTEGER);");

    $roomid = -1;
    $temperature = -270;
    $light = -1;
    $hasRoom = false;

    if (isset($_GET['roomid']))
    {
        $roomid = $_GET['roomid'];
    }
    if(isset($_GET['temperature'])){
        $temperature = $_GET['temperature'];
    }
    if(isset($_GET['light'])){
        $temperature = $_GET['light'];
    }

    if($roomid == -1)
    {
        echo "Wrong URL, roomid is required";
    }
    else
    {
        $stmt = $db->prepare('SELECT * FROM house WHERE roomid=:id');
        $stmt->bindValue(':id', $roomid, SQLITE3_INTEGER);

        $result = $stmt->execute();
        if(count($result->fetchArray()) == 1)
        {
            $hasRoom = true;
        }
        else
        {
            $hasRoom = false;
        }
    }
    if($temperature == -270 || $light == -1)
    {
        echo "Please provide at least temperature or light";
    }
    else if($temperature >= -273 && $hasRoom){
        $db->exec("UPDATE house SET temperature = " + $temperature + "WHERE roomid = " + $roomid);
    }
    else if($temperature >= -273 && $hasRoom==false)
    {
        $db->exec("INSERT INTO house (roomid, temperature) VALUES ("+$roomid+","+ $temperature +")");
    }
    else if($light >= 0 && $hasRoom){
        $db->exec("UPDATE house SET light = " + $light + "WHERE roomid = " + $roomid);
    }
    else if($light >= -273 && $hasRoom==false)
    {
        $db->exec("INSERT INTO house (roomid, light) VALUES ("+$roomid+","+ $light +")");
    }

    echo 'Data successfully saved to database';
}

?>
<body>
</html>
