<?php

namespace Tests\Unit;

use App\Jobs\SendEmailJob;
use App\Mail\SendEmailTest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendEmailJobTest extends TestCase
{
    use RefreshDatabase;

    public function testItSendsAnEmailWhenTheJobIsProcessed()
    {
        // Mock the Mail facade
        Mail::fake();

        // Create the job with correct details
        $details = ['email' => 'test@example.com'];
        $job = new SendEmailJob($details);
        $job->handle();

        // Assert that the email was sent
        Mail::assertSent(SendEmailTest::class, function ($mail) {
            return $mail->hasTo('test@example.com');
        });
    }
}
