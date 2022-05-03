/**
 * @package    BCS_Latest_Tracks
 * @author     Lodder
 * @copyright  Copyright (C) 2022 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
  let count
  let inView
  const href = 'track'
  const options = Joomla.getOptions('bcs-tracks')
  const slider = document.getElementById('bcstracks-slider')
  const triggers = document.querySelectorAll('#bcstracks [data-slide-move]')

  const isScrolledIntoView = (el) => {
    return parseInt(el.offsetLeft + 20, 10) <= slider.offsetWidth
  }

  const updateHrefs = (isNext) => {
    triggers.forEach(item => {
      const currentNumber = parseInt(item.getAttribute('href').replace(/\#track/, ''), 10)
      const newNumber = isNext ? parseInt(currentNumber - 1, 10) : parseInt(currentNumber + 1, 10)
      const movingForward = item.getAttribute('data-slide-move') === 'next'
      let proceed = true

      // Next button clicked
      if ((movingForward && newNumber < 1) || (!movingForward && newNumber < (inView + 1))) {
        proceed = false
      }

      // Prev button clicked
      if ((!movingForward && newNumber > count) || (movingForward && newNumber > (count - inView))) {
        proceed = false
      }

      if (proceed) {
        item.setAttribute('href', `#${href + newNumber}`)
      }
    })
  }

  fetch('index.php?option=com_ajax&module=tracks&method=getAuthorTracks&format=json', {
    method: 'POST',
    body: JSON.stringify({ authors: options.authors.split(',') })
  })
  .then(response => response.json())
  .then(response => {
    const data = response.data
    const keys = Object.keys(data)
    count = keys.length

    keys.forEach((key, index) => {
      const obj = data[key]
      const list = document.createElement('div')
      list.id = href + (index + 1)

      const mxLogoSrc = obj.Game === 'tm2020' ? 'Trackmania' : 'TMStadium'
      const html = 
      `<a href="${obj.endpoint}/maps/${obj.TrackID}" target="_blank" rel="noopener">
        <img class="screenshot" src="${obj.screenshot}" alt="Thumbnail" loading="lazy">
        <span class="flex align-items-center flex-wrap">
          <img class="mx-logo" src="media/mod_tracks/img/${mxLogoSrc}.webp" alt="MX Logo" loading="lazy">
          ${obj.GbxMapName}
        </span>
      </a>
      <div class="by">by ${obj.Username}</div>
      <div class="by">Uploaded ${obj.UploadedAt}</div>
      <div class="flex flex-wrap justify-content-between">
        <a class="btn btn-sm" href="${obj.endpoint}/maps/download/${obj.TrackID}" target="_blank" rel="noopener">Download</a>
        <a class="btn btn-sm" href="${obj.endpoint}/maps/installandplay/${obj.TrackID}" target="_blank" rel="noopener">Install & Play</a>
      </div>`
      list.innerHTML = html

      slider.insertBefore(list, slider.firstChild)
    })
  })
  .then(() => {
    const placeholders = slider.getElementsByClassName('placeholder')
    while (placeholders.length > 0) {
      placeholders[0].parentNode.removeChild(placeholders[0])
    }
  })
  .then(() => {
    inView = 1

    if (isScrolledIntoView(slider.children[1])) {
      inView = 2
    }
    if (isScrolledIntoView(slider.children[3])) {
      inView = 4
    }

    triggers.forEach(trigger => {
      trigger.classList.remove('hidden')

      const isNext = trigger.getAttribute('data-slide-move') === 'next'
      if (isNext) {
        trigger.href = `#${href + parseInt(count - (inView), 10)}`
      } else {
        trigger.href = `#${href + parseInt(count, 10)}`
      }

      trigger.addEventListener('click', ({ currentTarget }) => {
        updateHrefs(currentTarget.getAttribute('data-slide-move') === 'next')
      })
    })
  })
})()
