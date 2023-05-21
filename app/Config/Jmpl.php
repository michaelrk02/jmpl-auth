<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Jmpl extends BaseConfig
{
    public $secretKey = '';

    public $emailFromAddress = 'noreply@localhost.localdomain';
    public $emailFromName = 'JMPL Auth';

    public $recaptchaSecretKey = '';
    public $recaptchaSiteKey = '';
}
