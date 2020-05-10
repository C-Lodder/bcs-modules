const { readFile, writeFile } = require('fs').promises
const Terser = require('terser')

const files = [
  'mod_bcsinfo/media/js/mod_bcsinfo.js',
  'mod_servers/media/js/mod_servers.js',
  'mod_standings/media/js/mod_standings.js',
  'mod_tracks/media/js/mod_tracks.js',
]

files.forEach((file) => {
  readFile(file, { encoding: 'utf8' })
    .then((data) => {
      writeFile(`${file.substr(0, file.lastIndexOf('.'))}.min.js`, Terser.minify(data, { comments: false }).code)
    })
})
