<!doctype html>
<html>
<head>
    <style>
        .entry{
            border: 1px solid;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Gästbok</h1>
 
    <form method='post' action=''>
    <textarea name='message'></textarea><br>
    <input type='submit' value='Skicka inlägget' />
    </form>
 
    <?php
    $db = mysqli_connect('localhost', 'root', '', 'guestbook');
 
    if( isset($_POST['message']) 
        && isset($_POST['sender']) ){
         
        $sender = $_POST['sender'];
        $message = $_POST['message'];
 
        $query = "
            INSERT INTO entries 
            (date, sender, message) 
            VALUES 
            (NOW(), '$sender', '$message')
        ";
 
        mysqli_query($db, $query);
 
        echo "Skickat!";
    }
    
    if( isset($_POST['id']) ) {
      $id = $_POST['id'];
      $query = "
        DELETE FROM entries
        WHERE id = $id
      ";
      mysqli_query($db, $query);
    }
    
     
    $query = "
        SELECT * 
        FROM entries
        ORDER BY date DESC
    ";
    $result = mysqli_query($db, $query);
 
    while( $row = mysqli_fetch_assoc($result) ){
        echo "
            <div class='entry'>
                <p>{$row['message']}</p>
                <form method='post' action=''>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='submit' value='Ta bort'>
                </form>
            </div>
        "; 
    }
     
    ?>
 
</body>
</html>