# Interview reminders

## Objectif

Envoyer automatiquement un rappel par email lorsqu’un entretien est prévu dans les prochaines 24 heures.

## Flow

```txt
Cron / commande manuelle
↓
app:send-interview-reminders
↓
InterviewRepository::findScheduledInNext24Hours()
↓
Dispatch SendInterviewReminderMessage
↓
Transport async Doctrine
↓
Worker Messenger
↓
SendInterviewReminderMessageHandler
↓
Email via Symfony Mailer
↓
Mailpit en local