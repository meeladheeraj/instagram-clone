<?php
session_start();
$vis = true;
if(isset($_SESSION['us_email']))
{
    $vis = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

     <title>instagram</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="index.css">
    <style>
       .photo {
            width: 100%;
            height: 300px; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .photo img {
        max-width: 100%; 
        max-height: 100%;
        }
        p{
            font-size: 14px;
            line-height: 1.5;
            color: #262626;
            margin: 8px 0;
        }
        .profile1{
            margin-top:125px;
            display:flex;
            justify-content:center;
           
        }
        .form1
        {
            margin:10px;
            margin-left:200px;
            display:flex;
            flex-direction:column; 
            justify-content:center;
            border:2px solid black;
            padding:20px;
            box-shadow:inset 0 1px 1px rgba(0, 0, 0, .2), 0 .5px .5px rgba(0, 0, 0, .2);
            border-radius:10px;
            width:500px;
        }
        th,td{
            font-size:15px;
        }
        .float{
            display:flex;
            flex-direction:row;
        }
        .float form{
            margin:15px;
            
        }
        .end{
            margin:20px;
            padding:10px;
            top:50px;
            box-shadow: 0px 5px 3px 3px rgba(0,0,0,0.4);
            border-radius:5px;
            align-items:center;
        }
        .view{
            margin:10px;
            
        }

    </style>

</head>

<body>
    <header>

        <a href="index.php" class="logo">
        <i class="ui uil-instagram"></i>
        
        Instagram 
        </a>

        <nav class="navbar">
                      
            <?php 
            if($vis == false)
            {   
                echo'<a href="profile.php">profile</a>';
                echo'<a href="upload.php">upload</a>';
                echo '<a href="logout.php">logout</a>';
            }
            ?>
        </nav>
    </header>
    
        <?php
        if($vis==TRUE){
            echo'
            <main class="profile1">
            <div class="logos">
            ';
                        echo'
                        <div class="top"style="box-shadow: 0px 2px 2px 2px rgba(0,0,0,1);border-radius:10px;padding:10px;">
                        <h2><i class="ui uil-instagram"></i>top 3 likes users</h2>';
                        $con=new mysqli("localhost:3307","root","","upload");
                        if(isset($con)){
                        $sql="SELECT * FROM `images` ORDER BY likes DESC LIMIT 3;";
                        $top=$con->query($sql);
                        $j=1;
                        echo'<table cellspacing="35" cellpadding=6 style="border:2px solid black;border-radius:10px;"><tr><th>si.no</th><th>image</th><th>name</th><th>likes</th></tr>';
                        while($i=mysqli_fetch_assoc($top))
                        {   $likes=$i["likes"];
                            $t=$i["filename"];
                            $s="uploads/" . $t; 
                            echo'<tr><td>'.$j.".</td><td ><img src='".$s."'alt='img'Style='height:100px; width:100px;'></td><td>".$i["uname"].'</td><td>'.$likes.'</td></tr>';
                            $j+=1;
                        }
            echo'</table>
            </div>
            </div>
            </div>';}
       echo'    
                <form class="form1" action="login.php" method="POST">
                    <h2 style="margin-left:20px;text-align:center;margin-bottom:100px;">Instagram</h2>
                    <input placeholder="Email address or phone number"name = "uemail" class="input" type="text">
                    <input placeholder="Password" name="passw" class="input" type="password" id="password"> 
                    <button id="loginBtn"name="submit" type="submit">Log in</button>
                    <a id="forgotPassword" href="reset.html">Forgotten password?</a>
                    <button class="create" id="createAccountBtn"><a href="signup.php">Create new account</a></button>
                </form>
                </main>
                ';
        }
        if($vis == False){
            header("Refresh: 10");
        
        echo'<main class="profile">
        <div class="start"></div><div class="middle">';
        
            $con=new mysqli("localhost:3307","root","","upload");
            $query="SELECT  `id`,`filename`, `description`, `uname`, `likes` FROM `images`ORDER BY id DESC";
            $r=$con->query($query);
            while($row= mysqli_fetch_assoc($r))
            {
                $u=$row["uname"];
                $t=$row["filename"];
                $s="uploads/" . $t; 
                $d=$row["description"];
                $imgid=$row["id"];   
                $likes=$row["likes"];
            echo'
                
                <div class="container">
                <div class="feed">
                <h5>'.$u.'</h5>
                <div class="photo">
                <img src="'.$s.'"alt=""></div>
                <p>'.$d.'</p>
                <div class="float">
                <form action="like.php" method="POST">
                <input type="hidden" name="image_id" value="' . $imgid . '" />
                <button class="btn" name="submit" type="submit"><i class="uil uil-heart" ></i>'.$likes.'</button>
                </form>
                <form action="index.php" method="POST">
                <input name="comm" type="text"placeholder="comment..." >
                <input type="hidden" name="image_id" value="' . $imgid . '" />
                <button name="submit" type="submit" class="btn">Send</button></form></div><div id="view" class="view" >';
                        $q="SELECT `id`, `img_id`, `username`, `comment`, `timesatmp` FROM `comments` WHERE `img_id`='$imgid'";
                        $c=$con->query($q);
                        if(isset($c))
                        {
                            while($com=mysqli_fetch_assoc($c))
                            {
                                $commenter=$com['username'];
                                $des=$com['comment'];
                                echo'<p><b>'.$commenter.'</b></p>';
                                echo'<p>'.$des.'</p>';
                            }
                        }
                echo'
                </div>
               
                </div>
                </div>  '   ;
                echo'<script>
                var comments = document.getElementById("view");
                var showButton = document.getElementById("showComments");
                
                function toggleComments() {
                if (comments.style.display === "none") {
                    comments.style.display = "block";
                    showButton.innerHTML = "Hide Comments";
                } else {
                    comments.style.display = "none";
                    showButton.innerHTML = "Show Comments";
                }
                }
                
                showButton.addEventListener("click", toggleComments);
            </script>';
            }  
            echo'</div>
            <div>
            <div class="end" >
            
            <h3>active users</h3>
            ';
            $query="SELECT * FROM `activeusers` ";
            $res=$con->query($query);
            if(isset($res))
                {
                    while($com=mysqli_fetch_assoc($res))
                    {
                        $commenter=$com['username'];
                        echo'<p><b>'.$commenter.'</b></p>';
                    }
                }

            echo'</div></main>';


            if(isset($_POST["submit"]))
            {
                $i=$_POST['image_id'];
                $c=$_POST['comm'];
                $u=$_SESSION["name"];
                $con= new mysqli("localhost:3307","root","","upload");
                $query="INSERT INTO `comments`(`img_id`, `username`, `comment`) VALUES ('$i','$u','$c')";
                $r=$con->query($query);
                if(isset($r))
                {
                    // echo"<script>alert('commented');</script>";
                    echo '<script> window.location.replace("index.php");</script>';
                }
            }
        }
        ?>
    

</body>

</html>