const accoutButton = document.getElementById('accountButton')
const accoutDrop = document.getElementById('accountDrop')

accoutButton.addEventListener('click', () => {
    accoutDrop.classList.toggle('drop-toggle')
})