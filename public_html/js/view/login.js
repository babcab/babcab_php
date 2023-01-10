import axios from 'axios';

class Login {
    emailField = document.querySelector("#input-email");
    passwordField = document.querySelector("#input-password");
    loginBtn = document.querySelector("#login-now");

    constructor () {
        this.loginBtn.addEventListener("click", this.fireEvent.bind(this));
    }

    fireEvent () {
        if (this.emailField.value == '') {
            this.emailField.style.border = '1px solid red';
            return;
        } else {
            this.emailField.style.border = '1px solid var(--color-grey-3)';
        }

        if (this.passwordField.value == '') {
            this.passwordField.style.border = '1px solid red';
            return;
        } else {
            this.passwordField.style.border = '1px solid var(--color-grey-3)';
        }

        this.data = {
            'email': this.emailField.value,
            'password': this.passwordField.value
        }

        this.sendData();
    }

    async sendData () {
        this.loginBtn.innerText = 'Logging In...';

        try {
            const res = await axios({
                method: "POST",
                url: `/api/v1/login`,
                data: this.data
            });
            this.resData = res.data;
            this.renderPop(res.data.message, true);

        } catch (err) {
            this.renderPop(err.response.data.message);
        }
    }

    renderPop (msg, status = false) {
        document.querySelector('body').insertAdjacentHTML('beforeend',`<div class="popup">${msg}</div>`);
        this.loginBtn.innerText = 'Log In';

        setTimeout(() => {
            document.querySelector('.popup').remove();
            if (status) window.location.href = "/";
        }, 3000);
    }
}

export default Login;