<?php include 'header.php'; ?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col p-md-0">
                <h4>404 Not Found</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="error-text font-weight-bold">404</h1>
                        <h4 class="mt-4">Page Not Found</h4>
                        <p>The page you are looking for does not exist or has been moved.</p>
                        <a href="<?php echo site_url('admin'); ?>" class="btn btn-primary mt-4">Return to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?> 