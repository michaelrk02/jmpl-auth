<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function login()
    {
        $useCaptcha = (session()->get('throttle_login') ?? 0) >= 3;

        echo view('header', ['title' => 'Login', 'blank' => true]);
        echo view('user/login', compact('useCaptcha'));
        echo view('footer', ['blank' => true]);
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'E-mail and password are required'])->withInput();
        }

        $userModel = model(UserModel::class);
        $user = $userModel->findEmail($email);
        if (!isset($user)) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'E-mail does not exist'])->withInput();
        }

        if (!$user->is_activated) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'Account is not verified yet'])->withInput();
        }

        if (!password_verify($password, $user->password)) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'Incorrect password'])->withInput();
        }

        session()->set('auth', $user->id);
        return redirect()->route('home')->with('status', ['type' => 'success', 'message' => 'Welcome back, <strong>'.esc($user->name).'</strong>!']);
    }

    public function register()
    {
        echo view('header', ['title' => 'Register', 'blank' => true]);
        echo view('user/register');
        echo view('footer', ['blank' => true]);
    }

    public function otp()
    {
        echo view('header', ['title' => 'Enter OTP', 'blank' => true]);
        echo view('user/otp');
        echo view('footer', ['blank' => true]);
    }

    public function authenticateOtp()
    {
        $otp = $this->request->getPost('otp');

        $userModel = model(UserModel::class);
        $user = $userModel->find(session()->get('otp'));

        $curl = service('curlrequest');
        $response = $curl->request('GET', 'https://www.authenticatorapi.com/Validate.aspx?Pin='.urlencode($otp).'&SecretCode='.urlencode($user->gauth_secret_key));
        if ($response->getBody() !== 'True') {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'Invalid OTP code']);
        }

        session()->remove('otp');
        session()->set('auth', $user->id);

        return redirect()->route('home')->with('status', ['type' => 'success', 'message' => 'Welcome back, <strong>'.esc($user->name).'</strong>!']);
    }

    public function store()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passconf = $this->request->getPost('passconf');
        $name = $this->request->getPost('name');

        if (empty($email) || empty($password) || empty($passconf) || empty($name)) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'E-mail, passwords, and name are required'])->withInput();
        }

        $userModel = model(UserModel::class);
        $user = $userModel->findEmail($email);
        if (isset($user)) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'E-mail is already in use'])->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'Password length should not be less than 8 characters'])->withInput();
        }

        if ($password !== $passconf) {
            return redirect()->back()->with('status', ['type' => 'error', 'message' => 'Passwords do not match'])->withInput();
        }

        $user = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'name' => $name
        ];

        $userModel->insert($user);

        $jmpl = config('Jmpl');

        $id = $userModel->getInsertID();
        $exp = time() + 86400;
        $sig = hash_hmac('sha256', $id.$exp, $jmpl->secretKey);
        $link = url_to('user.activate').'?'.http_build_query(compact('id', 'exp', 'sig'));

        $mailer = service('email');
        $mailer->setFrom($jmpl->emailFromAddress, $jmpl->emailFromName);
        $mailer->setTo($email);
        $mailer->setSubject('Activate Your Account');
        $mailer->setMessage(view('mails/activate', compact('link')));
        $mailer->send();

        return redirect()->back()->with('status', ['type' => 'success', 'message' => 'Verification link has been sent to your e-mail. Follow the link to activate your account']);
    }

    public function activate()
    {
        $id = $this->request->getGet('id');
        $exp = $this->request->getGet('exp');
        $sig = $this->request->getGet('sig');

        $jmpl = config('Jmpl');
        if ($sig !== hash_hmac('sha256', $id.$exp, $jmpl->secretKey)) {
            return $this->response->setBody('Invalid signature');
        }

        if (time() >= $exp) {
            return $this->response->setBody('Link has expired');
        }

        $userModel = model(UserModel::class);
        $user = $userModel->find($id);
        if (!isset($user)) {
            return $this->response->setBody('Account not found');
        }

        if ($user->is_activated) {
            return $this->response->setBody('Account is already activated');
        }

        $userModel->update($id, ['is_activated' => true]);

        return redirect()->route('user.login')->with('status', ['type' => 'success', 'message' => 'Account has been activated. You can now login using your credentials']);
    }

    public function activateGoogleAuth()
    {
        $activate = !empty($this->request->getPost('activate'));

        $data = $activate ? [
            'gauth_is_activated' => true,
            'gauth_secret_key' => random_string('alnum', 16)
        ] : [
            'gauth_is_activated' => false,
            'gauth_secret_key' => null
        ];

        $userModel = model(UserModel::class);
        $userModel->update(session()->get('auth'), $data);

        return redirect()->back()->with('status', ['type' => 'success', 'message' => 'Google Auth '.($activate ? 'activation' : 'deactivation').' successful']);
    }

    public function logout()
    {
        session()->remove('auth');

        return redirect()->route('user.logout')->with('status', ['type' => 'success', 'message' => 'Logged out successfully']);
    }
}
