<?php session_start(); ?>
<?php
if(isset($_SESSION['valid'])) {
    if(isset($_SESSION['role']) == 1) {
        header('Location: client/admin/dashboard.php');
    } else {
        header('Location: client/user/votes.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SIeV</title>
    <link href="client/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    
<?php
include("api/koneksi.php");

if(isset($_POST['submit'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, $_POST['password']);

	$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password=md5('$pass')")
                or die("Could not execute the select query.");
    
    $row = mysqli_fetch_assoc($result);
    
    if(is_array($row) && !empty($row)) {
        $validuser = $row['email'];
        $_SESSION['valid'] = $validuser;
        $_SESSION['name'] = $row['nama'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['is_admin'];
    } else {
        header('Location: index.php?msg=Invalid username or password');
        // exit();
    }

    if(isset($_SESSION['valid'])) {
        if($_SESSION['role'] == 1) {
            header('Location: client/admin/dashboard.php');
        } else {
            header('Location: client/user/votes.php');
        }		
    }
} else {
?>

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <?php
                            // Display alert message if provided via URL parameters
                            if (isset($_GET['msg'])) {
                                echo '<div class="container-alert mt-2">
                                        <div class="alerts">
                                            <div class="alert alert-danger" style="display:flex">' . $_GET['msg'] .'</div>
                                        </div>
                                    </div>';
                            }
                        ?>
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                            <div class="card-body">
                                <form name="form1" method="post" action="">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" required />
                                        <label for="inputEmail">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required />
                                        <label for="inputPassword">Password</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Login">
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <!-- <div class="small"><a href="register.html">Need an account? Sign up!</a></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SIeV 2024</div>
                    <!-- <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div> -->
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="client/assets/js/scripts.js"></script>

<?php
}
?>
</body>
</html>
