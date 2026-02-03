<!DOCTYPE html>
<html>

<head>
    <title><?= $this->e($title) ?></title>
    <!-- <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css"> -->
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <header id="header">
        <div class="header-left">
            <a href="/">
                <img class="logo" src="https://sudwestfryslan.nl/wp-content/uploads/2024/07/logo-Gemeente-SWF_RGB.png"
                    alt="Sudwest-Fryslan Logo" />
            </a>

            <nav>
                <ul>
                    <a href="/">
                        <li>Home</li>
                    </a>
                    <a href="wegen">

                        <li>Wegen</li>
                    </a>
                </ul>
            </nav>
        </div>
        <button>+ Weg</button>
    </header>

    <?= $this->section("content") ?>

</body>

</html>