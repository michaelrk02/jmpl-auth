<?php $jmpl = config('Jmpl'); ?>
<script async src="https://www.google.com/recaptcha/api.js"></script>
<div class="row m-0" style="min-height: 100vh">
    <div class="col-12 col-lg-8" style="background-image: url(<?php echo base_url('tower.jpg'); ?>); background-size: cover"></div>
    <div class="col-12 col-lg-4">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="w-100" style="max-width: 360px">
                <h3 class="mb-3">LOGIN</h3>
                <?php echo view('components/status'); ?>
                <form method="POST" action="<?php echo url_to('user.login'); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="someone@example.com" value="<?php echo old('email'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="********">
                    </div>
                    <?php if ($useCaptcha): ?>
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="<?php echo $jmpl->recaptchaSiteKey; ?>"></div>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
