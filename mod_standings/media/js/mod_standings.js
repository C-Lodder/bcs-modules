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

    document.querySelectorAll('.getPoints').forEach((element) => {
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
  })
})()
