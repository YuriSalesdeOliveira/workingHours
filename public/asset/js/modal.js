(function() {
    function showModal(modal_class) {

        const modal = document.querySelector(`.${modal_class}`);

        modal.classList.add('show_modal');

        modal.addEventListener('click', (e) => {

            if (e.target.className === `${modal_class} show_modal`) {

                modal.classList.remove('show_modal');
            }
        });
    }

    const button = document.querySelector('.button_modal');

    button.addEventListener('click', () => showModal('modal_container'));
})()