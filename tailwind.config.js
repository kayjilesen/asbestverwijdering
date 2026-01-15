/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./inc/*.php",
    "./templates/**/*.php",
    "./templates/*.php",
    "./*.php"
  ],
  theme: {
    extend: {
      colors: {
        'primary' : '#FFD500',
        'secondary' : '#1A1603',
        'grey-dark' : '#1A1603',
        'grey-surface' : '#454545',
        'grey-decor' : '#DADADA',
        'grey' : '#414039',
        'grey-light' : '#F7F7F7',
        'grey-text' : '#8A8A8A',
        'yellow' : '#FFD500',
        'yellow-light' : '#F2F1EB',
        'blue' : '#004E64',
        'beige' : '#F7F7F2',
        'beige-darker' : '#F0F0EC',
      },
      fontFamily: {
        'sans': ['Karla', 'system-ui', 'sans-serif'],
        'serif' : ['Karla', 'serif'],
        'button': ['Karla', 'system-ui', 'sans-serif'],
        'title': ['TGS', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
