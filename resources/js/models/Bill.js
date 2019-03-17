import { config } from 'Config';
import Model from 'Models/model';

class Bill extends Model {
    constructor () {
        if (! Bill.instance) {
            super();
           Bill.instance = this;
        }

        return Bill.instance;
    }

    create ({ name, amount, due, recurring, recurring_period }) {
        const formData = this.buildFormData(name, amount, due, recurring, recurring_period);

        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/bills`,
                data: formData,
            };

            axios(requestOptions).then( () => {
                /* global Turbolinks */
                Turbolinks.visit('/');

                return resolve();
            }).catch( error => {
                console.log(error.response);

                return reject();
            });
        });
    }

    markPaid (bill) {
        let id = bill.id;
        let name = bill.name;
        let amount = bill.amount;
        let due = bill.due;
        let recurring = bill.recurring;
        let recurring_period = bill.recurring_period;
        let paid = 1;

        return this.update({ id, name, amount, due, recurring, recurring_period, paid});
    }

    update ({ id, name, amount, due, recurring, recurring_period, paid }, editAll = false) {
        const formData = this.buildFormData(name, amount, due, recurring, recurring_period, paid);
        return new Promise((resolve, reject) => {
            const requestOptions = {
                method: 'POST',
                url: `${config.apiUrl}/bills/${id}?editAll=${editAll}`,
                data: formData,
            };

            axios(requestOptions).then( () => {
                /* global Turbolinks */
                Turbolinks.visit('/');
            }).catch(error => {
                console.log(error.response);

                return reject();
            });
        });
    }

    delete (id) {
        return new Promise( (resolve, reject) => {
            const requestOptions = {
                method: 'DELETE',
                url: `${config.apiUrl}/bills/${id}/delete`,
            };

            axios(requestOptions).then( () => {
                /* global Turbolinks */
                Turbolinks.visit('/');
            }).catch( error => {
                console.log(error.response);

                return reject();
            });
        });
    }

    buildFormData (name, amount, due, recurring, recurring_period, paid = false) {
        let formData = new FormData();
        formData.append('name', name);
        formData.append('amount', amount * 100);
        formData.append('due', due);
        formData.append('recurring', recurring);
        formData.append('recurring_period', recurring_period);
        formData.append('paid', paid);

        return formData;
    }
}

const instance = new Bill();

export default instance;