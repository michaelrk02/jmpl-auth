<?php

namespace App;

trait StatusTestTrait
{
    public function assertStatus($result, $type, $messagePart)
    {
        $result->assertRedirect();

        $this->assertArrayHasKey('status', $_SESSION);

        $status = $_SESSION['status'];
        $this->assertEquals($status['type'], $type);
        $this->assertStringContainsString($messagePart, $status['message']);
    }
}
