import Validator from "./Validator.js";

export default class ValidatorMatch extends Validator {
    constructor(otherFieldId, errorMessage) {
        super();
        this.otherFieldId = otherFieldId;
        this.message = errorMessage;
    }

    validate(value, fields) {
        const otherInput = document.getElementById(this.otherFieldId);
        if (!otherInput || value !== otherInput.value) {
            return false;
        }
        return true;
    }
}