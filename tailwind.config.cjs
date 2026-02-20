/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/**/*.{ts,tsx,js,jsx}',
    './components/**/*.{ts,tsx,js,jsx}',
  ],
  theme: {
    extend: {
      colors: {
        mivehGreen: '#22c55e',
        mivehLime: '#bef264',
        mivehOrange: '#f97316',
        mivehRed: '#ef4444'
      }
    }
  },
  plugins: [],
}
