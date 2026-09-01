/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          dark: '#06612B',
          medium: '#0B8A3E',
          light: '#80EE82',
          lightbg: '#EAFCEB',
          peach: '#FFC0B4',
          graybg: '#F5F7F5'
        }
      }
    },
  },
  plugins: [],
}
