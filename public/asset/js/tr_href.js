(function () {
    let tr = document.querySelectorAll('tr[data-tr_href]');

    tr.forEach((tr) => {

        tr.addEventListener('click', () => {

            window.location.href = tr.getAttribute('data-tr_href')

        });

    });
})();

