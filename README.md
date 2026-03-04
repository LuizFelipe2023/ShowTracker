# 📺 Show Tracker CRUD

Um gerenciador de séries moderno e minimalista, focado em uma experiência de usuário fluida (SPA) e interface Dark Mode refinada.

## 🛠 Tech Stack
* **Laravel 11 & MySQL**: Robustez no processamento de dados e filtros.
* **Vue 3 & InertiaJS**: Reatividade do Frontend com a simplicidade do roteamento Backend.
* **Tailwind CSS**: Estilização utilitária customizada (zero CSS externo).
* **Choices.js & Flatpickr**: Componentes avançados para multi-seleção de gêneros e datas.

## ✨ Funcionalidades
* **Gestão Completa**: CRUD de shows com suporte a sinopses, notas (rating) e status.
* **Filtros Inteligentes**: Filtragem dinâmica por múltiplos gêneros e status em tempo real.
* **Upload de Capas**: Sistema de gerenciamento de posters integrado ao storage.
* **UX Otimizada**: Ordenação dinâmica de colunas (ASC/DESC) e navegação sem refresh de página.

## 🚀 Como Rodar
```bash
# 1. Instalar dependências
composer install && npm install

# 2. Configurar ambiente e banco
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# 3. Iniciar o projeto
npm run dev
php artisan serve