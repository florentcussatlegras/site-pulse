import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["sun", "moon"];

  connect() {
    this.html = document.documentElement;

    const storedTheme = localStorage.getItem("theme") || "light";
    this.applyTheme(storedTheme);
    this.updateIcons();
  }

  toggle() {
    const nextTheme = this.html.classList.contains("dark")
      ? "light"
      : "dark";

    localStorage.setItem("theme", nextTheme);
    this.applyTheme(nextTheme);
    this.updateIcons(); // ✅ MANQUAIT ICI
  }

  applyTheme(theme) {
    this.html.classList.remove("light", "dark");
    this.html.classList.add(theme);
  }

  updateIcons() {
    if (!this.hasSunTarget || !this.hasMoonTarget) return;

    const isDark = this.html.classList.contains("dark");

    // dark → afficher le soleil (retour light)
    this.sunTarget.classList.toggle("hidden", !isDark);
    this.moonTarget.classList.toggle("hidden", isDark);
  }
}
