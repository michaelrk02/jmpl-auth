<div class="row m-0" style="min-height: 100vh">
    <div class="col-12 col-lg-8" style="background-image: url(<?php echo base_url('tower.jpg'); ?>); background-size: cover"></div>
    <div class="col-12 col-lg-4">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="w-100" style="max-width: 360px">
                <h3 class="mb-3">REGISTER</h3>
                <?php echo view('components/status'); ?>
                <form method="POST" action="<?php echo url_to('user.register'); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="someone@example.com" value="<?php echo old('email'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="********">
                    </div>
                    <div class="mb-3">
                        <label for="passconf" class="form-label">Confirm Password</label>
                        <input id="passconf" type="password" class="form-control" name="passconf" placeholder="********">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="John Doe" value="<?php echo old('name'); ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
