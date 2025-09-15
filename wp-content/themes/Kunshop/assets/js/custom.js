var mainLocalStorage = 'filter_products';
var swup_main;
var allowajaxA = [];
var allowajaxB = true;
var allowajaxC = true;
var allowajaxD = true;
var swiper_home = [];
isShrunk = false;
var modalSuccess;
var modalError;
let scrollTimeout; 
let isPopupVisible = false;
init();
function init(){
    swup_main = new Swup({
        hooks: {
        'content:replace': () => {
            allowajaxB = true; allowajaxC = true; allowajaxD = true;
            isFixed = false;
            isPopupVisible = false;
            load_init();
          },
        }
    })
}

function loadscrollEvent() {
    window.addEventListener('scroll', () => {
        changeColorContactPopup();
        scrollHeaderFixed();
        showScrollTop();
        handleScrollPopup();
    });
}
/* Event Listener */
document.addEventListener('DOMContentLoaded', () => {
    load_init();
});
/* Load Main */
function load_init() {
    updateBodyClass();
    initSwiper();
    initAnimation();
    resetContactPopup();
    clearFormSignup();

    // Load
    loadPriceSlider();
    fetchDataFilter();
    loadproductFilterMain();
    loadModal();
    load_form();
    
    //CategoryCheckboxEvent('product-filter__product_brand');
    //CategoryCheckboxEvent('product-filter__product_category');
    //toggleCategoryExpand();

    // Scroll Event
    loadscrollEvent();
}
/* Header Mobile Fixed */
function scrollHeaderFixed() {
    const logo = document.querySelector('#header .top-logo');
    const header_top = document.querySelector('#header .header-top');
    if (window.innerWidth < 801) {
        if (!isShrunk && window.scrollY > 15) {
            isShrunk = true;
            header_top.classList.add('scrolling');
            document.querySelector('.header-mobile__menu').classList.add('scrolling');
        }else if (isShrunk && window.scrollY <= 15) {
            isShrunk = false;
            header_top.classList.remove('scrolling');
            document.querySelector('.header-mobile__menu').classList.remove('scrolling');
        }
    }else {
        const tl = anime.timeline({
        easing: 'easeOutQuad',
        duration: 500
        });

        if (window.scrollY > 15 && !isShrunk) {
            isShrunk = true;
            const newWidthLogo = changeRemtoPx(7.1);
            const newHeightLogo = changeRemtoPx(5);

            tl.add({
                targets: logo,
                width: newWidthLogo,
                height: newHeightLogo,
                begin: () => {
                    header_top.classList.add('scrolling');
                }
            }, 100);
        } else if (window.scrollY <= 15 && isShrunk) {
            isShrunk = false;
            const newWidthLogo = changeRemtoPx(21.2);
            const newHeightLogo = changeRemtoPx(15);

            tl.add({
                targets: logo,
                width: newWidthLogo,
                height: newHeightLogo,
                begin: () => {
                    header_top.classList.remove('scrolling');
                }
            }, 100);
        }
    }
}
/* Open Menu Mobile */
function toggleMenuMobile() {
    const menu = document.getElementById('menu-mobile');
    const header = document.getElementById('header');
    const menuicon = document.querySelectorAll('.header-mobile__menu');
    const body = document.body;

    if (menu) {
        header.classList.toggle('open-menu');
        menuicon.forEach((icon) => {
            icon.classList.toggle('active');
        });
        menu.classList.toggle('show-menu');
        body.classList.toggle('overflow-hidden');
    }
}
/* Handle Scroll Popup */
function handleScrollPopup() {
    const contactPopup = document.getElementById('contact-popup');
    if (!contactPopup) return;

    if (window.innerWidth < 801) {

        if (!isPopupVisible) {
            contactPopup.classList.remove('hide-popup');
            contactPopup.classList.add('show-popup');
            isPopupVisible = true;
        }

        clearTimeout(scrollTimeout);

        scrollTimeout = setTimeout(() => {
            contactPopup.classList.remove('show-popup');
            contactPopup.classList.add('hide-popup');
            isPopupVisible = false;
        }, 2000);
    }
}
/* Format Number */
function formatCurrency (value) {
    if (value >= 1000) {
        const billions = Math.floor(value / 1000);
        const millions = value % 1000;
        if (millions > 0) {
            return `${billions} triệu ${millions} ngàn`;
        } else {
            return `${billions} triệu`;
        }
    } else {
        return `${Math.round(value)} ngàn`;
    }
};
/* Load Ui Price Slider */
function loadPriceSlider() {
    const priceSlider = document.getElementById('product-filter__price-range');
    
    if (priceSlider) {
        const customTooltipLeft = document.createElement('div');
        const customTooltipRight = document.createElement('div');

        customTooltipLeft.classList.add('custom-tooltip-left');
        customTooltipRight.classList.add('custom-tooltip-right');

        priceSlider.appendChild(customTooltipLeft);
        priceSlider.appendChild(customTooltipRight);

        const minPrice = parseFloat(priceSlider.getAttribute('data-min'));
        const maxPrice = parseFloat(priceSlider.getAttribute('data-max'));

        noUiSlider.create(priceSlider, {
            start: [minPrice, maxPrice],
            connect: true,
            step: 1,
            range: {
                'min': minPrice,
                'max': maxPrice
            },
        });

        priceSlider.noUiSlider.on('update', function (values) {
            const valueTextmin = formatCurrency(values[0]);
            const valueTextmax = formatCurrency(values[1]);

            customTooltipLeft.innerHTML = valueTextmin;
            customTooltipRight.innerHTML = valueTextmax;
        });
        
        priceSlider.noUiSlider.on('change', function (values, handle) {
            if(document.querySelector('.price-filter.show-on')){
                document.querySelector('.price-filter.show-on').classList.remove('show-on');
            }
            const min = parseFloat(values[0]);
            const max = parseFloat(values[1]);
            
            const filterKey = 'product-filter__price-range';
            let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

            filter[filterKey] = [min, max];
            window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
        });
    }
}
/* Function Load Modal */
function loadModal() {
    modalSuccess = new bootstrap.Modal(document.getElementById('successModal'));
    modalError = new bootstrap.Modal(document.getElementById('errorModal'));   
}
/* Update body class */
function updateBodyClass() {
    const bodyElement = document.body;
    const newBodyClasses = document.getElementById('swup').getAttribute('body-class');

    if (newBodyClasses) {
        bodyElement.className = newBodyClasses;
    }
}
/* Swiper */
function initSwiper() {
    const bodyClass = document.body.classList;

    if (bodyClass.contains('home')) {
        if (document.querySelector('.swiper-material')) {
            const swiper_slide = new Swiper('.swiper-material', {
                loop: true,
                modules: [EffectMaterial],
                effect: 'material',
                materialEffect: {
                    slideSplitRatio: 1.2,
                },
                grabCursor: true,
                speed: 800,
                navigation: {
                    nextEl: '.swiper-material .swiper-button-next-custom',
                    prevEl: '.swiper-material .swiper-button-prev-custom',
                },
                autoplay: {
                    delay: 10000,
                },
            });
        }

        if (document.querySelector('.swiper-tab')) {
            const alltabs = document.querySelectorAll('.swiper-tab');
            const spaceBetween = changeRemtoPx(2);
            alltabs.forEach((tab, index) => {
                setTimeout(() => {
                    const tab_id = tab.parentElement.id;
                    allowajaxA[tab_id] = true;
                    swiper_home[tab_id] = new Swiper(tab, {
                        loop: false,
                        grabCursor: true,
                        allowTouchMove: true,
                        freeMode: true,
                        spaceBetween: spaceBetween,
                        slidesPerView: 1,
                        speed: 800,
                        autoplay: false,
                        navigation: {
                            nextEl: '.swiper-tab.' + tab_id + ' .swiper-button-next-custom',
                            prevEl: '.swiper-tab.' + tab_id + ' .swiper-button-prev-custom',
                        },
                        on: {
                            init: function () {
                                load_more_products(tab_id);
                            },
                            slideNextTransitionStart: function () {
                                load_more_products(tab_id);
                            }
                        },
                        breakpoints: {
                            801: {
                                slidesPerView: 4,
                            },
                        },
                    });
                }, 10);
            });
        }
    }
    if (bodyClass.contains('single-product')) {
        const spaceBetween = changeRemtoPx(1);
        if (document.querySelector('.swiper-thumbnail-1')) {
            const swiper_thumbnail_1 = new Swiper(".swiper-thumbnail-1", {
                slidesPerView: 2,
                grid: {
                    rows: 2,
                },
                spaceBetween: spaceBetween,
                watchSlidesProgress: true,
                freeMode: true,
                autoplay: false,
                speed: 800,
                breakpoints: {
                    801: {
                        slidesPerView: 4,
                        grid: {
                            rows: 1,
                        },
                        spaceBetween: spaceBetween,
                    },
                },
            });
    
            const swiper_thumbnail_2 = new Swiper(".swiper-thumbnail-2", {
                allowTouchMove: true,
                spaceBetween: spaceBetween,
                grabCursor: true,
                thumbs: {
                    swiper: swiper_thumbnail_1,
                },
                autoplay: false,
                speed: 800,
                navigation: {
                    nextEl: ".swiper-thumbnail-1 .swiper-button-next-custom",
                    prevEl: ".swiper-thumbnail-1 .swiper-button-prev-custom",
                },
            });
        }
        if (document.querySelector('.swiper-multi')) {
            const spaceBetween = changeRemtoPx(2);
            const swiper_single_product = new Swiper('.swiper-multi', {
                loop: false,
                grabCursor: true,
                freeMode: true,
                allowTouchMove: true,
                slidesPerView: 4,
                spaceBetween: spaceBetween,
                speed: 800,
                autoplay: false,
                navigation: {
                    nextEl: '.swiper-multi .swiper-button-next-custom',
                    prevEl: '.swiper-multi .swiper-button-prev-custom',
                },
            });
        }
    }
}
/* Change rem to px */
function changeRemtoPx (rem) {
    const remInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
    const value = rem * remInPx;
    return value;
}
/* Init Animation */
function initAnimation() {
    document.addEventListener('shown.bs.tab', function (event) {
        const target = document.querySelector(event.target.getAttribute('data-bs-target'));
    
        anime({
            targets: target,
            translateY: [-100, 0], 
            opacity: [0, 1],      
            duration: 600,        
            easing: 'easeOutQuad'
        });
    });
}
/* Scroll to Top */
function scrolltoTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
/* Show Scroll to Top */
function showScrollTop() {
    const scrolltop = document.getElementById('scrolltop');
    if(!scrolltop) return;

    const scrollPosition = window.scrollY || document.documentElement.scrollTop;

    const documentHeight = document.documentElement.scrollHeight;
    const viewportHeight = window.innerHeight;

    if (scrollPosition >=  viewportHeight / 2) {
        scrolltop.style.visibility = 'visible';
        scrolltop.style.opacity = '1';
        scrolltop.style.transition = 'opacity 0.5s ease, visibility 0s'; 
    } else {
        scrolltop.style.opacity = '0';
        scrolltop.style.visibility = 'hidden'; 
        scrolltop.style.transition = 'opacity 0.5s ease, visibility 0s 0.5s'; 
    }
}
/* Change Color Contact Popup */
function changeColorContactPopup() {
    const contactPopup = document.getElementById('contact-popup');
    if (!contactPopup) return;
    const bot = document.getElementById('footer');

    const fixedElement = contactPopup.querySelectorAll('.contact-popup-item');

    const rectBot = bot.getBoundingClientRect();

    if (rectBot.height <= rectBot.top) {
        fixedElement.forEach((element) => {
            element.style.background = '#1D51A2';
            element.querySelector('svg').style.fill = 'white';
        });
    }else {
        fixedElement.forEach((element) => {
            element.style.background = '#F8BB15';
            element.querySelector('svg').style.fill = '#1D51A2';
        });
    }
}
/* Reset Color Contact Popup */
function resetContactPopup() {
    const contactPopup = document.getElementById('contact-popup');
    const fixedElement = contactPopup.querySelectorAll('.contact-popup-item');

    fixedElement.forEach((element) => {
        element.style.background = '#1D51A2';
        element.querySelector('svg').style.fill = 'white';
    });
}
/* Search Event */
function searchProduct() {
    const keywordInput = document.getElementById('product-filter__keyword');
    if (keywordInput.value.trim() === '') {
        return;
    }
    resetLocalStorage();
    let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};
    filter['product-filter__keyword'] = sanitizeInput(keywordInput.value.trim());
    window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));

    const bodyClass = document.body.classList;
    if (bodyClass.contains('page-id-11')) {
        loadproductFilterMain();
    } else {
        const pageLink = new URL(document.getElementById('product-page').value);
        swup_main.navigate(pageLink.pathname);
    }
}
/* Fetch Data */
function fetchDataFilter() {
    let storedData = window.localStorage.getItem(mainLocalStorage);

    if (storedData) {
        try {
            const parsedObject = JSON.parse(storedData); 
            for (const key in parsedObject) {
                if (parsedObject.hasOwnProperty(key)) {
                    if (key == 'product-filter__keyword') {
                        const keywordInput = document.getElementById('product-filter__keyword');
                        if (keywordInput) {
                            keywordInput.value = parsedObject[key];
                        }
                        continue;
                    }
                    if (key == 'product-filter__price-range') {
                        const priceRange = document.getElementById('product-filter__price-range');
                        if (priceRange) {
                            priceRange.noUiSlider.set([parsedObject[key][0], parsedObject[key][1]]);
                        }
                        continue;
                    }
                    if (key == 'product-filter__product_brand' || key == 'product-filter__product_category') {
                        const checkboxes = document.querySelectorAll('.' + key);
                        if (checkboxes) {
                            checkboxes.forEach((checkbox) => {
                                if (parsedObject[key].includes(checkbox.value)) {
                                    checkbox.checked = true;
                                } else {
                                    checkbox.checked = false;
                                }
                            });
                        }
                    }
                }
            }
        } catch (e) {
            console.error(e);
        }
    }
}
/* Category Checkbox LocalStorage */
/* function CategoryCheckboxEvent(classElement) {
    const checkboxes = document.querySelectorAll('.' + classElement);

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};
            if (!Array.isArray(filter[classElement])) {
                filter[classElement] = [];
            }

            if (checkbox.checked) {
                if (!filter[classElement].includes(checkbox.value)) {
                    filter[classElement].push(checkbox.value);
                }
            } else {
                filter[classElement] = filter[classElement].filter(value => value !== checkbox.value);
            }
            window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
        });
    });
} */
/* Reset Local Storage */
function resetLocalStorage() {
    let storedData = window.localStorage.getItem(mainLocalStorage);

    if (storedData) {
        try {
            const filters = JSON.parse(storedData);
            if (filters) {
                Object.keys(filters).forEach(key => {
                    if (key !== 'product-filter__keyword'){
                        if (key === 'product-filter__price-range') {
                            const priceSlider = document.getElementById(key);
                            const minPrice = parseFloat(priceSlider.getAttribute('data-min'));
                            const maxPrice = parseFloat(priceSlider.getAttribute('data-max'));
                            filters[key] = [minPrice, maxPrice];
                            priceSlider.noUiSlider.set([minPrice, maxPrice]);
                        } else{
                            filters[key] = [];
                        }
                    }
                });
                localStorage.setItem(mainLocalStorage, JSON.stringify(filters));
            }
        } catch (e) {
            console.error(e);
        }
    }
}
/* Clear All Filter */
function clearAllfilter() {
    resetLocalStorage();
    fetchDataFilter();
    loadproductFilterMain();
}
function clearFormSignup (){
    document.getElementById('form-signup').reset();
}
/* Ajax */
/* Load Next Page Ajax */
function load_more_products(idtab) {
    const total_pages = parseInt(document.getElementById('total_pages' + idtab).value);
    const page_loaded = parseInt(document.getElementById('page_loaded' + idtab).value);

    if (total_pages == 1) {
        return;
    }

    if ((allowajaxA[idtab]) && page_loaded <= total_pages) {
        allowajaxA[idtab] = false;

        const params = buildQueryStr(idtab);
        
        showLoadingSpinner(idtab, true);

        fetch(`${protected_data.products.api_url}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            appendproductSlides(data, idtab);
            updateSlideAjax(idtab);
        })
        .catch(error => {
            console.error('Error: error');
        })
        .finally(() => {
            allowajaxA[idtab] = true;
            showLoadingSpinner(idtab, false);
            document.getElementById('page_loaded' + idtab).value = page_loaded + 1;
        });
    }
}
function appendproductSlides(data, idtab) {
    const divproductsWrapper = idtab
        ? document.querySelector(`#${idtab} .slider-ajax .swiper-wrapper`)
        : document.querySelector('.slider-ajax .swiper-wrapper');

    data.forEach((product) => {
        const divproduct = document.createElement('div');
        divproduct.classList.add('swiper-slide');
        divproduct.classList.add('product-box-item');
        divproduct.innerHTML = product.html;
        divproductsWrapper.appendChild(divproduct);
    });
    swiper_home[idtab].update();
}
function updateSlideAjax(idtab) {
    swiper_home[idtab].update();
}
function showLoadingSpinner(idtab, show) {
    const spinner = idtab
        ? document.getElementById(idtab).querySelector('.loading-spinner')
        : document.querySelector('.related-post').querySelector('.loading-spinner');

    if (show) {
        spinner.classList.add('show');
    } else {
        spinner.classList.remove('show');
    }
}
function buildQueryStr(idtab) {
    const formData = new FormData(document.getElementById('pagination-form' + idtab));
    const params = new URLSearchParams();
    for (const [key, value] of formData.entries()) {
        params.append(key, value); 
    }
    params.append('idtab', idtab);
    return params;
}
/* Main Filter */
function loadproductFilterMain($paged = 1) {
    const bodyClass = document.body.classList;
    if (bodyClass.contains('page-id-11')) {
        const filter_data = JSON.parse(window.localStorage.getItem(mainLocalStorage));
        let params = new URLSearchParams();

        if (filter_data) {
            for (const [key, value] of Object.entries(filter_data)) {
                if (key == 'product-filter__price-range') {
                    params.append('price_min', value[0]);
                    params.append('price_max', value[1]);
                    continue;
                }
                params.append(key, value);
            }
        }

        if (allowajaxD) {
            allowajaxD = false;
            
            const targetDiv = document.querySelector('.product-list-column-div'); 
            if (targetDiv) {
                targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            const product_list_ajax = document.getElementById('product-list-ajax');
            product_list_ajax.style.transition = 'opacity 0.5s ease-out';
            product_list_ajax.style.opacity = 0;

            document.querySelector('.loading-spinner').classList.add('show');

            fetch(`${protected_data.searchProducts.api_url}?${params}&paged=${$paged}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let pagination_ajax = document.getElementById('pagination-ajax');
                pagination_ajax.innerHTML = '';

                const tempDiv = document.createElement('div');
                if (data.length > 0) {
                    product_list_ajax.innerHTML = '';

                    data.forEach(product => {
                        tempDiv.innerHTML = product.html;
                        if (product.html) {
                            product_list_ajax.appendChild(tempDiv.firstChild);
                        }
                    });

                    pagination_ajax.innerHTML = data[data.length - 1].pagination;
                } else {
                    product_list_ajax.innerHTML = '<div class="title-not-found">Không tìm thấy sản phẩm nào</div>';
                    pagination_ajax.innerHTML = '';
                }

                setTimeout(() => {
                    product_list_ajax.style.transition = 'opacity 0.5s ease-in';
                    product_list_ajax.style.opacity = 1;
                }, 100);
            })
            .catch(error => {
                console.error('Error: ' + error);
            })
            .finally(() => {
                allowajaxD = true;
                document.querySelector('.loading-spinner').classList.remove('show');
            });
        }
    }
}
/* Expand/Collapse Category */
/* function toggleCategoryExpand() {
    if (!document.querySelector(".toggle-btn")) return;
    document.querySelectorAll(".toggle-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            let children = this.parentElement.querySelector(".children");
            if (children) {
                if (children.classList.contains("open")) {
                    children.classList.remove("open");
                    this.classList.remove("open");
                } else {
                    children.classList.add("open");
                    this.classList.add("open");
                }
            }
        });
    });
} */
/* Submit Form */
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
function showError($error) {
    document.getElementById('errorModal').querySelector('.error-title').innerHTML = $error

    modalError.show();
}
function showSuccess($success) {
    document.getElementById('successModal').querySelector('.success-title').innerHTML = $success;

    modalSuccess.show();
}