<?php
include 'admin/includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p class='text-red-500 text-center mt-10'>No project ID provided.</p>";
    exit;
}

// create DB instance
$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result->num_rows) {
    echo "<p class='text-red-500 text-center mt-10'>Project not found.</p>";
    exit;
}

$project = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.5/dist/tailwind.min.css" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

</head>

<body>

    <?php require(__DIR__  . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12 mt-[130px]" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Projects</h1>

            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Project</span>
            </nav>
        </div>
    </section>


    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <img src="admin/<?= $project['image'] ?>" alt="<?= htmlspecialchars($project['name']) ?>" class="w-full h-auto rounded shadow mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($project['name']) ?></h1>
            <p class="text-gray-700 leading-relaxed text-lg"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
        </div>
    </section>


    <?php require(__DIR__  . '/includes/footer.php'); ?>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>