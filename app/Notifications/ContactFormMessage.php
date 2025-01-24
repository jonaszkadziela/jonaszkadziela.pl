<?php

namespace App\Notifications;

use App\Notifications\Traits\HasTranslations;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ContactFormMessage extends Notification
{
    use HasTranslations;

    protected array $lang = [
        'en' => [
            'action' => 'Send reply to :fromEmail',
            'line-1' => 'A new message has been submitted by **:fromName (:fromEmail)** via the contact form on **:appName** website.',
            'line-2' => 'The message sent on :date at :time reads as follows:',
            'line-3' => ':message',
            'line-4' => 'If you think this message is spam, you can ignore it.',
            'subject' => ':appName - Message from :fromName',
        ],
        'pl' => [
            'action' => 'Wyślij odpowiedź do :fromEmail',
            'line-1' => 'Nowa wiadomość została przesłana przez **:fromName (:fromEmail)** za pośrednictwem formularza kontaktowego na stronie **:appName**.',
            'line-2' => 'Wiadomość wysłana dnia :date o :time brzmi następująco:',
            'line-3' => ':message',
            'line-4' => 'Jeśli uważasz, że ta wiadomość jest spamem, możesz ją zignorować.',
            'subject' => ':appName - Wiadomość od :fromName',
        ],
    ];

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $fromEmail, private string $fromName, private string $message)
    {
        $this->placeholdersMap = [
            ':appName' => config('app.name'),
            ':date' => Carbon::now()->toDateString(),
            ':fromEmail' => $fromEmail,
            ':fromName' => $fromName,
            ':message' => $message,
            ':time' => Carbon::now()->toTimeString('minute'),
        ];
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject($this->lang('subject'))
            ->line($this->lang('line-1'))
            ->line($this->lang('line-2'))
            ->line($this->lang('line-3'))
            ->line($this->lang('line-4'))
            ->action($this->lang('action'), 'mailto:' . $this->fromEmail);
    }
}
