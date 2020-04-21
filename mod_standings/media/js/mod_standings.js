/**
 * @package    BCS_Standings
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

(() => {
  document.addEventListener('DOMContentLoaded', () => {
    let totalBCS = 0
    let totalOther = 0

    const getPoints = document.querySelectorAll('.getPoints')
    getPoints.forEach((element) => {
      const points = parseInt(element.getAttribute('data-points'), 10)
      if (element.getAttribute('data-team') === 'bcs') {
        totalBCS += points
      } else {
        totalOther += points
      }
    })

    const scoreBCS = document.getElementById('scoreBCS')
    scoreBCS.innerHTML = totalBCS
    const classBCS = totalBCS > totalOther ? 'success' : 'danger'
    scoreBCS.classList.add(`uk-text-${classBCS}`)

    const scoreOther = document.getElementById('scoreOther')
    scoreOther.innerHTML = totalOther
    const classOther = totalBCS > totalOther ? 'danger' : 'success'
    scoreOther.classList.add(`uk-text-${classOther}`)

    const pointsEach = [...getPoints].reduce((acc, element) => {
      const { dataset: { playerId, points } } = element;

      acc[playerId] = acc[playerId] || 0;
      acc[playerId] += +points;
      return acc;
    }, {});

    const pointRanks = document.getElementById('point-ranks')
    const sorted = Object.entries(pointsEach).sort((a, b) => b[1] - a[1]);
    sorted.forEach((array) => {
      const player = document.querySelector(`[data-player-id="${array[0]}"]`).innerHTML
      const item = document.createElement('li')
      item.innerHTML = `[${array[1]}] - ${player.replace(/\<span class="match_number">\d+.<\/span><span class="top\d+ uk-text-bold">\s[0-9:.]+<\/span>\s-\s/g, ' ')}`
      pointRanks.append(item)
    })
  })
})()
