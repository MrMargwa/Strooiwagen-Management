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

    <div id="toast-root" class="toast-container" aria-live="polite" aria-atomic="true"></div>

    <!-- Footer -->
    <?= $this->insert("footer") ?>

    <script>
        (function () {
            var params = new URLSearchParams(window.location.search);
            var toastKey = params.get("toast");
            var type = params.get("type") || "success";
            if (!toastKey) {
                return;
            }

            var messages = {
                "road-created": "Weg is aangemaakt.",
                "road-create-failed": "Aanmaken is mislukt.",
                "road-updated": "Weg is bijgewerkt.",
                "road-update-failed": "Bewerken is mislukt.",
                "road-deleted": "Weg is verwijderd.",
                "road-delete-failed": "Verwijderen is mislukt.",
                "road-not-found": "Weg is niet gevonden."
            };

            var message = messages[toastKey];
            if (!message) {
                return;
            }

            var root = document.getElementById("toast-root");
            var toast = document.createElement("div");
            toast.className = "toast toast-" + (type === "error" ? "error" : "success");
            toast.setAttribute("role", "status");

            var text = document.createElement("div");
            text.className = "toast-text";
            text.textContent = message;

            var close = document.createElement("button");
            close.className = "toast-close";
            close.type = "button";
            close.setAttribute("aria-label", "Sluiten");
            close.textContent = "x";
            close.addEventListener("click", function () {
                toast.remove();
            });

            toast.appendChild(text);
            toast.appendChild(close);
            root.appendChild(toast);

            window.setTimeout(function () {
                toast.classList.add("toast-hide");
                window.setTimeout(function () {
                    toast.remove();
                }, 300);
            }, 4500);

            params.delete("toast");
            params.delete("type");
            var newQuery = params.toString();
            var newUrl = window.location.pathname + (newQuery ? "?" + newQuery : "") + window.location.hash;
            window.history.replaceState({}, document.title, newUrl);
        })();
    </script>

</body>

</html>