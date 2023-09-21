import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.toggleHome(window.location.href)

        document.addEventListener("turbo:visit", (e) => {
            this.toggleHome(e.detail.url)
        })
    }

    toggleHome(url) {
        if (url.endsWith('/')) {
            document.getElementById('application').classList.add('io-home');
        } else {
            document.getElementById('application').classList.remove('io-home');
        }
    }
}
