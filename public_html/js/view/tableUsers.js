import axios from 'axios';

class TableUsers {
    tableBody = document.querySelector('#table-users .table__users__b');
    paginationCont = document.getElementById('table__pagination');
    filtersArr = document.querySelectorAll("#order-filters");
    currPage = 1;
    limit = 5;
    role = '';

    constructor () {
        this.getData();

        window.addEventListener('click', function (el) {
            if (el.target.id == 'btn-pagination') {
                this.currPage = el.target.dataset.page;
                this.getData();
            } else if (el.target.id == 'order-filters') {
                this.role = el.target.dataset.f;
                this.filtersArr.forEach(el => el.classList.remove('active'));

                el.target.classList.add('active');
                this.getData();
            }
        }.bind(this));
    }

    async getData () {
        try {
            const res = await axios({
                method: "GET",
                url: `/api/v1/get-all-user?limit=${this.limit}&currPage=${this.currPage}&role=${this.role}`
            });

            this.data = res.data.data;
            this.renderData();
        } catch (err) {
            // btn.innerText = 'Sign up';
        }
    }

    renderData () {
        let markup = '';
        if (this.data.totalUser == 0) {
            markup = '<p class="p__4 p__r notfound">No Data found</p>'
        } else {
            markup = this.data.users.map(el => {
                return `
                    <a href="/users.php?id=${el.id}" class="table__users__b--rows">
                        <div class="table__users__b--el">${this.capitalizeFirstLetter(el.user_name)}</div>
                        <div class="table__users__b--el i">${this.capitalizeFirstLetter(el.user_role == 'both' ? 'Driver & Ryder' : el.user_role )}</div>
                        <div class="table__users__b--el">${this.capitalizeFirstLetter(el.user_city)}</div>
                        <div class="table__users__b--el">${el.user_email}</div>
                        <div class="table__users__b--el">${el.user_phoneNumber}</div>
                    </a>
                `;
            }).join('');
        }

        this.tableBody.innerHTML = markup;
        this.renderPagination();
    }

    capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    renderPagination () {
        const pagiParent = document.querySelector('.table__pagination');
        
        if (!this.paginationCont) return;

        let totalPage = Math.ceil(this.data.totalUser/this.data.limit);

        if (totalPage == 1) {
            this.paginationCont.innerHTML = '';
            return;
        }

        let markup = '';

        let start;
        let end;

        if (totalPage < 3) {
            {
                start = 1;
                end = totalPage
            }

        } else if (this.currPage < 3 || totalPage == 3) {
            start = 1;
            end = 3;
        } else if (this.currPage >= totalPage) {
            start = this.currPage - 2;
            end = totalPage;
        } else {
            start = +this.currPage - 1;
            end = +this.currPage + 1;
        }

        for(let i = start; i <= end; i++) {
            if (this.currPage == (i)) {
                markup += `<a class="active" id="btn-pagination" data-page="${i}">${i}</a>`;
            } else {
                markup += `<a id="btn-pagination" data-page="${i}">${i}</a>`;
            }
        }

        this.paginationCont.innerHTML = markup;
    }
}

export default TableUsers;