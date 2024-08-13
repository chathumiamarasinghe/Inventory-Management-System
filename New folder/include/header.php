<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header with Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <style>
        body {
            overflow-x: hidden;
            background-color: #f3f3f3;
        }

        .navbar {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
            border-radius: 1rem;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background-color: #045db5;
            border-color: #0080ff;
            color: #ffffff;
        }

        .sidebar {
            min-height: 100vh;
            padding-top: 60px;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
            max-width:300px;
        }

        .offcanvas-body {
            padding: 2rem;
        }

        .sidebar .nav-item {
            margin-bottom: 1rem;
        }

        .sidebar .nav-link {
            color: #333;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .sidebar .nav-link:hover {
            color: #045db5;
            background-color: #f0f0f0;
            border-radius: 0.5rem;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
            color: #045db5;
        }

        .offcanvas-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 1rem;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #045db5;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                ☰
            </button>
            <a class="navbar-brand ms-3" href="#">IMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn " type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title sidebar-title" id="sidebarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                <!-- Profile and Overview -->
                <li class="nav-item">
                    <a href="#" class="nav-link align-middle px-0">
                        <i class="fs-4 lni lni-user"></i> <span class="ms-1 d-none d-sm-inline">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../dashboard/dashboard.php" class="nav-link align-middle px-0">
                        <i class="fs-4 lni lni-agenda"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="../Register/register.php" class="nav-link align-middle px-0">
                        <i class="fs-4 lni lni-protection"></i> <span class="ms-1 d-none d-sm-inline">Regiter</span>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="../item/viewitem.php" class="nav-link align-middle px-0">
                        <i class="fs-4 lni lni-popup"></i> <span class="ms-1 d-none d-sm-inline">Product</span>
                    </a>
                </li>

                <!-- Other Items -->
                <li class="nav-item">
                    <a href="../item/viewcategory" class="nav-link align-middle px-0">
                        <i class="lni lni-tab"></i> <span class="ms-1 d-none d-sm-inline">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../report/export.php" class="nav-link align-middle px-0">
                        <i class="fs-4 lni lni-cog"></i> <span class="ms-1 d-none d-sm-inline">Report</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid mt-5 pt-4">
        <!-- Your page content goes here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
