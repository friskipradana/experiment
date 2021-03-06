<html>
 <head>
 <Title>Registration Form</Title>
      <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
  

 </head>
 <body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="https://experime.azurewebsites.net/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://experime.azurewebsites.net/analyze.php">Add Image</a>
      </li>
  </div>
</nav>
	 
	 
	 
 <div class="container">
  <div class="starter-template"> <br><br><br>
        <h1>Register here!!</h1>
        <p>Fill in your name and email address, then click Submit to register</p> <br>
        <span class="border-top my-3"></span>
      </div>
	 
	 
	 
	 
 <form method="post" action="index.php" enctype="multipart/form-data" >
	<div class="form-group">  
       Name  <input class="form-control form-control-sm" type="text" name="name" id="name"/>
	 </div>
	 <div class="form-group">
       Email <input class="form-control form-control-sm" type="text" name="email" id="email"/>
	 </div>
	 <div class="form-group">
       Job <input class="form-control form-control-sm" type="text" name="job" id="job"/>
	</div>
       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="load_data" value="Load Data" />

 </form>



 <?php
    $host = "azurewebsappserver.database.windows.net";
    $user = "azureusers";
    $pass = "Azure12345";
    $db = "azurewebappdb";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Job</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
</div> <br><br><br>
 </body>
 </html>
