<?php

use Ramsey\Uuid\Uuid;

function uuid()
{
    return Uuid::uuid4()->toString();
}
