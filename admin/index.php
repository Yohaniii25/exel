<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Exel Holdings</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form action="login_handler.php" method="post" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm space-y-6">
        <h2 class="text-2xl font-bold text-center text-gray-800">Admin Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="text-red-500 text-sm text-center bg-red-100 p-2 rounded"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div>
            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Login</button>
    </form>

</body>
</html>