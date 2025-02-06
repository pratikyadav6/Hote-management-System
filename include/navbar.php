<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Show the dropdown only if the user type is kitchen_manager -->
        <?php if ($_SESSION['type'] === 'kitchen_manager'): ?>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Edit Items</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../kitchen_manager/add_item.php">Add Item </a>
                    <a class="dropdown-item" href="../kitchen_manager/add_catagory.php">Add Category </a>
                    <a class="dropdown-item" href="../kitchen_manager/add_order_type.php">Add Order Type</a>
                    <a class="dropdown-item" href="../kitchen_manager/manage_item.php">Manage Item</a>
                </div>
            </li>

        <?php endif; ?>
        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Profile</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" style="color: green;">
                    <span>WELCOME <?php echo $_SESSION['first_name']; ?></span>
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" style="color: Red; text-transform: uppercase;">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    <span><?php echo $_SESSION['type']; ?></span>
                </a>
                <a class="dropdown-item" href="#" id="editProfile">
                    <i class="fas fa-cog fa-sm fa-fw mr-2"></i>
                    <span>Edit Profile</span>
                </a>
                <a class="dropdown-item" href="../logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<script>
    document.getElementById('editProfile').addEventListener('click', function(event) {
        event.preventDefault();
        var userType = "<?php echo $_SESSION['type']; ?>";

        if (userType === 'admin') {
            window.location.href = '../admin/editprofile.php?id=<?php echo $_SESSION['id']; ?>';
        } else if (userType === 'staff') {
            window.location.href = '../staff/editprofile.php?id=<?php echo $_SESSION['id']; ?>';
        } else if (userType === 'kitchen_manager') {
            window.location.href = '../kitchen_manager/editprofile.php?id=<?php echo $_SESSION['id']; ?>';
        } else {
            alert('User type not recognized.');
        }
    });
</script>