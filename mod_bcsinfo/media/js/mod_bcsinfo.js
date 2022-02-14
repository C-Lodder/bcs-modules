/**
 * @package    BCS_Info
 * @author     Lodder
 * @copyright  Copyright (C) 2020 Lodder. All Rights Reserved
 * @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
 */

const modal = document.getElementById('bcsinfo-modal')
modal.querySelectorAll('.copy').forEach((button) => {
  button.addEventListener('click', async({ currentTarget }) => {
    await navigator.clipboard.writeText(currentTarget.parentNode.previousElementSibling.innerText)
    console.log('Copying to clipboard was successful')
  })
})
