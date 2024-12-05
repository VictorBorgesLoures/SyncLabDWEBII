import Validator from "./Validator.js";

export default class ValidatorStrMinLen extends Validator {
    constructor(minLen, message) {
        super();
        this.minLen = minLen;
        this.message = message;
    }

    validate(fieldValue) {
        return fieldValue.length >= this.minLen
    }
}