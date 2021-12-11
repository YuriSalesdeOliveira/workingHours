(function() {
    const active_clock = document.querySelectorAll('[active_clock]');

    active_clock.forEach((active_clock) => {

        if (!active_clock) return;

        function addOneSecond(hours, minutes, seconds) {

            const date = new Date();
            date.setHours(parseInt(hours));
            date.setMinutes(parseInt(minutes));
            date.setSeconds(parseInt(seconds) + 1);

            hours = `${date.getHours()}`.padStart(2, 0);
            minutes = `${date.getMinutes()}`.padStart(2, 0);
            seconds = `${date.getSeconds()}`.padStart(2, 0);

            return `${hours}:${minutes}:${seconds}`;
        }

        setInterval(() => {

            const time = active_clock.innerHTML.split(':');
            active_clock.innerHTML = addOneSecond(...time);

        }, 1000);

    });
})()