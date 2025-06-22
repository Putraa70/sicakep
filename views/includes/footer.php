<!-- footer.php - Menampilkan footer umum untuk setiap halaman -->

<!-- Link ke CSS Footer -->
<!-- Footer -->
<footer class="footer mt-auto">
    <div class="container text-center">
        <p class="mb-1">&copy; <?= date("Y"); ?> Sicakep. All rights reserved.</p>
        <p class="mb-1">
            <a href="mailto:contact@sicakep.com">Contact Us</a> |
            <a href="privacy-policy.php">Privacy Policy</a>
        </p>
        <p class="mb-0">
            <small class="text-muted">Sistem Pengelola Keuangan Pribadi</small>
        </p>
    </div>
    <style>
/* Footer always at bottom */
html, body {
    height: 100%;
}
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.footer {
    margin-top: auto;
    background: #f8f9fa;
    padding: 1.2rem 0 1.2rem 0;
    border-top: 1px solid #dee2e6;
}
</style>

</footer>
