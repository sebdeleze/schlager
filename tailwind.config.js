/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
                heading: ['FugazOne', 'sans-serif'],
            },
            colors: {
                primary: 'var(--color-primary)',
            },
        },
    },
    plugins: [],
}
