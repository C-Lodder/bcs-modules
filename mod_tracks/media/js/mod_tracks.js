/**
 * @package    BCS_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
  document.addEventListener('DOMContentLoaded', () => {
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
          const list = document.createElement('li')

          const anchor = document.createElement('a')
          anchor.setAttribute('href', `https://tm.mania-exchange.com/tracks/${obj.TrackID}`)
          anchor.setAttribute('target', '_blank')

          const name = document.createElement('span')
          name.innerHTML = obj.GbxMapName

          const by = document.createElement('div')
          by.classList.add('by')
          by.innerHTML = `by ${obj.Username}`

          const by2 = document.createElement('div')
          by2.classList.add('by')
          by2.innerText = `Uploaded ${obj.UploadedAt}`

          const imgPlaceholder = document.createElement('svg')
          imgPlaceholder.style.width = '266px'
          imgPlaceholder.style.height = '193px'

          anchor.append(imgPlaceholder)

          const img = new Image
          img.src = obj.screenshot
          img.addEventListener('load', () => {
            anchor.append(img)
            anchor.append(name)
            anchor.removeChild(imgPlaceholder)
          }, false)

          const actions = document.createElement('div')
          actions.classList.add('uk-flex')

          const download = document.createElement('a')
          download.classList.add('uk-button', 'uk-button-primary', 'uk-button-small')
          download.setAttribute('href', `https://tm.mania-exchange.com/tracks/download/${obj.TrackID}`)
          download.innerText = 'Download'

          const install = document.createElement('a')
          install.classList.add('uk-button', 'uk-button-primary', 'uk-button-small', 'uk-margin-left')
          install.setAttribute('href', `https://tm.mania-exchange.com/tracks/installandplay/${obj.TrackID}`)
          install.innerText = 'Install & Play'

          actions.append(download)
          actions.append(install)

          list.append(anchor)
          list.append(by)
          list.append(by2)

          if (obj.magnets) {
            const magnet = document.createElement('div')
            magnet.classList.add('magnet')
            magnet.innerHTML = '<strong>WARNING</strong>: Contains magnetic blocks!'
            list.append(magnet)
          }

          list.append(actions)

          wrapper.insertBefore(list, wrapper.firstChild)

          const height = wrapper.querySelector('li').height
          wrapper.style.minHeight = `${height}px`
        })
      })
      .then(response => {
        const placeholders = wrapper.getElementsByClassName('placeholder')
        while (placeholders.length > 0) {
          placeholders[0].parentNode.removeChild(placeholders[0])
        }
      })
  })
})()
