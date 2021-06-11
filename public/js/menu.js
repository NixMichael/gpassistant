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
    }, 200)
    appointments.style.opacity = '0'
    bookNow.style.zIndex = '0'
}

const submitAppointmentDate = (date, month, year) => {
    const dataString = `querydate=${date}&querymonth=${month}&queryyear=${year}`
    const selectedDate = document.getElementById(date)
    const calendarElements = document.querySelectorAll('.calendar-element')
    // alert(date)

    calendarElements.forEach((el) => {
        el.classList.remove('highlight-date')
    })

    selectedDate.classList.add('highlight-date')


    $.ajax({
        type: "GET",
        url: "/includes/check.inc.php",
        data: dataString,
        cache: false,
        success: function(r) {
            let times = $.parseJSON(r)
            let timesHeading = `${date}/${month}/${year}`
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