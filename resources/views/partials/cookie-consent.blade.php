<style>
    #premium-cookie-wrap {
        position: fixed;
        bottom: 24px;
        left: 24px;
        right: 24px;
        z-index: 999999; /* Super high z-index */
        display: none; /* Hidden by default */
        pointer-events: all;
    }
    @media (min-width: 768px) {
        #premium-cookie-wrap {
            left: auto;
            right: 32px;
            width: 420px;
        }
    }
    #premium-cookie-wrap.is-visible {
        display: block;
        animation: cookieSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes cookieSlideUp {
        0% { transform: translateY(100px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
</style>

<div id="premium-cookie-wrap">
    <div class="bg-white border border-gray-100 shadow-[0_30px_70px_rgba(0,0,0,0.2)] rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
        <!-- Close Button -->
        <button onclick="dismissCookiePopup()" class="absolute top-6 right-8 text-gray-300 hover:text-gray-500 transition-colors">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                <i class="fa-solid fa-cookie-bite text-2xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-black text-primary tracking-tight">Cookie Policy</h3>
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest leading-none">Privacy Matters</p>
            </div>
        </div>

        <p class="text-gray-600 text-sm leading-relaxed mb-8 font-medium">
            We use cookies to personalize your experience. By clicking "Accept All", you agree to our use of cookies.
        </p>

        <div class="flex flex-col gap-3">
            <button onclick="acceptAllCookies()" 
                class="w-full bg-primary hover:bg-primary-dark text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                <span>Accept All Cookies</span>
                <i class="fa-solid fa-check text-xs"></i>
            </button>
            
            <div class="grid grid-cols-2 gap-3">
                <button onclick="acceptNecessaryCookies()" 
                    class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold py-3.5 rounded-2xl transition-all text-xs border border-gray-100">
                    Necessary Only
                </button>
                <a href="{{ route('help') }}" 
                    class="bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold py-3.5 rounded-2xl transition-all text-xs border border-gray-100 flex items-center justify-center">
                    Learn More
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showCookiePopup() {
        const wrap = document.getElementById('premium-cookie-wrap');
        if (wrap) {
            wrap.classList.add('is-visible');
        }
    }

    function dismissCookiePopup() {
        const wrap = document.getElementById('premium-cookie-wrap');
        if (wrap) {
            wrap.style.display = 'none';
        }
    }

    function acceptAllCookies() {
        try {
            localStorage.setItem('cookieConsent', 'all');
        } catch(e) {}
        dismissCookiePopup();
    }

    function acceptNecessaryCookies() {
        try {
            localStorage.setItem('cookieConsent', 'necessary');
        } catch(e) {}
        dismissCookiePopup();
    }

    (function() {
        try {
            if (!localStorage.getItem('cookieConsent')) {
                // Use a slight delay to ensure the page is rendered
                setTimeout(showCookiePopup, 1500);
            }
        } catch(e) {
            // If localStorage is blocked, we still show the popup but it won't persist
            setTimeout(showCookiePopup, 1500);
        }
    })();
</script>