var mainLocalStorage = 'filter_products';
var homeLocalStorage = 'home_products';
var swup_main;
var allowajaxA = [];
var allowajaxB = true;
var allowajaxC = true;
var allowajaxD = true;
var swiper_single_product;
var swiper_home = [];
var modalSuccess;
var modalError;
let isFixed = false;
let scrollTimeout; 
let isPopupVisible = false;
init();
function init(){
    clearLocalStorage();
    swup_main = new Swup({
        hooks: {
        'content:replace': () => {
            allowajaxB = true; allowajaxC = true; allowajaxD = true;
            isFixed = false;
            isPopupVisible = false;
            updateBodyClass();
            resetContactPopup();
            initSwiper();
            loadPriceSlider();
            loadPressEnterInput();
            clearLocalStorage();
            beforeLoadproduct();
            fetchDataFilter();
            loadproductFilterMain();
            loadModal();
            load_form();
            resetFormSignup();
          },
        }
    })
}
document.addEventListener('scroll', () => {
    showScrollTop();
    showHeaderFixed();
    changeColorContactPopup();
    handleScrollPopup();
});
document.addEventListener('DOMContentLoaded', () => {
    load_init();
});
/* Load Main */
function load_init() {
    initSwiper();
    initAnimation();
    resetContactPopup();
    changeColorContactPopup();
    showHeaderFixed();
    loadPriceSlider();
    loadPressEnterInput();
    fetchDataFilter();
    loadproductFilterMain();
    loadModal();
    load_form();
    toggleCategoryExpand();
}
/* Header Mobile Fixed */
function showHeaderFixed() {
    const header = document.getElementById('header');
    const headerfixed = document.getElementById('header-fixed');

    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    if (scrollTop > (0.5 * window.innerHeight) && !isFixed) {
        isFixed = true;
        anime({
            targets: headerfixed,
            translateY: [ '-100%', '0%' ],
            easing: 'easeOutExpo',
            duration: 500,
            begin: function() {
                anime({
                    targets: header,
                    translateY: [ '0', '-100%' ],
                    easing: 'linear',
                    duration: 500,
                })
            },
        });
    } else if (scrollTop <= (0.5 * window.innerHeight) && isFixed) {
        isFixed = false;
        anime({
            targets: headerfixed,
            translateY: [ '0%', '-100%' ],
            easing: 'easeInExpo',
            duration: 500,
            begin: function() {
                anime({
                    targets: header,
                    translateY: [ '-100%', '0' ],
                    easing: 'linear',
                    duration: 500,
                })
            }
        });
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
/* Load Air Date Picker and Event */
function loadDatepicker() {
    const localeVi = {
        days: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
        daysShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        months: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        monthsShort: ['Thg 1', 'Thg 2', 'Thg 3', 'Thg 4', 'Thg 5', 'Thg 6', 'Thg 7', 'Thg 8', 'Thg 9', 'Thg 10', 'Thg 11', 'Thg 12'],
        firstDay: 1,
    }

    let isShow = false;
    if (document.getElementById('form-drive__date')) {
        let datepicker = new AirDatepicker('#form-drive__date', {          
            dateFormat: 'dd/MM/yyyy',
            minDate: new Date(),
            position: 'top right',
            isMobile: true,
            autoClose: true,
            locale: localeVi,
            onShow: function () {
                isShow = true;
            }
        });

        const myModal = document.getElementById('registerDriveModal');
        myModal.addEventListener('hidden.bs.modal', function (event) {
            myModal.setAttribute('aria-hidden', 'true');
            if (isShow) {
                datepicker.hide();
            }
        });
        myModal.addEventListener('show.bs.modal', function (event) {
            myModal.removeAttribute('aria-hidden');
        });
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
/* Load Press Enter Input */
function loadPressEnterInput() {
    pressEnterInput('product-filter__keyword', 'btn-searchKeyword');
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

    if (bodyClass.contains('home') || bodyClass.contains('page-id-11') || bodyClass.contains('page-id-14')) {
        if (window.innerWidth < 801) {
            const space_between = changeRemtoPx(1);
            if (document.querySelector('.product-type-section')) {
                const swiper_slide = new Swiper('.product-type-section', {
                    loop: false,
                    grabCursor: true,
                    spaceBetween: space_between,
                    slidesPerView: 2.1,
                    freeMode: true,
                    speed: 800,
                    navigation: {
                        nextEl: '.product-type-section .swiper-button-next-custom',
                        prevEl: '.product-type-section .swiper-button-prev-custom',
                    },
                    autoplay: false,
                });
            }
        }

        if (document.querySelector('.swiper-material')) {
            const swiper_slide = new Swiper('.swiper-material', {
                slidePerView: 1,
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

        if (document.querySelector('.swiper-normal')) {
            if (document.querySelector('.swiper-normal')) {
                const swiper_slide = new Swiper('.swiper-normal', {
                    loop: false,
                    grabCursor: true,
                    slidePerView: 1,
                    speed: 800,
                    navigation: {
                        nextEl: '.swiper-normal .swiper-button-next-custom',
                        prevEl: '.swiper-normal .swiper-button-prev-custom',
                    },
                    autoplay: false,
                });
            }
        }

        if (document.querySelector('.swiper-tab')) {
            const alltabs = document.querySelectorAll('.swiper-tab');
            alltabs.forEach((tab, index) => {
                setTimeout(() => {
                    const tab_id = tab.parentElement.id;
                    allowajaxA[tab_id] = true;
                    swiper_home[tab_id] = new Swiper(tab, {
                        loop: false,
                        grabCursor: false,
                        allowTouchMove: false,
                        slidesPerView: 1,
                        speed: 800,
                        autoplay: false,
                        navigation: {
                            nextEl: '#btn-next' + tab_id,
                            prevEl: '#btn-prev' + tab_id,
                        },
                        on: {
                            init: function () {
                                load_more_products(tab_id);
                            },
                            slidePrevTransitionStart: function () {
                                load_prev_products(tab_id);
                            },
                            slideNextTransitionStart: function () {
                                load_more_products(tab_id);
                            }
                        }
                    });
                }, 10);
            });
        }
    }

    if (bodyClass.contains('single-products')) {
        const remInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const spaceBetween = 3 * remInPx;
        const spaceBetweenMB = 1 * remInPx;
        if (document.querySelector('.swiper-thumbnail-1')) {
            const swiper_thumbnail_1 = new Swiper(".swiper-thumbnail-1", {
                slidesPerView: 2,
                grid: {
                    rows: 2,
                },
                spaceBetween: spaceBetweenMB,
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
            allowajaxA[''] = true;
            swiper_single_product = new Swiper('.swiper-multi', {
                loop: false,
                grabCursor: false,
                allowTouchMove: false,
                slidesPerView: 1,
                speed: 800,
                autoplay: false,
                navigation: {
                    nextEl: '.swiper-multi #btn-next',
                    prevEl: '.swiper-multi #btn-prev',
                },
                on: {
                    init: function () {
                        load_more_products('');
                    },
                    slidePrevTransitionStart: function () {
                        load_prev_products('');
                    },
                    slideNextTransitionStart: function () {
                        load_more_products('');
                    }
                }
            });
        }
    }

    function changeRemtoPx (rem) {
        const remInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const value = rem * remInPx;
        return value;
    }
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

    const top = document.getElementById('selling-page-header');
    const bot = document.getElementById('footer');

    const fixedElement = contactPopup.querySelectorAll('.contact-popup-item');

    if (top) {
        const rectTop = top.getBoundingClientRect();
        const rectBot = bot.getBoundingClientRect();

        if (rectTop.top <= 0 && rectBot.top >= window.innerHeight) {
            fixedElement.forEach((element) => {
                element.style.background = '#1D51A2';
                element.querySelector('svg').style.fill = 'white';
            });
        } else { 
            fixedElement.forEach((element) => {
                element.style.background = '#F8BB15';
                element.querySelector('svg').style.fill = '#1D51A2';
            });
        }
    }else {
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
}
/* Reset Color Contact Popup */
function resetContactPopup() {
    const contactPopup = document.getElementById('contact-popup');
    const fixedElement = contactPopup.querySelectorAll('.contact-popup-item');

    const top = document.getElementById('selling-page-header');
    if (top) {
        fixedElement.forEach((element) => {
            element.style.background = '#F8BB15';
            element.querySelector('svg').style.fill = '#1D51A2';
        });
    }else {
        fixedElement.forEach((element) => {
            element.style.background = '#1D51A2';
            element.querySelector('svg').style.fill = 'white';
        });
    }
}
/* Show Advanced Filter */
function showAdvancedFilter() {
    const filter = document.getElementById('product-filter-advanced');
    filter.classList.toggle('show-filter');
}
/* Press Enter function */
function pressEnterInput(idInput, idButton) {
    const input = document.getElementById(idInput);
    
    if (input) {
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(idButton).click();
            }
        });
    }
}
/* Search Keyword */
function searchproductbyKeyword(url, idkeyword) {
    const keyword = document.getElementById(idkeyword);
    
    if (document.body.classList.contains('home')) {
        if (keyword.value.length < 2) {
            addError('Từ khóa phải có ít nhất 2 ký tự', keyword);
            return;
        }

        let newUrl = new URL(url);

        let filter = JSON.parse(window.localStorage.getItem(homeLocalStorage));
        if(filter) {
            filter[idkeyword] = keyword.value;
            window.localStorage.setItem(homeLocalStorage, JSON.stringify(filter));
        }else {
            let newFilter = {};
            newFilter[idkeyword] = keyword.value;
            window.localStorage.setItem(homeLocalStorage, JSON.stringify(newFilter));
        }

        swup_main.navigate(newUrl.toString());
    }else if (document.body.classList.contains('page-id-14')) {
        if (keyword.value.length < 2) {
            addError('Từ khóa phải có ít nhất 2 ký tự', keyword);
            return;
        }

        resetLocalStorage();
        let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

        filter[idkeyword] = keyword.value;
        window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
        loadproductFilterMain();
    }
}
/* Search by Taxonomy */
function searchproductbyTaxonomy(url, key, value) {
    let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

    const isHomePage = document.body.classList.contains('home');
    const filterKey = 'product-filter__' + key;
    const filterElement = document.getElementById(filterKey);

    filter[filterKey] = value;

    if (key === 'hang-xe') {
        filter['product-filter__dong-xe'] = 0;
    }
    window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
    
    if (isHomePage) {
        const newUrl = new URL(url);
        window.localStorage.setItem(homeLocalStorage, JSON.stringify(filter));
        swup_main.navigate(newUrl.toString());
    } else { 
        if (filterElement && filterElement.value === value) {
            return;
        }
        if (filterElement) {
            filterElement.value = value;
        }
        if (key === 'hang-xe') {
            loadproductModel(filterKey);
        }
        loadproductFilterMain();
    }
}
/* Search by Price */
function searchproductbyPrice(url, min, max) {
    const filterKey = 'product-filter__price-range';
    let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

    filter[filterKey] = [min, max];
    window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));

    if (document.body.classList.contains('home')) {
        window.localStorage.setItem(homeLocalStorage, JSON.stringify(filter));
        swup_main.navigate(new URL(url).toString());
    } else {
        document.querySelector('.price-filter.show-on')?.classList.remove('show-on');
        document.getElementById(`price-filter__${min}-${max}`)?.classList.add('show-on');

        const priceRange = document.getElementById(filterKey);
        if (priceRange?.noUiSlider) {
            priceRange.noUiSlider.set([min, max]);
        }

        loadproductFilterMain();
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
                    const element = document.getElementById(key);
                    if (element) {
                        element.value = parsedObject[key];
                        if (key == 'product-filter__hang-xe') {
                            loadproductModel(key);
                        }
                        if (key == 'product-filter__price-range') {
                            const priceRange = document.getElementById('product-filter__price-range');
                            priceRange.noUiSlider.set([parsedObject[key][0], parsedObject[key][1]]);

                            const priceButton = document.getElementById('price-filter__' + parsedObject[key][0] + '-' + parsedObject[key][1]);
                            if (priceButton) {
                                priceButton.classList.add('show-on');
                            }
                        }
                    }
                }
            }
        } catch (e) {
            console.error(e);
        }
    }
}
/* Update Local Storage from Select */
function updateLocalStorageSelect(idElement) {
    const element = document.getElementById(idElement);
    if (element) {
        let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

        if (filter) {
            filter[idElement] = element.value;
        }else {
            filter = {};
            filter[idElement] = element.value;
        }
        window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter)); 
    }
}
/* Clear Local Storage */
function clearLocalStorage() {
    window.localStorage.removeItem(mainLocalStorage);
}
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
    
                            const priceButton = document.querySelector('.price-filter.show-on');
                            if (priceButton) {
                                priceButton.classList.remove('show-on');
                            }
                        } else{
                            filters[key] = 0;
                            const element = document.getElementById(key);
                            if (element) {
                                element.value = 0;
                            }
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
/* Before Load product */
function beforeLoadproduct() {
    const homeFilter = window.localStorage.getItem(homeLocalStorage);

    if (homeFilter) {
        let filter_home = JSON.parse(homeFilter);
        let filter_main = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};
        filter_main = { ...filter_main, ...filter_home };

        window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter_main));
        window.localStorage.removeItem(homeLocalStorage);
    }
}
/* Clear All Filter */
function clearAllfilter() {
    resetLocalStorage();
    fetchDataFilter();

    const filter = JSON.parse(window.localStorage.getItem(mainLocalStorage));
    if (filter) {
        window.localStorage.removeItem(mainLocalStorage);
        
        if(document.querySelector('.price-filter.show-on')){
            document.querySelector('.price-filter.show-on').classList.remove('show-on');
        }
        document.querySelector('.keyword-ajax').innerHTML = '';
        document.getElementById('product-filter__keyword').value = '';
        loadproductFilterMain();
    }    
}
/* Function show Error */
function showError($error) {
    document.getElementById('errorModal').querySelector('.error-title').innerHTML = $error

    modalError.show();
}
/* Function show Success */
function showSuccess($success) {
    document.getElementById('successModal').querySelector('.success-title').innerHTML = $success;

    modalSuccess.show();
}
function resetFormSignup (){
    document.getElementById('form-signup').reset();
}
/* Ajax */
/* Load Next Page Ajax */
function load_more_products(idtab) {
    const total_pages = parseInt(document.getElementById('total_pages' + idtab).value);
    const next_page = parseInt(document.getElementById('next_page' + idtab).value);
    const page_loaded = parseInt(document.getElementById('page_loaded' + idtab).value);
    const first_load = parseInt(document.getElementById('first_load' + idtab).value);
    document.getElementById('first_load' + idtab).value = 1;

    if (total_pages == 1) {
        return;
    }

    if ((next_page <= total_pages && first_load != 0 && next_page < page_loaded) || (next_page <= total_pages && first_load != 0 && page_loaded == total_pages)) {
        updateStatusPage(idtab, next_page, first_load);
        updateButtonStatus(idtab, next_page, total_pages, first_load);
        return;
    }
    if ((allowajaxA[idtab]) && page_loaded <= total_pages) {
        allowajaxA[idtab] = false;

        if (page_loaded == total_pages) {
            updateStatusPage(idtab, next_page, first_load);
            updateButtonStatus(idtab, next_page, total_pages, first_load);
            return;
        }
        
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
            updateSlideAjax(idtab, first_load);
        })
        .catch(error => {
            console.error('Error: error');
        })
        .finally(() => {
            allowajaxA[idtab] = true;
            showLoadingSpinner(idtab, false);
            updateStatusPage(idtab, next_page, first_load);
            updatePageLoaded(idtab, page_loaded);
            updateButtonStatus(idtab, next_page, total_pages, first_load);
        });
    }
}
function appendproductSlides(data, idtab) {
    const divproductsWrapper = idtab
        ? document.querySelector(`#${idtab} .slider-ajax .swiper-wrapper`)
        : document.querySelector('.slider-ajax .swiper-wrapper');

    const divproducts = document.createElement('div');
    divproducts.classList.add('swiper-slide', 'justify-content-start');

    if (idtab !== '') {
        divproducts.classList.add('flex-wrap');
    }

    data.forEach((product) => {
        const divproduct = document.createElement('div');
        divproduct.classList.add('product-box-item');
        divproduct.innerHTML = product.html;
        divproducts.appendChild(divproduct);
    });

    divproductsWrapper.appendChild(divproducts);

    if (idtab !== '') {
        swiper_home[idtab].update();
    } else {
        swiper_single_product.update();
    }
}
function updateStatusPage(idtab, oldNextPage, first_load) {
    if (first_load != 0) {
        document.getElementById('next_page' + idtab).value = oldNextPage + 1;
    }
}
function updatePageLoaded(idtab, oldPageLoaded) {
    document.getElementById('page_loaded' + idtab).value = oldPageLoaded + 1;
}
function updateButtonStatus(idtab, next_page, total_pages, first_load) {
    if (first_load != 0) {
        document.getElementById('btn-prev' + idtab).classList.remove('disabled-custom');
        if (next_page + 1 > total_pages) {
            document.getElementById('btn-next' + idtab).classList.add('disabled-custom');
        }
    }
}
function updateSlideAjax(idtab, first_load) {
    if (idtab != '') {
        swiper_home[idtab].update();
    }
    else {
        swiper_single_product.update();
    }
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
/* Load Preview Page Ajax */
function load_prev_products(idtab) {
    const next_page = parseInt(document.getElementById('next_page' + idtab).value);
    if (next_page == 2) {
        return;
    }
    
    document.getElementById('btn-next' + idtab).classList.remove('disabled-custom');

    document.getElementById('next_page' + idtab).value = next_page - 1;
    if (next_page - 1 == 2) {
        document.getElementById('btn-prev' + idtab).classList.add('disabled-custom');
    }
}
/* Load product and Model */
function loadproductModel(idElement) {
    const element = document.getElementById(idElement);

    if(element.id == 'product-filter__hang-xe') {
        const brand = element.value;
        const modeldiv = document.getElementById('product-filter__dong-xe');
        updateLocalStorageSelect(idElement);
        if (allowajaxB) {
            allowajaxB = false;
            fetch(`${protected_data.models.api_url}?model=${brand}`, {
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
                if (data) {
                    modeldiv.innerHTML = '';
                    const option = document.createElement('option');
                    option.value = '0';
                    option.text = 'Dòng xe';
                    modeldiv.appendChild(option);
                    
                    data.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.id;
                        option.text = model.name;
                        modeldiv.appendChild(option); 
                    });
                    updateLocalStorageSelect('product-filter__dong-xe');
                }
            })
            .catch(error => {
                console.error('Error: ' + error);
            })
            .finally(() => {
                allowajaxB = true;
            });
        }
    }
}
function loadproductBrand(idElement) {
    const element = document.getElementById(idElement);
    if(element.id == 'product-filter__dong-xe') {
        const model = element.value;
        updateLocalStorageSelect(idElement);
        const branddiv = document.getElementById('product-filter__hang-xe');

        if (allowajaxC) {
            allowajaxC = false;
            fetch(`${protected_data.brands.api_url}?model=${model}`, {
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
                if (data.parent_id) {
                    branddiv.value = data.parent_id;
                    updateLocalStorageSelect('product-filter__hang-xe');
                }
            })
            .catch(error => {
                console.error('Error: ' + error);
            })
            .finally(() => {
                allowajaxC = true;
            });
        }
    }
}
/* Main Filter */
function loadproductFilterMain($paged = 1) {
    if (document.body.classList.contains('page-id-14')) {
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
            
            if (filter_data['product-filter__keyword']) {
                document.querySelector('.keyword-ajax').innerHTML = `Tìm kiếm: ${filter_data['product-filter__keyword']}`;
            }else {
                document.querySelector('.keyword-ajax').innerHTML = '';
            }
        }

        if (allowajaxD) {
            allowajaxD = false;
            
            const targetDiv = document.querySelector('.product-filter-all'); 
            if (targetDiv) {
                targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            const product_list_ajax = document.getElementById('product-list-ajax');
            product_list_ajax.style.transition = 'opacity 0.5s ease-out';
            product_list_ajax.style.opacity = 0;

            document.querySelector('.loading-spinner').classList.add('show'); 
            fetch(`${protected_data.searchproducts.api_url}?${params}&paged=${$paged}`, {
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
                    product_list_ajax.innerHTML = '<div class="title-not-found">Không tìm thấy xe nào</div>';
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

/* Load Category */
function load_category_lv1() {
    const categoryLv1 = document.getElementById('product-filter__category_lv1').value;
    
    if (allowajaxB) {
        allowajaxB = false;
        
        fetch(`${protected_data.categories.api_url}?parent=${categoryLv1}`, {
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
            if (data) {
                const categoryLv2div = document.getElementById('product-filter__category_lv2');
                
                categoryLv2div.innerHTML = '';

                const option2 = document.createElement('option');
                option2.value = '0';
                option2.text = 'Danh mục';
                categoryLv2div.appendChild(option2);

                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.name;
                    categoryLv2div.appendChild(option); 
                });
            }
        })
        .catch(error => {
            console.error('Error: ' + error);
        })
        .finally(() => {
            allowajaxB = true;
        });
    }

}

/* Expand/Collapse Category */
function toggleCategoryExpand() {
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
}