<div wire:poll.keep-alive="updateNotificationCount">
    <!-- This div is polled every 10 seconds and running in background to update the notification count -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('title-update', event => {
            document.title = event.detail[0].title;
        });
    });
</script>
