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

function load_form() {
    if (document.getElementById('form-signup')) {
        document.getElementById('form-signup').addEventListener('submit', function(event) {
            event.preventDefault();
        
            const email_value = document.getElementById('email-signup');
            
            let hasError = false;
            if (!validateEmail(email_value.value)) {
                hasError = true;
                addError('Email không hợp lệ', email_value);
            }else {
                removeError(email_value);
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
                    email: email_value.value,
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
    if (document.getElementById('form-sellproduct')) {
        document.getElementById('form-sellproduct').addEventListener('submit', function(event) {
            event.preventDefault();
        
            const contact_email = document.getElementById('form-sellproduct__email');
            const contact_phone = document.getElementById('form-sellproduct__phone');
            const product_model = document.getElementById('form-sellproduct__product-model');
            const product_version = document.getElementById('form-sellproduct__product-version');
            const km_driven = document.getElementById('form-sellproduct__product-odo');
            const year_of_manufacture = document.getElementById('form-sellproduct__product-year');
            
            let hasError = false;

            if (!validateEmail(contact_email.value)) {
                addError('Email không hợp lệ', contact_email);
                hasError = true;
            } else {
                removeError(contact_email); 
            }

            if (!validatePhone(contact_phone.value)) {
                addError('Số điện thoại không hợp lệ', contact_phone);
                hasError = true;
            } else {
                removeError(contact_phone);
            }

            if (!validateText(product_model.value)) {
                addError('Thông tin không hợp lệ', product_model);
                hasError = true;
            } else {
                removeError(product_model); 
            }

            if (!validateText(product_version.value)) {
                addError('Thông tin không hợp lệ', product_version);
                hasError = true;
            } else {
                removeError(product_version); 
            }

            if (!validateNumber(km_driven.value)) {
                addError('Thông tin không hợp lệ', km_driven);
                hasError = true;
            } else {
                removeError(km_driven);
            }

            if (!validateYear(year_of_manufacture.value)) {
                addError('Thông tin không hợp lệ', year_of_manufacture);
                hasError = true;
            } else {
                removeError(year_of_manufacture);
            }

            if (hasError) {
                return;
            }
        
            document.getElementById('form-sellproduct').querySelector('.loading-spinner').classList.add('show');
        
            fetch(`${protected_data.sellproduct.api_url}`, { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    contact_email: contact_email.value,
                    contact_phone: contact_phone.value,
                    product_model: product_model.value,
                    product_version: product_version.value,
                    km_driven: km_driven.value,
                    year_of_manufacture: year_of_manufacture.value,
                    nonce: protected_data.sellproduct.nonce
                })
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    document.getElementById('form-sellproduct').reset();
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                document.getElementById('form-sellproduct').querySelector('.loading-spinner').classList.remove('show');
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

    element.addEventListener('input', function() {
        removeError(element);
    });
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

