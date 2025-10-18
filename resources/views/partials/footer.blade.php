<footer class="text-center py-4 text-gray-600 dark:text-gray-400">
    <p id="footer-text"></p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const year = new Date().getFullYear();
        const name = "Grado";
        document.getElementById("footer-text").innerHTML = `&copy; ${year} ${name}. All rights reserved.`;
    });
</script>
