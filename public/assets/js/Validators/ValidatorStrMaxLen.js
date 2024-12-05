import Validator from "./Validator.js";

export default class ValidatorStrMinLen extends Validator {
    constructor(maxLen, message) {
        super();
        this.maxLen = maxLen;
        this.message = message;
    }

    validate(fieldValue) {
        return fieldValue.length <= this.maxLen
    }
}