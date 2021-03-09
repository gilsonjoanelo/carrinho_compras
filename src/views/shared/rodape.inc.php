    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/bootstrap.min.js"></script>
    <script src="/scripts/toastr.min.js"></script>
    <script src="/scripts/funcoes.js"></script>
    <?php 
        if (isset($jsFile)) {
            foreach ($jsFile as $item) {
                echo "<script src=\"/scripts/$item\"></script>";
            }
        }
    ?>
</body>
</html>