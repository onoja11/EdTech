# EdTech

**EdTech** is an AI-powered educational platform that enhances students’ learning experience using intelligent chat-based support. It allows users to ask questions based on specific lesson PDFs and receive AI-generated answers powered by Google's Gemini API.

---

##  Features

-  **AI-Powered Q&A**: Ask questions and receive smart, context-aware answers.
-  **PDF Lesson Integration**: The system extracts text from uploaded lesson PDFs for precise and relevant AI responses.
-  **User Authentication**: Secure login and registration with role-based access.
-  **Question History**: Tracks previous questions and responses per user and lesson.
-  **Clean UI**: Built with Vue.js and Tailwind CSS for a responsive and user-friendly interface.

---

##  Tech Stack

| Layer         | Technology           |
|---------------|----------------------|
| Backend       | Laravel (PHP)        |
| Frontend      | Vue.js, Tailwind CSS |
| AI Integration| Gemini API (Google)  |
| PDF Parsing   | Smalot/PDFParser     |
| Database      | MySQL                |
| Auth          | Laravel Sanctum      |

---

##  Installation Guide

### 1. Clone the Repository
git clone https://github.com/onoja11/EdTech.git
```bash
cd EdTech
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run dev

```

---

##  Admin Access

### To access the admin panel, use the following credentials:
#### Email: admin@example.com
#### Password: password

##### Admins can:
##### * View all users and lessons
##### * Change user roles (e.g., promote a student to teacher or admin)

##### Teachers can:
##### * Create lessons and view lessons created by them

##### Students can:
##### * Can view all the lessons available
---
##  Acknowledgements

- [Google Gemini API](https://ai.google.dev/gemini-api/docs)
- [Smalot PDF Parser](https://github.com/smalot/pdfparser)
- [Laravel](https://laravel.com/)
- [Vue.js](https://vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)



