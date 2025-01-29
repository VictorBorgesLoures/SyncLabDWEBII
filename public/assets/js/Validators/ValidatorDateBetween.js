import Validator from "./Validator.js";

export default class ValidatorDateBetween extends Validator {
    constructor(days, errorMessage) {
        super();
        this.days = days;
        this.message = errorMessage;
    }

    validate(value) {
        console.log(value);
        const otherInput = document.getElementById(this.days);
        if (!otherInput || value !== otherInput.value) {
            return false;
        }
        return true;
    }
}