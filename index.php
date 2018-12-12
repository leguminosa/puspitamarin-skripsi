<?php   include('core/core.php'); ?>
<?php   include('includes/session.php'); ?>
<?php   // phpinfo(); ?>
<?php   //print_r(count($_SESSION)); ?>

<?php   include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>PUSPITAMARIN</h1>

            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks home active">Home</button>
                <button class="tablinks tab2">Other(2)</button>
                <button class="tablinks tab3">Other(3)</button>
                <button class="tablinks tab4">Other(4)</button>
            </div>

            <!-- Tab content -->
            <div id="home" class="tabcontent" style="display:block;">
                <h3>London</h3>
                <p>London is the capital city of England.</p>
            </div>

            <div id="tab2" class="tabcontent">
                <h3>Paris</h3>
                <p>Paris is the capital of France.</p>
            </div>

            <div id="tab3" class="tabcontent">
                <h3>Tokyo</h3>
                <p>Tokyo is the capital of Japan.</p>
            </div>

            <div id="tab4" class="tabcontent">
                <h3>Jekardah</h3>
                <p>Jekardah is the capital of Indonesia.</p>
            </div>

        </div>
    </main>
<?php   include('includes/footer.php'); ?>
