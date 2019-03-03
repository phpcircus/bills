import ParentModel from 'Models/model';

class Bill extends ParentModel {
    constructor () {
        super();
        this.urlName = 'bill';
    }

    failedRequest (error, request) {
        console.log(request, error);
          throw error
    }
}

export default Bill;