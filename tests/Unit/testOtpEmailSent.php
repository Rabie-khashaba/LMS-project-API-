<?php

namespace Tests\Unit;

use App\Mail\sendOTP;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\TestCase;

class testOtpEmailSent extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        Mail::fake();

        $otp = 123456;
        Mail::to('test@example.com')->send(new sendOTP($otp));

        Mail::assertSent(sendOTP::class);
    }
}
