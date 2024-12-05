import Validator from "./Validator.js";

export default class ValidatorRequired extends Validator {
    constructor(message) {
        super();
        this.message = message;
    }

    validate(fieldValue) {
        return fieldValue.toString().length > 0
    }
}