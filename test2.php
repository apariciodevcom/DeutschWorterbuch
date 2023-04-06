<?php // test2.php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Fatal Error");

    echo '<body style="background-color:#1C2833; font-family: Arial; color:gray">';

    $datetime = date('m/d/Y h:i:s a', time());
    echo "<h3>La fecha actual es: " . $datetime ."</h3>";

    if (isset($_POST['wort']) &&
    isset($_POST['typ']) &&
    isset($_POST['add']))

    {
    $wort = get_post($conn, 'wort');
    $plural = get_post($conn, 'plural');
    $typ = get_post($conn, 'typ');
    $datetime = date('m/d/Y h:i:s a', time());  
    $beispiel = get_post($conn, 'beispiel');
    $bedeutung = get_post($conn, 'bedeutung'); 
    $query = "INSERT INTO worte VALUES" .
        "('$wort', Null,'$plural','$typ', '$datetime', '$bedeutung', '$beispiel')";
    $result = $conn->query($query);
    if (!$result) echo "INSERT failed<br><br>";
    }

    echo <<<_END

    <form action="test2.php" method="post"><pre>
    <input type="hidden" name="add" value=yes>
    Wort <input type="text" name="wort">
    plural <input type="text" name="plural" value="">
    Typ <select name="typ" size="1">
    <option value="null">not defined</option>
    <option value="der">Noun Maskulin (der)</option>
    <option value="die">Noun Faminin (die)</option>
    <option value="das">Noun Neutral (das)</option>
    <option value="verb">Verb</option>
    <option value="cnj">Conjunktion</option>
    <option value="adj">Adjetiv</option>
    <option value="adv">Adverb</option>
    </select>
    Bedeutung <input type="text" name="bedeutung">
    Beispiel <input type="text" name="beispiel">

    <input type="submit" value="Wort hinzufügen">
    </pre></form>
    _END;

//    $nnouns = "SELECT COUNT(*) FROM worte WHERE typ='verb'"; 
//    $result_nouns = $conn->query($nnouns);
//    $result_nounsp = mysqli_fetch_assoc($result_nouns);
//    echo "Noun".$result_nounsp;

    echo "WORTLIST"."<br>";
    $sql = "SELECT * FROM worte ORDER BY wort";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '#'. $row["idwort"].' <strong><span style="color:#E4E3E1">'. $row["wort"].'</span></strong>    <span style="color:green">('. $row["typ"].')</span>  <span style="color:#33FF66">'. $row["bedeutung"].'</span> '.'<br>'.'   '. $row["beispiel"].'<br>'.'<br>';
        }
    }
    else {
      echo "0 results";
    
    }

    $result->close();
    $conn->close();
    function get_post($conn, $var)
    {
    return $conn->real_escape_string($_POST[$var]);
    }
?>