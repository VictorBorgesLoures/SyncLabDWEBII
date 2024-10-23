import Validator from "./Validator.js";

export default class ValidatorEnum extends Validator {
    constructor(enumData, message) {
        super();
        this.enum = enumData;
        this.message = message;
    }

    validate(fieldValue) {
        console.log(fieldValue);
        let found = false;
        if(this.enum.length > 0) {
            for(let i in this.enum) {
                if(this.enum[i] == fieldValue)
                    found=true;
            }
        }
        return found;
    }
}