<?php
    session_start();
    if (!isset($_SESSION["email"]) || $_SESSION["key"] !== 'admin') {
        header("location: admin.php");
        exit;
    }
    else
    {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Online Quiz System</title>
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/welcome.css">
    <link  rel="stylesheet" href="css/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
    <style>
     body {
        background-image: url('https://images.freecreatives.com/wp-content/uploads/2016/01/Free-Solids-Background.jpg');
        background-size: cover;
    }
    .carousel-inner .item img {
        height: 635px; /* Set the desired height */
        width: 100%;   /* Set the desired width */
    }

    /* Set the background color to green using a more specific selector */
    .navbar.navbar-dark.title1 {
        background-color: black !important;
    }

    /* Set the text color to white for the links */
    .navbar.navbar-dark.title1 .navbar-nav > li > a {
        color: white !important;
        font-weight: bold;
    }

    /* Add styles for the active link */
    .navbar.navbar-dark.title1 .navbar-nav > .active > a {
        background-color: black !important;
        color: white !important;
    }

    /* Style for links on hover */
    .navbar.navbar-dark.title1 .navbar-nav > li > a:hover {
        background-color: white !important;
        color: black !important;
    }
    #myCarousel {
    margin: 0;
    padding: 0;
}
</style>
</head>

<body>
    <div style="margin: 0; padding: 0;">

<nav class="navbar navbar-dark bg-dark title1" >
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Javascript:void(0)" style="color: blue;"><b>Online Quiz</b></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li <?php if(@$_GET['q']==0) echo 'class="active"'; ?>><a href="dashboard.php?q=0" >Home<span class="sr-only">(current)</span></a></li>
                <li <?php if(@$_GET['q']==1) echo 'class="active"'; ?>><a href="dashboard.php?q=1" >User</a></li>
                <li <?php if(@$_GET['q']==2) echo 'class="active"'; ?>><a href="dashboard.php?q=2">Ranking</a></li>
                <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo 'active'; ?>">
                <li><a href="dashboard.php?q=4" >Add Quiz</a></li>
                <li><a href="dashboard.php?q=5" >Remove Quiz</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li <?php echo ''; ?> > <a style="color: red;" href="logout1.php?q=dashboard.php"><span style="color: red;" class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Log out</a></li>
            </ul>
        </div>
    </div>
