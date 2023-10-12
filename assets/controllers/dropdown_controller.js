import { Controller } from '@hotwired/stimulus';
import { useClickOutside } from 'stimulus-use'

export default class extends Controller {
    static targets = ["content"]

    connect() {
        if (this.hasContentTarget) {
            useClickOutside(this, { element: this.contentTarget })
        }
    }

    toggle(event) {
        if (!this.hasContentTarget) {
            return;
        }

        event.preventDefault();

        if (this.contentTarget.classList.contains('io-hidden')) {
            this.contentTarget.classList.remove('io-hidden');
        } else {
            this.hide();
        }
    }

    hide() {
        this.contentTarget.classList.add('io-hidden');
    }

    clickOutside() {
        this.hide();
    }
}
