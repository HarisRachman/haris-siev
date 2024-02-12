<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: ../../index.php');
} else {
    if($_SESSION['role'] == 0) {
        header('Location: ../user/votes.php');
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
        <title>Candidates - SIeV</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
        <style>
            label{
                margin: 5px 0px;
            }

            .form-group{
                margin: 10px 0px;
            }

            .ck-editor__editable_inline {
                min-height: 300px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">SIeV</a>
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
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link" href="users.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                User Data
                            </a>
                            <a class="nav-link" href="positions.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div>
                                Position Data
                            </a>
                            <a class="nav-link" href="candidates.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Candidate Data
                            </a>
                            <div class="sb-sidenav-menu-heading">Report</div>
                            <a class="nav-link" href="votes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-check-to-slot"></i></div>
                                Votes
                            </a>
                            <a class="nav-link" href="chart.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                                Live Chart
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
                        <h1 class="mt-4">Candidates</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Candidates</li>
                        </ol>
                        <div class="container-alert">
                            <div class="alerts">
                                <div class="alert alert-success">gg</div>
                                <div class="alert alert-danger">ee</div>
                            </div>
                        </div>
                        <button style="margin-bottom:10px" class="btn btn-primary" id="create">Tambah Data</button>
                        <div class="card mb-4" id="input_kandidat" style="display:none">
                            <div class="card-header">
                                <i class="fas fa-user-tie me-1"></i>
                                Input Kandidat
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Masukkan Nama Kandidat</b></label>
                                            <input type="text" placeholder="Nama" id="nama" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Pilih Posisi Kandidat</b></label>
                                            <select id="posisi_kandidat" class="form-control">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Masukkan Foto Kandidat</b></label>
                                            <input type="file" placeholder="Gambar" id="image" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for=""><b>Visi Kandidat</b></label>
                                            <textarea id="visi_editor"></textarea>
                                            <textarea name="visi" id="visi" hidden></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for=""><b>Misi Kandidat</b></label>
                                            <textarea id="misi_editor"></textarea>
                                            <textarea name="misi" id="misi" hidden></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group buttons">
                                    <button class="btn btn-success" type="submit" id="save">Save</button>
                                    <button class="btn btn-danger" type="button" id="close">Cancel</button>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4" id="update_kandidat" style="display:none">
                            <div class="card-header">
                                <i class="fas fa-user-tie me-1"></i>
                                Update Kandidat
                            </div>
                            <div class="card-body">
                                <input type="hidden" placeholder="Id" id="id" class="form-control">
                                <input type="hidden" placeholder="Gambar" id="gambar" class="form-control">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Masukkan Nama Kandidat</b></label>
                                            <input type="text" placeholder="Nama" id="edit_nama" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Pilih Posisi Kandidat</b></label>
                                            <select id="edit_posisi_kandidat" class="form-control">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for=""><b>Masukkan Foto Kandidat</b></label>
                                            <input type="file" placeholder="Gambar" id="edit_image" class="form-control">
                                            <p>Kosongkan bila tidak ingin mengubah gambar.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for=""><b>Visi Kandidat</b></label>
                                            <textarea id="edit_visi_editor"></textarea>
                                            <textarea name="edit_visi" id="edit_visi" hidden></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for=""><b>Misi Kandidat</b></label>
                                            <textarea id="edit_misi_editor"></textarea>
                                            <textarea name="edit_misi" id="edit_misi" hidden></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group buttons">
                                    <button class="btn btn-success" type="submit" id="update">Save</button>
                                    <button class="btn btn-danger" type="button" id="update_close">Cancel</button>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-tie me-1"></i>
                                Candidate Data
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-responsive table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Posisi</th>
                                            <th>Nama</th>
                                            <th>Image</th>
                                            <th>Visi</th>
                                            <th>Misi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Posisi</th>
                                            <th>Nama</th>
                                            <th>Image</th>
                                            <th>Visi</th>
                                            <th>Misi</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/js/datatables-simple.js"></script> -->
        <script src="../assets/js/fetch_api_admin/kandidat.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#visi_editor' ) )
                .then( editor => {
                    const visi = document.querySelector('#visi');

                    editor.model.document.on('change:data', () => {
                        visi.value = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );
        </script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#misi_editor' ) )
                .then( editor => {
                    const misi = document.querySelector('#misi');

                    editor.model.document.on('change:data', () => {
                        misi.value = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );
        </script>
        
    </body>
</html>
