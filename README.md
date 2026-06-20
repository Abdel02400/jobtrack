# JobTrack

Application de suivi de candidatures.

## Stack

### Backend

- Symfony 7
- API Platform
- PostgreSQL
- Lexik JWT

### Frontend

- Next.js (à venir)

### Infrastructure

- Docker
- Docker Compose

## Prérequis

- Docker Desktop

## Installation

### Configuration

Copier :

```bash
backend/.env.example
```

vers :

```bash
backend/.env.local
```

Puis renseigner les variables nécessaires.

### Initialiser le projet

```powershell
.\scripts\setup.ps1
```

Ce script :
- démarre les containers Docker
- installe les dépendances Composer
- génère les clés JWT si elles n'existent pas
- exécute les migrations Doctrine

## Démarrage quotidien

```powershell
.\scripts\dev.ps1
```

Ce script démarre les containers Docker existants sans relancer toute l'installation.

## URLs

Swagger :
http://localhost:8000/api/docs

Backend :
http://localhost:8000

## Structure du projet

backend/
frontend/
docs/