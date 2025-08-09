<!-- Notification & Service Worker Scripts -->
<script>
    window.userId = {{ Auth::id() }};
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent double binding across partial re-renders or duplicate includes
        if (window.__stuntcareEchoBound) {
            return;
        }
        window.__stuntcareEchoBound = true;

        if (typeof window.Echo === 'undefined') {
            console.error('Laravel Echo belum terinisialisasi!');
            return;
        }
        if (!window.userId) {
            console.error('User ID tidak ditemukan!');
            return;
        }

        const channelName = 'user.' + window.userId;
        const channel = window.Echo.private(channelName);

        channel
            .listen('MealReminderNotification', (e) => {
                showWebNotification(e.message);
            })
            .listen('DailyNutritionNotification', (e) => {
                showWebNotification(e.message);
            })
            .listen('ConsultationBookedNotification', (e) => {
                showWebNotification('Konsultasi berhasil dipesan: ' + e.message);
            })
            .listen('ConsultationConfirmedNotification', (e) => {
                showWebNotification('Konsultasi dikonfirmasi: ' + e.message);
            });

        function showWebNotification(message) {
            if (!('Notification' in window)) {
                console.warn('Browser tidak mendukung Web Notification');
                return;
            }
            if (Notification.permission === 'granted') {
                new Notification('StuntCare', { body: message, icon: '/logo.png' });
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        new Notification('StuntCare', { body: message, icon: '/logo.png' });
                    }
                });
            }
        }
    });
</script>

<!-- Service Worker Registration -->
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>
