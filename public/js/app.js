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
    setTimeout(() => {
        bookNow.style.opacity = '1'
        bookNow.style.zIndex = '0'
    }, 400)
    appointments.style.opacity = '0'
    bookNow.style.zIndex = '1'
}

const submitAppointmentDate = (date, month, year) => {
    const dataString = `querydate=${date}&querymonth=${month}&queryyear=${year}`
    const selectedDate = document.getElementById(date)
    const calendarElements = document.querySelectorAll('.calendar-element')

    calendarElements.forEach((el) => {
        el.classList.remove('highlight-date')
    })

    selectedDate.classList.add('highlight-date')

    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

    let monthName = monthNames[month - 1]

    let prefix = 'th'
    if (date == 1 || date == 21 || date == 31) {
        prefix = 'st'
    } else if (date == 2 || date == 22) {
        prefix = 'nd'
    } else if (date == 3 || date == 23) {
        prefix = 'rd'
    } else {
        prefix = 'th'
    }

    $.ajax({
        type: "GET",
        url: "/includes/checkavailability.inc.php",
        data: dataString,
        cache: false,
        success: function(r) {
            sessionStorage.removeItem('timer_value');
            let times = $.parseJSON(r)
            let timesHeading = `${date}${prefix} ${monthName} ${year}`
            let content = ''
            $.each(times, function(i, v) {
                content += `
                    <input type='submit' name='time' value=${v} class='result'>`
                })
            content += `<input type='hidden' name='date' value='${date}'>
            <input type='hidden' name='month' value='${month}'>
            <input type='hidden' name='year' value='${year}'>`

            $(".times-heading").html(timesHeading)
            $("#choose-time").css('opacity', '1')
            $(".times-heading").css('opacity', '1')
            $(".results-area").html(content)
        }
    })
}