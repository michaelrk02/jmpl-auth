<?php echo view('components/status'); ?>
<div class="card">
    <div class="card-body">
        <h3 class="mb-3">Welcome!</h3>
        <div class="mb-2">Name: <strong><?php echo esc($user->name); ?></strong></div>
        <div class="mb-2">E-mail: <strong><?php echo $user->email; ?></strong></div>
        <hr>
        <div>
            <form class="mb-2" method="POST" action="<?php echo route_to('user.activate.gauth'); ?>" onsubmit="return confirm('Are you sure?')">
                <input type="hidden" name="activate" value="<?php echo !$user->gauth_is_activated; ?>">
                <?php if ($user->gauth_is_activated): ?>
                    <button type="submit" class="btn btn-danger">Deactivate Google Auth</button>
                <?php else: ?>
                    <button type="submit" class="btn btn-success">Activate Google Auth</button>
                <?php endif; ?>
            </form>
            <?php if ($user->gauth_is_activated): ?>
                <div class="mb-2">Use QR code below to pair with your Google Authenticator app</div>
                <iframe class="mb-2" src="https://authenticatorapi.com/pair.aspx?AppName=JmplAuth&AppInfo=<?php echo urlencode($user->email); ?>&SecretCode=<?php echo urlencode($user->gauth_secret_key); ?>" width="360" height="360"></iframe>
            <?php endif; ?>
        </div>
    </div>
</div>
