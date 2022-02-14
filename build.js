const { readFile, writeFile } = require('fs').promises
const { minify } = require('terser')
const postcss = require('postcss')

const plugins = [
  require('cssnano')({
    preset: 'default',
  })
]

const files = {
  js: [
    'mod_bcsinfo/media/js/mod_bcsinfo.js',
    'mod_servers/media/js/mod_servers.js',
    'mod_standings/media/js/mod_standings.js',
    'mod_tracks/media/js/mod_tracks.js',
  ],
  css: [
    'mod_bcsinfo/media/css/mod_bcsinfo.css',
    'mod_standings/media/css/mod_standings.css',
    'mod_tracks/media/css/mod_tracks.css',
  ],
}

files.js.forEach(async(file) => {
  const data = await readFile(file, { encoding: 'utf8' })
  const minified = await minify(data, { output: { comments: false } } )

  try {
    writeFile(`${file.substr(0, file.lastIndexOf('.'))}.min.js`, minified.code, { flag: 'w'})
  } catch(error) {
    console.log(error)
  }
})

files.css.forEach(async(file) => {
  const data = await readFile(file, { encoding: 'utf8' })
  const dest = `${file.substr(0, file.lastIndexOf('.'))}.min.css`
  const minified = await postcss(plugins).process(data, { from: file, to: dest })

  try {
    writeFile(dest, minified.css, { flag: 'w'})
  } catch(error) {
    console.log(error)
  }
})
