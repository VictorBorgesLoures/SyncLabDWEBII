import Validator from "./Validator.js";

export default class ValidatorRegex extends Validator {
    constructor(regex, message) {
        super();
        this.regex = regex;
        this.message = message;
    }

    validate(fieldValue) {
        return this.regex.exec(fieldValue);
    }
}