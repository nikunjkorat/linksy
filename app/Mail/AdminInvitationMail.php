<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Company $company;

    public string $acceptUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, string $rawToken)
    {
        $this->company = $company;

        $this->acceptUrl = route('invitations.show', [
            'token' => $rawToken,
        ]);
    }

    public function build()
    {
        return $this
            ->subject("You're invited as Admin to {$this->company->name}")
            ->view('emails.admin-invitation');
    }
}
