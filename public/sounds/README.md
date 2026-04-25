# 📵 Fichiers Audio SmartQueue AI

## 🎯 Sons Requis pour le Système

### 1. **ticket-called.mp3** - Son d'appel de ticket
- **Usage** : Quand un agent appelle un ticket
- **Style** : 3 bips ascendantes (800Hz → 1000Hz → 1200Hz)
- **Durée** : 1.5 secondes
- **Alternative** : Son de porte ou cloche douce

### 2. **client-notification.mp3** - Notification d'avancement
- **Usage** : Quand le client avance dans la file
- **Style** : Son doux et court
- **Durée** : 0.8 secondes
- **Alternative** : Notification smartphone

### 3. **preparation-alert.mp3** - Rappel urgent
- **Usage** : Rappels automatiques (2ème et 3ème)
- **Style** : 4 bips rapides et aigus
- **Durée** : 1.0 seconde
- **Alternative** : Son d'alerte

### 4. **agent-notification.mp3** - Notification agent
- **Usage** : Confirmation présence client
- **Style** : Son professionnel et court
- **Durée** : 0.6 secondes
- **Alternative** : Son de notification système

### 5. **ticket-absent.mp3** - Ticket absent
- **Usage** : Client absent après 3 rappels
- **Style** : Son grave descendant
- **Durée** : 1.2 secondes
- **Alternative** : Son d'erreur

---

## 🔗 Sources de Sons Gratuits

### Sites Recommandés :
1. **Freesound.org** - Sons libres de droits
2. **Zapsplat** - Sons professionnels gratuits
3. **Pixabay Music** - Effets sonores gratuits
4. **Mixkit** - Sons modernes et gratuits

### Mots-clés pour rechercher :
- "Bell notification"
- "Chime sound effect"
- "Alert beep"
- "Doorbell sound"
- "Notification sound"
- "Alarm short"

---

## 🎛️ Générateur de Sons Inclus

Ouvrez `audio-generator.html` dans votre navigateur pour :
1. Générer tous les sons nécessaires
2. Les écouter immédiatement
3. Les télécharger en format WAV
4. Les convertir en MP3 si nécessaire

---

## 📁 Installation

1. Téléchargez ou générez les 5 fichiers audio
2. Placez-les dans le dossier `/public/sounds/`
3. Assurez-vous que les noms correspondent exactement
4. Testez en cliquant sur les boutons dans l'application

---

## 🔧 Conversion WAV → MP3

Si nécessaire, utilisez :
- **Online Audio Converter** (gratuit en ligne)
- **Audacity** (logiciel gratuit)
- **FFmpeg** (ligne de commande)

```bash
# Exemple FFmpeg
ffmpeg -i input.wav -codec:a mp3 -b:a 192k output.mp3
```
