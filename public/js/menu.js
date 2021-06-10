const links = document.querySelectorAll('.menu a')
const urlEls = window.location.href.split('/').reverse();
let currentPage = urlEls[0]
currentPage = currentPage.split('?')[0]

links.forEach((link, i) => {
    if (link.getAttribute('href') === `/${currentPage}`) {
        link.classList.add('link-highlight')
    } else {
        link.classList.remove('link-highlight')
    }
})

const appointments = document.querySelector('.appointments')
const bookNow = document.querySelector('.calendar-area')

const showBooking = () => {
    appointments.style.opacity = '0'
    setTimeout(() => {
        bookNow.style.transform = 'translateX(0)'
    }, 200)
}