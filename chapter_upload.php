
<?php

session_start();

include 'config.php';

if(!isset($_GET['id'])){

    die("Chapter not found.");
}

$chapter_id = $_GET['id'];

/* GET CHAPTER */

$chapter_query = mysqli_query(

    $conn,

    "SELECT chapters.*,
    stories.title AS story_title,
    stories.user_id AS author_id

    FROM chapters

    JOIN stories
    ON chapters.story_id = stories.id

    WHERE chapters.id='$chapter_id'"
);

if(mysqli_num_rows($chapter_query) == 0){

    die("Chapter not found.");
}

$chapter = mysqli_fetch_assoc($chapter_query);

$message = "";

/* UNLOCK SYSTEM */

if(isset($_POST['unlock'])){

    if(!isset($_SESSION['user_id'])){

        header("Location: login.php");
        exit();
    }

    $uid = $_SESSION['user_id'];

    /* CHECK USER COINS */

    $user_query = mysqli_query(

        $conn,

        "SELECT * FROM users
        WHERE id='$uid'"
    );

    $user = mysqli_fetch_assoc($user_query);

    if($user['coins'] >= $chapter['chapter_price']){

        /* CHECK IF ALREADY UNLOCKED */

        $check = mysqli_query(

            $conn,

            "SELECT * FROM unlocked_chapters

            WHERE user_id='$uid'

            AND chapter_id='$chapter_id'"
        );

        if(mysqli_num_rows($check) == 0){

            /* REMOVE COINS */

            mysqli_query(

                $conn,

                "UPDATE users

                SET coins =
                coins - ".$chapter['chapter_price']."

                WHERE id='$uid'"
            );

            /* SAVE UNLOCK */

            mysqli_query(

                $conn,

                "INSERT INTO unlocked_chapters

                (user_id, chapter_id)

                VALUES

                ('$uid','$chapter_id')"
            );

            /* AUTHOR EARNINGS */

            $author_id = $chapter['author_id'];

            $earnings =
            $chapter['chapter_price'] * 0.01;

            $earn_check = mysqli_query(

                $conn,

                "SELECT * FROM earnings

                WHERE user_id='$author_id'"
            );

            if(mysqli_num_rows($earn_check) > 0){

                mysqli_query(

                    $conn,

                    "UPDATE earnings

                    SET amount =
                    amount + $earnings

                    WHERE user_id='$author_id'"
                );

            }else{

                mysqli_query(

                    $conn,

                    "INSERT INTO earnings

                    (user_id, amount)

                    VALUES

                    ('$author_id','$earnings')"
                );
            }

            $message =
            "Chapter unlocked successfully!";
        }

    }else{

        $message =
        "Not enough coins.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

<?php echo $chapter['title']; ?>

</title>

<style>

body{

    background:#050816;

    color:white;

    font-family:Poppins,sans-serif;

    margin:0;
}

.container{

    width:900px;

    margin:auto;

    padding:50px 0;
}

.chapter-box{

    background:#111827;

    padding:40px;

    border-radius:20px;
}

h1{

    margin-bottom:10px;
}

.story{

    color:#9ca3af;

    margin-bottom:30px;
}

.content{

    line-height:1.9;

    font-size:18px;
}

.locked{

    background:#1f2937;

    padding:40px;

    border-radius:20px;

    text-align:center;
}

button{

    padding:15px 25px;

    background:#ff7b29;

    color:white;

    border:none;

    border-radius:10px;

    cursor:pointer;

    margin-top:20px;
}

.message{

    background:#16a34a;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;
}

.error{

    background:#dc2626;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="container">

<div class="chapter-box">

<h1>

<?php echo $chapter['title']; ?>

</h1>

<p class="story">

Story:
<?php echo $chapter['story_title']; ?>

</p>

<?php if($message != ""){ ?>

<div class="<?php echo ($message == 'Not enough coins.') ? 'error' : 'message'; ?>">

<?php echo $message; ?>

</div>

<?php } ?>

<div class="content">

<?php

/* FREE CHAPTER */

if($chapter['premium'] == 0){

    echo nl2br($chapter['content']);

}else{

    /* PREMIUM CHAPTER */

    if(!isset($_SESSION['user_id'])){

        ?>

        <div class="locked">

        <h2>
        🔒 Premium Chapter
        </h2>

        <p>
        Login to unlock this chapter.
        </p>

        <a href="login.php">

        <button>

        Login

        </button>

        </a>

        </div>

        <?php

    }else{

        $uid = $_SESSION['user_id'];

        /* CHECK UNLOCK */

        $unlock_check = mysqli_query(

            $conn,

            "SELECT * FROM unlocked_chapters

            WHERE user_id='$uid'

            AND chapter_id='$chapter_id'"
        );

        if(mysqli_num_rows($unlock_check) > 0){

            echo nl2br($chapter['content']);

        }else{

            ?>

            <div class="locked">

            <h2>
            🔒 Premium Chapter
            </h2>

            <p>

            Unlock this chapter for

            <b>

            <?php echo $chapter['chapter_price']; ?>

            coins

            </b>

            </p>

            <form method="POST">

            <button
            type="submit"
            name="unlock">

            Unlock Chapter

            </button>

            </form>

            </div>

            <?php
        }
    }
}

?>

</div>

</div>

</div>

</body>

</html>