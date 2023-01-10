import axios from 'axios';

class SignUp {
    data = {
        currStage: 1,
        stages: [
            ['name', 'join-as', 'graduated', 'college'],
            ['phoneNumber', 'city', 'pincode', 'address'],
            ['email', 'password', 'confirmPassword']
        ],
        fields: {
            'name': {
                "name": "Name",
                "type": "string",
                "apiName": "name",
                "full": true
            },
            'join-as': {
                "name": "Join as",
                "type": "select",
                "apiName": "role",
                "values": {
                    'driver': 'Driver',
                    "rider": "Ryder",
                    "both": "Driver and Ryder"
                },
                "full": false
            },
            'graduated': {
                "name": "Graduated",
                "type": "select",
                "apiName": "graduated",
                "values": {
                    'true': 'Yes',
                    "false": "No"
                },
                "full": false
            },
            'college': {
                "name": "College",
                "type": "string",
                "apiName": "college",
                "full": true
            },
            'phoneNumber': {
                "name": "Phone Number",
                "type": "string",
                "apiName": "phoneNumber",
                "full": true
            },
            'address': {
                "name": "Address",
                "type": "string",
                "apiName": "address",
                "full": true
            },
            'city': {
                "name": "City",
                "type": "string",
                "apiName": "city",
                "full": false
            },
            'pincode': {
                "name": "Pincode",
                "type": "string",
                "apiName": "pincode",
                "full": false
            },
            'email': {
                "name": "Email",
                "type": "string",
                "apiName": "email",
                "full": true
            },
            'password': {
                "name": "Password",
                "type": "password",
                "apiName": "password",
                "full": true
            },
            'confirmPassword': {
                "name": "Confirm Password",
                "type": "password",
                "apiName": "confirmPassword",
                "full": true
            },
        }
    };
    visible = 1;
    postdata = {};

    constructor (contName) {
        this.contName = document.getElementById(contName);
        this.btnCont = document.getElementById(contName+'-btns');

        this.generateTemplate();
        this.renderBtns();
        this.renderBar();

        window.addEventListener('click', function (el) {

            if (el.target.id == 'signup-btn') {
                this.btnclicked(el.target.dataset.curr)
            } else if (el.target.id == 'signup-now') {
                if (this.getData()) {
                    this.SignUp(this.postdata, el.target);
                }
            }
        }.bind(this));
    }

    async SignUp (data, btn) {
        btn.innerText = 'Signing up...';

        try {
            const res = await axios({
                method: "POST",
                url: `/api/v1/create-user`,
                data: data
            });

            btn.innerText = 'Sign up';
            this.renderPop(res.data.message, true);
        } catch (err) {
            btn.innerText = 'Sign up';
            this.renderPop(err.response.data.message);
        }
    }

    renderPop (msg, status = false) {
        document.querySelector('body').insertAdjacentHTML('beforeend',`<div class="popup">${msg}</div>`);
        if (status) document.querySelector('#steps-bar').style.width = `100%`;

        setTimeout(() => {
            document.querySelector('.popup').remove();
            if (status) window.location.href = '/login.php';
        }, 4000);
    }

    getData () {
        let status = true;
        let fieldsArr = this.data.stages[this.visible-1];

        fieldsArr.forEach(el => {
            let field = document.getElementById(`field-${el}`);

            if (el == 'password' || el == 'confirmPassword') {
                let password = document.getElementById(`field-password`);
                let confirmPassword = document.getElementById(`field-confirmPassword`);

                if (password.value != confirmPassword.value || password.value == '' || confirmPassword.value == '') {
                    password.style.border = '1px solid red';
                    confirmPassword.style.border = '1px solid red';
                    status = false;
                } else {
                    password.style.border = '1px solid var(--color-grey-3)';
                    confirmPassword.style.border = '1px solid var(--color-grey-3)';
                    this.postdata['password'] = password.value;
                }
            } else if (field.value == '') {
                status = false;
                field.style.border = '1px solid red';
            } else {
                field.style.border = '1px solid var(--color-grey-3)';

                this.postdata[this.data.fields[el].apiName] = field.value;
            }
        })

        return status
    }

    btnclicked (currIndex) {
        let dataSatus = this.getData();

        if (currIndex < this.visible) dataSatus = true;
        if (!dataSatus) return;

        for(let i = 1; i < 4; i++) {
            if (i == currIndex) {
                document.querySelector(`#form-wrapper-${i}`).classList.add('visible');
            } else {
                document.querySelector(`#form-wrapper-${i}`).classList.remove('visible');
            }
        }

        this.visible = +currIndex;
        this.renderBtns();
        this.renderBar();
    }


    generateTemplate () {
        let markup = '';

        this.data.stages.forEach((el, i) => {
            let visible = 'visible'            
            if ((i+1) != 1) visible = '';

            markup += `<div class='form-wrapper ${visible}' id="form-wrapper-${i+1}">`;
            markup += this.generateWrapper(el);
            markup += `</div>`;
        })

        this.contName.innerHTML = markup;
    }

    generateWrapper (el) {
        let markup = '';

        el.forEach(element => {
            const type = this.data.fields[element].type;

            if (type == 'string') {
                markup += this.generateInputField(element);
            } else if (type == 'select') {
                markup += this.generateSelectField(element);
            } else if (type == 'password') {
                markup += this.generatePasswordInputField(element);
            }
        })

        return markup;
    }

    generateInputField (el) {
        const data = this.data.fields[el]
        return `
            <div class="wrapper ${data.full ? 'full' : ''}">
                <label for="field-${el}">${data.name}</label>
                <input type="text" id="field-${el}">
            </div>
        `;
    }
    generatePasswordInputField (el) {
        const data = this.data.fields[el]
        return `
            <div class="wrapper ${data.full ? 'full' : ''}">
                <label for="field-${el}">${data.name}</label>
                <input type="password" id="field-${el}">
            </div>
        `;
    }

