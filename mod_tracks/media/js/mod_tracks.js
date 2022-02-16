/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2022 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
  // Assemble variables to submit
  const options = Joomla.getOptions('bcs-tracks')
  const wrapper = document.getElementById('bcstracks-slider')
  const request = {
    authors: options.authors.split(','),
  }

  fetch('index.php?option=com_ajax&module=tracks&method=getAuthorTracks&format=json', {
    method: 'POST',
    body: JSON.stringify(request)
  })
  .then(response => response.json())
  .then(response => {
    const data = response.data

    Object.keys(data).forEach(key => {
      const obj = data[key]
      const list = document.createElement('div')

      const anchor = document.createElement('a')
      anchor.setAttribute('href', `${obj.endpoint}/maps/${obj.TrackID}`)
      anchor.setAttribute('target', '_blank')

      const name = document.createElement('span')
      name.classList.add('flex', 'align-items-center', 'flex-wrap')
      name.innerHTML = obj.GbxMapName

      const mxLogo = new Image
      const mxLogoSrc = obj.TitlePack === 'Trackmania' ? 'Trackmania' : 'TMStadium';
      mxLogo.src = `media/mod_tracks/img/${mxLogoSrc}.webp`
      mxLogo.classList.add('mx-logo')
      mxLogo.addEventListener('load', () => {
        name.prepend(mxLogo)
      }, false)

      const by = document.createElement('div')
      by.classList.add('by')
      by.innerHTML = `by ${obj.Username}`

      const by2 = document.createElement('div')
      by2.classList.add('by')
      by2.innerText = `Uploaded ${obj.UploadedAt}`

      const img = new Image
      img.src = obj.screenshot
      img.classList.add('screenshot')
      img.addEventListener('load', () => {
        anchor.prepend(img)
      }, false)

      anchor.append(name)

      const actions = document.createElement('div')
      actions.classList.add('flex', 'flex-wrap', 'justify-content-between')

      const download = document.createElement('a')
      download.classList.add('btn', 'btn-sm')
      download.setAttribute('href', `${obj.endpoint}/maps/download/${obj.TrackID}`)
      download.innerText = 'Download'

      const install = document.createElement('a')
      install.classList.add('btn', 'btn-sm')
      install.setAttribute('href', `${obj.endpoint}/maps/installandplay/${obj.TrackID}`)
      install.innerText = 'Install & Play'

      actions.append(download)
      actions.append(install)

      list.append(anchor)
      list.append(by)
      list.append(by2)

      // if (obj.magnets) {
        // const magnet = document.createElement('div')
        // magnet.classList.add('magnet')
        // magnet.innerHTML = '<strong>WARNING</strong>: Contains magnetic blocks!'
        // list.append(magnet)
      // }

      list.append(actions)

      wrapper.insertBefore(list, wrapper.firstChild)

      const height = wrapper.querySelector('div').height
      wrapper.style.minHeight = `${height}px`
    })
  })
  .then(() => {
    const placeholders = wrapper.getElementsByClassName('placeholder')
    while (placeholders.length > 0) {
      placeholders[0].parentNode.removeChild(placeholders[0])
    }
  })
})()
