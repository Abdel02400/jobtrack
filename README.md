# JobTrack

> SaaS de gestion et de suivi des candidatures, développé avec Symfony et API Platform.

JobTrack est un projet personnel conçu pour mettre en pratique la conception d'une application web moderne autour d'une API REST, avec une attention particulière portée à l'architecture, à la séparation des responsabilités, à la sécurité et à la maintenabilité.

## 🎯 Objectifs

Le projet a pour objectif de permettre à un utilisateur de :

* centraliser ses candidatures ;
* suivre l'avancement de ses recherches d'emploi ;
* gérer les informations liées aux entreprises et aux offres ;
* sécuriser l'accès à son espace personnel ;
* exposer les fonctionnalités via une API REST documentée.

Le projet sert également de support d'expérimentation autour de plusieurs pratiques d'architecture et de conception applicative.

## 🏗️ Architecture

Le backend est organisé autour d'une séparation claire des responsabilités et s'inspire de plusieurs principes issus de la Clean Architecture et du Domain-Driven Design.

Les principaux concepts travaillés sont notamment :

* séparation domaine / application / infrastructure ;
* DTO d'entrée et de sortie ;
* séparation des responsabilités ;
* gestion centralisée des erreurs ;
* validation des données ;
* traitement asynchrone avec Symfony Messenger ;
* conception d'API orientée ressources ;
* documentation OpenAPI.

## 🛠️ Stack technique

### Backend

* PHP
* Symfony 7
* API Platform 4
* Doctrine ORM
* PostgreSQL
* Symfony Messenger
* Symfony Security
* Symfony Validator
* Symfony Serializer
* Lexik JWT Authentication
* OpenAPI / Swagger

### Infrastructure

* Docker
* Docker Compose

### Frontend

* Next.js / React / TypeScript — prévu pour une prochaine étape

## 🔐 Sécurité

L'authentification de l'API repose sur JWT avec LexikJWTAuthenticationBundle.

Le projet utilise notamment :

* authentification utilisateur ;
* validation des données ;
* gestion des accès ;
* variables d'environnement pour la configuration sensible ;
* génération des clés JWT lors de l'installation.

## 📚 API

L'API est exposée avec API Platform et documentée automatiquement avec OpenAPI.

Une interface Swagger est disponible localement après installation :

```text
http://localhost:8000/api/docs
```

Elle permet notamment d'explorer les endpoints et de tester les différentes opérations de l'API.

## 🐳 Installation

### Prérequis

* Docker Desktop
* Git

### Installation

```bash
git clone https://github.com/Abdel02400/jobtrack.git
cd jobtrack
```

Copier la configuration :

```bash
cp backend/.env.example backend/.env.local
```

Puis lancer le script d'installation :

```powershell
.\scripts\setup.ps1
```

Le script :

* démarre les containers Docker ;
* installe les dépendances Composer ;
* génère les clés JWT si nécessaire ;
* exécute les migrations Doctrine.

### Démarrage

```powershell
.\scripts\dev.ps1
```

## 📁 Structure

```text
jobtrack/
├── backend/
│   ├── config/
│   ├── migrations/
│   ├── src/
│   └── tests/
├── docker/
├── docs/
├── scripts/
├── compose.yml
└── README.md
```

## 🚧 État du projet

Le projet est actuellement en cours de développement.

Certaines fonctionnalités restent à implémenter, notamment la partie frontend complète.

L'objectif est de faire évoluer progressivement le projet tout en conservant une architecture claire et maintenable.

## 🎓 Objectifs pédagogiques

Ce projet me permet notamment de travailler sur :

* conception d'API REST ;
* API Platform ;
* OpenAPI ;
* authentification JWT ;
* Symfony Messenger ;
* architecture DDD / CQRS ;
* séparation des responsabilités ;
* tests automatisés ;
* Docker ;
* qualité et maintenabilité du code.
