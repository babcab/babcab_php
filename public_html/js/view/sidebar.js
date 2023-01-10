class Sidebar {
    navBtn = document.querySelector(".btn-nav");
    sidebar = document.querySelector(".section-sidebar");
    overlay = document.querySelector(".sidebar-overlay");

    constructor () {
        this.navBtn.addEventListener("click", this.toggleElements.bind(this));
        this.overlay.addEventListener("click", this.toggleElements.bind(this));
    }

    toggleElements () {
        this.sidebar.classList.toggle("active");
        this.overlay.classList.toggle("active");
    }
}
export default Sidebar;