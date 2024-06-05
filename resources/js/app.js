import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


// get the btn that opens the modal
const allDeleteButtons = document.querySelectorAll('.js-delete-btn');

allDeleteButtons.forEach((deleteButton) => {
    deleteButton.addEventListener('click', function (event) {
        event.preventDefault();

        // get the modal
        const confirmDelete = document.getElementById('confirmDeleteModal');
        // open the modal
        confirmDelete.style.display = "block";

        // CLOSE
        // get the 'x' that closes the modal
        const close = confirmDelete.querySelector('.ms-close');
        // close the modal
        close.onclick = function () {
            confirmDelete.style.display = "none";
        };

        // get the cancel btn that closes the modal
        const closeBtn = confirmDelete.querySelector('.ms-close-btn');
        // close the modal
        closeBtn.onclick = function () {
            confirmDelete.style.display = "none";
        };

        // close the modal by clicking outside the window
        window.onclick = function (event) {
            if (event.target == confirmDelete) {
                confirmDelete.style.display = "none";
            }
        };
        // END CLOSE

        // get project title from dataset
        const projectTitle = this.dataset.projectTitle;

        // print html inside the modal body
        confirmDelete.querySelector('.ms-modal-body').innerHTML = `Are you sure you want to delete '${projectTitle}'?`;

        // get the btn that confirms the modal
        const modalConfirm = document.getElementById('modal-confirm');

        modalConfirm.addEventListener('click', function () {
            // submit the form
            deleteButton.parentElement.submit();
        });
    });
});