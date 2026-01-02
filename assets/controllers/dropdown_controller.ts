import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="dropdown"
export default class extends Controller {
    static targets = ["menu"];

    declare readonly menuTarget: HTMLElement;

    connect() {
        // Fermer si on clique en dehors
        console.log('connect dropdown controller');
        document.addEventListener("click", this.outsideClick.bind(this))
    }

    disconnect() {
        document.removeEventListener("click", this.outsideClick.bind(this))
    }

    toggle() {
        this.menuTarget.classList.toggle("hidden")
    }

    outsideClick(event: MouseEvent) {
        if (!this.element.contains(event.target as Node)) {
            this.menuTarget.classList.add("hidden")
        }
    }
}
