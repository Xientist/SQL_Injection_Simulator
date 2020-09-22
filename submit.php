<?php

    if(isset($_POST['notsecure'])){

        function OpenCon()
        {
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $db = "secunews";
            $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

            return $conn;
        }

        function CloseCon($conn)
        {
            $conn -> close();
        }

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        
        $email = $_POST['email'];

        $conn = OpenCon();

        // La requête est construite à partir des entrées utilisateurs non filtrée!
        $query = "INSERT INTO subscribers VALUES ('' ,'".$name."', '".$surname."', '".$email."');";
        $results = $conn->query($query);
        echo "Vous vous êtes inscrits!<br>";
        
        echo "(la requête formulée est: ".$query.")";

        CloseCon($conn);

    } else if(isset($_POST['secure'])){ // Code sécurisé

        $mysqli = new mysqli("localhost", "root", "", "secunews");
        if($mysqli->connect_error) {
            exit('Error connecting to database');
        }

        // On prépare la requête en avance pour y insérer en sécurité les entrées utilisateurs.
        $query = "INSERT INTO subscribers VALUES ('', ?, ?, ?);";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $_POST['name'], $_POST['surname'], $_POST['email']);
        $stmt->execute();
        $stmt->close();
        
        echo "Vous vous êtes inscrits en toute sécurité!<br>";
    }
    

?>