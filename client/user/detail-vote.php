<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: ../../index.php');
} else {
    if($_SESSION['role'] == 1) {
        header('Location: ../admin/dashboard.php');
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
        <title>Detail Votes - SIeV</title>
        <link href="../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .modal{
            position:fixed;
            top: 0;
            background-color: rgba(0, 0, 0, 0.842);
            width: 100%;
            height: 100vh;
            display:none;
            justify-content: center;
            align-items:center;
            }

            .modal-body{
            background-color: white;
            width: 50%;
            padding: 30px;
            margin:50px 500px;
            border-radius: 10px;
            }

            .modal-body h3{
            margin-bottom: 30px ;
            text-align: center;
            }

            label{
            margin: 10px 0px;
            }

            .form-group{
            margin: 20px 0px;
            }

            .form-control{
            width: 100%;
            outline: none;
            border: none;
            background-color:none;
            border-bottom: 1px solid #006266;
            padding: 10px 0px;
            font-size: 18px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">SIeV</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
                        <?php
                            if(isset($_SESSION['valid'])) {
                                echo $_SESSION['name'];
                            }
                        ?>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li> -->
                        <li><a href="../../api/logout.php" onclick="return confirm('Are you sure you want to Log Out?')" class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="votes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-check-to-slot"></i></div>
                                Votes
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php
                            if(isset($_SESSION['valid'])) {
                                echo $_SESSION['name'];
                            }
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Votes</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><a href="votes.php">Votes</a></li>
                            <li class="breadcrumb-item active">Detail Vote</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fas fa-check-to-slot me-1"></i>
                                Detail Votes
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    include("../../api/koneksi.php");
                                        $id = $_GET['id']; // Assuming you're passing the ID via GET parameter
                                        $sql = "SELECT candidates.id as id, candidates.nama as nama, candidates.image as image, 
                                                candidates.visi as visi, candidates.misi as misi, positions.posisi as posisi 
                                                FROM candidates 
                                                LEFT JOIN positions ON candidates.position_id = positions.id
                                                WHERE candidates.position_id = $id";
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="col-4">
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <i class="fas fas fa-check-to-slot me-1"></i>
                                                            '. $row["posisi"] .'
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <center>
                                                                    <h4>' . $row["nama"] . '</h4>
                                                                    <img src="../assets/images/candidates/'. $row["image"] .'" width="100%" height="auto" style="border-radius:10px">
                                                                </center>
                                                                <div class="row mt-2" style="margin:auto">
                                                                    <div class="card mb-1" style="padding:10px">
                                                                        <h6>Visi:</h6>
                                                                        ' . $row["visi"] . '
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-1" style="margin:auto">
                                                                    <div class="card mb-1" style="padding:10px">
                                                                        <h6>Misi:</h6>
                                                                        ' . $row["misi"] . '
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <center><button onclick="showModal_'.$row["id"].'()" class="btn btn-lg btn-outline-primary mt-2">Vote</button></center>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                        } else {
                                            echo '<div class="col-4">
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <i class="fas fas fa-check-to-slot me-1"></i>
                                                            Posisi
                                                        </div>
                                                        <div class="card-body">
                                                            <h6>Belum Ada Kandidat</h6>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
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

        <?php
        include("../../api/koneksi.php");
            $id = $_GET['id']; // Assuming you're passing the ID via GET parameter
            $sql = "SELECT candidates.id as id, candidates.nama as nama, candidates.image as image, 
                    candidates.visi as visi, candidates.misi as misi, positions.posisi as posisi 
                    FROM candidates 
                    LEFT JOIN positions ON candidates.position_id = positions.id
                    WHERE candidates.position_id = $id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="modal" id="konfirmasi('.$row["id"].')">
                        <div class="modal-body">
                            <form name="form1" method="post" action="">
                                <h3>Konfirmasi Vote</h3>
                                <div class="form-group">
                                    <label for=""><h5>Apa anda yakin akan memilih ' . $row["nama"] . ' sebagai '. $row["posisi"] .'? </h5></label>
                                    <input type="hidden" name="id_user" value="' . $_SESSION['user_id'] . '" class="form-control">
                                    <input type="hidden" name="id_candidate" value="' . $row["id"] . '" class="form-control">
                                </div>
                                <div class="form-group buttons">
                                    <button class="btn btn-success" name="submit_'.$row["id"].'" type="submit" id="save">Ya, Vote</button>
                                    <button class="btn btn-danger" onclick="closeModal_'.$row["id"].'()" type="button" id="close">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>';

                    echo '<div class="modal" id="success('.$row["id"].')">
                        <div class="modal-body">
                            <h3>Vote Berhasil</h3>
                            <div class="form-group">
                                <label for=""><h5>Selamat, Anda telah berhasil melakukan Vote.</h5></label>
                            </div>
                            <div class="form-group buttons">
                                <center><button class="btn btn-danger" onclick="closeSuccess_'.$row["id"].'()" type="button" id="close">Close</button></center>
                            </div>
                        </div>
                    </div>';

                    echo '<div class="modal" id="failed('.$row["id"].')">
                        <div class="modal-body">
                            <h3>Vote Gagal</h3>
                            <div class="form-group">
                                <label for=""><h5>Maaf, Anda gagal melakukan Vote.</h5></label>
                            </div>
                            <div class="form-group buttons">
                                <center><button class="btn btn-danger" onclick="closeFailed_'.$row["id"].'()" type="button" id="close">Close</button></center>
                            </div>
                        </div>
                    </div>';

                    echo '<script>
                        function showModal_'.$row["id"].'() {
                            document.getElementById("konfirmasi('.$row["id"].')").style.display = "flex";
                        }
                    </script>';

                    echo '<script>
                        function closeModal_'.$row["id"].'() {
                            document.getElementById("konfirmasi('.$row["id"].')").style.display = "none";
                        }
                    </script>';

                    echo '<script>
                        function closeSuccess_'.$row["id"].'() {
                            window.location.href = "votes.php";
                        }
                    </script>';

                    echo '<script>
                        function closeFailed_'.$row["id"].'() {
                            window.location.reload();
                        }
                    </script>';

                    if(isset($_POST['submit_'.$row["id"].''])) {	
                        $id_user = $_POST['id_user'];
                        $id_kandidat = $_POST['id_candidate'];
                            
                        $result = mysqli_query($conn, "INSERT INTO votes(user_id, candidate_id) VALUES('$id_user', '$id_kandidat')");
                        if ($result) {
                            echo '<script>
                                document.getElementById("konfirmasi('.$row["id"].')").style.display = "none";
                                document.getElementById("success('.$row["id"].')").style.display = "flex";
                            </script>';
                        } else {
                            echo '<script>
                                document.getElementById("konfirmasi('.$row["id"].')").style.display = "none";
                                document.getElementById("failed('.$row["id"].')").style.display = "flex";
                            </script>';
                        }
                    }
                }
            } else {
                
            }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>
</html>
