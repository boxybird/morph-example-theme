/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    './index.php',
    './header.php',
    './footer.php',
    './single.php',
    './page.php',
    './page-time.php',
    './page-notes.php',
    './page-deploy.php',
    './page-interval.php',
    './page-adventure.php',
    './page-movies-filter.php',
    './page-message-board.php',
    './woocommerce.php',
    './resources/**/*.php',
    './components/**/*.php',
  ],
  theme: {
    extend: {
      container: {
        center: true,
        padding: '1rem',
      },
    },
  },
  plugins: [require('@tailwindcss/typography')],
}
