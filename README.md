# site-pulse.com

**Site-Pulse** est une application web d’audit de sites web, permettant d’analyser automatiquement la **performance**, l’**accessibilité**, le **SEO** et les **bonnes pratiques** d’une URL. Chaque audit retourne une notation en pourcentage et est associé à l’utilisateur qui l’a lancé.  

Le projet est développé avec **Symfony, ReactJS, TypeScript, TailwindCSS et Symfony UX**, et **développé avec Docker** pour faciliter l’installation et l’environnement de développement.

---

## 🚀 Fonctionnalités principales

- Page d’accueil avec champ de saisie d’URL pour lancer un audit.
- Calcul automatique de :
  - Performance
  - Accessibilité
  - SEO
  - Bonnes pratiques
- Système d’authentification complet (Symfony) :
  - Login / Register
  - Récupération et modification de mot de passe
- Page Profil utilisateur :
  - Historique des audits réalisés
  - Consultation des détails des audits

---

## 🛠 Stack technique

- **Backend :** PHP, Symfony 6+, Symfony UX  
- **Frontend :** ReactJS, TypeScript, TailwindCSS  
- **Base de données :** PostgreSQL  
- **Développement :** Docker  
- **Déploiement :** Railway (Docker)

---

## ⚙️ Installation et développement local

### Prérequis

- Docker & Docker Compose
- PHP 8.4+
- Composer
- Node.js / npm ou yarn

### Lancer le projet en local

1. Cloner le projet :

```bash
git clone https://github.com/florentcussatlegras/site-pulse.git
cd site-pulse

