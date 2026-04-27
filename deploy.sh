#!/bin/bash

echo "🚀 Déploiement de SmartQueue AI sur Railway.app"

# Vérifier si Railway CLI est installé
if ! command -v railway &> /dev/null
then
    echo "❌ Railway CLI n'est pas installé. Installation en cours..."
    npm install -g @railway/cli
else
    echo "✅ Railway CLI est déjà installé"
fi

# Se connecter à Railway
echo "🔐 Connexion à Railway..."
railway login

# Initialiser le projet Railway
echo "📦 Initialisation du projet Railway..."
railway init

# Ajouter les bases de données
echo "🗄️ Ajout de la base de données MySQL..."
railway add mysql

echo "🔴 Ajout de Redis..."
railway add redis

# Pousser le code
echo "📤 Déploiement du code..."
railway up

echo "✅ Déploiement terminé !"
echo "📊 Votre application sera disponible sur: https://votre-app.railway.app"
echo "🔧 N'oubliez pas de configurer les variables d'environnement dans le dashboard Railway"