</nav>
</div>

    <div style="width:100%;margin: 0; padding: 0;">
            <?php if(@$_GET['q']==0)
            {
                echo '
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="image/mypic1.jpg" alt="New York" width="100%" height="1580px">
                <div class="carousel-caption">
                <h3>Welcome to Admin Page!!</h3>
                </div>      
            </div>
            </div>';
                
            }

            if(@$_GET['q']== 2) 
            {
                $q=mysqli_query($con,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
                echo  '<div class="panel title"><div class="table-responsive">
                <table class="table table-striped title1" >
                <tr style="color:red"><td style="background-color:black;color:white;"><center><b>Rank</b></center></td><td style="background-color:black;color:white;"><center><b>Name</b></center></td><td style="background-color:black;color:white;"><center><b>Score</b></center></td></tr>';
                $c=0;
                while($row=mysqli_fetch_array($q) )
                {
                    $e=$row['email'];
                    $s=$row['score'];
                    $q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
                    while($row=mysqli_fetch_array($q12) )
                    {
                        $name=$row['name'];
                        $college=$row['college'];
                    }
                    $c++;
                    echo '<tr><td style="color:#99cc32"><center><b>'.$c.'</b></center></td><td><center>'.$e.'</center></td><td><center>'.$s.'</center></td>';
                }
                echo '</table></div></div>';
            }
            ?>
            <?php 
                if(@$_GET['q']==1) 
                {
                    $result = mysqli_query($con, "SELECT * FROM user") or die('Error');
                    echo '<div class="panel"><div class="table-responsive"><table class="table table-striped table-bordered title1">
                    <thead class="table-dark">
                    <tr >
                        <th class="text-center" style="background-color:black;color:white;">S.N.</th>
                        <th class="text-center" style="background-color:black;color:white;">Name</th>
                        <th class="text-center" style="background-color:black;color:white;">College</th>
                        <th class="text-center" style="background-color:black;color:white;">Email</th>
                        <th class="text-center" style="background-color:black;color:white;">Action</th>
                    </tr> </thead>';
                    $c = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $name = $row['name'];
                        $email = $row['email'];
                        $college = $row['college'];
                        echo '<tr>
                            <td class="text-center">' . $c++ . '</td>
                            <td class="text-center">' . $name . '</td>
                            <td class="text-center">' . $college . '</td>
                            <td class="text-center">' . $email . '</td>
                            <td class="text-center">
                                <a title="Delete User" href="update.php?demail=' . $email . '">
                                    <b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b>
                                </a>
                            </td>
                        </tr>';
                    }
                    $c = 0;
                    echo '</table></div></div>';
                }
            ?>

            <?php
                if(@$_GET['q']==4 && !(@$_GET['step']) ) 
                {
                    echo '<div class="row"><span class="title1" style="margin-left:40%;font-size:30px;color:black;"><b>Enter Quiz Details</b></span><br /><br />
                    <div class="col-md-3"></div><div class="col-md-6">   
                    <form class="form-horizontal title1" name="form" action="update.php?q=addquiz"  method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name"></label>  
                                <div class="col-md-12">
                                    <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 control-label" for="total"></label>  
                                <div class="col-md-12">
                                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 control-label" for="right"></label>  
                                <div class="col-md-12">
                                    <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12 control-label" for="wrong"></label>  
                                <div class="col-md-12">
                                    <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-12 control-label" for=""></label>
                                <div class="col-md-12"> 
                                    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                                </div>
                            </div>

                        </fieldset>
                    </form></div>';
                }
            ?>

            <?php
                if(@$_GET['q']==4 && (@$_GET['step'])==2 ) 
                {
                    echo ' 
                    <div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
                    <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&eid='.@$_GET['eid'].'&ch=4 "  method="POST">
                    <fieldset>
                    ';
            
                    for($i=1;$i<=@$_GET['n'];$i++)
                    {
                        echo '<b>Question number&nbsp;'.$i.'&nbsp;:</><br /><!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="qns'.$i.' "></label>  
                                    <div class="col-md-12">
                                        <textarea rows="3" cols="5" name="qns'.$i.'" class="form-control" placeholder="Write question number '.$i.' here..."></textarea>  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="'.$i.'1"></label>  
                                    <div class="col-md-12">
                                        <input id="'.$i.'1" name="'.$i.'1" placeholder="Enter option a" class="form-control input-md" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="'.$i.'2"></label>  
                                    <div class="col-md-12">
                                        <input id="'.$i.'2" name="'.$i.'2" placeholder="Enter option b" class="form-control input-md" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="'.$i.'3"></label>  
                                    <div class="col-md-12">
                                        <input id="'.$i.'3" name="'.$i.'3" placeholder="Enter option c" class="form-control input-md" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="'.$i.'4"></label>  
                                    <div class="col-md-12">
                                        <input id="'.$i.'4" name="'.$i.'4" placeholder="Enter option d" class="form-control input-md" type="text">
                                    </div>
                                </div>
                                <br />
                                <b>Correct answer</b>:<br />
                                <select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct answer " class="form-control input-md" >
                                <option value="a">Select answer for question '.$i.'</option>
                                <option value="a"> option a</option>
                                <option value="b"> option b</option>
                                <option value="c"> option c</option>
                                <option value="d"> option d</option> </select><br /><br />'; 
                    }
                    echo '<div class="form-group">
                            <label class="col-md-12 control-label" for=""></label>
                            <div class="col-md-12"> 
                                <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                            </div>
                            </div>

                    </fieldset>
                    </form></div>';
                }
            ?>

<?php 
if (@$_GET['q'] == 5) {
    $result = mysqli_query($con, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
    <tr>
        <td style="background-color:black;color:white;"><center><b>S.N.</b></center></td>
        <td style="background-color:black;color:white;"><center><b>Topic</b></center></td>
        <td style="background-color:black;color:white;"><center><b>Total question</b></center></td>
        <td style="background-color:black;color:white;"><center><b>Marks</b></center></td>
        <td style="background-color:black;color:white;"><center><b>Action</b></center></td>
    </tr>';
    
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $total = $row['total'];
        $sahi = $row['sahi'];
        $eid = $row['eid'];
        echo '<tr>
            <td><center>'.$c++.'</center></td>
            <td><center>'.$title.'</center></td>
            <td><center>'.$total.'</center></td>
            <td><center>'.$sahi * $total.'</center></td>
            <td><center><b><a href="update.php?q=rmquiz&eid='.$eid.'" class="pull-right btn sub1" style="margin: 0; background-color: red; color: black;">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Remove</b></span></a></b></center></td>
        </tr>';
    }
    $c = 0;
    echo '</table></div></div>';
}
?>

            </div>
        </div>
    </div>
</body>
</html>
