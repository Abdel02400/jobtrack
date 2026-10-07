# Auth Module - Todo

## Fondations métier

### User

* [ ] Identifier les règles métier du User
* [ ] Définir les invariants métier
* [ ] Vérifier les responsabilités de l'entité User
* [ ] Identifier les futurs Domain Events
* [ ] Identifier les futures Factories

### Value Objects

* [ ] Créer Email

  * [ ] Validation format
  * [ ] Normalisation lowercase
  * [ ] Égalité métier

* [ ] Étudier PlainPassword

* [ ] Étudier HashedPassword

---

## Refacto Architecture

* [ ] Analyser l'architecture actuelle
* [ ] Définir l'architecture cible
* [ ] Refactorer progressivement lorsque cela apporte une valeur métier

---

## Cas d'usage existants

### Inscription

* [ ] Revoir RegisterProcessor
* [ ] Vérifier les responsabilités
* [ ] Introduire UserFactory si pertinent
* [ ] Vérifier unicité email

### Authentification

* [ ] Vérifier intégration JWT
* [ ] Vérifier séparation des responsabilités

### Profil connecté

* [ ] Revoir GET /api/me
* [ ] Vérifier les données exposées

---

# Features métier

## Authentification

* [x] POST /api/register
* [x] POST /api/login_check
* [ ] POST /api/logout
* [ ] POST /api/token/refresh

---

## Profil utilisateur

* [x] GET /api/me

* [ ] PATCH /api/me

  * [ ] Modifier prénom
  * [ ] Modifier nom
  * [ ] Modifier avatar

* [ ] DELETE /api/me

---

## Mot de passe

* [ ] PATCH /api/me/password

Règles :

* [ ] Vérification ancien mot de passe
* [ ] Vérification nouveau mot de passe
* [ ] Hash du mot de passe

---

## Gestion email

### Vérification email

* [ ] POST /api/verify-email

* [ ] POST /api/resend-verification-email

Règles :

* [ ] Génération token
* [ ] Expiration token
* [ ] Validation du compte

### Changement email

* [ ] PATCH /api/me/email

Règles :

* [ ] Email unique
* [ ] Validation du format
* [ ] Confirmation obligatoire

Champs potentiels :

* email
* pendingEmail
* emailVerifiedAt
* emailVerificationToken

---

## Reset password

### Demande

* [ ] POST /api/forgot-password

Règles :

* [ ] Génération token
* [ ] Expiration token
* [ ] Envoi email

### Réinitialisation

* [ ] POST /api/reset-password

Règles :

* [ ] Vérification token
* [ ] Vérification expiration
* [ ] Mise à jour mot de passe

---

## Domain Events

* [ ] UserRegistered
* [ ] UserEmailVerified
* [ ] UserPasswordChanged
* [ ] UserRequestedPasswordReset
* [ ] UserEmailChanged
* [ ] UserDeleted

---

## Factories

* [ ] UserFactory

---

## Objectif final

* [ ] Module cohérent métier
* [ ] Module sécurisé
* [ ] DDD pragmatique
* [ ] CQRS lorsque pertinent
* [ ] Prêt pour la production
