<div class="row m-0" style="min-height: 100vh">
    <div class="col-12 col-lg-8" style="background-image: url(<?php echo base_url('tower.jpg'); ?>); background-size: cover"></div>
    <div class="col-12 col-lg-4">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="w-100" style="max-width: 360px">
                <h3 class="mb-3">VERIFY OTP</h3>
                <div class="mb-3 text-muted fst-italic">Open your Google Authenticator app</div>
                <?php echo view('components/status'); ?>
                <form method="POST" action="<?php echo url_to('user.otp'); ?>">
                    <div class="mb-3">
                        <label for="otp" class="form-label">OTP Code</label>
                        <input id="otp" type="text" class="form-control" name="otp" placeholder="XXXXXX">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