    generateSelectField (el) {
        const data = this.data.fields[el]
        let markup = `
            <div class="wrapper ${data.full ? 'full' : ''}">
                <label for="field-${el}">${data.name}</label>
                <select name="" id="field-${el}">
                    <option value="" hidden>Select</option>
        `;

        for (const key in data.values) {
            markup += `<option value="${key}">${data.values[key]}</option>`;
        }
        
        markup +=  `</select></div>`;

        return markup
    }

    renderBar () {
        document.querySelector('#curr-steps').innerHTML = this.visible;

        let width =(33.3*(this.visible-1));

        document.querySelector('#steps-bar').style.width = `${width}%`;
    }

    renderBtns () {
        if (this.visible == 1) {
            this.btnCont.innerHTML = `
                <a href="/login.php" class="btn btn__sec btn--f">Log in</a>
                <div class="btn btn__prim btn--f" data-curr="2" id="signup-btn">
                    Next
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.15624 2.175L13.475 8.475C13.55 8.55 13.603 8.63125 13.634 8.71875C13.6655 8.80625 13.6812 8.9 13.6812 9C13.6812 9.1 13.6655 9.19375 13.634 9.28125C13.603 9.36875 13.55 9.45 13.475 9.525L7.15624 15.8437C6.98124 16.0187 6.76249 16.1062 6.49999 16.1062C6.23749 16.1062 6.01249 16.0125 5.82499 15.825C5.63749 15.6375 5.54374 15.4187 5.54374 15.1687C5.54374 14.9187 5.63749 14.7 5.82499 14.5125L11.3375 9L5.82499 3.4875C5.64999 3.3125 5.56249 3.097 5.56249 2.841C5.56249 2.5845 5.65624 2.3625 5.84374 2.175C6.03124 1.9875 6.24999 1.89375 6.49999 1.89375C6.74999 1.89375 6.96874 1.9875 7.15624 2.175Z" fill="white"/>
                    </svg>
                </div>
            `;
        } else if (this.visible == 2) {
            this.btnCont.innerHTML = `
                <a href="#" class="btn btn__sec btn--f" data-curr="1" id="signup-btn">
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.8437 15.825L5.52498 9.525C5.44998 9.45 5.39698 9.36875 5.36598 9.28125C5.33448 9.19375 5.31873 9.1 5.31873 9C5.31873 8.9 5.33448 8.80625 5.36598 8.71875C5.39698 8.63125 5.44998 8.55 5.52498 8.475L11.8437 2.15625C12.0187 1.98125 12.2375 1.89375 12.5 1.89375C12.7625 1.89375 12.9875 1.9875 13.175 2.175C13.3625 2.3625 13.4562 2.58125 13.4562 2.83125C13.4562 3.08125 13.3625 3.3 13.175 3.4875L7.66248 9L13.175 14.5125C13.35 14.6875 13.4375 14.903 13.4375 15.159C13.4375 15.4155 13.3437 15.6375 13.1562 15.825C12.9687 16.0125 12.75 16.1063 12.5 16.1063C12.25 16.1063 12.0312 16.0125 11.8437 15.825Z" fill="#333333"/>
                    </svg>
                    Back
                </a>
                <div class="btn btn__prim btn--f" data-curr="3" id="signup-btn">
                    Next
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.15624 2.175L13.475 8.475C13.55 8.55 13.603 8.63125 13.634 8.71875C13.6655 8.80625 13.6812 8.9 13.6812 9C13.6812 9.1 13.6655 9.19375 13.634 9.28125C13.603 9.36875 13.55 9.45 13.475 9.525L7.15624 15.8437C6.98124 16.0187 6.76249 16.1062 6.49999 16.1062C6.23749 16.1062 6.01249 16.0125 5.82499 15.825C5.63749 15.6375 5.54374 15.4187 5.54374 15.1687C5.54374 14.9187 5.63749 14.7 5.82499 14.5125L11.3375 9L5.82499 3.4875C5.64999 3.3125 5.56249 3.097 5.56249 2.841C5.56249 2.5845 5.65624 2.3625 5.84374 2.175C6.03124 1.9875 6.24999 1.89375 6.49999 1.89375C6.74999 1.89375 6.96874 1.9875 7.15624 2.175Z" fill="white"/>
                    </svg>
                </div>
            `;
        } else if (this.visible == 3) {
            this.btnCont.innerHTML = `
                <a href="#" class="btn btn__sec btn--f" data-curr="2" id="signup-btn">
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.8437 15.825L5.52498 9.525C5.44998 9.45 5.39698 9.36875 5.36598 9.28125C5.33448 9.19375 5.31873 9.1 5.31873 9C5.31873 8.9 5.33448 8.80625 5.36598 8.71875C5.39698 8.63125 5.44998 8.55 5.52498 8.475L11.8437 2.15625C12.0187 1.98125 12.2375 1.89375 12.5 1.89375C12.7625 1.89375 12.9875 1.9875 13.175 2.175C13.3625 2.3625 13.4562 2.58125 13.4562 2.83125C13.4562 3.08125 13.3625 3.3 13.175 3.4875L7.66248 9L13.175 14.5125C13.35 14.6875 13.4375 14.903 13.4375 15.159C13.4375 15.4155 13.3437 15.6375 13.1562 15.825C12.9687 16.0125 12.75 16.1063 12.5 16.1063C12.25 16.1063 12.0312 16.0125 11.8437 15.825Z" fill="#333333"/>
                    </svg>
                    Back
                </a>
                <div class="btn btn__prim btn--f" data-curr="4" id="signup-now">Sign up</div>
            `;
        }
    }
}

export default SignUp;