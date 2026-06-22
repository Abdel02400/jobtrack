# Deployment

## Overview

JobTrack relies on asynchronous processing for interview reminders.

The following components must be running in production:

* Symfony application
* PostgreSQL database
* Messenger worker
* Scheduled command for interview reminders

---

## Interview reminders

The application sends reminder emails for interviews scheduled within the next 24 hours.

Command:

```bash
php bin/console app:send-interview-reminders
```

The command:

1. Retrieves interviews scheduled in the next 24 hours.
2. Ignores interviews that already received a reminder.
3. Dispatches a `SendInterviewReminderMessage` for each interview.
4. Lets Messenger process the email asynchronously.

---

## Messenger worker

The Messenger worker must run continuously.

Example:

```bash
php bin/console messenger:consume async
```

Production environments should use a process manager such as:

* Supervisor
* systemd
* Docker restart policies
* Kubernetes deployments

---

## Scheduled execution

The reminder command should be executed periodically.

Example cron:

```cron
0 * * * * cd /var/www/jobtrack && php bin/console app:send-interview-reminders
```

This runs the command every hour.

---

## Email delivery

Development environment:

* Mailpit
* SMTP: `mailpit:1025`
* Web UI: `http://localhost:8025`

Production environment:

* SMTP provider (Mailgun, Brevo, Postmark, etc.)

---

## Idempotence

Interview reminders are idempotent.

The system uses the `reminderSentAt` field to ensure that a reminder is sent only once.

Additional protection is implemented in the Messenger handler to prevent duplicate processing.
