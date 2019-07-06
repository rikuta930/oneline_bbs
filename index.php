<?php
try {
    $db = new PDO('pgsql:dbname=rikuta;host=localhost','rikuta','LLkoO89K');
} catch(PDOExeption $e) {
    echo 'DB接続エラー：' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $name = null;
        $comment = null;
        $created_at = date('Y-m-d H:i:s');

        if (!isset($_POST['name'])) {
            $errors['name'] = 'Please enter a name';
        } else if (strlen($_POST['name']) > 40) {
            $errors['name'] = 'Usernames cannot be longer than 40 characters';
        } else {
            $name = $_POST['name'];
        }

        if (!isset($_POST['comment'])) {
            $errors['comment'] = 'Please enter a comment';
        } else if (strlen($_POST['comment']) > 200) {
            $errors['comment'] = 'Comment cannot be longer than 200 characters';
        } else {
            $comment = $_POST['comment'];
        }

        if (empty($errors)) {
        $posts = $db->prepare('INSERT INTO bbs_posts (name,comment,created_at) VALUES(?,?,?)');
        $posts->execute(array(
            $_POST['name'],
            $_POST['comment'],
            $created_at
        ));
        header('Location: index.php');
        exit();
        }
    }
}

$sql = 'SELECT name, comment, created_at FROM bbs_posts ORDER BY created_at';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>One Line BBS!!!</h1>
<?php if (count($errors)):?>
    <ul>
    <?php foreach($errors as $error):?>
        <li>
        <?php echo htmlspecialchars($error, ENT_QUOTES);?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif;?>
    <form action="" method="post">
        <p>Name <input type="text" name="name"></p>
        <p>Comment <input type="text" name="comment" id=""></p>
        <input type="submit" value="送信">
    </form>

    <ul>
<?php foreach($db->query($sql) as $row):?>
        <li>
        <?php echo $row['name'] . ':' . $row['comment'] . ' [' . $row['created_at'] . ']';?>
        </li>
<?php endforeach;?>
    </ul>
</body>
</html>