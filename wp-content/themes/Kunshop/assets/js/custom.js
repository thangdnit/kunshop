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
            fetchDataFilter();
            loadproductFilterMain();
            loadModal();
            load_form();
            resetFormSignup();
            toggleCategoryExpand();
            CategoryCheckboxEvent('product-filter__product_category');
            CategoryCheckboxEvent('product-filter__product_tag');
            CategoryCheckboxEvent('product-filter__product_brand');
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
    CategoryCheckboxEvent('product-filter__product_category');
    CategoryCheckboxEvent('product-filter__product_tag');
    CategoryCheckboxEvent('product-filter__product_brand');
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

    if (bodyClass.contains('home')) {
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
            swiper_single_product = new Swiper('.swiper-multi', {
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
            addError('Vui lòng nhập từ khóa tìm kiếm ít nhất 2 ký tự', keyword);
            return;
        }

        let newUrl = new URL(url);

        let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage));
        if(filter) {
            filter[idkeyword] = keyword.value;
            window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
        }else {
            let newFilter = {};
            newFilter[idkeyword] = keyword.value;
            window.localStorage.setItem(mainLocalStorage, JSON.stringify(newFilter));
        }

        swup_main.navigate(newUrl.toString());
    }else if (document.body.classList.contains('page-id-11')) {
        let filter = JSON.parse(window.localStorage.getItem(mainLocalStorage)) || {};

        filter[idkeyword] = keyword.value;
        window.localStorage.setItem(mainLocalStorage, JSON.stringify(filter));
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
                    if (key == 'product-filter__price-range') {
                        const priceRange = document.getElementById('product-filter__price-range');
                        priceRange.noUiSlider.set([parsedObject[key][0], parsedObject[key][1]]);
                        continue;
                    }

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
        } catch (e) {
            console.error(e);
        }
    }
}
/* Category Checkbox LocalStorage */
function CategoryCheckboxEvent(classElement) {
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
/* Main Filter */
function loadproductFilterMain($paged = 1) {
    if (document.body.classList.contains('page-id-11')) {
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