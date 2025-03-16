document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.querySelector('.form-message');

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(contactForm);
        const data = {
            name: formData.get('name'),
            phone: formData.get('phone'),
            message: formData.get('message')
        };

        fetch('sendmail.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                formMessage.textContent = 'Заявка отправлена!';
                formMessage.classList.remove('error');
                formMessage.classList.add('success');
                contactForm.reset();
            } else {
                throw new Error(result.message);
            }
        })
        .catch(error => {
            formMessage.textContent = 'Ошибка: ' + error.message;
            formMessage.classList.remove('success');
            formMessage.classList.add('error');
        });
    });
});