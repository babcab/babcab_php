import axios from "axios";

class AddRide {
    addBtn = document.querySelector("#btn-add-route");
    locations = [];

    constructor () {
        this.addMap();

        this.setEvents();
    }

    setEvents () {
        window.addEventListener('click', function (el) {
            const target = el.target;

            if (target.id == 'btn-add-route') {
                this.addBtn.innerText = 'Adding...';
                this.getRouteDetails();
            }
        }.bind(this));
    }

    addMap () {
        let map = L.map('map').setView([30.344034, 76.442540], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            if (this.marker) this.marker.remove();

            this.marker = L.marker([lat, lng]).addTo(map);

            this.selectedLatLng = {
                'lat': lat,
                'lng': lng
            };

        }.bind(this));
    }

    async getRouteDetails () {
            try {
                const res = await axios({
                    method: "POST",
                    url: `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${this.selectedLatLng.lat}&lon=${this.selectedLatLng.lng}`,
                    data: this.data
                });
                this.resData = res.data;




                if (!this.resData.address.city && !this.resData.address.town) throw new Exception ("Location not valid!");
                
                this.locations.push({
                    "lat": this.selectedLatLng.lat,
                    "lng": this.selectedLatLng.lng,
                    "city": this.resData.address.city ? this.resData.address.city : this.resData.address.town,
                    "state": this.resData.address.state,
                    "country": this.resData.address.country
                });

                console.log(this.locations);


                this.addBtn.innerText = 'Added!';
                setTimeout(() => {
                    this.addBtn.innerText = 'Add';
                }, 2000)

            } catch (err) {
                // this.renderPop(err.response.data.message);
                this.addBtn.innerText = 'Not Valid!';
                setTimeout(() => {
                    this.addBtn.innerText = 'Add';
                }, 2000)
        }
    }
}

export default AddRide;