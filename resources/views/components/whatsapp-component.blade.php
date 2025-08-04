<div class="whatsapp-button">
    <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp whatsapp-icon"></i>
    </a>
</div>
{{-- change image with fontawesome icon + changes in css done by Hamza Amjad --}}
<style>
    .whatsapp-button {
        position: fixed;
        bottom: 60px;
        right: 30px;
        z-index: 1000;
    }
    .whatsapp-icon {
        font-size: 60px;
        color: #25D366;
    }
</style>
