function validateEmail(email) {
    const pEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    if (!pEmail.test(email)) {
        return false;
    }

    return true;
}

function validatePhone(phone) {
    const pPhone = /^[0-9]{10,11}$/;

    if (!pPhone.test(phone)) {
        return false;
    }

    return true;
}

function validateYear(year) {
    const pYear = /^[0-9]{4}$/;

    if (!pYear.test(year)) {
        return false;
    }

    return true;
}

function validateText(text) {
    const pText = /^[\p{L}0-9\s]+$/u;

    if (!pText.test(text)) {
        return false;
    }

    return true;
}

function validateNumber(number) {
    const pNumber = /^[0-9]{1,}$/;

    if (!pNumber.test(number)) {
        return false;
    }

    return true;
}

function sanitizeInput(str) {
    if (!str) return "";

    str = str.trim();

    str = str.replace(/<script.*?>.*?<\/script>/gi, "")
             .replace(/<.*?on\w+=.*?>/gi, "")
             .replace(/<iframe.*?>.*?<\/iframe>/gi, "")
             .replace(/<img.*?>/gi, "");

    str = str.replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");

    return str;
}

function load_form() {
    if (document.getElementById('form-signup')) {
        document.getElementById('form-signup').addEventListener('submit', function(event) {
            event.preventDefault();
        
            const emaildiv = document.getElementById('email-signup');
            const emailvalue = sanitizeInput(emaildiv.value);
            
            let hasError = false;
            if (!validateEmail(emailvalue)) {
                hasError = true;
                addError('Email không hợp lệ', emaildiv);
            }else {
                removeError(emaildiv);
            }
            
            if (hasError) {
                return;
            }
        
            document.getElementById('form-signup').querySelector('.loading-spinner').classList.add('show');
            fetch(`${protected_data.signupEmail.api_url}`, { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: emailvalue,
                    nonce: protected_data.signupEmail.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    document.getElementById('form-signup').reset(); 
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                document.getElementById('form-signup').querySelector('.loading-spinner').classList.remove('show');
            });
        });
    }
    if (document.getElementById('form-contact')) {
        document.getElementById('form-contact').addEventListener('submit', function(event) {
            event.preventDefault();

            const contact_name_div = document.getElementById('form-contact__name');
            const contact_email_div = document.getElementById('form-contact__email');
            const contact_phone_div = document.getElementById('form-contact__phone');
            const contact_title_div = document.getElementById('form-contact__title');
            const contact_content_div = document.getElementById('form-contact__content');

            const namevalue = sanitizeInput(contact_name_div.value);
            const emailvalue = sanitizeInput(contact_email_div.value);
            const phonevalue = sanitizeInput(contact_phone_div.value);
            const titlevalue = sanitizeInput(contact_title_div.value);
            const contentvalue = sanitizeInput(contact_content_div.value);

            let hasError = false;
            if (!validateEmail(emailvalue)) {
                addError('Email không hợp lệ', contact_email_div);
                hasError = true;
            } else {
                removeError(contact_email_div);
            }
            if (!validatePhone(phonevalue)) {
                addError('Số điện thoại không hợp lệ', contact_phone_div);
                hasError = true;
            } else {
                removeError(contact_phone_div);
            }

            if (hasError) {
                return;
            }

            document.getElementById('form-contact').querySelector('.loading-spinner').classList.add('show');

            fetch(`${protected_data.contact.api_url}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    contact_name: namevalue,
                    contact_email: emailvalue,
                    contact_phone: phonevalue,
                    contact_title: titlevalue,
                    contact_content: contentvalue,
                    nonce: protected_data.contact.nonce
                })
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    document.getElementById('form-contact').reset();
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                document.getElementById('form-contact').querySelector('.loading-spinner').classList.remove('show');
            });
        });
    }
}

function addError(message, element) {
    if (element.classList.contains('error-input')) {
        return;
    }
    element.classList.add('error-input');
    const divError = document.createElement('div');
    divError.innerHTML = message;
    divError.classList.add('error-message');
    element.parentNode.appendChild(divError);

    setTimeout(() => {
        removeError(element);
    }, 5000);
}

function removeError(element) {
    if (element.classList.contains('error-input')){
        element.classList.remove('error-input');
        const errorElement = element.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
    }
}

