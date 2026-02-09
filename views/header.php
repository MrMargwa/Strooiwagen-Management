<header id="header">
    <div class="header-left">
        <a href="/">
            <img class="logo" src="https://sudwestfryslan.nl/wp-content/uploads/2024/07/logo-Gemeente-SWF_RGB.png"
                alt="Sudwest-Fryslan Logo" />
        </a>

        <nav>
            <ul>
                <li><a href="/" <?= ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') ? 'class="active"' : '' ?>>Home</a></li>
                <li><a href="/wegen" <?= (strpos($_SERVER['REQUEST_URI'], '/wegen') !== false) ? 'class="active"' : '' ?>>Wegen</a></li>
            </ul>
        </nav>
    </div>
    <button onclick="window.location.href='/wegen/create'">+ Weg</button>
</header>