const links = document.querySelectorAll('.menu a')
const urlEls = window.location.href.split('/').reverse();
const currentPage = urlEls[0]

links.forEach((link, i) => {
    if (link.getAttribute('href') === `/${currentPage}`) {
        link.classList.add('link-highlight')
    } else {
        link.classList.remove('link-highlight')
    }
})