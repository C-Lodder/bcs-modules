/**
 * @package    BCS_Servers
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
  const options = Joomla.getOptions('servers')

  async function postData(url = '', data = {}) {
    const response = await fetch(url, {
      method: 'POST',
	  headers: {
	    'Content-Type': 'application/json'
	  },
	  body: JSON.stringify(data)
    })
    return response.json()
  }

  const message = {
    username: 'Lodder',
    avatar_url: '',
    content: 'The message to send',
  }

  // postData('https://discord.com/api/webhooks/xxx', message)
  // .then(data => {
    // console.log(data) // JSON data parsed by `data.json()` call
  // })

  const notify = (server) => {
    if ('Notification' in window) {
      // Let's check whether notification permissions have already been granted
      if (Notification.permission === 'granted') {
        // If it's okay let's create a notification
        const settings = {
          body: `New player joined ${server}`,
          icon: options.img,
        }
        const notification = new Notification('New Player!', settings)
      }
    }
  }

  const getServerData = (element) => {
    const players = {}
    const spinners = element.querySelectorAll('.icon-spin')

    // Show the spinners
    spinners.forEach((item) => {
      item.classList.remove('hidden')
    })

    fetch('index.php?option=com_ajax&module=servers&method=getServerData&format=json')
      .then(response => response.json())
      .then(response => {
        const data = response.data

        // Loop through results
        Object.keys(data).forEach((key) => {
          const item = data[key]
          const playercount = element.querySelector(`#count_${item.id}`)
          const currentmap = element.querySelector(`#currentmap_${item.id}`)
          const nextmap = element.querySelector(`#nextmap_${item.id}`)

          // Update player count
          if (playercount) {
            // Check if the new player count is bigger than the current player count
            if (players.login !== undefined && item.playercount > playercount.innerText) {
              notify(item.raw)
            }
            // Update player count for notifications
            players.login = item.playercount

            playercount.innerHTML = item.playercount
          }

          // Update current map
          if (currentmap) {
            currentmap.innerHTML = item.currentmap
          }

          // Update next map
          if (nextmap) {
            nextmap.innerHTML = item.nextmap
          }
        })
      })
      .then(() => {
        // Hide the spinners
        spinners.forEach((item) => {
          item.classList.add('hidden')
        })
      })
  }

  const getPlayersNames = (element, name, modalId) => {
    const modal = document.getElementById(modalId)
    const playerList = modal.querySelector('.player-list')

    modal.querySelector('.server-name').innerHTML = name

    // Assemble variables to submit
    const request = {
      servers: element,
    }

    fetch('index.php?option=com_ajax&module=servers&method=getPlayersNames&format=json', {
        method: 'POST',
        body: JSON.stringify(request)
      })
      .then(response => response.json())
      .then(response => {
        const results = response.data
        if (results.length) {
          playerList.innerHTML = ''
          Object.keys(results).forEach((key) => {
            const result = results[key]
            const login = options.isAdmin == 1 ? ` <span class="text-muted text-small">(${result.login})</span>` : ''
            const listItem = `<li>${result.nickname}${login}</li>`
            playerList.insertAdjacentHTML('beforeend', listItem)
          })
        } else {
          playerList.innerHTML = '<li class="text-danger">No players online</li>'
        }
      })
  }

  document.querySelectorAll('.show-players').forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
      event.preventDefault()
      const server = event.currentTarget.id
      const name = event.currentTarget.closest('tr').querySelector('td').innerHTML
      const modalId = event.currentTarget.getAttribute('data-bs-target').replace(/#/, '')
      getPlayersNames(server, name, modalId)
    })
  })

  if (!options.guest) {
    window.setInterval(() => {
      getServerData(document.getElementById('tm_server'))
    }, options.refresh)
  }
})()
