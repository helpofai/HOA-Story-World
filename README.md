# HOA-Story-World - Next-Generation Story Reading & Authoring Platform

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Architecture](https://img.shields.io/badge/Architecture-Modular_DDD-blue?style=for-the-badge)](https://en.wikipedia.org/wiki/Domain-driven_design)

HOA-Story-World is a premium, industry-grade story ecosystem built with Laravel 13 and Tailwind CSS v4. It transcends traditional story websites by combining the community power of Wattpad, the depth of Royal Road, and the world-building tools of a game engine.

## 🚀 Key Features

### 📖 Immersive Reading Experience
- **Smart Immersive Reader:** Distraction-free interface with Light, Sepia, Dark, and AMOLED themes.
- **Persistent Settings:** LocalStorage-backed typography controls (Font size, line height, family).
- **Multi-Language Engine:** Native support for English, Bengali, and Hindi with optimized scripts.
- **Progress Synchronization:** Server-side tracking of reading progress (percentile based).

### ✍️ Professional Author Studio
- **Tiptap Powered Editor:** A distraction-free, "Scrivener-style" writing environment.
- **Bubble Contextual Toolbar:** Modern formatting controls that appear exactly when needed.
- **Story Bible:** Integrated sidebar for managing Characters, World History (Timeline), and Locations.
- **Lore Assistant:** AI-ready sidebar for context-aware descriptions and consistency checks.
- **Auto-Save Heartbeat:** Real-time, debounced saving with visual pulse indicators.

### 🗺️ Advanced World Building
- **Interactive Story Maps:** Point-and-click map editor for authors to place Cities, Dungeons, and Kingdoms.
- **Geography Lore:** Readers can explore locations on a map to discover related chapters and history.
- **Visual Timelines:** Interactive chronological tracking of universe-altering events.

### 📊 Intelligence & Gamification
- **Reading DNA:** Real-time analytics of user reading habits and streaks.
- **Activity Heatmaps:** GitHub-style activity visualizer for user dashboards.
- **Dynamic Dashboards:** Personalized home screens for both Readers (Library focus) and Authors (Studio focus).

## 🏗️ Architecture

HOA-Story-World follows a strict **Modular Domain-Driven Architecture**. Unlike standard Laravel apps, features are organized into self-contained domains:

```text
app/Modules/
├── Auth/               # High-security GSAP-animated auth system
├── Story/              # Core story, chapter, and map engine
├── Author/             # Writing Studio and creator tools
├── Library/            # Reading history, stats, and collections
└── UserDashboard/      # Personalized analytics and UI
```

- **Actions-Based Logic:** Controllers are ultra-thin, delegating all business logic to reusable Action classes.
- **Explicit Naming:** Every file follows the `[Feature][Domain][Type]` naming mandate for massive scalability.

## 🛠️ Tech Stack

- **Backend:** PHP 8.5+ | Laravel 13
- **Frontend:** Tailwind CSS v4 | Alpine.js | Vite
- **Animations:** GSAP (GreenSock Animation Platform)
- **Editor:** Tiptap (ProseMirror Wrapper)
- **Database:** MySQL 8.0+

## ⚙️ Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/helpofai/HOA-Story-World.git
   cd HOA-Story-World
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   # Update DB_DATABASE, DB_USERNAME, DB_PASSWORD
   php artisan key:generate
   ```

4. **Initialize Database:**
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets:**
   ```bash
   npm run dev
   ```

## 📅 Roadmap
- [ ] AI Content Generation (Complete Chapter generation)
- [ ] Premium Chapter Subscriptions (Stripe Integration)
- [ ] Real-time Collaborative Editing
- [ ] Native Mobile App (PWA Optimized)

---
Developed with ❤️ for the next generation of storytellers.
