<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use App\Models\NewsletterSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMonthlyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to all active subscribers (run on 1st of each month at 9:00 Asia/Kuala_Lumpur). Content is based on the current month.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sendDate = Carbon::now('Asia/Kuala_Lumpur');
        $this->info('Sending monthly newsletter for ' . $sendDate->format('F Y') . '.');

        $subscriptions = NewsletterSubscription::where('is_active', true)->get();

        if ($subscriptions->isEmpty()) {
            $this->warn('No active newsletter subscriptions.');
            return self::SUCCESS;
        }

        $sent = 0;
        $failed = 0;

        foreach ($subscriptions as $subscription) {
            if (!$this->isGmail($subscription->email)) {
                $this->warn("Skipping non-Gmail: {$subscription->email}");
                continue;
            }

            try {
                Mail::to($subscription->email)->send(new NewsletterMail($sendDate));
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                Log::error('Monthly newsletter send failed', [
                    'email' => $subscription->email,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Failed to send to {$subscription->email}: " . $e->getMessage());
            }
        }

        $this->info("Newsletter sent: {$sent} success, {$failed} failed.");
        return self::SUCCESS;
    }

    private function isGmail(string $email): bool
    {
        return str_ends_with(strtolower(trim($email)), '@gmail.com');
    }
}
