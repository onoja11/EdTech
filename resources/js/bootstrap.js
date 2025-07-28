import axios from 'axios';
window.axios = axios;

window.axios.defaults.baseURL = 'https://edtech-52ei.onrender.com'; 


// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF token setup
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('❌ CSRF token not found. Make sure it’s in your HTML <head>');
}
