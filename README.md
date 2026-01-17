# fc-site-pulse.com

**FC Site Pulse** est une application web d’audit de sites web, permettant d’analyser automatiquement la **performance**, l’**accessibilité**, le **SEO** et les **bonnes pratiques** d’une URL. Chaque audit retourne une notation en pourcentage et est associé à l’utilisateur qui l’a lancé.  

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

- **Backend :** PHP, Symfony 8, Symfony UX  
- **Frontend :** ReactJS, TypeScript, TailwindCSS  
- **Base de données :** PostgreSQL  
- **Développement :** Docker  
- **Déploiement :** Railway (Docker)

---

## ⚙️ Installation et développement local

### Prérequis

- PHP 8.4+
- Composer
- Node.js / npm ou yarn

### Cloner le projet :

```bash
git clone https://github.com/florentcussatlegras/site-pulse.git
cd site-pulse
```

### Installer les dépendances
```bash
npm install
```

### Lancer en développement
```bash
npm run dev
```

### Ouvrez http://localhost:3000 dans votre navigateur.

### Compiler pour la production
```bash
npm run build
npm start
```

---

## 🎯 Utilisation

Saisissez une url dans le champs de saisie de la page d'accueil

Accédez en détails aux résultats d'audit de l'url

Suivez vos activités d'audit depuis votre page de profil

---

## 🌐 Démo en ligne

https://sitepulse-production.up.railway.app/app

---

## ⚖️ Licence

Ce projet est open source (Licence MIT)

