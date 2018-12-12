<!-- Loading Javascripts... -->
    <!-- jQuery -->
    <script src="<?php echo BASE_URI; ?>assets/plugins/jquery/3.3.1/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo BASE_URI; ?>assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Other -->
    <script src="<?php echo BASE_URI; ?>assets/plugins/select2/select2.min.js"></script>
    <script src="<?php echo BASE_URI; ?>assets/plugins/waves/waves.min.js"></script>
    <script src="<?php echo BASE_URI; ?>assets/plugins/datatables/js/jquery.datatables.js"></script>
    <script src="<?php echo BASE_URI; ?>assets/plugins/datatables/js/formatted-number.js"></script>
    <script src="<?php echo BASE_URI; ?>assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="<?php echo BASE_URI; ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

    <script src="<?php echo BASE_URI; ?>assets/js/terra.js"></script>
    <!-- <script src="<?php //echo BASE_URI; ?>assets/js/naive-bayes-libs.js"></script> -->
    <script src="<?php echo BASE_URI; ?>assets/js/naive-bayesian.js"></script>

    <!-- Loading Core... -->
<?php   $uri = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>
<?php   $uri = $uri == 'malaria' ? 'index' : basename($uri, '.php'); ?>
    <script type="text/javascript" src="<?php echo $uri; ?>.js"></script>
</body>
</html>
