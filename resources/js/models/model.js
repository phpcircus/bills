import { Model as BaseModel } from 'javel';

class ParentModel extends BaseModel {
    baseUrl () {
        return '';
    }

    buildUrl ({ action, params }) {
        if (['find', 'update', 'delete'].includes(action)) {
            const id = params[0];

            return [this.urlName, id];
        }

        return this.urlName;
    }
}

export default ParentModel;