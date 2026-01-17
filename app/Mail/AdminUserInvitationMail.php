<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminUserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Company $company;

    public string $acceptUrl;

    public string $role;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, string $rawToken, string $role)
    {
        $this->company = $company;

        $this->role = $role;

        $this->acceptUrl = route('invitations.show', [
            'token' => $rawToken,
        ]);
    }

    public function build()
    {
        return $this
            ->subject("You're invited as {$this->role} to {$this->company->name}")
            ->view('emails.admin-user-invitation');
    }
}
