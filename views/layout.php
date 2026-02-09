<!DOCTYPE html>
<html>

<head>
    <title><?= $this->e($title) ?></title>
    <!-- <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css"> -->
<link rel="stylesheet" href="/styles.css">

</head>
<body>
   <!-- Header -->
    <?= $this->insert("header") ?>

    <main class="page-content">
        <!-- Content -->
        <?= $this->section("content") ?>
    </main>

    <!-- Footer -->
    <?= $this->insert("footer") ?>

</body>

</html>