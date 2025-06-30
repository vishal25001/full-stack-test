<?php
// Database connection using MySQLi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpoets_test";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// CRUD Operations
// Create
if (isset($_POST['create'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'];
    $tab_id = (int)$_POST['tab_id'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    
    $query = "INSERT INTO slides (title, description, image, tab_id) VALUES ('$title', '$description', '$image', $tab_id)";
    mysqli_query($conn, $query);
}

// Read
$tabs_query = mysqli_query($conn, "SELECT DISTINCT tab_id FROM slides");
$tabs = [];
while ($row = mysqli_fetch_assoc($tabs_query)) {
    $tabs[] = $row['tab_id'];
}
$slides_query = mysqli_query($conn, "SELECT * FROM slides");
$slides = mysqli_fetch_all($slides_query, MYSQLI_ASSOC);

// Update
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['old_image'];
    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }
    
    $query = "UPDATE slides SET title='$title', description='$description', image='$image' WHERE id=$id";
    mysqli_query($conn, $query);
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM slides WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WPoets Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- CRUD Form -->
        <div class="row mb-3">
            <div class="col">
                <h2>Add/Edit Slide</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="slide_id">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept=".jpg,.png,.svg">
                        <input type="hidden" name="old_image" id="old_image">
                    </div>
                    <div class="mb-3">
                        <label>Tab ID</label>
                        <select name="tab_id" class="form-control" required>
                            <option value="1">Communication</option>
                            <option value="2">Learning</option>
                            <option value="3">Technology</option>
                        </select>
                    </div>
                    <button type="submit" name="create" class="btn btn-primary">Add Slide</button>
                    <button type="submit" name="update" class="btn btn-warning" style="display:none;">Update Slide</button>
                </form>
            </div>
        </div>

        <!-- Web View -->
        <div class="row d-none d-md-flex">
            <div class="col-md-3">
                <ul class="nav nav-tabs flex-column" id="tabMenu">
                    <?php
                    $tab_names = [1 => 'Communication', 2 => 'Learning', 3 => 'Technology'];
                    $tab_icons = [
                        1 => 'files/images/DL-communication.svg',
                        2 => 'files/images/DL-learning.svg',
                        3 => 'files/images/DL-technology.svg'
                    ];
                    foreach ($tabs as $index => $tab_id):
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $tab_id; ?>" href="#">
                                <img src="<?php echo $tab_icons[$tab_id]; ?>" alt="<?php echo $tab_names[$tab_id]; ?>" class="tab-icon">
                                <?php echo $tab_names[$tab_id]; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <div id="slider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($slides as $index => $slide): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo $slide['tab_id']; ?>">
                                <img src="uploads/<?php echo $slide['image']; ?>" class="d-block w-100" alt="<?php echo $slide['title']; ?>">
                                <div class="slide-content">
                                    <h3><?php echo $slide['title']; ?></h3>
                                    <p><?php echo $slide['description']; ?></p>
                                    <a href="?delete=<?php echo $slide['id']; ?>" class="btn btn-danger">Delete</a>
                                    <button class="btn btn-warning edit-slide" data-id="<?php echo $slide['id']; ?>" data-title="<?php echo $slide['title']; ?>" data-description="<?php echo $slide['description']; ?>" data-image="<?php echo $slide['image']; ?>" data-tab_id="<?php echo $slide['tab_id']; ?>">Edit</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
                        <img src="files/images/arrow-right.svg" class="carousel-control-icon" style="transform: rotate(180deg);">
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
                        <img src="files/images/arrow-right.svg" class="carousel-control-icon">
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div id="image-preview">
                    <img src="uploads/<?php echo $slides[0]['image'] ?? 'DL-Communication.jpg'; ?>" alt="Slide Image" class="img-fluid">
                </div>
            </div>
        </div>

        <!-- Mobile View -->
        <div class="row d-md-none">
            <div class="col">
                <div class="accordion" id="accordionMenu">
                    <?php foreach ($tabs as $index => $tab_id): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $tab_id; ?>">
                                    <img src="<?php echo $tab_icons[$tab_id]; ?>" alt="<?php echo $tab_names[$tab_id]; ?>" class="tab-icon">
                                    <?php echo $tab_names[$tab_id]; ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $tab_id; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-tab="<?php echo $tab_id; ?>">
                                <div class="accordion-body">
                                    <div class="carousel slide mobile-slider" data-tab="<?php echo $tab_id; ?>">
                                        <div class="carousel-inner">
                                            <?php foreach ($slides as $slide_index => $slide): ?>
                                                <?php if ($slide['tab_id'] == $tab_id): ?>
                                                    <div class="carousel-item <?php echo $slide_index === 0 ? 'active' : ''; ?>" style="background-image: url('uploads/<?php echo $slide['image']; ?>');">
                                                        <div class="slide-content">
                                                            <h3><?php echo $slide['title']; ?></h3>
                                                            <p><?php echo $slide['description']; ?></p>
                                                            <a href="?delete=<?php echo $slide['id']; ?>" class="btn btn-danger">Delete</a>
                                                            <button class="btn btn-warning edit-slide" data-id="<?php echo $slide['id']; ?>" data-title="<?php echo $slide['title']; ?>" data-description="<?php echo $slide['description']; ?>" data-image="<?php echo $slide['image']; ?>" data-tab_id="<?php echo $slide['tab_id']; ?>">Edit</button>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target=".mobile-slider[data-tab='<?php echo $tab_id; ?>']" data-bs-slide="prev">
                                            <img src="files/images/arrow-right.svg" class="carousel-control-icon" style="transform: rotate(180deg);">
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target=".mobile-slider[data-tab='<?php echo $tab_id; ?>']" data-bs-slide="next">
                                            <img src="files/images/arrow-right.svg" class="carousel-control-icon">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>