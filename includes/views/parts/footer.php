    <script src="assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <?php if($this->current == "index"): ?>
        <script type="text/javascript">
            let rootUrl = "<?php echo URL_PATH ?>";
        </script>
        <script src="assets/js/classes/utils.js" type="text/javascript"></script>
        <script src="assets/js/classes/core.js" type="text/javascript"></script>
        <script src="assets/js/classes/file-explorer.js" type="text/javascript"></script>
    <?php endif; ?>
    </body>
</html>