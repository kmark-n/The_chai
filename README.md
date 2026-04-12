A content-driven news platform using React and a headless CMS (WordPress), focusing on content structuring, mobile optimization, and performance improvements. Implemented features like trending posts, category filtering, and responsive design.

## Project Overview
Frontend: React 18+ with TypeScript
Backend: WordPress 6.0+ as headless CMS
API: RESTful WordPress REST API v2
Styling: Tailwind CSS for rapid development
State Management: React Context API / TanStack Query
SEO: Next.js for SSR (optional but recommended)

## Architectural Diagram
┌─────────────────────────────────────────────────────────┐
│                    React Frontend                        │
│  (Components, Pages, State Management, UI/UX)           │
└────────────────┬────────────────────────────────────────┘
                 │
        ┌────────▼─────────────────────┐
        │  API Layer (Custom Hooks)     │
        │  - TanStack Query             │
        │  - Error Handling             │
        │  - Caching                    │
        └────────┬─────────────────────┘
                 │
        ┌────────▼─────────────────────┐
        │  REST API (HTTP Requests)     │
        │  Base URL: wp.example.com     │
        │  /wp-json/wp/v2/              │
        └────────┬─────────────────────┘
                 │
        ┌────────▼─────────────────────────────────────┐
        │      WordPress Installation                  │
        │  - Core WordPress                            │
        │  - Custom Post Types (Articles)              │
        │  - Custom Fields (ACF)                       │
        │  - Custom Endpoints                          │
        │  - Media Library Integration                 │
        └──────────────────────────────────────────────┘
